@extends('layouts.admin')

@section('title', 'Dashboard - EktaMart Admin')

@section('page-title', 'Dashboard')
@section('icon', 'th-large')

@section('content')
<div class="container-fluid">
    
    {{-- ============================================================
         STATS CARDS - MODERN & COMPACT
    ============================================================ --}}
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="stats-card stats-card-purple">
                <div class="stats-card-inner">
                    <div class="stats-icon">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <div class="stats-content">
                        <span class="stats-label">Total Orders</span>
                        <h3 class="stats-value">{{ $totalOrders ?? 0 }}</h3>
                        <span class="stats-change up">
                            <i class="fas fa-arrow-up"></i> 12.5%
                        </span>
                    </div>
                </div>
                <div class="stats-footer">
                    <span>{{ $pendingOrders ?? 0 }} Pending</span>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="stats-card stats-card-green">
                <div class="stats-card-inner">
                    <div class="stats-icon">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="stats-content">
                        <span class="stats-label">Revenue</span>
                        <h3 class="stats-value">${{ number_format($totalRevenue ?? 0, 2) }}</h3>
                        <span class="stats-change up">
                            <i class="fas fa-arrow-up"></i> 18.2%
                        </span>
                    </div>
                </div>
                <div class="stats-footer">
                    <span>This Month</span>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="stats-card stats-card-blue">
                <div class="stats-card-inner">
                    <div class="stats-icon">
                        <i class="fas fa-box"></i>
                    </div>
                    <div class="stats-content">
                        <span class="stats-label">Products</span>
                        <h3 class="stats-value">{{ $totalProducts ?? 0 }}</h3>
                        <span class="stats-change up">
                            <i class="fas fa-arrow-up"></i> 8.4%
                        </span>
                    </div>
                </div>
                <div class="stats-footer">
                    @php $low = \App\Models\Product::where('stock', '<', 10)->count(); @endphp
                    <span>{{ $low }} Low Stock</span>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="stats-card stats-card-orange">
                <div class="stats-card-inner">
                    <div class="stats-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stats-content">
                        <span class="stats-label">Users</span>
                        <h3 class="stats-value">{{ $totalUsers ?? 0 }}</h3>
                        <span class="stats-change up">
                            <i class="fas fa-arrow-up"></i> 5.6%
                        </span>
                    </div>
                </div>
                <div class="stats-footer">
                    @php $vendors = \App\Models\User::where('role', 'vendor')->count(); @endphp
                    <span>{{ $vendors }} Vendors</span>
                </div>
            </div>
        </div>
    </div>

    {{-- ============================================================
         STATS CARDS - ROW 2 (Additional Metrics)
    ============================================================ --}}
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="stats-card stats-card-pink">
                <div class="stats-card-inner">
                    <div class="stats-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="stats-content">
                        <span class="stats-label">Reviews</span>
                        <h3 class="stats-value">{{ \App\Models\Review::count() }}</h3>
                        <span class="stats-change up">
                            <i class="fas fa-arrow-up"></i> 15.2%
                        </span>
                    </div>
                </div>
                <div class="stats-footer">
                    <span>{{ \App\Models\Review::where('is_approved', false)->count() }} Pending</span>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="stats-card stats-card-indigo">
                <div class="stats-card-inner">
                    <div class="stats-icon">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <div class="stats-content">
                        <span class="stats-label">Payments</span>
                        <h3 class="stats-value">{{ \App\Models\Payment::count() }}</h3>
                        <span class="stats-change up">
                            <i class="fas fa-arrow-up"></i> 22.8%
                        </span>
                    </div>
                </div>
                <div class="stats-footer">
                    <span>{{ \App\Models\Payment::where('status', 'pending')->count() }} Pending</span>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="stats-card stats-card-teal">
                <div class="stats-card-inner">
                    <div class="stats-icon">
                        <i class="fas fa-tag"></i>
                    </div>
                    <div class="stats-content">
                        <span class="stats-label">Categories</span>
                        <h3 class="stats-value">{{ \App\Models\Category::count() }}</h3>
                        <span class="stats-change up">
                            <i class="fas fa-arrow-up"></i> 3.1%
                        </span>
                    </div>
                </div>
                <div class="stats-footer">
                    <span>Active Categories</span>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="stats-card stats-card-red">
                <div class="stats-card-inner">
                    <div class="stats-icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="stats-content">
                        <span class="stats-label">Low Stock</span>
                        <h3 class="stats-value">{{ \App\Models\Product::where('stock', '<', 5)->where('stock', '>', 0)->count() }}</h3>
                        <span class="stats-change down">
                            <i class="fas fa-arrow-down"></i> Needs Attention
                        </span>
                    </div>
                </div>
                <div class="stats-footer">
                    <span>Critical Stock</span>
                </div>
            </div>
        </div>
    </div>

    {{-- ============================================================
         QUICK ACTIONS
    ============================================================ --}}
    <div class="row g-3 mb-4">
        <div class="col-12">
            <div class="quick-actions-card">
                <div class="quick-actions-header">
                    <h5><i class="fas fa-bolt text-warning me-2"></i>Quick Actions</h5>
                </div>
                <div class="quick-actions-body">
                    <a href="{{ route('admin.products.create') }}" class="quick-action-btn purple">
                        <i class="fas fa-plus"></i>
                        <span>Add Product</span>
                    </a>
                    <a href="{{ route('admin.orders.index') }}" class="quick-action-btn green">
                        <i class="fas fa-shopping-bag"></i>
                        <span>View Orders</span>
                    </a>
                    <a href="{{ route('admin.categories.create') }}" class="quick-action-btn blue">
                        <i class="fas fa-layer-group"></i>
                        <span>Add Category</span>
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="quick-action-btn orange">
                        <i class="fas fa-users"></i>
                        <span>Manage Users</span>
                    </a>
                    <a href="{{ route('admin.reports.sales') }}" class="quick-action-btn pink">
                        <i class="fas fa-chart-line"></i>
                        <span>Sales Report</span>
                    </a>
                    <a href="{{ route('admin.coupons.index') }}" class="quick-action-btn teal">
                        <i class="fas fa-ticket"></i>
                        <span>Coupons</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- ============================================================
         RECENT ORDERS & ACTIVITY
    ============================================================ --}}
    <div class="row g-3">
        <div class="col-xl-8">
            <div class="card premium-card">
                <div class="card-header-custom">
                    <h5><i class="fas fa-clock text-primary me-2"></i>Recent Orders</h5>
                    <a href="{{ route('admin.orders.index') }}" class="btn-view-all">
                        View All <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="card-body-custom">
                    @if(isset($recentOrders) && $recentOrders->count() > 0)
                        <div class="table-responsive">
                            <table class="table premium-table">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Customer</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentOrders as $order)
                                    <tr>
                                        <td><span class="order-id">#{{ $order->id }}</span></td>
                                        <td>{{ $order->user->name ?? 'Guest' }}</td>
                                        <td class="fw-semibold">${{ number_format($order->total ?? 0, 2) }}</td>
                                        <td>
                                            @php
                                                $statusColors = [
                                                    'pending' => 'warning',
                                                    'processing' => 'info',
                                                    'shipped' => 'primary',
                                                    'delivered' => 'success',
                                                    'cancelled' => 'danger',
                                                    'refunded' => 'secondary'
                                                ];
                                                $color = $statusColors[$order->status ?? 'pending'] ?? 'secondary';
                                            @endphp
                                            <span class="badge-status bg-{{ $color }}">
                                                {{ ucfirst($order->status ?? 'Pending') }}
                                            </span>
                                        </td>
                                        <td class="text-muted small">{{ $order->created_at->diffForHumans() }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="fas fa-inbox"></i>
                            <h6>No Orders Found</h6>
                            <p class="text-muted small">Your store hasn't received any orders yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card premium-card">
                <div class="card-header-custom">
                    <h5><i class="fas fa-bell text-warning me-2"></i>Recent Activity</h5>
                </div>
                <div class="card-body-custom p-0">
                    <div class="activity-list">
                        @if(isset($latestNotifications) && $latestNotifications->count() > 0)
                            @foreach($latestNotifications as $notif)
                            <div class="activity-item {{ !$notif->is_read ? 'unread' : '' }}">
                                <div class="activity-icon" style="background: {{ $notif->color ?? '#8B5CF6' }}20; color: {{ $notif->color ?? '#8B5CF6' }};">
                                    <i class="{{ $notif->icon_class ?? 'fas fa-bell' }}"></i>
                                </div>
                                <div class="activity-content">
                                    <div class="activity-title">{{ $notif->title }}</div>
                                    <div class="activity-time">{{ $notif->created_at->diffForHumans() }}</div>
                                </div>
                                @if(!$notif->is_read)
                                    <span class="activity-dot"></span>
                                @endif
                            </div>
                            @endforeach
                        @else
                            <div class="empty-state py-4">
                                <i class="fas fa-check-circle text-success"></i>
                                <h6 class="mt-2">All caught up!</h6>
                                <p class="text-muted small">No recent activity</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('styles')
<style>
/* ============================================================
   STATS CARDS - PREMIUM
============================================================ */
.stats-card {
    background: var(--bg-card);
    border-radius: 12px;
    border: 1px solid var(--border-color);
    overflow: hidden;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: var(--shadow-sm);
    height: 100%;
}
.stats-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-md);
}

.stats-card-inner {
    padding: 16px 20px 12px 20px;
    display: flex;
    align-items: flex-start;
    gap: 14px;
}

.stats-icon {
    width: 44px;
    height: 44px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    flex-shrink: 0;
}

.stats-content {
    flex: 1;
    min-width: 0;
}
.stats-label {
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: var(--text-muted);
    display: block;
}
.stats-value {
    font-size: 22px;
    font-weight: 700;
    color: var(--text-primary);
    margin: 2px 0 4px 0;
    line-height: 1.2;
}
.stats-change {
    font-size: 11px;
    font-weight: 600;
    padding: 1px 10px;
    border-radius: 20px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}
.stats-change.up {
    background: #dcfce7;
    color: #16a34a;
}
.stats-change.down {
    background: #fee2e2;
    color: #dc2626;
}

.stats-footer {
    padding: 8px 20px 14px 20px;
    border-top: 1px solid var(--border-color);
    font-size: 12px;
    color: var(--text-muted);
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.stats-footer span {
    display: flex;
    align-items: center;
    gap: 6px;
}

/* Stats Card Colors */
.stats-card-purple .stats-icon {
    background: rgba(139, 92, 246, 0.12);
    color: #8B5CF6;
}
.stats-card-purple .stats-footer {
    color: #8B5CF6;
}

.stats-card-green .stats-icon {
    background: rgba(16, 185, 129, 0.12);
    color: #10B981;
}
.stats-card-green .stats-footer {
    color: #10B981;
}

.stats-card-blue .stats-icon {
    background: rgba(59, 130, 246, 0.12);
    color: #3B82F6;
}
.stats-card-blue .stats-footer {
    color: #3B82F6;
}

.stats-card-orange .stats-icon {
    background: rgba(245, 158, 11, 0.12);
    color: #F59E0B;
}
.stats-card-orange .stats-footer {
    color: #F59E0B;
}

.stats-card-pink .stats-icon {
    background: rgba(236, 72, 153, 0.12);
    color: #EC4899;
}
.stats-card-pink .stats-footer {
    color: #EC4899;
}

.stats-card-indigo .stats-icon {
    background: rgba(99, 102, 241, 0.12);
    color: #6366F1;
}
.stats-card-indigo .stats-footer {
    color: #6366F1;
}

.stats-card-teal .stats-icon {
    background: rgba(20, 184, 166, 0.12);
    color: #14B8A6;
}
.stats-card-teal .stats-footer {
    color: #14B8A6;
}

.stats-card-red .stats-icon {
    background: rgba(239, 68, 68, 0.12);
    color: #EF4444;
}
.stats-card-red .stats-footer {
    color: #EF4444;
}

/* ============================================================
   QUICK ACTIONS CARD
============================================================ */
.quick-actions-card {
    background: var(--bg-card);
    border-radius: 12px;
    border: 1px solid var(--border-color);
    box-shadow: var(--shadow-sm);
    overflow: hidden;
}
.quick-actions-header {
    padding: 14px 20px;
    border-bottom: 1px solid var(--border-color);
}
.quick-actions-header h5 {
    font-weight: 600;
    font-size: 14px;
    color: var(--text-primary);
    margin: 0;
}
.quick-actions-body {
    padding: 14px 20px;
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.quick-action-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 6px 14px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s ease;
    border: 1px solid var(--border-color);
    background: var(--bg-body);
    color: var(--text-secondary);
}
.quick-action-btn:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-sm);
    text-decoration: none;
}
.quick-action-btn i {
    font-size: 14px;
}
.quick-action-btn.purple:hover {
    background: #8B5CF6;
    color: #fff;
    border-color: #8B5CF6;
}
.quick-action-btn.green:hover {
    background: #10B981;
    color: #fff;
    border-color: #10B981;
}
.quick-action-btn.blue:hover {
    background: #3B82F6;
    color: #fff;
    border-color: #3B82F6;
}
.quick-action-btn.orange:hover {
    background: #F59E0B;
    color: #fff;
    border-color: #F59E0B;
}
.quick-action-btn.pink:hover {
    background: #EC4899;
    color: #fff;
    border-color: #EC4899;
}
.quick-action-btn.teal:hover {
    background: #14B8A6;
    color: #fff;
    border-color: #14B8A6;
}

