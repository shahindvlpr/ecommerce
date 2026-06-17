<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ReturnItem;
use App\Models\ProductReturn;

class CustomerReturnItemController extends Controller
{
    public function index($returnId)
    {
        $return = ProductReturn::where('user_id', Auth::id())
            ->findOrFail($returnId);

        $items = ReturnItem::where('return_id', $returnId)
            ->with('orderItem.product')
            ->get();

        return view('customer.return-items.index', compact('return', 'items'));
    }

    public function create($returnId)
    {
        $return = ProductReturn::where('user_id', Auth::id())
            ->findOrFail($returnId);

        return view('customer.return-items.create', compact('return'));
    }

    public function store(Request $request, $returnId)
    {
        $request->validate([
            'order_item_id' => 'required|exists:order_items,id',
            'quantity' => 'required|integer|min:1',
            'refund_amount' => 'required|numeric|min:0',
            'condition' => 'nullable|string|max:50',
        ]);

        $return = ProductReturn::where('user_id', Auth::id())
            ->findOrFail($returnId);

        $item = ReturnItem::create([
            'return_id' => $returnId,
            'order_item_id' => $request->order_item_id,
            'quantity' => $request->quantity,
            'refund_amount' => $request->refund_amount,
            'condition' => $request->condition,
        ]);

        return redirect()->route('customer.return-items.index', $returnId)
            ->with('success', 'Return item added successfully.');
    }

    public function destroy($returnId, $itemId)
    {
        $return = ProductReturn::where('user_id', Auth::id())
            ->findOrFail($returnId);

        $item = ReturnItem::where('return_id', $returnId)
            ->where('id', $itemId)
            ->firstOrFail();

        $item->delete();

        return redirect()->back()->with('success', 'Return item removed.');
    }
}