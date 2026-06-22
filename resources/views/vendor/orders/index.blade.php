@extends('vendor.layouts.app')

@section('title', 'Orders - Vendor Panel')
@section('page-title', 'Orders')

@section('content')
<div class="container-fluid">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold mb-1">Manage Orders</h5>
            <p class="text-muted small">View and manage customer orders</p>
        </div>
    </div>

    {{-- Status Counts --}}
    <div class="row g-3 mb-4">
        <div class="col-md-2">
            <a href="{{ route('vendor.orders.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm rounded-4 hover-card">
                    <div class="card-body p-3 text-center">
                        <h5 class="fw-bold">{{ $statusCounts['all'] }}</h5>
                        <small class="text-muted">All</small>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-2">
            <a href="{{ route('vendor.orders.index', ['status' => 'pending']) }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm rounded-4 hover-card">
                    <div class="card-body p-3 text-center">
                        <h5 class="fw-bold text-warning">{{ $statusCounts['pending'] }}</h5>
                        <small class="text-muted">Pending</small>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-2">
            <a href="{{ route('vendor.orders.index', ['status' => 'processing']) }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm rounded-4 hover-card">
                    <div class="card-body p-3 text-center">
                        <h5 class="fw-bold text-info">{{ $statusCounts['processing'] }}</h5>
                        <small class="text-muted">Processing</small>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-2">
            <a href="{{ route('vendor.orders.index', ['status' => 'shipped']) }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm rounded-4 hover-card">
                    <div class="card-body p-3 text-center">
                        <h5 class="fw-bold text-primary">{{ $statusCounts['shipped'] }}</h5>
                        <small class="text-muted">Shipped</small>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-2">
            <a href="{{ route('vendor.orders.index', ['status' => 'delivered']) }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm rounded-4 hover-card">
                    <div class="card-body p-3 text-center">
                        <h5 class="fw-bold text-success">{{ $statusCounts['delivered'] }}</h5>
                        <small class="text-muted">Delivered</small>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-2">
            <a href="{{ route('vendor.orders.index', ['status' => 'cancelled']) }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm rounded-4 hover-card">
                    <div class="card-body p-3 text-center">
                        <h5 class="fw-bold text-danger">{{ $statusCounts['cancelled'] }}</h5>
                        <small class="text-muted">Cancelled</small>
                    </div>
                </div>
            </a>
        </div>
    </div>

    {{-- Search --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-3">
            <form method="GET" class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control form-control-sm" 
                           placeholder="Search by order ID or customer..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select form-select-sm">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div class="col-md-5">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary btn-sm flex-fill">
                            <i class="fas fa-search me-1"></i> Search
                        </button>
                        <a href="{{ route('vendor.orders.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-undo"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Orders Table --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-3">Order ID</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th class="text-end pe-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td class="ps-3">
                                <span class="fw-semibold">#{{ $order->order_number ?? $order->id }}</span>
                            </td>
                            <td>{{ $order->user->name ?? 'Guest' }}</td>
                            <td>
                                <span class="fw-bold">${{ number_format($order->total, 2) }}</span>
                            </td>
                            <td>
                                <span class="badge 
                                    @if($order->status == 'pending') bg-warning
                                    @elseif($order->status == 'processing') bg-info
                                    @elseif($order->status == 'shipped') bg-primary
                                    @elseif($order->status == 'delivered') bg-success
                                    @else bg-danger
                                    @endif
                                    rounded-pill px-3 py-2">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>
                                <div>
                                    <small>{{ $order->created_at->format('M d, Y') }}</small>
                                    <br>
                                    <small class="text-muted">{{ $order->created_at->diffForHumans() }}</small>
                                </div>
                            </td>
                            <td class="text-end pe-3">
                                <div class="d-flex gap-1 justify-content-end">
                                    <a href="{{ route('vendor.orders.show', $order->id) }}" 
                                       class="btn btn-sm btn-outline-primary" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('vendor.orders.invoice', $order->id) }}" 
                                       class="btn btn-sm btn-outline-secondary" title="Invoice">
                                        <i class="fas fa-file-invoice"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="fas fa-shopping-cart fa-3x text-muted d-block mb-3"></i>
                                <h5 class="text-muted">No Orders Found</h5>
                                <p class="text-muted small">You haven't received any orders yet</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($orders->hasPages())
            <div class="card-footer bg-white border-0 py-3">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</div>

@push('styles')
<style>
    .hover-card {
        transition: all 0.3s ease;
        cursor: pointer;
    }
    .hover-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.08) !important;
    }
    .hover-card .card-body {
        transition: all 0.3s ease;
    }
</style>
@endpush
@endsection