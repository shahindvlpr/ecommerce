<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of orders.
     */
    public function index()
    {
        $orders = Order::with('user')->latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Display pending orders.
     */
    public function pending()
    {
        $orders = Order::where('status', 'pending')
            ->with('user')
            ->latest()
            ->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Display processing orders.
     */
    public function processing()
    {
        $orders = Order::where('status', 'processing')
            ->with('user')
            ->latest()
            ->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Display completed orders.
     */
    public function completed()
    {
        $orders = Order::where('status', 'delivered')
            ->with('user')
            ->latest()
            ->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Display cancelled orders.
     */
    public function cancelled()
    {
        $orders = Order::where('status', 'cancelled')
            ->with('user')
            ->latest()
            ->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        $order->load('items.product', 'user');
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update order status.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled'
        ]);

        $order->status = $request->status;
        $order->save();

        return redirect()->back()->with('success', 'Order status updated successfully!');
    }

    /**
     * Generate invoice.
     */
    public function generateInvoice(Order $order)
    {
        return view('admin.orders.invoice', compact('order'));
    }

    /**
     * Export orders to CSV.
     */
    public function exportExcel()
    {
        // Get all orders with user and items
        $orders = Order::with(['user', 'items.product'])->get();

        // If no orders, show error
        if ($orders->isEmpty()) {
            return redirect()->back()->with('error', 'No orders found to export!');
        }

        // Prepare data for export
        $data = [];
        foreach ($orders as $order) {
            // If order has items, export each item as a row
            if ($order->items->isNotEmpty()) {
                foreach ($order->items as $item) {
                    $data[] = [
                        'Order ID' => $order->order_number ?? $order->id,
                        'Order Date' => $order->created_at->format('Y-m-d H:i:s'),
                        'Customer Name' => $order->user->name ?? 'Guest',
                        'Customer Email' => $order->user->email ?? 'N/A',
                        'Customer Phone' => $order->phone ?? 'N/A',
                        'Product Name' => $item->product->name ?? 'N/A',
                        'Product SKU' => $item->product->sku ?? 'N/A',
                        'Quantity' => $item->quantity,
                        'Unit Price' => $item->price,
                        'Item Total' => $item->price * $item->quantity,
                        'Order Subtotal' => $order->subtotal,
                        'Shipping Cost' => $order->shipping_cost ?? 0,
                        'Tax' => $order->tax ?? 0,
                        'Order Total' => $order->total,
                        'Status' => $order->status ?? 'pending',
                        'Payment Status' => $order->payment_status ?? 'pending',
                        'Payment Method' => $order->payment_method ?? 'N/A',
                        'Shipping Address' => $order->shipping_address ?? 'N/A',
                    ];
                }
            } else {
                // If order has no items, export just the order
                $data[] = [
                    'Order ID' => $order->order_number ?? $order->id,
                    'Order Date' => $order->created_at->format('Y-m-d H:i:s'),
                    'Customer Name' => $order->user->name ?? 'Guest',
                    'Customer Email' => $order->user->email ?? 'N/A',
                    'Customer Phone' => $order->phone ?? 'N/A',
                    'Product Name' => 'N/A',
                    'Product SKU' => 'N/A',
                    'Quantity' => 0,
                    'Unit Price' => 0,
                    'Item Total' => 0,
                    'Order Subtotal' => $order->subtotal,
                    'Shipping Cost' => $order->shipping_cost ?? 0,
                    'Tax' => $order->tax ?? 0,
                    'Order Total' => $order->total,
                    'Status' => $order->status ?? 'pending',
                    'Payment Status' => $order->payment_status ?? 'pending',
                    'Payment Method' => $order->payment_method ?? 'N/A',
                    'Shipping Address' => $order->shipping_address ?? 'N/A',
                ];
            }
        }

        // Generate CSV
        $fileName = 'orders-' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');
            
            // Add UTF-8 BOM for Excel compatibility
            fwrite($file, "\xEF\xBB\xBF");
            
            // Add headers
            fputcsv($file, array_keys($data[0]));
            
            // Add data rows
            foreach ($data as $row) {
                fputcsv($file, $row);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export orders to PDF (Optional - Coming Soon)
     */
    public function exportPdf()
    {
        return redirect()->back()->with('info', 'PDF export feature coming soon!');
    }
}