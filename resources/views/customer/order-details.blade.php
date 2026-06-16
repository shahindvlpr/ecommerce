@extends('layouts.app')

@section('title', 'Order Details - EktaMart')

@section('content')
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --shadow-sm: 0 2px 12px rgba(0, 0, 0, 0.06);
        --shadow-hover: 0 8px 30px rgba(0, 0, 0, 0.1);
        --radius: 1rem;
        --radius-sm: 0.75rem;
    }

    .page-wrapper {
        background: #f5f6fa;
        min-height: 100vh;
        padding: 1.5rem 0;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        color: #667eea;
        text-decoration: none;
        font-weight: 500;
        font-size: 0.85rem;
        transition: all 0.3s ease;
        margin-bottom: 1rem;
    }
    .back-link:hover {
        color: #764ba2;
        transform: translateX(-3px);
    }

    .order-detail-card {
        background: white;
        border-radius: var(--radius);
        padding: 1.2rem 1.5rem;
        box-shadow: var(--shadow-sm);
        margin-bottom: 1rem;
        border: 1px solid rgba(0,0,0,0.02);
    }
    .order-detail-card:hover {
        box-shadow: var(--shadow-hover);
    }

    .detail-label {
        font-size: 0.7rem;
        text-transform: uppercase;
        color: #6b7280;
        font-weight: 600;
        letter-spacing: 0.3px;
        margin-bottom: 0.15rem;
    }
    .detail-value {
        font-weight: 600;
        color: #1a1a2e;
        font-size: 0.9rem;
    }

    .order-status {
        padding: 0.2rem 0.7rem;
        border-radius: 2rem;
        font-size: 0.65rem;
        font-weight: 600;
        text-transform: capitalize;
        display: inline-block;
    }
    .order-status.delivered { background: #dcfce7; color: #16a34a; }
    .order-status.pending { background: #fef3c7; color: #d97706; }
    .order-status.processing { background: #dbeafe; color: #2563eb; }
    .order-status.cancelled { background: #fee2e2; color: #dc2626; }
    .order-status.shipped { background: #e0e7ff; color: #4f46e5; }

    .product-item {
        display: flex;
        gap: 0.8rem;
        padding: 0.6rem 0;
        border-bottom: 1px solid #f3f4f6;
        align-items: center;
    }
    .product-item:last-child {
        border-bottom: none;
    }
    .product-img {
        width: 50px;
        height: 50px;
        border-radius: 0.5rem;
        background: #f3f4f6;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        color: #9ca3af;
        flex-shrink: 0;
        overflow: hidden;
    }
    .product-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .product-info {
        flex: 1;
    }
    .product-name {
        font-weight: 600;
        font-size: 0.85rem;
    }
    .product-meta {
        color: #6b7280;
        font-size: 0.7rem;
    }
    .product-price {
        font-weight: 600;
        font-size: 0.85rem;
        white-space: nowrap;
    }

    @media (max-width: 576px) {
        .order-detail-card { padding: 0.8rem 1rem; }
        .product-item { flex-wrap: wrap; }
    }
</style>

<div class="page-wrapper">
    <div class="container">
        <a href="{{ route('customer.orders') }}" class="back-link">
            <i class="fas fa-arrow-left"></i> Back to Orders
        </a>

        <!-- Order Header -->
        <div class="order-detail-card">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="detail-label">Order ID</div>
                    <div class="detail-value">#{{ $order->order_number ?? $order->id }}</div>
                </div>
                <div class="col-md-3">
                    <div class="detail-label">Date</div>
                    <div class="detail-value">{{ $order->created_at->format('M d, Y h:i A') }}</div>
                </div>
                <div class="col-md-3">
                    <div class="detail-label">Status</div>
                    <div class="detail-value">
                        <span class="order-status {{ $order->status }}">{{ $order->status }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Items -->
        <div class="order-detail-card">
            <h6 style="font-weight: 700; font-size: 0.9rem; margin-bottom: 0.8rem;">
                <i class="fas fa-box" style="color: #667eea;"></i> Order Items
            </h6>
            @foreach($order->items as $item)
            <div class="product-item">
                <div class="product-img">
                    @if($item->product && $item->product->thumbnail)
                        <img src="{{ asset('storage/' . $item->product->thumbnail) }}" alt="{{ $item->product->name }}">
                    @else
                        <i class="fas fa-image"></i>
                    @endif
                </div>
                <div class="product-info">
                    <div class="product-name">{{ $item->product->name ?? 'Product' }}</div>
                    <div class="product-meta">Qty: {{ $item->quantity }}</div>
                    @if($item->variation)
                        <div class="product-meta">{{ $item->variation->attribute_name }}: {{ $item->variation->attribute_value }}</div>
                    @endif
                </div>
                <div class="product-price">${{ number_format($item->total, 2) }}</div>
            </div>
            @endforeach
        </div>

        <!-- Order Summary -->
        <div class="order-detail-card">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="detail-label">Subtotal</div>
                    <div class="detail-value">${{ number_format($order->subtotal, 2) }}</div>
                </div>
                <div class="col-md-3">
                    <div class="detail-label">Tax</div>
                    <div class="detail-value">${{ number_format($order->tax, 2) }}</div>
                </div>
                <div class="col-md-3">
                    <div class="detail-label">Shipping</div>
                    <div class="detail-value">${{ number_format($order->shipping_cost, 2) }}</div>
                </div>
            </div>
            <hr style="margin: 0.5rem 0;">
            <div class="row">
                <div class="col-md-6">
                    <div class="detail-label">Total</div>
                    <div class="detail-value" style="font-size: 1.1rem; color: #667eea;">${{ number_format($order->total, 2) }}</div>
                </div>
                <div class="col-md-6 text-md-end">
                    @if(in_array($order->status, ['pending', 'processing']))
                        <form method="POST" action="{{ route('customer.orders.cancel', $order->id) }}" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-sm" style="background: #fee2e2; color: #dc2626; border: none; border-radius: 0.4rem; padding: 0.25rem 0.8rem; font-size: 0.7rem; font-weight: 500; cursor: pointer;" onclick="return confirm('Are you sure you want to cancel this order?')">
                                <i class="fas fa-times me-1"></i> Cancel Order
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <!-- Shipping Address -->
        <div class="order-detail-card">
            <h6 style="font-weight: 700; font-size: 0.9rem; margin-bottom: 0.6rem;">
                <i class="fas fa-map-marker-alt" style="color: #667eea;"></i> Shipping Address
            </h6>
            <div style="font-size: 0.85rem; color: #4b5563; white-space: pre-line;">
                {{ $order->shipping_address }}
            </div>
        </div>
    </div>
</div>
@endsection