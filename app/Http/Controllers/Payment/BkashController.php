<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\BkashService;
use Illuminate\Http\Request;

class BkashController extends Controller
{
    protected $bkash;

    public function __construct(BkashService $bkash)
    {
        $this->bkash = $bkash;
    }

    /**
     * bKash Callback
     */
    public function callback(Request $request)
    {
        $paymentID = $request->paymentID;
        $status = $request->status;

        if ($status == 'success') {
            // Execute payment
            $result = $this->bkash->executePayment($paymentID);

            if ($result && $result['transactionStatus'] == 'Completed') {
                // Get order from session
                $orderId = session('bkash_order_id');
                $order = Order::find($orderId);

                if ($order) {
                    $order->payment_status = 'paid';
                    $order->status = 'processing';
                    $order->save();

                    session()->forget(['bkash_payment_id', 'bkash_order_id']);

                    return redirect()->route('checkout.success', $order->id)
                        ->with('success', 'Payment successful! Order confirmed.');
                }
            }
        }

        return redirect()->route('checkout.cancel')
            ->with('error', 'Payment failed! Please try again.');
    }
}