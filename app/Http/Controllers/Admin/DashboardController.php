<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistics
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $totalRevenue = Order::where('status', 'delivered')->sum('total');
        $totalProducts = Product::count();
        $totalUsers = User::count();
        $pendingReviews = Review::where('is_approved', false)->count();

        // Recent Orders
        $recentOrders = Order::with('user')
            ->latest()
            ->limit(10)
            ->get();

        // Sales Data for Chart
        $salesData = Order::where('status', 'delivered')
            ->selectRaw('DATE(created_at) as date, SUM(total) as total')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->limit(30)
            ->get();

        return view('admin.dashboard', compact(
            'totalOrders',
            'pendingOrders',
            'totalRevenue',
            'totalProducts',
            'totalUsers',
            'pendingReviews',
            'recentOrders',
            'salesData'
        ));
    }

    public function analytics()
    {
        // Analytics data
        return view('admin.analytics');
    }

    public function stats()
    {
        $stats = [
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'total_revenue' => Order::where('status', 'delivered')->sum('total'),
            'total_products' => Product::count(),
            'total_users' => User::count(),
        ];

        return response()->json($stats);
    }

    public function notifications()
    {
        // Get notifications
        return view('admin.notifications');
    }

    public function markAsRead($id)
    {
        // Mark notification as read
        return response()->json(['success' => true]);
    }

    public function markAllAsRead()
    {
        // Mark all notifications as read
        return response()->json(['success' => true]);
    }
    public function profile()
{
    $user = Auth::user();
    return view('admin.profile', compact('user'));
}

public function updateProfile(Request $request)
{
    $user = Auth::user();
    
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
    ]);

    $user->update($request->only(['name', 'email']));

    return redirect()->back()->with('success', 'Profile updated successfully!');
}
}