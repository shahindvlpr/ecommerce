<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ProductReturn;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Str;

class CustomerReturnController extends Controller
{
    public function index()
    {
        $returns = ProductReturn::where('user_id', Auth::id())
            ->with(['order', 'orderItem.product'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('customer.returns.index', compact('returns'));
    }

    public function create($orderId = null)
    {
        $orders = Order::where('user_id', Auth::id())
            ->where('status', 'delivered')
            ->with('items.product')
            ->get();

        $selectedOrder = null;
        if ($orderId) {
            $selectedOrder = Order::where('user_id', Auth::id())
                ->where('id', $orderId)
                ->with('items.product')
                ->first();
        }

        return view('customer.returns.create', compact('orders', 'selectedOrder'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'order_item_id' => 'required|exists:order_items,id',
            'reason' => 'required|string|min:10|max:500',
            'refund_method' => 'required|in:bank,bkash,nagad,rocket',
            'bank_details' => 'required_if:refund_method,bank|array',
            'attachment' => 'nullable|image|max:2048',
        ]);

        $existing = ProductReturn::where('order_item_id', $request->order_item_id)
            ->whereIn('status', ['pending', 'approved'])
            ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'A return request already exists for this item.');
        }

        $order = Order::find($request->order_id);
        $orderItem = OrderItem::find($request->order_item_id);

        $returnNumber = 'RET-' . strtoupper(Str::random(6)) . '-' . time();

        $return = ProductReturn::create([
            'user_id' => Auth::id(),
            'order_id' => $request->order_id,
            'order_item_id' => $request->order_item_id,
            'return_number' => $returnNumber,
            'reason' => $request->reason,
            'status' => 'pending',
            'refund_amount' => $orderItem->price * $orderItem->quantity,
            'refund_method' => $request->refund_method,
            'bank_details' => $request->refund_method === 'bank' ? $request->bank_details : null,
            'requested_at' => now(),
        ]);

        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('returns', 'public');
            $return->attachment = $path;
            $return->save();
        }

        return redirect()->route('customer.returns.show', $return->id)
            ->with('success', 'Return request submitted successfully!');
    }

    public function show($id)
    {
        $return = ProductReturn::where('user_id', Auth::id())
            ->with(['order', 'orderItem.product'])
            ->findOrFail($id);

        return view('customer.returns.show', compact('return'));
    }

    public function cancel($id)
    {
        $return = ProductReturn::where('user_id', Auth::id())
            ->where('status', 'pending')
            ->findOrFail($id);

        $return->status = 'cancelled';
        $return->save();

        return redirect()->route('customer.returns.index')
            ->with('success', 'Return request cancelled.');
    }

    public function getOrderItems($orderId)
    {
        $items = Order::where('user_id', Auth::id())
            ->findOrFail($orderId)
            ->items()
            ->with('product')
            ->get();

        return response()->json($items);
    }
}