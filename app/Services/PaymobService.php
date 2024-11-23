<?php

namespace App\Services;

use GuzzleHttp\Client;

class PaymobService
{
    protected $client;

    protected $apiKey;

    protected $integrationId;

    protected $iframeId;

    protected $hmacSecret;

    public function __construct()
    {
        $this->client = new Client;
        $this->apiKey = config('services.paymob.api_key');
        $this->integrationId = config('services.paymob.integration_id');
        $this->iframeId = config('services.paymob.iframe_id');
        $this->hmacSecret = config('services.paymob.hmac_secret');
    }

    public function authenticate()
    {
        $response = $this->client->post('https://accept.paymob.com/api/auth/tokens', [
            'json' => [
                'api_key' => $this->apiKey,
            ],
        ]);

        $data = json_decode($response->getBody(), true);

        return $data['token'];
    }

    public function createOrder($token, $amount)
    {
        $response = $this->client->post('https://accept.paymob.com/api/ecommerce/orders', [
            'headers' => ['Authorization' => "Bearer $token"],
            'json' => [
                'amount_cents' => $amount,
                'currency' => 'EGP',
                'merchant_order_id' => uniqid(),
            ],
        ]);

        return json_decode($response->getBody(), true);
    }

    public function getPaymentToken($orderId, $amount, $token, $billingData)
    {
        $response = $this->client->post('https://accept.paymob.com/api/acceptance/payment_keys', [
            'headers' => ['Authorization' => "Bearer $token"],
            'json' => [
                'amount_cents' => $amount * 100,
                'currency' => 'EGP',
                'order_id' => $orderId,
                'integration_id' => $this->integrationId,
                'billing_data' => [
                    'apartment' => $billingData['apartment'] ?? 'N/A',
                    'email' => $billingData['email'],
                    'floor' => $billingData['floor'] ?? 'N/A',
                    'first_name' => $billingData['first_name'],
                    'street' => $billingData['street'] ?? 'N/A',
                    'building' => $billingData['building'] ?? 'N/A',
                    'phone_number' => $billingData['phone_number'],
                    'shipping_method' => $billingData['shipping_method'] ?? 'PKG',
                    'postal_code' => $billingData['postal_code'] ?? '00000',
                    'city' => $billingData['city'],
                    'country' => $billingData['country'] ?? 'EG',
                    'last_name' => $billingData['last_name'],
                    'state' => $billingData['state'] ?? 'N/A',
                ],
            ],
        ]);

        return json_decode($response->getBody(), true)['token'];
    }
}
