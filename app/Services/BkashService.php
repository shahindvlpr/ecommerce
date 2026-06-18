<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class BkashService
{
    protected $appKey;
    protected $appSecret;
    protected $baseUrl;
    protected $token;

    public function __construct()
    {
        $this->appKey = config('services.bkash.app_key');
        $this->appSecret = config('services.bkash.app_secret');
        $this->baseUrl = config('services.bkash.base_url');
    }

    /**
     * Get bKash Token
     */
    public function getToken()
    {
        $response = Http::post($this->baseUrl . '/tokenized/checkout/token/grant', [
            'app_key' => $this->appKey,
            'app_secret' => $this->appSecret,
        ]);

        if ($response->successful()) {
            $this->token = $response->json()['id_token'];
            return $this->token;
        }

        return null;
    }

    /**
     * Create bKash Payment
     */
    public function createPayment($order, $amount)
    {
        $token = $this->getToken();
        
        if (!$token) {
            return null;
        }

        $response = Http::withHeaders([
            'Authorization' => $token,
            'X-APP-Key' => $this->appKey,
        ])->post($this->baseUrl . '/tokenized/checkout/create', [
            'mode' => '0011',
            'payerReference' => $order->order_number,
            'callbackURL' => route('bkash.callback'),
            'amount' => $amount,
            'currency' => 'BDT',
            'intent' => 'sale',
            'merchantInvoiceNumber' => $order->order_number,
        ]);

        return $response->json();
    }

    /**
     * Execute bKash Payment
     */
    public function executePayment($paymentID)
    {
        $token = $this->getToken();

        $response = Http::withHeaders([
            'Authorization' => $token,
            'X-APP-Key' => $this->appKey,
        ])->post($this->baseUrl . '/tokenized/checkout/execute', [
            'paymentID' => $paymentID,
        ]);

        return $response->json();
    }
}