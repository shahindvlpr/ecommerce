<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Sales Report
     */
    public function sales(Request $request)
    {
        // Get date range
        $startDate = $request->get('start_date', now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-d'));

        // Sales data
        $salesData = Order::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->where('status', 'delivered')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as total_orders'),
                DB::raw('SUM(total) as total_revenue')
            )
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        // Summary stats
        $totalRevenue = Order::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->where('status', 'delivered')
            ->sum('total');

        $totalOrders = Order::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->where('status', 'delivered')
            ->count();

        $averageOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        // Top products
        $topProducts = Order::whereBetween('orders.created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->where('orders.status', 'delivered')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->select(
                'products.id',
                'products.name',
                DB::raw('SUM(order_items.quantity) as total_sold'),
                DB::raw('SUM(order_items.total) as total_revenue')
            )
            ->groupBy('products.id', 'products.name')
            ->orderBy('total_sold', 'desc')
            ->limit(10)
            ->get();

        // Daily orders for chart
        $dailyOrders = Order::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        return view('admin.reports.sales', compact(
            'salesData',
            'totalRevenue',
            'totalOrders',
            'averageOrderValue',
            'topProducts',
            'dailyOrders',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Products Report
     */
    public function products(Request $request)
    {
        $products = Product::with(['category', 'brand'])
            ->withCount('orderItems')
            ->withSum('orderItems', 'total')
            ->latest()
            ->paginate(20);

        $totalProducts = Product::count();
        $activeProducts = Product::where('status', true)->count();
        $inactiveProducts = Product::where('status', false)->count();
        $lowStockProducts = Product::where('stock', '<', 10)->where('stock', '>', 0)->count();
        $outOfStockProducts = Product::where('stock', '<=', 0)->count();

        return view('admin.reports.products', compact(
            'products',
            'totalProducts',
            'activeProducts',
            'inactiveProducts',
            'lowStockProducts',
            'outOfStockProducts'
        ));
    }

    /**
     * Users Report
     */
    public function users(Request $request)
    {
        $users = User::withCount('orders')
            ->withSum('orders', 'total')
            ->latest()
            ->paginate(20);

        $totalUsers = User::count();
        $activeUsers = User::where('status', true)->count();
        $inactiveUsers = User::where('status', false)->count();
        $customers = User::where('role', 'customer')->count();
        $vendors = User::where('role', 'vendor')->count();
        $admins = User::where('role', 'admin')->count();

        // New users this month
        $newUsersThisMonth = User::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        return view('admin.reports.users', compact(
            'users',
            'totalUsers',
            'activeUsers',
            'inactiveUsers',
            'customers',
            'vendors',
            'admins',
            'newUsersThisMonth'
        ));
    }

    /**
     * Top Selling Products
     */
    public function topSelling(Request $request)
    {
        $topProducts = Order::where('status', 'delivered')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->select(
                'products.id',
                'products.name',
                'products.price',
                'products.thumbnail',
                'products.rating',
                DB::raw('SUM(order_items.quantity) as total_sold'),
                DB::raw('SUM(order_items.total) as total_revenue')
            )
            ->groupBy('products.id', 'products.name', 'products.price', 'products.thumbnail', 'products.rating')
            ->orderBy('total_sold', 'desc')
            ->limit(20)
            ->get();

        return view('admin.reports.top-selling', compact('topProducts'));
    }

    /**
     * Low Stock Products
     */
    public function lowStock(Request $request)
    {
        $products = Product::where('stock', '<', 10)
            ->with(['category', 'brand'])
            ->orderBy('stock', 'asc')
            ->paginate(20);

        return view('admin.reports.low-stock', compact('products'));
    }

    /**
     * Export Sales Report
     */
    public function exportSales(Request $request)
    {
        $startDate = $request->get('start_date', now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-d'));

        $orders = Order::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->where('status', 'delivered')
            ->with(['user', 'items.product'])
            ->get();

        if ($orders->isEmpty()) {
            return redirect()->back()->with('error', 'No sales data found for export!');
        }

        $data = [];
        foreach ($orders as $order) {
            foreach ($order->items as $item) {
                $data[] = [
                    'Order ID' => $order->order_number ?? $order->id,
                    'Date' => $order->created_at->format('Y-m-d'),
                    'Customer' => $order->user->name ?? 'Guest',
                    'Product' => $item->product->name ?? 'N/A',
                    'Quantity' => $item->quantity,
                    'Price' => $item->price,
                    'Total' => $item->total,
                    'Order Total' => $order->total,
                ];
            }
        }

        $fileName = 'sales-report-' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');
            fwrite($file, "\xEF\xBB\xBF");
            fputcsv($file, array_keys($data[0]));
            foreach ($data as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export Products Report
     */
    public function exportProducts()
    {
        $products = Product::with(['category', 'brand'])->get();

        if ($products->isEmpty()) {
            return redirect()->back()->with('error', 'No products found for export!');
        }

        $data = [];
        foreach ($products as $product) {
            $data[] = [
                'ID' => $product->id,
                'Name' => $product->name,
                'Category' => $product->category->name ?? 'N/A',
                'Brand' => $product->brand->name ?? 'N/A',
                'Price' => $product->price,
                'Stock' => $product->stock,
                'Status' => $product->status ? 'Active' : 'Inactive',
            ];
        }

        $fileName = 'products-report-' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');
            fwrite($file, "\xEF\xBB\xBF");
            fputcsv($file, array_keys($data[0]));
            foreach ($data as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}