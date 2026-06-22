<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::where('vendor_id', Auth::id())->with('user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'LIKE', "%{$search}%")
                  ->orWhereHas('user', function($user) use ($search) {
                      $user->where('name', 'LIKE', "%{$search}%");
                  });
            });
        }

        $orders = $query->latest()->paginate(20);

        $statusCounts = [
            'all' => Order::where('vendor_id', Auth::id())->count(),
            'pending' => Order::where('vendor_id', Auth::id())->where('status', 'pending')->count(),
            'processing' => Order::where('vendor_id', Auth::id())->where('status', 'processing')->count(),
            'shipped' => Order::where('vendor_id', Auth::id())->where('status', 'shipped')->count(),
            'delivered' => Order::where('vendor_id', Auth::id())->where('status', 'delivered')->count(),
            'cancelled' => Order::where('vendor_id', Auth::id())->where('status', 'cancelled')->count(),
        ];

        return view('vendor.orders.index', compact('orders', 'statusCounts'));
    }

    public function show($id)
    {
        $order = Order::where('vendor_id', Auth::id())
            ->with(['user', 'items.product'])
            ->findOrFail($id);

        return view('vendor.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::where('vendor_id', Auth::id())->findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled'
        ]);

        $order->update(['status' => $request->status]);

        return redirect()->route('vendor.orders.index')
            ->with('success', 'Order status updated successfully!');
    }

    public function invoice($id)
    {
        $order = Order::where('vendor_id', Auth::id())->findOrFail($id);

        // Invoice generation logic
        return view('vendor.orders.invoice', compact('order'));
    }
}