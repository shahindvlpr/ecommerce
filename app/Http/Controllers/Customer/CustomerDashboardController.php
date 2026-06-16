<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Wishlist;
use App\Models\Review;
use App\Models\Address;
use App\Models\User;

class CustomerDashboardController extends Controller
{
    /**
     * Show the customer dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Check if user is customer or admin
        if ($user->role !== 'customer' && !$user->is_admin) {
            abort(403, 'Unauthorized access. You must be a customer to view this page.');
        }

        // Get customer statistics
        $totalOrders = Order::where('user_id', $user->id)->count();
        $pendingOrders = Order::where('user_id', $user->id)->where('status', 'pending')->count();
        $completedOrders = Order::where('user_id', $user->id)->where('status', 'delivered')->count();
        $cancelledOrders = Order::where('user_id', $user->id)->where('status', 'cancelled')->count();
        
        $wishlistCount = Wishlist::where('user_id', $user->id)->count();
        $reviewsCount = Review::where('user_id', $user->id)->count();
        $addressesCount = Address::where('user_id', $user->id)->count();

        // Get recent orders
        $recentOrders = Order::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Get total spent
        $totalSpent = Order::where('user_id', $user->id)
            ->where('status', 'delivered')
            ->sum('total');

        // Get user details
        $userDetails = User::where('id', $user->id)->first();

        return view('customer.dashboard', compact(
            'user',
            'userDetails',
            'totalOrders',
            'pendingOrders',
            'completedOrders',
            'cancelledOrders',
            'wishlistCount',
            'reviewsCount',
            'addressesCount',
            'recentOrders',
            'totalSpent'
        ));
    }
}