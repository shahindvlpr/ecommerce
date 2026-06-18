<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\SslCommerzService;
use Illuminate\Http\Request;

class SslCommerzController extends Controller
{
    public function pay($orderId)
    {
        $order = Order::findOrFail($orderId);
        
        $sslcommerz = new SslCommerzService();
        $paymentUrl = $sslcommerz->createPayment($order);
        
        if ($paymentUrl) {
            return redirect($paymentUrl);
        }
        
        return redirect()->route('checkout.cancel')
            ->with('error', 'Payment initialization failed!');
    }

    public function success(Request $request)
    {
        // Payment success logic
        $order = Order::where('order_number', $request->tran_id)->first();
        
        if ($order) {
            $order->payment_status = 'paid';
            $order->status = 'processing';
            $order->save();
        }

        return redirect()->route('checkout.success', $order->id ?? 0)
            ->with('success', 'Payment successful!');
    }

    public function fail(Request $request)
    {
        return redirect()->route('checkout.cancel')
            ->with('error', 'Payment failed!');
    }

    public function cancel(Request $request)
    {
        return redirect()->route('checkout.cancel')
            ->with('error', 'Payment cancelled!');
    }

    public function ipn(Request $request)
    {
        // IPN logic
        return response()->json(['status' => 'success']);
    }
}