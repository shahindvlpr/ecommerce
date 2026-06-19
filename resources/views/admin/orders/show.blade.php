@extends('layouts.admin')

@section('title', 'Order Details - EktaMart Admin')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">
                <i class="fas fa-shopping-cart text-primary me-2"></i>Order Details
                <code>#{{ $order->order_number ?? $order->id }}</code>
            </h4>
            <p class="text-muted small">View and manage order details</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.orders.invoice', $order) }}" class="btn btn-outline-secondary">
                <i class="fas fa-file-invoice"></i> Invoice
            </a>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="row g-4">
        {{-- Order Items --}}
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-4">
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
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <img src="{{ $item->product->thumbnail_url ?? asset('images/default-product.png') }}" 
                                                 alt="{{ $item->product->name ?? 'Product' }}" 
                                                 style="width: 40px; height: 40px; object-fit: cover; border-radius: 8px;">
                                            <div>
                                                <div class="fw-semibold">{{ $item->product->name ?? 'Product' }}</div>
                                                <small class="text-muted">SKU: {{ $item->product->sku ?? 'N/A' }}</small>
                                            </div>
                                        </div>
                                    </td>
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
                                    <td colspan="3" class="text-end fw-bold">Discount</td>
                                    <td class="text-end">-${{ number_format($order->discount ?? 0, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end fw-bold fs-5">Total</td>
                                    <td class="text-end fw-bold text-success fs-5">${{ number_format($order->total, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Order Information --}}
        <div class="col-lg-4">
            {{-- Status Update --}}
            <div class="card shadow-sm border-0 rounded-4 mb-4">
                <div class="card-header bg-transparent border-0 pt-3">
                    <h6 class="fw-bold">Order Status</h6>
                </div>
                <div class="card-body">
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
                        <button type="submit" class="btn btn-primary btn-sm">Update</button>
                    </form>
                </div>
            </div>

            {{-- Customer Info --}}
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-transparent border-0 pt-3">
                    <h6 class="fw-bold">Customer Information</h6>
                </div>
                <div class="card-body">
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
                    <div>
                        <label class="text-muted small">Shipping Address</label>
                        <p class="mb-0">{{ $order->shipping_address ?? 'N/A' }}</p>
                    </div>
                    @if($order->notes)
                    <hr>
                    <div>
                        <label class="text-muted small">Order Notes</label>
                        <p class="mb-0">{{ $order->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection