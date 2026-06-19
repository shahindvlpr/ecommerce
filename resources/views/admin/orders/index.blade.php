@extends('layouts.admin')

@section('title', 'Orders - EktaMart Admin')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">
                <i class="fas fa-shopping-cart text-primary me-2"></i>Orders
            </h4>
            <p class="text-muted small">Manage all customer orders</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.orders.export.excel') }}" class="btn btn-success btn-sm">
                <i class="fas fa-file-excel"></i> Export
            </a>
            <button class="btn btn-outline-secondary btn-sm" onclick="window.location.reload()">
                <i class="fas fa-sync-alt"></i>
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Status Filter Tabs --}}
    <ul class="nav nav-pills mb-4 gap-2 flex-wrap">
        <li class="nav-item">
            <a href="{{ route('admin.orders.index') }}" 
               class="nav-link {{ !request()->routeIs('admin.orders.pending') && !request()->routeIs('admin.orders.processing') && !request()->routeIs('admin.orders.completed') && !request()->routeIs('admin.orders.cancelled') ? 'active' : '' }}">
                All Orders
                <span class="badge bg-light text-dark ms-1">{{ \App\Models\Order::count() }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.orders.pending') }}" 
               class="nav-link {{ request()->routeIs('admin.orders.pending') ? 'active' : '' }}">
                Pending
                <span class="badge bg-warning text-dark ms-1">{{ \App\Models\Order::where('status', 'pending')->count() }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.orders.processing') }}" 
               class="nav-link {{ request()->routeIs('admin.orders.processing') ? 'active' : '' }}">
                Processing
                <span class="badge bg-info text-dark ms-1">{{ \App\Models\Order::where('status', 'processing')->count() }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.orders.completed') }}" 
               class="nav-link {{ request()->routeIs('admin.orders.completed') ? 'active' : '' }}">
                Completed
                <span class="badge bg-success text-dark ms-1">{{ \App\Models\Order::where('status', 'delivered')->count() }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.orders.cancelled') }}" 
               class="nav-link {{ request()->routeIs('admin.orders.cancelled') ? 'active' : '' }}">
                Cancelled
                <span class="badge bg-danger text-dark ms-1">{{ \App\Models\Order::where('status', 'cancelled')->count() }}</span>
            </a>
        </li>
    </ul>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-transparent border-0 pt-3 pb-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <span class="text-muted small">Total Orders: <strong>{{ $orders->total() }}</strong></span>
                </div>
                <div class="input-group input-group-sm" style="width: 250px;">
                    <span class="input-group-text bg-transparent border-end-0">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" class="form-control border-start-0" placeholder="Search orders..." id="searchInput">
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="orderTable">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-3">Order #</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Payment</th>
                            <th>Date</th>
                            <th class="text-end pe-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td class="ps-3">
                                <code>#{{ $order->order_number ?? $order->id }}</code>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle bg-primary bg-opacity-10 p-2">
                                        <i class="fas fa-user text-primary fa-sm"></i>
                                    </div>
                                    {{ $order->user->name ?? 'Guest' }}
                                </div>
                            </td>
                            <td class="fw-bold text-success">${{ number_format($order->total, 2) }}</td>
                            <td>
                                @php
                                    $statusClass = match($order->status ?? 'pending') {
                                        'delivered' => 'badge-delivered',
                                        'paid' => 'badge-paid',
                                        'pending' => 'badge-pending',
                                        'shipped' => 'badge-shipped',
                                        'cancelled' => 'badge-cancelled',
                                        'processing' => 'badge-processing',
                                        default => 'badge-pending',
                                    };
                                @endphp
                                <span class="badge-status {{ $statusClass }}">
                                    {{ ucfirst($order->status ?? 'Pending') }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $order->payment_status == 'paid' ? 'bg-success' : 'bg-warning' }}">
                                    {{ ucfirst($order->payment_status ?? 'pending') }}
                                </span>
                            </td>
                            <td>
                                <small>{{ $order->created_at->format('d M Y, h:i A') }}</small>
                            </td>
                            <td class="text-end pe-3">
                                <div class="d-flex justify-content-end gap-1">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-info" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.orders.invoice', $order) }}" class="btn btn-sm btn-outline-secondary" title="Invoice">
                                        <i class="fas fa-file-invoice"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-5">
                                <i class="fas fa-inbox fa-3x d-block mb-3" style="color: #d1d5db;"></i>
                                <h5>No Orders Found</h5>
                                <p class="text-muted">Orders will appear here once customers place them.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($orders->hasPages())
            <div class="card-footer bg-transparent">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <span class="text-muted small">
                        Showing {{ $orders->firstItem() ?? 0 }} to {{ $orders->lastItem() ?? 0 }} of {{ $orders->total() }} entries
                    </span>
                    {{ $orders->links() }}
                </div>
            </div>
        @endif
    </div>
</div>

<script>
    // Search functionality
    document.getElementById('searchInput')?.addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('#orderTable tbody tr');
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? '' : 'none';
        });
    });

    console.log('%c📦 Orders Page Loaded', 'color: #8b5cf6; font-size: 13px; font-weight: bold;');
    console.log(`%c📊 Total Orders: {{ $orders->total() }}`, 'color: #10b981; font-size: 12px;');
</script>

<style>
    .badge-status {
        padding: 0.3rem 0.7rem;
        border-radius: 2rem;
        font-size: 0.7rem;
        font-weight: 600;
    }
    .badge-paid { background: #dcfce7; color: #166534; }
    .badge-pending { background: #fed7aa; color: #9a3412; }
    .badge-delivered { background: #dbeafe; color: #1e40af; }
    .badge-cancelled { background: #fee2e2; color: #991b1b; }
    .badge-shipped { background: #e0e7ff; color: #3730a3; }
    .badge-processing { background: #fef3c7; color: #92400e; }
    
    .nav-pills .nav-link {
        border-radius: 2rem;
        padding: 0.4rem 1rem;
        font-size: 0.8rem;
        font-weight: 500;
        color: #6b7280;
        background: #f3f4f6;
        transition: all 0.2s ease;
    }
    .nav-pills .nav-link:hover {
        background: #e5e7eb;
        color: #374151;
    }
    .nav-pills .nav-link.active {
        background: linear-gradient(135deg, #8b5cf6, #6366f1);
        color: white;
    }
    .nav-pills .nav-link .badge {
        font-size: 0.6rem;
        padding: 0.15rem 0.4rem;
    }
</style>
@endsection