<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use App\Traits\ApiResponse;
use App\Models\ShopOrders;
use App\Models\Payments;

class StripeController extends Controller
{
    use ApiResponse ;
    public function createCheckoutSession(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $amount = $request->input('amount');
        $cartID = $request->input('cartID');

        $YOUR_DOMAIN = 'http://localhost:4200';

        try {
            $checkout_session = StripeSession::create([
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'EGP',
                        'product_data' => [
                            'name' => 'Cart Purchase',
                        ],
                        'unit_amount' => $amount * 100, //in cents so I need to multiplie 100
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => $YOUR_DOMAIN . '/cart',
                'cancel_url' => $YOUR_DOMAIN . '/cart',
            ]);

            return response()->json(['url' => $checkout_session->url, 'success' => true]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage(), 'success' => false], 500);
        }
    }

    public function cashPayment(Request $request)
    {
        $request->validate([
            'CartID' => 'required',
            'amount' => 'required',
        ]);

        // Retrieve the CartID from the request
        $cartID = $request->input('CartID');
        $amount = $request->input('amount');
        
        // Retrieve all orders associated with the CartID
        $orders = ShopOrders::where('CartID', $cartID)->get();

        if ($orders->isEmpty()) {
            return response()->json(['error' => 'No orders found for the given CartID'], 404);
        }

        foreach ($orders as $order) {
            $order->Status = '1';
            $order->save();
        }

        // Create a record in the Payment table for cash payment
        Payments::create([
            'OrderID' => $cartID,
            'TransactionID' => null,
            'currency' => 'EGP',
            'amount' => $amount,
            'status' => '2', // Payment is pending until cash is received
            'source_data_type' => 'cash',
            'source_data_sub_type'=>'cash',
        ]);

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