/* ============================================================
   PREMIUM CARD
============================================================ */
.premium-card {
    background: var(--bg-card);
    border-radius: 12px;
    border: 1px solid var(--border-color);
    box-shadow: var(--shadow-sm);
    overflow: hidden;
    height: 100%;
}
.premium-card:hover {
    box-shadow: var(--shadow-md);
}

.card-header-custom {
    padding: 14px 20px;
    border-bottom: 1px solid var(--border-color);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 8px;
}
.card-header-custom h5 {
    font-weight: 600;
    font-size: 14px;
    color: var(--text-primary);
    margin: 0;
}

.btn-view-all {
    font-size: 12px;
    font-weight: 500;
    color: var(--primary);
    text-decoration: none;
    padding: 4px 12px;
    border-radius: 6px;
    transition: all 0.2s ease;
}
.btn-view-all:hover {
    background: rgba(139, 92, 246, 0.08);
    color: var(--primary-dark);
}

.card-body-custom {
    padding: 0;
}

/* ============================================================
   PREMIUM TABLE
============================================================ */
.premium-table {
    margin: 0;
    font-size: 13px;
}
.premium-table thead th {
    background: var(--bg-body);
    color: var(--text-muted);
    font-weight: 600;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 10px 16px;
    border-bottom: 1px solid var(--border-color);
}
.premium-table tbody td {
    padding: 10px 16px;
    border-bottom: 1px solid var(--border-color);
    color: var(--text-primary);
    vertical-align: middle;
}
.premium-table tbody tr:hover {
    background: rgba(139, 92, 246, 0.02);
}
.premium-table tbody tr:last-child td {
    border-bottom: none;
}

