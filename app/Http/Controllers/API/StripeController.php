<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class StripeController extends Controller
{
    public function createPaymentIntent(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $paymentIntent = PaymentIntent::create([
            'amount' => 1000, // e.g., amount in cents for $10
            'currency' => 'usd',
            // 'payment_method_types' => ['card'], // Optional: specify payment method types
        ]);

        return response()->json([
            'clientSecret' => $paymentIntent->client_secret,
        ]);
    }
}
