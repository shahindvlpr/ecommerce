<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Wishlist;
use App\Models\Review;
use App\Models\Address;

class CustomerDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->role !== 'customer' && !$user->is_admin) {
            abort(403, 'Unauthorized access.');
        }

        $totalOrders = Order::where('user_id', $user->id)->count();
        $pendingOrders = Order::where('user_id', $user->id)->where('status', 'pending')->count();
        $completedOrders = Order::where('user_id', $user->id)->where('status', 'delivered')->count();
        $wishlistCount = Wishlist::where('user_id', $user->id)->count();
        $reviewsCount = Review::where('user_id', $user->id)->count();
        $addressesCount = Address::where('user_id', $user->id)->count();
        $totalSpent = Order::where('user_id', $user->id)->where('status', 'delivered')->sum('total');
        $recentOrders = Order::where('user_id', $user->id)->orderBy('created_at', 'desc')->limit(5)->get();

        return view('customer.dashboard', compact(
            'user',
            'totalOrders',
            'pendingOrders',
            'completedOrders',
            'wishlistCount',
            'reviewsCount',
            'addressesCount',
            'totalSpent',
            'recentOrders'
        ));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('customer.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:255',
        ]);

        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'postal_code' => $request->postal_code,
            'country' => $request->country,
        ]);

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
}