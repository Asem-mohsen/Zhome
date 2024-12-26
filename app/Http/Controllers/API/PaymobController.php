<?php

namespace App\Http\Controllers\API;

use App\Enums\OrderStatusEnum;
use App\Events\OrderConfirmedEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\Checkout\{ CashPaymentRequest , CreatePaymentRequest};
use App\Models\{ Order , Payment};
use App\Services\PaymobService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymobController extends Controller
{
    protected $pending = OrderStatusEnum::PENDING->value;

    public function __construct(protected PaymobService $paymobService)
    {
        $this->paymobService = $paymobService;
    }

    public function createCheckoutSession(CreatePaymentRequest $request)
    {
        $validated = $request->validated();

        $user = Auth::guard('sanctum')->user();

        if (!$user) {
            return failureResponse(message: 'Unauthorized');
        }

        $totalAmount = $validated['amount'];
        if (!$validated['order_id']) {
            return failureResponse('No orders provided for payment', 400);
        }

        if ($totalAmount <= 0) {
            return failureResponse('No amount due for payment', 400);
        }

        $authToken = $this->paymobService->authenticate();

        $orderData = $this->paymobService->createOrder($authToken, (int)($totalAmount * 100), $validated['order_id']);
        $orderId = $orderData['id'];

        $billingData = $this->getUserBillingData($user);

        $paymentToken = $this->paymobService->getPaymentToken($orderId, $totalAmount, $authToken, $billingData);

        $iframeId = config('services.paymob.iframe_id');
        $paymentLink = "https://accept.paymob.com/api/acceptance/iframes/{$iframeId}?payment_token={$paymentToken}";

        return successResponse(['payment_link' => $paymentLink], code: 202);
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

        if (!$this->verifyHmac($data)) {
            return failureResponse('Invalid HMAC signature', 403);
        }

        $orderId = $request->input('merchant_order_id');

        preg_match('/order_(\d+)_/', $orderId, $matches);

        if (empty($matches[1])) {
            return failureResponse('Invalid OrderId Format', 403);
        }

        $numericOrderId = $matches[1];

        DB::beginTransaction();
        try {

            $order = Order::where('id', $numericOrderId)->with('products.product')->first();

            if (!$order) {
                return redirect(env('FRONTEND_FAILURE_URL', 'http://localhost:4200/payment/failed'));
            }

            $isSuccess = filter_var($request->input('success'), FILTER_VALIDATE_BOOLEAN);
            $status = $isSuccess ? OrderStatusEnum::COMPLETED->value : OrderStatusEnum::FAILED->value;

            $this->processTransaction($order, $request, $status);

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
        foreach ($order->products as $orderProduct) {
            $product = $orderProduct->product;

            if (!$product) {
                throw new \Exception("Product not found for order ID {$order->id}");
            }

            if ($status === OrderStatusEnum::COMPLETED->value && $product->quantity < $orderProduct->quantity) {
                throw new \Exception("Not enough stock for product ID {$product->id}");
            }

            $product->update([
                'quantity' => $product->quantity - $orderProduct->quantity,
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

    }

    public function cashPayment(CashPaymentRequest $request)
    {
        $user = Auth::guard('sanctum')->user();

        if (!$user) {
            return failureResponse('Unauthorized', 401);
        }

        $validated = $request->validated();

        $amount  = $validated['amount'];
        $orderId = $validated['order_id'];

        $order = Order::where('id', $orderId)->with('products.product')->first();;

        if (!$order) {
            return failureResponse('No pending orders found', 401);
        }

        DB::beginTransaction();

        try {
            $uniqueToken = uniqid('CASH_PAYMENT_');

            foreach ($order->products as $orderProduct) {
                $this->processOrderProduct($orderProduct);
            }

            $uniqueToken = uniqid('CASH_PAYMENT_');

            $order->update([
                'status' => strtolower(OrderStatusEnum::CASH_ON_DELIVERY->value),
                'transaction_id' => $uniqueToken,
            ]);

            Payment::create([
                'order_id' => $order->id,
                'payment_token' => $uniqueToken,
                'amount' => $order->total_amount,
                'currency' => 'EGP',
                'type' => OrderStatusEnum::CASH_ON_DELIVERY->value,
                'payment_status' => OrderStatusEnum::CASH_ON_DELIVERY->value,
                'created_at' => now(),
            ]);

            event(new OrderConfirmedEvent($order, $user));

            DB::commit();

            $responseData = $this->prepareOrderResponse($order, $uniqueToken);

            return successResponse($responseData ,'Order placed successfully');

        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('Cash payment failed: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'amount' => $amount,
            ]);

            return failureResponse('Please try again in a few minutes', 500);
        }

    }
    
    private function processOrderProduct($orderProduct)
    {
        $product = $orderProduct->product;
    
        if ($product->quantity < $orderProduct->quantity) {
            return failureResponse('"Not enough stock for product', 500);
        }

        $product->update([
            'quantity' => $product->quantity - $orderProduct->quantity,
        ]);
    }

    private function prepareOrderResponse($order, $uniqueToken)
    {
        Log::info("Preparing order response", [
            'order_id' => $order->id,
            'products_count' => $order->products->count(),
        ]);
        return [
            'payment_token' => $uniqueToken,
            'order' => [
                'order_id' => $order->id,
                'total_amount' => $order->total_amount,
                'currency' => 'EGP',
                'status' => $order->status,
                'products' => $order->products->map(function ($orderProduct) {
                    $product = $orderProduct->product;
    
                    // Ensure the product exists
                    if (!$product) {
                        Log::error("Product not found for order product", [
                            'order_product_id' => $orderProduct->id,
                        ]);
                        return [
                            'product_name' => 'N/A',
                            'product_image' => 'N/A',
                            'product_description' => 'N/A',
                            'quantity' => $orderProduct->quantity,
                            'total_price' => 0,
                        ];
                    }
    
                    return [
                        'product_name' => $product->translations->name ?? 'N/A',
                        'product_image' => $product->image_url ?? 'N/A',
                        'product_description' => $product->description ?? 'N/A',
                        'quantity' => $orderProduct->quantity,
                        'total_price' => $orderProduct->quantity * $product->getCurrentPrice(),
                    ];
                }),
            ],
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
                    $value = ''; // Optional fields, set as empty string if missing
                } else {
                    Log::error("Missing required field: {$field}");
                    return false; // Missing a required field, abort HMAC verification
                }
            }

            $concatenatedString .= $value;
        }

        $calculatedHmac = hash_hmac('sha512', $concatenatedString, $secretKey);

        $isValidHmac = hash_equals($calculatedHmac, $receivedHmac);
        if (!$isValidHmac) {
            Log::warning("HMAC validation failed. Calculated: {$calculatedHmac}, Received: {$receivedHmac}");
        }

        return $isValidHmac;
    }
}