.order-id {
    font-weight: 600;
    color: var(--text-primary);
}

.badge-status {
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
}
.badge-status.bg-warning {
    background: #fef3c7 !important;
    color: #d97706 !important;
}
.badge-status.bg-info {
    background: #dbeafe !important;
    color: #2563eb !important;
}
.badge-status.bg-primary {
    background: #e0e7ff !important;
    color: #4f46e5 !important;
}
.badge-status.bg-success {
    background: #dcfce7 !important;
    color: #16a34a !important;
}
.badge-status.bg-danger {
    background: #fee2e2 !important;
    color: #dc2626 !important;
}
.badge-status.bg-secondary {
    background: #f1f5f9 !important;
    color: #64748b !important;
}

/* ============================================================
   ACTIVITY LIST
============================================================ */
.activity-list {
    padding: 4px 0;
}
.activity-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 10px 16px;
    border-bottom: 1px solid var(--border-color);
    transition: all 0.2s ease;
}
.activity-item:last-child {
    border-bottom: none;
}
.activity-item:hover {
    background: var(--bg-body);
}
.activity-item.unread {
    background: rgba(139, 92, 246, 0.03);
}

.activity-icon {
    width: 34px;
    height: 34px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    flex-shrink: 0;
}

.activity-content {
    flex: 1;
    min-width: 0;
}
.activity-title {
    font-size: 13px;
    font-weight: 500;
    color: var(--text-primary);
}
.activity-time {
    font-size: 11px;
    color: var(--text-muted);
    margin-top: 2px;
}

