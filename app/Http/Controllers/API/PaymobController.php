<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use App\Services\PaymobService;
use Illuminate\Support\Facades\Auth;
use App\Enums\OrderStatusEnum;
use App\Events\OrderConfirmed;

class PaymobController extends Controller
{
    use ApiResponse ;

    protected $paymobService;

    protected $pending = OrderStatusEnum::PENDING->value;

    public function __construct(PaymobService $paymobService)
    {
        $this->paymobService = $paymobService;
    }

    public function createCheckoutSession(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
    
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    
        // Step 1: Calculate total amount for unpaid orders
        $totalAmount = $this->calculateTotalAmount($user);
    
        if ($totalAmount <= 0) {
            return response()->json(['message' => 'No amount due for payment'], 400);
        }

        // Step 2: Authenticate and get the token
        $authToken = $this->paymobService->authenticate();

        // Step 3: Create an order in Paymob with the total amount
        $orderData = $this->paymobService->createOrder($authToken, $totalAmount);
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

    protected function calculateTotalAmount($user)
    {
        return $user->orders()->where('status', $this->pending)->sum('total_amount');
    }

    protected function getUserBillingData($user)
    {
        $user->load(['phones' , 'address']);

        $address = $user->userAddress;
        $phone = $user->phones->first();

        $nameParts = explode(' ', $user->name);
        $firstName = $nameParts[0];
        $lastName = count($nameParts) > 1 ? end($nameParts) : '';

        return [
            'apartment'     => $address->apartment ?? 'N/A',
            'email'         => $user->email,
            'floor'         => $address->floor ?? 'N/A',
            'first_name'    => $firstName,
            'street'        => $address->street_address ?? 'N/A',
            'building'      => $address->building ?? 'N/A',
            'phone_number'  => $phone->phone ?? 'N/A',
            'shipping_method'=> 'PKG',
            'postal_code'   => $address->postal_code ?? '00000',
            'city'          => $address->city ?? 'N/A',
            'country'       => $address->country ?? 'EG',
            'last_name'     => $lastName,
            'state'         => $address->state ?? 'N/A'
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

        $user->orders()->update(['status' => OrderStatusEnum::COMPLETED->value]);

        // Create a record in the Payment table for cash payment
        Payment::create([
            'OrderID' => $cartID,
            'TransactionID' => null,
            'currency' => 'EGP',
            'amount' => $amount,
            'status' => '2', // Payment is pending until cash is received
            'source_data_type' => 'cash',
            'source_data_sub_type'=>'cash',
        ]);

        event(new OrderConfirmedEvent($order, $user));

        return $this->success('Cash payment option done');
    }

    public function successPage(Request $request)
    {
        $cartID = $request->query('CartID');
        $transactionID = $request->query('transactionID');

        // Update the ShopOrders table
        $orders = ShopOrders::where('CartID', $cartID)->get();

        foreach ($orders as $order) {
            $order->Status = 1 ;
            $order->TransactionID = $transactionID;
            $order->save();
        }

        // Insert or update the Payment table
        Payments::updateOrCreate(
            ['OrderID' => $cartID],
            [
                'TransactionID' => $transactionID,
                'source_data_type' => 'card',
                'source_data_sub_type'=>'visa',
            ]
        );


    }
}
