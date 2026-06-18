<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SslCommerzService
{
    protected $storeId;
    protected $storePassword;
    protected $baseUrl;

    public function __construct()
    {
        $this->storeId = config('services.sslcommerz.store_id');
        $this->storePassword = config('services.sslcommerz.store_password');
        $this->baseUrl = config('services.sslcommerz.base_url');
    }

    public function createPayment(Order $order)
    {
        $postData = [
            'store_id' => $this->storeId,
            'store_passwd' => $this->storePassword,
            'total_amount' => $order->total,
            'currency' => 'BDT',
            'tran_id' => $order->order_number,
            'success_url' => route('sslcommerz.success'),
            'fail_url' => route('sslcommerz.fail'),
            'cancel_url' => route('sslcommerz.cancel'),
            'ipn_url' => route('sslcommerz.ipn'),
            'cus_name' => $order->name ?? 'Customer',
            'cus_email' => $order->email ?? 'customer@example.com',
            'cus_phone' => $order->phone ?? '01700000000',
            'cus_add1' => $order->address ?? 'Dhaka',
            'cus_city' => $order->city ?? 'Dhaka',
            'cus_country' => $order->country ?? 'Bangladesh',
            'shipping_method' => 'NO',
            'product_name' => 'Order #' . $order->order_number,
            'product_category' => 'Ecommerce',
            'product_profile' => 'general',
            'multi_card_name' => 'mastercard,visacard,amexcard',
            'value_a' => $order->id,
            'value_b' => $order->order_number,
            'value_c' => $order->user_id,
        ];

        try {
            $response = Http::asForm()->post($this->baseUrl . '/gwprocess/v4/api.php', $postData);

            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['status']) && $data['status'] === 'SUCCESS') {
                    return $data['GatewayPageURL'];
                }
                
                Log::error('SSLCommerz Error: ' . json_encode($data));
                return null;
            }

            Log::error('SSLCommerz HTTP Error: ' . $response->status());
            return null;

        } catch (\Exception $e) {
            Log::error('SSLCommerz Exception: ' . $e->getMessage());
            return null;
        }
    }
}