<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

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

        $orders = Order::where('user_id', $user->id)
            ->with('items')
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
            ->with(['items.product', 'items.variation'])
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
}