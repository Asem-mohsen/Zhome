<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Webhook;
use Stripe\Checkout\Session as StripeSession;
use App\Models\ShopOrders;
use App\Models\Payments;
use Illuminate\Support\Facades\Log;

class StripeWebhook extends Controller
{
    public function handleWebhook(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $endpoint_secret = config('services.stripe.webhook_secret');

        $payload = $request->getContent();
        $sig_header = $request->header('stripe-signature');

        try {
            $event = Webhook::constructEvent($payload, $sig_header, $endpoint_secret);
        } catch (\UnexpectedValueException $e) {
            Log::error('Invalid payload');
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            Log::error('Invalid signature');
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        // Handle the event
        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object; // Contains a Stripe Checkout Session object

            $cartID = $session->client_reference_id;
            $transactionID = $session->payment_intent;

            // Update ShopOrders model
            $order = ShopOrders::where('cart_id', $cartID)->first();
            if ($order) {
                $order->status = 'paid';
                $order->save();
            }

            // Insert or update Payment table
            Payments::updateOrCreate(
                ['cart_id' => $cartID],
                [
                    'transaction_id' => $transactionID,
                    'amount' => $session->amount_total / 100, // Convert amount from cents to currency
                    'currency' => $session->currency,
                    'status' => $session->payment_status
                ]
            );

            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'ignored']);
    }
}