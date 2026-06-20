<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
public function index()

{
    
    try {
    
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $totalRevenue = Order::where('status', 'delivered')->sum('total') ?? 0;
        $totalProducts = Product::count();
        $totalUsers = User::count();
        $pendingReviews = Review::where('is_approved', false)->count();

        $recentOrders = Order::with('user')->latest()->limit(10)->get();
        
        $salesData = Order::where('status', 'delivered')
            ->selectRaw('DATE(created_at) as date, SUM(total) as total')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->limit(30)
            ->get();

        $latestNotifications = Notification::where('user_id', Auth::id())
            ->latest()
            ->take(5)
            ->get();

        $unreadCount = Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->count();

        $recentUsers = User::latest()->take(5)->get();

        $categoryStats = \App\Models\Category::withCount('products')
            ->latest('products_count')
            ->take(5)
            ->get();

        $lowStockProducts = Product::where('stock', '<', 10)
            ->where('stock', '>', 0)
            ->take(5)
            ->get();

        $pendingPayments = \App\Models\Payment::where('status', 'pending')->count() ?? 0;
        $pendingVendors = User::where('role', 'vendor')->where('status', 'pending')->count() ?? 0;

        return view('admin.dashboard', compact(
            'totalOrders',
            'pendingOrders',
            'totalRevenue',
            'totalProducts',
            'totalUsers',
            'pendingReviews',
            'recentOrders',
            'salesData',
            'latestNotifications',
            'unreadCount',
            'recentUsers',
            'categoryStats',
            'lowStockProducts',
            'pendingPayments',
            'pendingVendors'
        ));
        
    } catch (\Exception $e) {
        \Log::error('Dashboard error: ' . $e->getMessage());
        return view('admin.dashboard', [
            'totalOrders' => 0,
            'pendingOrders' => 0,
            'totalRevenue' => 0,
            'totalProducts' => 0,
            'totalUsers' => 0,
            'pendingReviews' => 0,
            'recentOrders' => collect([]),
            'salesData' => collect([]),
            'latestNotifications' => collect([]),
            'unreadCount' => 0,
            'recentUsers' => collect([]),
            'categoryStats' => collect([]),
            'lowStockProducts' => collect([]),
            'pendingPayments' => 0,
            'pendingVendors' => 0,
        ]);
    }

}

