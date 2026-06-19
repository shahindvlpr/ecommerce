@extends('layouts.admin')

@section('title', 'Order Details - EktaMart Admin')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">
            <i class="fas fa-shopping-cart text-primary me-2"></i>Order Details
            <code>#{{ $order->order_number ?? $order->id }}</code>
        </h4>
        <div>
            <a href="{{ route('admin.orders.invoice', $order) }}" class="btn btn-outline-secondary me-2">
                <i class="fas fa-file-invoice"></i> Invoice
            </a>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-4 mb-4">
                <div class="card-header bg-transparent border-0 pt-3">
                    <h6 class="fw-bold">Order Items</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>Product</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td>{{ $item->product->name ?? 'Product' }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>${{ number_format($item->price, 2) }}</td>
                                    <td class="text-end">${{ number_format($item->price * $item->quantity, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-light">
                                <tr>
                                    <td colspan="3" class="text-end fw-bold">Subtotal</td>
                                    <td class="text-end">${{ number_format($order->subtotal, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end fw-bold">Shipping</td>
                                    <td class="text-end">${{ number_format($order->shipping_cost ?? 0, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end fw-bold">Tax</td>
                                    <td class="text-end">${{ number_format($order->tax ?? 0, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end fw-bold">Total</td>
                                    <td class="text-end fw-bold text-success">${{ number_format($order->total, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm border-0 rounded-4 mb-4">
                <div class="card-header bg-transparent border-0 pt-3">
                    <h6 class="fw-bold">Order Information</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted small">Order Status</label>
                        <div class="mt-1">
                            <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="d-flex gap-2">
                                @csrf
                                @method('PUT')
                                <select name="status" class="form-control form-control-sm">
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                                <button type="submit" class="btn btn-sm btn-primary">Update</button>
                            </form>
                        </div>
                    </div>

                    <hr>

                    <div class="mb-2">
                        <label class="text-muted small">Customer</label>
                        <p class="fw-semibold mb-0">{{ $order->user->name ?? 'Guest' }}</p>
                    </div>
                    <div class="mb-2">
                        <label class="text-muted small">Email</label>
                        <p class="mb-0">{{ $order->user->email ?? 'N/A' }}</p>
                    </div>
                    <div class="mb-2">
                        <label class="text-muted small">Phone</label>
                        <p class="mb-0">{{ $order->phone ?? 'N/A' }}</p>
                    </div>
                    <div class="mb-2">
                        <label class="text-muted small">Payment Method</label>
                        <p class="mb-0">{{ ucfirst($order->payment_method ?? 'N/A') }}</p>
                    </div>
                    <div class="mb-2">
                        <label class="text-muted small">Payment Status</label>
                        <p class="mb-0">
                            <span class="badge {{ $order->payment_status == 'paid' ? 'bg-success' : 'bg-warning' }}">
                                {{ ucfirst($order->payment_status ?? 'pending') }}
                            </span>
                        </p>
                    </div>
                    <div class="mb-2">
                        <label class="text-muted small">Order Date</label>
                        <p class="mb-0">{{ $order->created_at->format('d M Y, h:i A') }}</p>
                    </div>

                    <hr>

                    <div class="mb-2">
                        <label class="text-muted small">Shipping Address</label>
                        <p class="mb-0">{{ $order->shipping_address ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection