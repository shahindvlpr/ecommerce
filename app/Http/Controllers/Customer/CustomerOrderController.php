<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;

class CustomerOrderController extends Controller
{
    /**
     * Display a listing of the user's orders.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Check if user is customer or admin
        if ($user->role !== 'customer' && !$user->is_admin) {
            abort(403, 'Unauthorized access.');
        }

        $query = Order::where('user_id', $user->id);

        // Filter by status
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->has('from') && $request->has('to')) {
            $query->whereBetween('created_at', [$request->from, $request->to]);
        }

        $orders = $query->with('items')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('customer.orders', compact('orders'));
    }

    /**
     * Display the specified order details.
     */
    public function show($id)
    {
        $user = Auth::user();
        
        // Check if user is customer or admin
        if ($user->role !== 'customer' && !$user->is_admin) {
            abort(403, 'Unauthorized access.');
        }

        $order = Order::where('user_id', $user->id)
            ->with(['items.product', 'items.variation', 'payment'])
            ->findOrFail($id);

        return view('customer.order-details', compact('order'));
    }

    /**
     * Cancel an order.
     */
    public function cancel($id)
    {
        $user = Auth::user();
        
        // Check if user is customer or admin
        if ($user->role !== 'customer' && !$user->is_admin) {
            abort(403, 'Unauthorized access.');
        }

        $order = Order::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'processing'])
            ->findOrFail($id);

        $order->status = 'cancelled';
        $order->save();

        return redirect()->back()->with('success', 'Order cancelled successfully.');
    }

    /**
     * Get order statuses for filtering.
     */
    public function getStatuses()
    {
        return response()->json([
            'statuses' => [
                'all' => 'All Orders',
                'pending' => 'Pending',
                'processing' => 'Processing',
                'shipped' => 'Shipped',
                'delivered' => 'Delivered',
                'cancelled' => 'Cancelled'
            ]
        ]);
    }

    /**
     * Get order statistics for the user.
     */
    public function getStats()
    {
        $user = Auth::user();
        
        $stats = [
            'total' => Order::where('user_id', $user->id)->count(),
            'pending' => Order::where('user_id', $user->id)->where('status', 'pending')->count(),
            'processing' => Order::where('user_id', $user->id)->where('status', 'processing')->count(),
            'delivered' => Order::where('user_id', $user->id)->where('status', 'delivered')->count(),
            'cancelled' => Order::where('user_id', $user->id)->where('status', 'cancelled')->count(),
            'total_spent' => Order::where('user_id', $user->id)->where('status', 'delivered')->sum('total'),
        ];

        return response()->json($stats);
    }

    /**
     * Download order invoice as PDF.
     */
    public function invoice($id)
    {
        $user = Auth::user();
        
        // Check if user is customer or admin
        if ($user->role !== 'customer' && !$user->is_admin) {
            abort(403, 'Unauthorized access.');
        }

        $order = Order::where('user_id', $user->id)
            ->with(['items.product', 'user'])
            ->findOrFail($id);

        // Generate PDF invoice (using DomPDF or similar)
        // $pdf = PDF::loadView('customer.invoice', compact('order'));
        // return $pdf->download('invoice-' . $order->order_number . '.pdf');

        return view('customer.invoice', compact('order'));
    }
}