public function analytics()
{
    try {
        // Basic Stats
        $totalOrders = Order::count();
        $totalRevenue = Order::where('status', 'delivered')->sum('total') ?? 0;
        $totalProducts = Product::count();
        $totalUsers = User::count();
        $totalCategories = Category::count();
        $totalVendors = User::where('role', 'vendor')->count();
        $pendingOrders = Order::where('status', 'pending')->count();

        // Monthly Sales Data for Chart
        $monthlySales = Order::where('status', 'delivered')
            ->selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, SUM(total) as total, COUNT(*) as orders_count')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->limit(12)
            ->get()
            ->reverse()
            ->values();

        // Prepare monthly data for chart
        $monthlyLabels = [];
        $monthlyRevenueData = [];
        $monthlyOrdersData = [];

        // ✅ Check if collection is not empty
        if ($monthlySales->isNotEmpty()) {
            foreach ($monthlySales as $sale) {
                $monthName = DateTime::createFromFormat('!m', $sale->month)->format('M');
                $monthlyLabels[] = $monthName . ' ' . $sale->year;
                $monthlyRevenueData[] = (float) $sale->total;
                $monthlyOrdersData[] = $sale->orders_count;
            }
        }

        // If no data, provide default
        if (empty($monthlyLabels)) {
            $monthlyLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            $monthlyRevenueData = [12500, 15200, 16800, 14200, 18900, 21400, 23500, 22800, 25600, 28900, 31200, 34800];
            $monthlyOrdersData = [45, 52, 48, 40, 58, 64, 72, 68, 78, 85, 92, 105];
        }

        // Top Selling Products
        $topProducts = Product::withCount('orderItems')
            ->with(['category', 'orderItems'])
            ->orderBy('order_items_count', 'desc')
            ->limit(5)
            ->get();

        // Category Distribution for Chart
        $categoryStats = Category::withCount('products')
            ->orderBy('products_count', 'desc')
            ->limit(6)
            ->get();

        $categoryLabels = $categoryStats->pluck('name')->toArray();
        $categoryData = $categoryStats->pluck('products_count')->toArray();

        // If no category data, provide default
        if (empty($categoryLabels)) {
            $categoryLabels = ['No Categories'];
            $categoryData = [1];
        }

        // Growth percentages (mock calculation - you can replace with real calculation)
        $totalRevenueGrowth = 18.5;
        $ordersGrowth = 12.3;
        $productsGrowth = 8.7;
        $usersGrowth = 5.6;

        return view('admin.analytics', compact(
            'totalOrders',
            'totalRevenue',
            'totalProducts',
            'totalUsers',
            'totalCategories',
            'totalVendors',
            'pendingOrders',
            'monthlyLabels',
            'monthlyRevenueData',
            'monthlyOrdersData',
            'topProducts',
            'categoryLabels',
            'categoryData',
            'totalRevenueGrowth',
            'ordersGrowth',
            'productsGrowth',
            'usersGrowth'
        ));

    } catch (\Exception $e) {
        Log::error('Analytics error: ' . $e->getMessage());
        
        return view('admin.analytics', [
            'totalOrders' => 0,
            'totalRevenue' => 0,
            'totalProducts' => 0,
            'totalUsers' => 0,
            'totalCategories' => 0,
            'totalVendors' => 0,
            'pendingOrders' => 0,
            'monthlyLabels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            'monthlyRevenueData' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
            'monthlyOrdersData' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
            'topProducts' => collect([]),
            'categoryLabels' => ['No Data'],
            'categoryData' => [1],
            'totalRevenueGrowth' => 0,
            'ordersGrowth' => 0,
            'productsGrowth' => 0,
            'usersGrowth' => 0,
        ]);
    }
}
    public function stats()
    {
        $stats = [
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'total_revenue' => Order::where('status', 'delivered')->sum('total'),
            'total_products' => Product::count(),
            'total_users' => User::count(),
            'pending_reviews' => Review::where('is_approved', false)->count(),
            'unread_notifications' => Notification::where('user_id', Auth::id())
                ->where('is_read', false)
                ->count(),
        ];

        return response()->json($stats);
    }

    /**
     * Get notifications for navbar (AJAX)
     */
    public function getNotifications()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->latest()
            ->take(5)
            ->get();

        $unreadCount = Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->count();

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $unreadCount,
        ]);
    }

    /**
     * Mark a notification as read (AJAX)
     */
    public function markAsRead($id)
    {
        $notification = Notification::where('user_id', Auth::id())
            ->where('id', $id)
            ->first();

        if ($notification) {
            $notification->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
            return response()->json(['success' => true, 'message' => 'Notification marked as read']);
        }

        return response()->json(['success' => false, 'message' => 'Notification not found'], 404);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead()
    {
        Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

        return redirect()->back()->with('success', 'All notifications marked as read');
    }

    /**
     * Delete a notification (AJAX)
     */
    public function deleteNotification($id)
    {
        $notification = Notification::where('user_id', Auth::id())
            ->where('id', $id)
            ->first();

        if ($notification) {
            $notification->delete();
            return response()->json(['success' => true, 'message' => 'Notification deleted']);
        }

        return response()->json(['success' => false, 'message' => 'Notification not found'], 404);
    }

    /**
     * Delete all notifications
     */
    public function deleteAllNotifications()
    {
        Notification::where('user_id', Auth::id())->delete();
        return redirect()->back()->with('success', 'All notifications deleted');
    }

    /**
     * Display admin profile
     */
    public function profile()
    {
        $user = Auth::user();
        return view('admin.profile', compact('user'));
    }

    /**
     * Update admin profile
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:500',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            $avatarName = time() . '_' . $request->file('avatar')->getClientOriginalName();
            $request->file('avatar')->storeAs('public/avatars', $avatarName);
            $validated['avatar'] = $avatarName;
        }

        $user->update($validated);

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    /**
     * Update admin password
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user->update([
            'password' => bcrypt($validated['password']),
        ]);

        return redirect()->back()->with('success', 'Password updated successfully!');
    }
}