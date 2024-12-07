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
use Illuminate\Support\Facades\Validator;

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

        $orderIds = $request->input('order_ids', []);
        $totalAmount = $request->input('amount', 0);


        if (empty($orderIds)) {
            return response()->json(['message' => 'No orders provided for payment'], 400);
        }

        // Step 1: total amount for unpaid orders
        if ($totalAmount <= 0) {
            return response()->json(['message' => 'No amount due for payment'], 400);
        }

        // Step 2: Authenticate and get the token
        $authToken = $this->paymobService->authenticate();

        // Step 3: Create an order in Paymob with the total amount
        $orderData = $this->paymobService->createOrder($authToken,(int)($totalAmount * 100), $orderIds);
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

    public function handleTransactionProcessed(Request $request)
    {
        $data = $request->all();

        // Step 1: Verify HMAC signature
        if (!$this->verifyHmac($data)) {
            return response()->json(['message' => 'Invalid HMAC signature'], 403);
        }

        $orderIds = explode(',', $request->input('merchant_order_id', ''));
        if (empty($orderIds)) {
            return redirect(env('FRONTEND_FAILURE_URL', 'http://localhost:4200/payment/failed'));
        }

        DB::beginTransaction();
        try {
            // Step 2: Retrieve orders
            $orders = Order::whereIn('id', $orderIds)->get();
            if ($orders->isEmpty()) {
                Log::error('Orders not found', ['order_ids' => $orderIds, 'data' => $data]);
                return redirect(env('FRONTEND_FAILURE_URL', 'http://localhost:4200/payment/failed'));
            }

            // Step 3: Determine transaction success
            $isSuccess = filter_var($request->input('success'), FILTER_VALIDATE_BOOLEAN);
            $status = $isSuccess ? OrderStatusEnum::COMPLETED->value : OrderStatusEnum::FAILED->value;

            // Step 4: Process each order
            foreach ($orders as $order) {
                $this->processTransaction($order, $request, $status);
            }

            DB::commit();

            return $isSuccess
            ? redirect(env('FRONTEND_SUCCESS_URL', 'http://localhost:4200/payment/success'))
            : redirect(env('FRONTEND_FAILURE_URL', 'http://localhost:4200/payment/failed'));

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error processing Paymob callback', [
                'error' => $e->getMessage(),
                'data' => $data,
            ]);
            return redirect(env('FRONTEND_FAILURE_URL', 'http://localhost:4200/payment/failed'));
        }
    }

    private function processTransaction(Order $order, Request $request, string $status)
    {
        $product = $order->product;

        if (!$product) {
            throw new \Exception("Product not found for order ID {$order->id}");
        }

        if ($status === OrderStatusEnum::COMPLETED->value) {
            if ($product->quantity < $order->quantity) {
                throw new \Exception("Not enough stock for product ID {$product->id}");
            }
            $product->update([
                'quantity' => $product->quantity - $order->quantity,
            ]);
        }

        $order->update([
            'status' => $status,
            'transaction_id' => $request->input('hmac'),
        ]);

        Payment::create([
            'payment_token' => $request->input('hmac'),
            'order_id' => $order->id,
            'amount' => $order->total_amount,
            'currency' => $request->input('currency', 'EGP'),
            'type' => $request->input('source_data_sub_type'),
            'payment_status' => $status,
        ]);

        Log::info("Order ID {$order->id} processed with status: {$status}");
    }

    public function cashPayment(Request $request)
    {
        $user = Auth::guard('sanctum')->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        $amount = $request->input('amount');

        // Fetch pending orders
        $orders = $user->orders()
            ->where('status', OrderStatusEnum::PENDING->value)
            ->with(['product.translations'])
            ->get();

        if ($orders->isEmpty()) {
            return $this->error(['message' => 'No pending orders found'], "No pending orders found", 404);
        }


        DB::beginTransaction();

        try {
            $processedOrders = collect();

            $uniqueToken = uniqid('CASH_PAYMENT_');

            foreach ($orders as $order) {
               $this->processOrder($order, $uniqueToken);
    
                $processedOrders->push($order);
            }

            event(new OrderConfirmedEvent($processedOrders, $user));

            DB::commit();

            $responseData = $this->prepareOrderResponse($processedOrders, $uniqueToken);

            return $this->data($responseData, 'Order placed successfully');

        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('Cash payment failed: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'amount' => $amount,
            ]);

            return $this->error(['message' => 'An error occurred'], "Please try again in a few minutes", 500);
        }

    }
    private function processOrder($order, $uniqueToken)
    {
        $product = $order->product;

        if (!$product) {
            throw new \Exception("Product not found for order ID {$order->id}");
        }

        if ($product->quantity < $order->quantity) {
            throw new \Exception("Not enough stock for product ID {$product->id}");
        }

        $product->update([
            'quantity' => $product->quantity - $order->quantity,
        ]);

        $order->update(['status' => OrderStatusEnum::CASH_ON_DELIVERY->value ,'transaction_id' => $uniqueToken] );

        Payment::create([
            'order_id' => $order->id,
            'payment_token' => $uniqueToken,
            'amount' => $order->total_amount,
            'currency' => 'EGP',
            'type'=> OrderStatusEnum::CASH_ON_DELIVERY->value,
            'payment_status' => OrderStatusEnum::CASH_ON_DELIVERY->value,
            'created_at' => now(),
        ]);
    }
    private function prepareOrderResponse($orders,$uniqueToken)
    {
        return [
            'payment_token' => $uniqueToken,
            'orders' => $orders->map(function ($order) {
                return [
                    'order_id' => $order->id,
                    'total_amount' => $order->total_amount,
                    'currency' => 'EGP',
                    'status' => $order->status,
                    'product' => [
                        'product_name' => $order->product->translations->name ?? 'N/A',
                        'product_image' => $order->product->image_url ?? 'N/A',
                        'product_description' => $order->product->description ?? 'N/A',
                        'quantity' => $order->quantity,
                        'total_price' => $order->total_amount,
                    ],
                ];
            })->toArray(),
        ];
    }

    private function verifyHmac(array $data): bool
    {
        $secretKey = env('PAYMOB_HMAC_SECRET');
    
        $receivedHmac = $data['hmac'] ?? null;
        unset($data['hmac']);
    
        $requiredFields = [
            'amount_cents',
            'created_at',
            'currency',
            'error_occured',
            'has_parent_transaction',
            'id',
            'integration_id',
            'is_3d_secure',
            'is_auth',
            'is_capture',
            'is_refunded',
            'is_standalone_payment',
            'is_voided',
            'order',
            'owner',
            'pending',
            'source_data_pan',
            'source_data_sub_type',
            'source_data_type',
            'success',
        ];
    
        $concatenatedString = '';
        foreach ($requiredFields as $field) {
            $value = $data[$field] ?? null;
    
            if ($value === null) {
                if (in_array($field, ['source_data_pan', 'source_data_sub_type', 'source_data_type'])) {
                    $value = ''; 
                } else {
                    Log::error("Missing required field: $field");
                    return false; 
                }
            }
    
            $concatenatedString .= $value;
        }
    
        $calculatedHmac = hash_hmac('sha512', $concatenatedString, $secretKey);
    
        return hash_equals($calculatedHmac, $receivedHmac);
    }
}
