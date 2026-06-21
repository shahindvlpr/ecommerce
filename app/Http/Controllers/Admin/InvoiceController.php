<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Order;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with(['user', 'order'])
            ->latest()
            ->paginate(15);
            
        return view('admin.invoices.index', compact('invoices'));
    }

    public function unpaid()
    {
        $invoices = Invoice::with(['user', 'order'])
            ->unpaid()
            ->latest()
            ->paginate(15);
            
        return view('admin.invoices.index', compact('invoices'));
    }

    public function paid()
    {
        $invoices = Invoice::with(['user', 'order'])
            ->paid()
            ->latest()
            ->paginate(15);
            
        return view('admin.invoices.index', compact('invoices'));
    }

    public function overdue()
    {
        $invoices = Invoice::with(['user', 'order'])
            ->overdue()
            ->latest()
            ->paginate(15);
            
        return view('admin.invoices.index', compact('invoices'));
    }

    public function show($id)
    {
        $invoice = Invoice::with(['user', 'order', 'order.items'])
            ->findOrFail($id);
            
        return view('admin.invoices.show', compact('invoice'));
    }

    public function create($orderId = null)
    {
        $order = null;
        if ($orderId) {
            $order = Order::with('user')->findOrFail($orderId);
        }
        return view('admin.invoices.create', compact('order'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'user_id' => 'required|exists:users,id',
            'subtotal' => 'required|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'shipping' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'status' => 'required|in:paid,unpaid,partial,refunded,cancelled',
            'due_date' => 'nullable|date|after:today',
            'notes' => 'nullable|string|max:1000',
        ]);

        $validated['invoice_number'] = 'INV-' . date('Ymd') . '-' . str_pad(Invoice::count() + 1, 4, '0', STR_PAD_LEFT);
        
        // Get order details for addresses
        $order = Order::find($validated['order_id']);
        if ($order) {
            $validated['billing_address'] = $order->billing_address ?? $order->shipping_address;
            $validated['shipping_address'] = $order->shipping_address;
            $validated['items'] = $order->items->toArray();
        }

        $invoice = Invoice::create($validated);

        return redirect()->route('admin.invoices.index')
            ->with('success', 'Invoice created successfully!');
    }

    public function update(Request $request, $id)
    {
        $invoice = Invoice::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:paid,unpaid,partial,refunded,cancelled',
            'due_date' => 'nullable|date',
            'notes' => 'nullable|string|max:1000',
        ]);

        if ($request->status == 'paid' && $invoice->status != 'paid') {
            $validated['paid_date'] = now();
        }

        $invoice->update($validated);

        return redirect()->back()->with('success', 'Invoice updated successfully!');
    }

    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();
        
        return redirect()->route('admin.invoices.index')
            ->with('success', 'Invoice deleted successfully!');
    }

    public function generateFromOrder($orderId)
    {
        $order = Order::with('user', 'items')->findOrFail($orderId);
        
        // Check if invoice already exists
        $existingInvoice = Invoice::where('order_id', $orderId)->first();
        if ($existingInvoice) {
            return redirect()->route('admin.invoices.show', $existingInvoice->id)
                ->with('info', 'Invoice already exists for this order.');
        }

        $subtotal = $order->items->sum(function($item) {
            return $item->price * $item->quantity;
        });

        $invoice = Invoice::create([
            'order_id' => $order->id,
            'user_id' => $order->user_id,
            'invoice_number' => 'INV-' . date('Ymd') . '-' . str_pad(Invoice::count() + 1, 4, '0', STR_PAD_LEFT),
            'subtotal' => $subtotal,
            'tax' => $order->tax ?? 0,
            'shipping' => $order->shipping_charge ?? 0,
            'discount' => $order->discount ?? 0,
            'total' => $order->total ?? $subtotal,
            'status' => 'unpaid',
            'due_date' => now()->addDays(15),
            'billing_address' => $order->billing_address ?? $order->shipping_address,
            'shipping_address' => $order->shipping_address,
            'items' => $order->items->toArray(),
        ]);

        return redirect()->route('admin.invoices.show', $invoice->id)
            ->with('success', 'Invoice generated successfully!');
    }
}