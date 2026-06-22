<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\VendorEarning;
use App\Models\VendorWithdraw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorEarningController extends Controller
{
    public function index()
    {
        $vendorId = Auth::id();

        $stats = [
            'total_earnings' => VendorEarning::where('vendor_id', $vendorId)->where('status', 'paid')->sum('net_amount'),
            'pending_earnings' => VendorEarning::where('vendor_id', $vendorId)->where('status', 'pending')->sum('net_amount'),
            'total_withdrawn' => VendorWithdraw::where('vendor_id', $vendorId)->where('status', 'completed')->sum('net_amount'),
            'pending_withdrawals' => VendorWithdraw::where('vendor_id', $vendorId)->where('status', 'pending')->sum('amount'),
        ];

        $earnings = VendorEarning::where('vendor_id', $vendorId)
            ->with('order')
            ->latest()
            ->paginate(20);

        $withdrawals = VendorWithdraw::where('vendor_id', $vendorId)
            ->latest()
            ->get();

        return view('vendor.earnings.index', compact('stats', 'earnings', 'withdrawals'));
    }

    public function withdraw(Request $request)
    {
        $vendorId = Auth::id();

        $pendingEarnings = VendorEarning::where('vendor_id', $vendorId)
            ->where('status', 'pending')
            ->sum('net_amount');

        if ($pendingEarnings <= 0) {
            return back()->with('error', 'No pending earnings to withdraw.');
        }

        $request->validate([
            'amount' => 'required|numeric|min:100|max:' . $pendingEarnings,
            'payment_method' => 'required|in:bank_transfer,bkash,nagad',
            'account_details' => 'required|string',
        ]);

        $withdraw = VendorWithdraw::create([
            'vendor_id' => $vendorId,
            'amount' => $request->amount,
            'fee' => 0,
            'net_amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'account_details' => $request->account_details,
            'notes' => $request->notes,
            'status' => 'pending',
        ]);

        // Mark earnings as processing
        VendorEarning::where('vendor_id', $vendorId)
            ->where('status', 'pending')
            ->update(['status' => 'processing']);

        return redirect()->route('vendor.earnings')
            ->with('success', 'Withdrawal request submitted successfully!');
    }

    public function requestWithdraw(Request $request)
    {
        return $this->withdraw($request);
    }
}