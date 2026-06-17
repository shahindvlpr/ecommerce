@extends('layouts.app')

@section('title', 'Order Success - EktaMart')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-4 text-center">
                <div class="card-body p-5">
                    <div style="width: 80px; height: 80px; background: #dcfce7; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
                        <i class="fas fa-check-circle fa-3x text-success"></i>
                    </div>
                    <h3 class="fw-bold">Order Placed Successfully! 🎉</h3>
                    <p class="text-muted">Thank you for your order. We'll send you a confirmation email shortly.</p>
                    
                    <div class="bg-light rounded-4 p-4 my-4 text-start">
                        <h6 class="fw-bold">Order Details</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <small class="text-muted d-block">Order Number</small>
                                <strong>#{{ $order->order_number ?? $order->id }}</strong>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted d-block">Total Amount</small>
                                <strong class="text-primary">${{ number_format($order->total, 2) }}</strong>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted d-block">Payment Method</small>
                                <strong>{{ ucfirst($order->payment_status) }}</strong>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted d-block">Status</small>
                                <span class="badge bg-warning text-dark">{{ ucfirst($order->status) }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-3 justify-content-center flex-wrap">
                        <a href="{{ route('customer.orders.show', $order->id) }}" class="btn btn-primary-premium">
                            <i class="fas fa-eye me-2"></i> View Order
                        </a>
                        <a href="{{ route('shop.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-shopping-bag me-2"></i> Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection