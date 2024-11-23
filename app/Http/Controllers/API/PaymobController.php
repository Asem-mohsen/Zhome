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
        $validated = $request->validate([
            'order_ids' => 'required|array',
            'success' => 'required|boolean',
            'amount_cents' => 'required|integer',
            'currency' => 'required|string',
        ]);
    
        $orders = Order::whereIn('id', $validated['order_ids'])->get();

        if ($orders->isEmpty()) {
            return response()->json(['message' => 'Orders not found'], 404);
        }

        try {
            $user = Auth::guard('sanctum')->user();
    
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
