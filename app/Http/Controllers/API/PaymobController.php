<?php

namespace App\Http\Controllers\API;

use App\Enums\OrderStatusEnum;
use App\Events\OrderConfirmedEvent;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Services\PaymobService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymobController extends Controller
{
    use ApiResponse;

    protected $paymobService;

    protected $pending = OrderStatusEnum::PENDING->value;

    public function __construct(PaymobService $paymobService)
    {
        $this->paymobService = $paymobService;
    }

    public function createCheckoutSession(Request $request)
    {
        $user = Auth::guard('sanctum')->user();

        if (! $user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Step 1: Calculate total amount for unpaid orders
        $totalAmount = (integer) $request->amount;

        if ($totalAmount <= 0) {
            return response()->json(['message' => 'No amount due for payment'], 400);
        }

        // Step 2: Authenticate and get the token
        $authToken = $this->paymobService->authenticate();

        // Step 3: Create an order in Paymob with the total amount
        $orderData = $this->paymobService->createOrder($authToken, (int)($totalAmount * 100));
        $orderId = $orderData['id'];

        // Step 4: Fetch billing data from user's saved details
        $billingData = $this->getUserBillingData($user);

        // Step 5: Generate payment token with billing data
        $paymentToken = $this->paymobService->getPaymentToken($orderId, $totalAmount, $authToken, $billingData);

        // Step 6: Create payment link using the iframe ID
        $iframeId = config('services.paymob.iframe_id');
        $paymentLink = "https://accept.paymob.com/api/acceptance/iframes/{$iframeId}?payment_token={$paymentToken}";

        // Step 7: Return payment link to frontend
        return response()->json([
            'payment_link' => $paymentLink,
        ]);
    }

    protected function getUserBillingData($user)
    {
        $user->load(['phones', 'address']);

        $address = $user->userAddress;
        $phone = $user->phones->first();

        $nameParts = explode(' ', $user->name);
        $firstName = $nameParts[0];
        $lastName = count($nameParts) > 1 ? end($nameParts) : '';

        return [
            'apartment' => $address->apartment ?? 'N/A',
            'email' => $user->email,
            'floor' => $address->floor ?? 'N/A',
            'first_name' => $firstName,
            'street' => $address->street_address ?? 'N/A',
            'building' => $address->building ?? 'N/A',
            'phone_number' => $phone->phone ?? 'N/A',
            'shipping_method' => 'PKG',
            'postal_code' => $address->postal_code ?? '00000',
            'city' => $address->city ?? 'N/A',
            'country' => $address->country ?? 'EG',
            'last_name' => $lastName,
            'state' => $address->state ?? 'N/A',
        ];
    }

    public function cashPayment(Request $request)
    {
        $user = Auth::guard('sanctum')->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $request->validate([
            'amount' => 'required',
        ]);

        $amount = $request->input('amount');

        $orders = $user->orders()->where('status', OrderStatusEnum::PENDING->value);

        if (!$orders) {
            return response()->json(['message' => 'No pending orders found'], 404);
        }

        foreach( $orders as $order ) {
            $order->update(['status' => OrderStatusEnum::CASH_ON_DELIVERY->value]);
        }

        // Create a record in the Payment table for cash payment
        Payment::create([
            'payment_token' => uniqid(),
            'amount' => $amount,
            'currency' => 'EGP',
            'status' => OrderStatusEnum::CASH_ON_DELIVERY->value,
            'created_at' => now(),
        ]);

        event(new OrderConfirmedEvent($order, $user));

        return $this->success('Cash payment done');
    }

    public function successPage(Request $request)
    {
        $cartID = $request->query('CartID');
        $transactionID = $request->query('transactionID');

        // Update the ShopOrders table
        $orders = Order::where('CartID', $cartID)->get();

        foreach ($orders as $order) {
            $order->Status = 1;
            $order->TransactionID = $transactionID;
            $order->save();
        }

        // Insert or update the Payment table
        Payment::updateOrCreate(
            ['OrderID' => $cartID],
            [
                'TransactionID' => $transactionID,
                'source_data_type' => 'card',
                'source_data_sub_type' => 'visa',
            ]
        );

    }

    public function handleTransactionProcessed(Request $request)
    {
        // ?id=237877218
        // &pending=false
        // &amount_cents=44000
        // &success=false
        // &is_auth=false
        // &is_capture=false
        // &is_standalone_payment=true
        // &is_voided=false
        // &is_refunded=false
        // &is_3d_secure=false
        // &integration_id=4417643
        // &profile_id=97671
        // &has_parent_transaction=false
        // &order=267314090
        // &created_at=2024-11-23T15%3A48%3A45.145277
        // &currency=EGP
        // &merchant_commission=0
        // &discount_details=%5B%5D
        // &is_void=false
        // &is_refund=false
        // &error_occured=true
        // &refunded_amount_cents=0
        // &captured_amount=0
        // &updated_at=2024-11-23T15%3A48%3A46.982467
        // &is_settled=false
        // &bill_balanced=false
        // &is_bill=false
        // &owner=159677
        // &merchant_order_id=6741dc9ecec5a
        // &data.message=Invalid+Card+Number
        // &source_data.type=card
        // &source_data.pan=2424
        // &source_data.sub_type=Visa
        // &acq_response_code=-1
        // &txn_response_code=-1
        // &hmac=ff72e2f28db8d3dffa84b294f5788fe418bebd5cf7969aefd51f92605934a7fe24e6ee16b88037c244b2f102aa1906f418edddfebd79c8bd5c89d4392b650152
        $validated = $request->validate([
            'order' => 'required|string', // Paymob order ID
            'success' => 'required|boolean', // Payment success
            'amount_cents' => 'required|integer', // Payment amount
            'currency' => 'required|string', // Payment currency
            'hmac' => 'required|string', // Hash for callback validation
        ]);
        Log::error('Request data: ' . json_encode($request->all()));
        Log::error('Validated request: ' . json_encode($validated));

        $orders = Order::whereIn('id', $validated['order_ids'])->get();
        Log::error('orders: ' .$orders);

        if ($orders->isEmpty()) {
            return response()->json(['message' => 'Orders not found'], 404);
        }

        try {
            $user = Auth::guard('sanctum')->user();
            Log::error('User: ' .$user);

            $status = $validated['success'] ? OrderStatusEnum::COMPLETED->value : OrderStatusEnum::FAILED->value;
            $orders->each(fn($order) => $order->update(['status' => $status]));
    
            if ($validated['success']) {
                Payment::create([
                    'payment_token' => $request->input('hmac'),
                    'amount' => $validated['amount_cents'] / 100,
                    'currency' => $validated['currency'],
                    'status' => $status,
                    'created_at' => now(),
                ]);
    
                event(new OrderConfirmedEvent($orders, $user));
    
                return redirect(env('FRONTEND_SUCCESS_URL', 'https://orangered-curlew-529745.hostingersite.com/payment/success'));
            }
    
            return redirect(env('FRONTEND_FAILURE_URL', 'https://orangered-curlew-529745.hostingersite.com/payment/failed'));
        } catch (\Exception $e) {
            Log::error('Payment processing error: ' . $e->getMessage());
            return response()->json(['message' => 'Payment processing failed'], 500);
        }
    }

    public function success()
    {
        return redirect(env('FRONTEND_SUCCESS_URL', 'https://orangered-curlew-529745.hostingersite.com/payment/success'));
    }
    public function failed()
    {
        return redirect(env('FRONTEND_FAILURE_URL', 'https://orangered-curlew-529745.hostingersite.com/payment/failed'));
    }
}
