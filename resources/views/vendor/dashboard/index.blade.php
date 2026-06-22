@extends('vendor.layouts.app')

@section('title', 'Dashboard - Vendor Panel')
@section('page-title', 'Dashboard')

@section('content')
<div class="container-fluid">
    {{-- Welcome --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold mb-1">Welcome back, {{ Auth::user()->name }}! 👋</h5>
            <p class="text-muted small">Here's what's happening with your store today</p>
        </div>
        <div>
            <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">
                <i class="fas fa-circle me-1" style="font-size: 6px;"></i>
                {{ Auth::user()->is_vendor_approved ? 'Active' : 'Pending Approval' }}
            </span>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 hover-card">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-primary bg-opacity-10 p-3 rounded-3">
                            <i class="fas fa-box text-primary fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted small mb-0">Total Products</h6>
                            <h3 class="fw-bold mb-0 text-primary">{{ $stats['total_products'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 hover-card">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-success bg-opacity-10 p-3 rounded-3">
                            <i class="fas fa-shopping-cart text-success fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted small mb-0">Total Orders</h6>
                            <h3 class="fw-bold mb-0 text-success">{{ $stats['total_orders'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 hover-card">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-warning bg-opacity-10 p-3 rounded-3">
                            <i class="fas fa-clock text-warning fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted small mb-0">Pending Orders</h6>
                            <h3 class="fw-bold mb-0 text-warning">{{ $stats['pending_orders'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 hover-card">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-danger bg-opacity-10 p-3 rounded-3">
                            <i class="fas fa-exclamation-triangle text-danger fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted small mb-0">Low Stock</h6>
                            <h3 class="fw-bold mb-0 text-danger">{{ $stats['low_stock'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Earnings Stats --}}
    <div class="row g-3 mb-4">
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 hover-card">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-emerald bg-opacity-10 p-3 rounded-3">
                            <i class="fas fa-money-bill-wave text-emerald fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted small mb-0">Total Earnings</h6>
                            <h3 class="fw-bold mb-0 text-emerald">${{ number_format($stats['total_earnings'], 2) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 hover-card">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-amber bg-opacity-10 p-3 rounded-3">
                            <i class="fas fa-hourglass-half text-amber fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted small mb-0">Pending Earnings</h6>
                            <h3 class="fw-bold mb-0 text-amber">${{ number_format($stats['pending_earnings'], 2) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 hover-card">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-purple bg-opacity-10 p-3 rounded-3">
                            <i class="fas fa-credit-card text-purple fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted small mb-0">Total Withdrawn</h6>
                            <h3 class="fw-bold mb-0 text-purple">${{ number_format($stats['total_withdrawn'], 2) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Activity --}}
    <div class="row g-3">
        {{-- Recent Orders --}}
        <div class="col-xl-6">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="fw-bold mb-0">
                        <i class="fas fa-clock text-primary me-2"></i>Recent Orders
                    </h6>
                </div>
                <div class="card-body p-0">
                    @if($recentOrders->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($recentOrders as $order)
                                <div class="list-group-item d-flex justify-content-between align-items-center border-0 py-3">
                                    <div>
                                        <span class="fw-semibold">#{{ $order->order_number ?? $order->id }}</span>
                                        <br>
                                        <small class="text-muted">{{ $order->user->name ?? 'Guest' }}</small>
                                    </div>
                                    <div class="text-end">
                                        <span class="fw-bold">${{ number_format($order->total, 2) }}</span>
                                        <br>
                                        <span class="badge 
                                            @if($order->status == 'pending') bg-warning
                                            @elseif($order->status == 'processing') bg-info
                                            @elseif($order->status == 'shipped') bg-primary
                                            @elseif($order->status == 'delivered') bg-success
                                            @else bg-danger
                                            @endif
                                            rounded-pill px-3 py-1">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                            <p class="text-muted">No orders yet</p>
                        </div>
                    @endif
                </div>
                <div class="card-footer bg-white border-0 py-2">
                    <a href="{{ route('vendor.orders.index') }}" class="text-decoration-none small">
                        View All Orders <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- Recent Products --}}
        <div class="col-xl-6">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="fw-bold mb-0">
                        <i class="fas fa-box text-primary me-2"></i>Recent Products
                    </h6>
                </div>
                <div class="card-body p-0">
                    @if($recentProducts->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($recentProducts as $product)
                                <div class="list-group-item d-flex justify-content-between align-items-center border-0 py-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="{{ $product->thumbnail_url ?? asset('images/placeholder.jpg') }}" 
                                             alt="{{ $product->name }}" 
                                             style="width: 40px; height: 40px; object-fit: cover; border-radius: 8px;">
                                        <div>
                                            <span class="fw-semibold">{{ $product->name }}</span>
                                            <br>
                                            <small class="text-muted">{{ $product->category->name ?? 'Uncategorized' }}</small>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <span class="fw-bold">${{ number_format($product->price, 2) }}</span>
                                        <br>
                                        <span class="badge 
                                            @if($product->stock > 10) bg-success
                                            @elseif($product->stock > 0) bg-warning
                                            @else bg-danger
                                            @endif
                                            rounded-pill px-3 py-1">
                                            {{ $product->stock }} in stock
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-box-open fa-2x text-muted mb-2"></i>
                            <p class="text-muted">No products added yet</p>
                            <a href="{{ route('vendor.products.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus me-1"></i> Add Product
                            </a>
                        </div>
                    @endif
                </div>
                <div class="card-footer bg-white border-0 py-2">
                    <a href="{{ route('vendor.products.index') }}" class="text-decoration-none small">
                        View All Products <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .hover-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .hover-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 40px rgba(0,0,0,0.08) !important;
    }
    .bg-emerald { background: #10b981 !important; }
    .text-emerald { color: #10b981 !important; }
    .bg-amber { background: #f59e0b !important; }
    .text-amber { color: #f59e0b !important; }
    .bg-purple { background: #8b5cf6 !important; }
    .text-purple { color: #8b5cf6 !important; }
    .list-group-item {
        transition: all 0.2s ease;
    }
    .list-group-item:hover {
        background: #f8fafc;
    }
</style>
@endpush
@endsection