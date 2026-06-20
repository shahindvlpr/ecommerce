<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorDashboardController extends Controller
{
    /**
     * Display vendor dashboard.
     */
    public function index()
    {
        $vendor = Auth::user();
        
        // Vendor এর প্রোডাক্টের পরিসংখ্যান
        $totalProducts = Product::where('vendor_id', $vendor->id)->count();
        $totalOrders = Order::whereHas('items.product', function ($query) use ($vendor) {
            $query->where('vendor_id', $vendor->id);
        })->count();
        
        $pendingOrders = Order::whereHas('items.product', function ($query) use ($vendor) {
            $query->where('vendor_id', $vendor->id);
        })->where('status', 'pending')->count();
        
        $totalRevenue = Order::whereHas('items.product', function ($query) use ($vendor) {
            $query->where('vendor_id', $vendor->id);
        })->where('status', 'delivered')->sum('total');
        
        $recentOrders = Order::whereHas('items.product', function ($query) use ($vendor) {
            $query->where('vendor_id', $vendor->id);
        })->latest()->take(5)->get();
        
        $lowStockProducts = Product::where('vendor_id', $vendor->id)
            ->where('stock', '<', 10)
            ->get();
        
        return view('vendor.dashboard', compact(
            'vendor',
            'totalProducts',
            'totalOrders',
            'pendingOrders',
            'totalRevenue',
            'recentOrders',
            'lowStockProducts'
        ));
    }

    /**
     * Display vendor profile.
     */
    public function profile()
    {
        $vendor = Auth::user();
        return view('vendor.profile', compact('vendor'));
    }

    /**
     * Update vendor profile.
     */
    public function updateProfile(Request $request)
    {
        $vendor = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $vendor->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'store_name' => 'nullable|string|max:255',
            'store_description' => 'nullable|string|max:1000',
        ]);

        $vendor->update($validated);

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    /**
     * Display vendor settings.
     */
    public function settings()
    {
        $vendor = Auth::user();
        return view('vendor.settings', compact('vendor'));
    }
}