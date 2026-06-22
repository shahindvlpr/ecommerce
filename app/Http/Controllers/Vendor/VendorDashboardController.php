<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\VendorEarning;
use App\Models\VendorWithdraw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorDashboardController extends Controller
{
    public function index()
    {
        $vendorId = Auth::id();

        // Stats
        $stats = [
            'total_products' => Product::where('vendor_id', $vendorId)->count(),
            'total_orders' => Order::where('vendor_id', $vendorId)->count(),
            'pending_orders' => Order::where('vendor_id', $vendorId)->where('status', 'pending')->count(),
            'total_earnings' => VendorEarning::where('vendor_id', $vendorId)->where('status', 'paid')->sum('net_amount'),
            'pending_earnings' => VendorEarning::where('vendor_id', $vendorId)->where('status', 'pending')->sum('net_amount'),
            'low_stock' => Product::where('vendor_id', $vendorId)->where('stock', '<', 10)->count(),
            'total_withdrawn' => VendorWithdraw::where('vendor_id', $vendorId)->where('status', 'completed')->sum('net_amount'),
        ];

        // Recent Orders
        $recentOrders = Order::where('vendor_id', $vendorId)
            ->with('user')
            ->latest()
            ->take(5)
            ->get();

        // Recent Products
        $recentProducts = Product::where('vendor_id', $vendorId)
            ->latest()
            ->take(5)
            ->get();

        // Recent Earnings
        $recentEarnings = VendorEarning::where('vendor_id', $vendorId)
            ->with('order')
            ->latest()
            ->take(5)
            ->get();

        // Monthly Sales Chart Data
        $monthlySales = Order::where('vendor_id', $vendorId)
            ->where('status', 'delivered')
            ->selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, SUM(total) as total')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->limit(6)
            ->get()
            ->map(function ($item) {
                return [
                    'month' => date('M', mktime(0, 0, 0, $item->month, 1)),
                    'total' => $item->total
                ];
            })
            ->reverse()
            ->values();

        return view('vendor.dashboard.index', compact(
            'stats', 'recentOrders', 'recentProducts', 
            'recentEarnings', 'monthlySales'
        ));
    }

    public function stats()
    {
        $vendorId = Auth::id();

        return response()->json([
            'total_products' => Product::where('vendor_id', $vendorId)->count(),
            'total_orders' => Order::where('vendor_id', $vendorId)->count(),
            'total_earnings' => VendorEarning::where('vendor_id', $vendorId)->where('status', 'paid')->sum('net_amount'),
        ]);
    }

    public function salesReport(Request $request)
    {
        $vendorId = Auth::id();

        $query = Order::where('vendor_id', $vendorId)->where('status', 'delivered');

        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }

        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }

        $sales = $query->selectRaw('DATE(created_at) as date, COUNT(*) as orders, SUM(total) as total')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->paginate(20);

        return view('vendor.reports.sales', compact('sales'));
    }

    public function exportReport(Request $request)
    {
        // Export logic
        return back()->with('success', 'Report exported successfully!');
    }
}