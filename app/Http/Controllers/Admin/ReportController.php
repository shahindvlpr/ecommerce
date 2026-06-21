<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Category; 

class ReportController extends Controller
{
    /**
     * Sales Report
     */
public function sales(Request $request)
{
    // Date range
    $startDate = $request->get('start_date', now()->subDays(30)->format('Y-m-d'));
    $endDate = $request->get('end_date', now()->format('Y-m-d'));

    // Basic Stats
    $totalRevenue = Order::where('status', 'delivered')
        ->whereBetween('created_at', [$startDate, $endDate])
        ->sum('total') ?? 0;
    
    $totalOrders = Order::whereBetween('created_at', [$startDate, $endDate])->count();
    
    $averageOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

    // Sales Data for Chart
    $salesData = Order::where('status', 'delivered')
        ->whereBetween('created_at', [$startDate, $endDate])
        ->selectRaw('DATE(created_at) as date, SUM(total) as total_revenue')
        ->groupBy('date')
        ->orderBy('date', 'asc')
        ->get();

    // ✅ Top Products (সঠিকভাবে)
    $topProducts = Product::withCount(['orderItems as total_sold' => function($q) use ($startDate, $endDate) {
        $q->whereHas('order', function($oq) use ($startDate, $endDate) {
            $oq->whereBetween('created_at', [$startDate, $endDate])
               ->where('status', 'delivered');
        });
    }])
    ->withSum(['orderItems as total_revenue' => function($q) use ($startDate, $endDate) {
        $q->whereHas('order', function($oq) use ($startDate, $endDate) {
            $oq->whereBetween('created_at', [$startDate, $endDate])
               ->where('status', 'delivered');
        });
    }], 'price')  // ✅ 'subtotal' এর পরিবর্তে 'price' ব্যবহার করুন
    ->having('total_sold', '>', 0)
    ->orderBy('total_revenue', 'desc')
    ->limit(10)
    ->get();

    // Category Stats
    $categoryStats = Category::withCount(['products'])
        ->get();

    // Growth percentages
    $revenueGrowth = 12.5;
    $ordersGrowth = 8.3;
    $avgOrderGrowth = 5.2;
    $customerGrowth = 3.7;

    return view('admin.reports.sales', compact(
        'totalRevenue',
        'totalOrders',
        'averageOrderValue',
        'startDate',
        'endDate',
        'salesData',
        'topProducts',
        'categoryStats',
        'revenueGrowth',
        'ordersGrowth',
        'avgOrderGrowth',
        'customerGrowth'
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