@extends('vendor.layouts.app')

@section('title', 'Order Details - Vendor Panel')
@section('page-title', 'Order Details')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold mb-1">Order #{{ $order->order_number ?? $order->id }}</h5>
            <p class="text-muted small">Order details and status management</p>
        </div>
        <div>
            <a href="{{ route('vendor.orders.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Back to Orders
            </a>
        </div>
    </div>

    <div class="row g-4">
        {{-- Order Info --}}
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="fw-bold mb-0">Order Information</h6>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <h6 class="text-muted small">Customer</h6>
                            <p class="fw-semibold">{{ $order->user->name ?? 'Guest' }}</p>
                            <p class="text-muted small">{{ $order->user->email ?? 'No email' }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted small">Order Status</h6>
                            <span class="badge 
                                @if($order->status == 'pending') bg-warning
                                @elseif($order->status == 'processing') bg-info
                                @elseif($order->status == 'shipped') bg-primary
                                @elseif($order->status == 'delivered') bg-success
                                @else bg-danger
                                @endif
                                rounded-pill px-3 py-2 fs-6">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                    </div>

                    <hr>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <h6 class="text-muted small">Order Date</h6>
                            <p>{{ $order->created_at->format('F d, Y h:i A') }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted small">Payment Method</h6>
                            <p>{{ $order->payment_method ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <hr>

                    {{-- Order Items --}}
                    <h6 class="fw-semibold mb-3">Order Items</h6>
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="bg-light">
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td>{{ $item->product->name ?? 'Product' }}</td>
                                    <td>${{ number_format($item->price, 2) }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td class="text-end">${{ number_format($item->price * $item->quantity, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end fw-semibold">Subtotal:</td>
                                    <td class="text-end">${{ number_format($order->subtotal ?? $order->total, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end fw-semibold">Shipping:</td>
                                    <td class="text-end">${{ number_format($order->shipping ?? 0, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end fw-semibold">Tax:</td>
                                    <td class="text-end">${{ number_format($order->tax ?? 0, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end fw-bold">Total:</td>
                                    <td class="text-end fw-bold text-primary">${{ number_format($order->total, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="fw-bold mb-0">Update Status</h6>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('vendor.orders.update-status', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Change Status</label>
                            <select name="status" class="form-select">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-save me-1"></i> Update Status
                        </button>
                    </form>
                </div>
            </div>

            {{-- Actions --}}
            <div class="card border-0 shadow-sm rounded-4 mt-3">
                <div class="card-body p-4">
                    <a href="{{ route('vendor.orders.invoice', $order->id) }}" class="btn btn-outline-secondary w-100 mb-2">
                        <i class="fas fa-file-invoice me-1"></i> Download Invoice
                    </a>
                    <a href="#" class="btn btn-outline-primary w-100">
                        <i class="fas fa-print me-1"></i> Print Order
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection