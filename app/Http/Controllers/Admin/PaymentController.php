<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('order.user')->latest()->paginate(15);
        $stats = [
            'total' => Payment::count(),
            'pending' => Payment::where('status', 'pending')->count(),
            'paid' => Payment::where('status', 'paid')->count(),
            'failed' => Payment::where('status', 'failed')->count(),
            'refunded' => Payment::where('status', 'refunded')->count(),
        ];
        return view('admin.payments.index', compact('payments', 'stats'));
    }

    public function pending()
    {
        $payments = Payment::with('order.user')->where('status', 'pending')->latest()->paginate(15);
        $stats = [
            'total' => Payment::count(),
            'pending' => Payment::where('status', 'pending')->count(),
            'paid' => Payment::where('status', 'paid')->count(),
            'failed' => Payment::where('status', 'failed')->count(),
            'refunded' => Payment::where('status', 'refunded')->count(),
        ];
        return view('admin.payments.index', compact('payments', 'stats'));
    }

    public function paid()
    {
        $payments = Payment::with('order.user')->where('status', 'paid')->latest()->paginate(15);
        $stats = [
            'total' => Payment::count(),
            'pending' => Payment::where('status', 'pending')->count(),
            'paid' => Payment::where('status', 'paid')->count(),
            'failed' => Payment::where('status', 'failed')->count(),
            'refunded' => Payment::where('status', 'refunded')->count(),
        ];
        return view('admin.payments.index', compact('payments', 'stats'));
    }

    public function failed()
    {
        $payments = Payment::with('order.user')->where('status', 'failed')->latest()->paginate(15);
        $stats = [
            'total' => Payment::count(),
            'pending' => Payment::where('status', 'pending')->count(),
            'paid' => Payment::where('status', 'paid')->count(),
            'failed' => Payment::where('status', 'failed')->count(),
            'refunded' => Payment::where('status', 'refunded')->count(),
        ];
        return view('admin.payments.index', compact('payments', 'stats'));
    }

    public function refunded()
    {
        $payments = Payment::with('order.user')->where('status', 'refunded')->latest()->paginate(15);
        $stats = [
            'total' => Payment::count(),
            'pending' => Payment::where('status', 'pending')->count(),
            'paid' => Payment::where('status', 'paid')->count(),
            'failed' => Payment::where('status', 'failed')->count(),
            'refunded' => Payment::where('status', 'refunded')->count(),
        ];
        return view('admin.payments.index', compact('payments', 'stats'));
    }

    public function show(Payment $payment)
    {
        $payment->load('order.user', 'order.items.product');
        return view('admin.payments.show', compact('payment'));
    }

    public function updateStatus(Request $request, Payment $payment)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,failed,refunded'
        ]);

        $payment->status = $request->status;
        $payment->save();

        if ($payment->order) {
            $payment->order->payment_status = $request->status;
            $payment->order->save();
        }

        return redirect()->back()->with('success', 'Payment status updated successfully!');
    }

    public function exportExcel()
    {
        $payments = Payment::with('order.user')->get();

        if ($payments->isEmpty()) {
            return redirect()->back()->with('error', 'No payments found to export!');
        }

        $data = [];
        foreach ($payments as $payment) {
            $data[] = [
                'Payment ID' => $payment->id,
                'Transaction ID' => $payment->transaction_id ?? 'N/A',
                'Order ID' => $payment->order->order_number ?? $payment->order_id,
                'Customer' => $payment->order->user->name ?? 'Guest',
                'Amount' => $payment->amount,
                'Method' => $payment->payment_method,
                'Status' => $payment->status,
                'Date' => $payment->created_at->format('Y-m-d H:i:s'),
            ];
        }

        $fileName = 'payments-' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');
            fwrite($file, "\xEF\xBB\xBF");
            fputcsv($file, array_keys($data[0]));
            foreach ($data as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}