.activity-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #8B5CF6;
    flex-shrink: 0;
    margin-top: 6px;
    animation: pulse 2s ease-in-out infinite;
}

/* ============================================================
   EMPTY STATE
============================================================ */
.empty-state {
    text-align: center;
    padding: 30px 20px;
}
.empty-state i {
    font-size: 32px;
    color: var(--text-muted);
    opacity: 0.3;
}
.empty-state h6 {
    margin-top: 12px;
    font-weight: 600;
    color: var(--text-primary);
}
.empty-state p {
    margin: 4px 0 0 0;
}

/* ============================================================
   DARK MODE
============================================================ */
[data-theme="dark"] .stats-card {
    background: #1A1A3E;
    border-color: rgba(255, 255, 255, 0.06);
}
[data-theme="dark"] .stats-card .stats-value {
    color: #f1f5f9;
}
[data-theme="dark"] .quick-actions-card {
    background: #1A1A3E;
    border-color: rgba(255, 255, 255, 0.06);
}
[data-theme="dark"] .quick-action-btn {
    background: rgba(255, 255, 255, 0.04);
    border-color: rgba(255, 255, 255, 0.08);
    color: #9896b0;
}
[data-theme="dark"] .quick-action-btn:hover {
    color: #fff;
}
[data-theme="dark"] .premium-card {
    background: #1A1A3E;
    border-color: rgba(255, 255, 255, 0.06);
}
[data-theme="dark"] .premium-table thead th {
    background: rgba(255, 255, 255, 0.03);
    color: #7F77DD;
}
[data-theme="dark"] .premium-table tbody td {
    border-color: rgba(255, 255, 255, 0.04);
    color: #e2e0f0;
}
[data-theme="dark"] .card-header-custom h5 {
    color: #e2e0f0;
}
[data-theme="dark"] .activity-item {
    border-color: rgba(255, 255, 255, 0.04);
}
[data-theme="dark"] .activity-item:hover {
    background: rgba(255, 255, 255, 0.02);
}
[data-theme="dark"] .activity-title {
    color: #e2e0f0;
}
[data-theme="dark"] .stats-footer {
    border-top-color: rgba(255, 255, 255, 0.04);
}
[data-theme="dark"] .card-header-custom {
    border-bottom-color: rgba(255, 255, 255, 0.04);
}
[data-theme="dark"] .quick-actions-header {
    border-bottom-color: rgba(255, 255, 255, 0.04);
}

/* ============================================================
   RESPONSIVE
============================================================ */
@media (max-width: 768px) {
    .stats-card-inner {
        padding: 12px 16px 8px 16px;
        gap: 10px;
    }
    .stats-icon {
        width: 38px;
        height: 38px;
        font-size: 15px;
    }
    .stats-value {
        font-size: 18px;
    }
    .stats-footer {
        padding: 6px 16px 10px 16px;
        font-size: 11px;
    }
    .quick-actions-body {
        padding: 10px 16px;
        gap: 6px;
    }
    .quick-action-btn {
        padding: 5px 10px;
        font-size: 12px;
    }
    .quick-action-btn i {
        font-size: 12px;
    }
    .card-header-custom {
        padding: 10px 16px;
    }
    .premium-table {
        font-size: 12px;
    }
    .premium-table thead th,
    .premium-table tbody td {
        padding: 6px 10px;
    }
}

@media (max-width: 576px) {
    .stats-card-inner {
        padding: 10px 12px 6px 12px;
        gap: 8px;
    }
    .stats-icon {
        width: 32px;
        height: 32px;
        font-size: 13px;
    }
    .stats-value {
        font-size: 16px;
    }
    .stats-label {
        font-size: 10px;
    }
    .stats-footer {
        padding: 4px 12px 8px 12px;
        font-size: 10px;
    }
    .stats-change {
        font-size: 10px;
        padding: 0px 8px;
    }
}
</style>
@endpush