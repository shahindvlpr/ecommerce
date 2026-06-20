@extends('layouts.admin')

@section('title', 'Analytics - EktaMart Admin')
@section('page-title', 'Analytics')
@section('icon', 'chart-bar')

@section('content')
<div class="container-fluid">
    
    {{-- ============================================================
         STATS CARDS
    ============================================================ --}}
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="stats-card stats-card-purple">
                <div class="stats-card-inner">
                    <div class="stats-icon">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="stats-content">
                        <span class="stats-label">Total Revenue</span>
                        <h3 class="stats-value">${{ number_format($totalRevenue ?? 0, 2) }}</h3>
                        <span class="stats-change up">
                            <i class="fas fa-arrow-up"></i> {{ number_format($totalRevenueGrowth ?? 0, 1) }}%
                        </span>
                    </div>
                </div>
                <div class="stats-footer">
                    <span><i class="far fa-calendar-alt me-1"></i> Last 30 days</span>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="stats-card stats-card-green">
                <div class="stats-card-inner">
                    <div class="stats-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="stats-content">
                        <span class="stats-label">Total Orders</span>
                        <h3 class="stats-value">{{ $totalOrders ?? 0 }}</h3>
                        <span class="stats-change up">
                            <i class="fas fa-arrow-up"></i> {{ number_format($ordersGrowth ?? 0, 1) }}%
                        </span>
                    </div>
                </div>
                <div class="stats-footer">
                    <span><i class="far fa-clock me-1"></i> {{ $pendingOrders ?? 0 }} Pending</span>
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
                        <span class="stats-label">Total Products</span>
                        <h3 class="stats-value">{{ $totalProducts ?? 0 }}</h3>
                        <span class="stats-change up">
                            <i class="fas fa-arrow-up"></i> {{ number_format($productsGrowth ?? 0, 1) }}%
                        </span>
                    </div>
                </div>
                <div class="stats-footer">
                    <span><i class="fas fa-tag me-1"></i> {{ $totalCategories ?? 0 }} Categories</span>
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
                        <span class="stats-label">Total Users</span>
                        <h3 class="stats-value">{{ $totalUsers ?? 0 }}</h3>
                        <span class="stats-change up">
                            <i class="fas fa-arrow-up"></i> {{ number_format($usersGrowth ?? 0, 1) }}%
                        </span>
                    </div>
                </div>
                <div class="stats-footer">
                    <span><i class="fas fa-store me-1"></i> {{ $totalVendors ?? 0 }} Vendors</span>
                </div>
            </div>
        </div>
    </div>

    {{-- ============================================================
         CHARTS SECTION
    ============================================================ --}}
    <div class="row g-3 mb-4">
        <div class="col-xl-8">
            <div class="card premium-card">
                <div class="card-header-custom">
                    <h5><i class="fas fa-chart-line text-primary me-2"></i>Sales Overview</h5>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-primary bg-opacity-10 text-primary">+12.5%</span>
                        <span class="text-muted small">vs last month</span>
                    </div>
                </div>
                <div class="card-body-custom p-3">
                    <canvas id="salesChart" height="280"></canvas>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card premium-card">
                <div class="card-header-custom">
                    <h5><i class="fas fa-chart-pie text-primary me-2"></i>Category Distribution</h5>
                </div>
                <div class="card-body-custom p-3">
                    <canvas id="categoryChart" height="280"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- ============================================================
         TOP SELLING PRODUCTS
    ============================================================ --}}
    <div class="row g-3 mb-4">
        <div class="col-xl-6">
            <div class="card premium-card">
                <div class="card-header-custom">
                    <h5><i class="fas fa-trophy text-warning me-2"></i>Top Selling Products</h5>
                    <a href="{{ route('admin.products.index') }}" class="btn-view-all">
                        View All <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="card-body-custom p-0">
                    @if(isset($topProducts) && $topProducts->count() > 0)
                        <div class="table-responsive">
                            <table class="table premium-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Sold</th>
                                        <th>Revenue</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($topProducts as $index => $product)
                                    <tr>
                                        <td>
                                            @if($index == 0)
                                                <span class="rank-badge gold">🥇</span>
                                            @elseif($index == 1)
                                                <span class="rank-badge silver">🥈</span>
                                            @elseif($index == 2)
                                                <span class="rank-badge bronze">🥉</span>
                                            @else
                                                <span class="rank-number">#{{ $index + 1 }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                @if($product->image)
                                                    <img src="{{ asset('storage/products/' . $product->image) }}" 
                                                         alt="{{ $product->name }}" 
                                                         class="product-thumb">
                                                @else
                                                    <div class="product-thumb-placeholder">
                                                        <i class="fas fa-box"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <div class="product-name">{{ Str::limit($product->name, 25) }}</div>
                                                    <div class="product-category">{{ $product->category->name ?? 'Uncategorized' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="fw-semibold">${{ number_format($product->price ?? 0, 2) }}</td>
                                        <td>{{ $product->orderItems->sum('quantity') ?? 0 }}</td>
                                        <td class="fw-semibold text-success">
                                            ${{ number_format($product->orderItems->sum('subtotal') ?? 0, 2) }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="fas fa-box-open"></i>
                            <h6>No Products Found</h6>
                            <p class="text-muted small">Start adding products to see analytics.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- ============================================================
             MONTHLY SALES SUMMARY
        ============================================================ --}}
        <div class="col-xl-6">
            <div class="card premium-card">
                <div class="card-header-custom">
                    <h5><i class="fas fa-calendar-alt text-primary me-2"></i>Monthly Sales Summary</h5>
                    <span class="text-muted small">{{ now()->format('Y') }}</span>
                </div>
                <div class="card-body-custom p-0">
                    @if(isset($monthlySales) && $monthlySales->count() > 0)
                        <div class="table-responsive">
                            <table class="table premium-table">
                                <thead>
                                    <tr>
                                        <th>Month</th>
                                        <th>Orders</th>
                                        <th>Revenue</th>
                                        <th>Growth</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($monthlySales as $month)
                                    <tr>
                                        <td>
                                            <span class="month-name">
                                                {{ $month->month_name ?? 'N/A' }}
                                                <span class="month-year">{{ $month->year }}</span>
                                            </span>
                                        </td>
                                        <td>{{ $month->orders_count ?? 0 }}</td>
                                        <td class="fw-semibold">${{ number_format($month->total ?? 0, 2) }}</td>
                                        <td>
                                            @if(isset($month->growth))
                                                @if($month->growth > 0)
                                                    <span class="badge-status bg-success">
                                                        <i class="fas fa-arrow-up me-1"></i>{{ number_format($month->growth, 1) }}%
                                                    </span>
                                                @elseif($month->growth < 0)
                                                    <span class="badge-status bg-danger">
                                                        <i class="fas fa-arrow-down me-1"></i>{{ number_format(abs($month->growth), 1) }}%
                                                    </span>
                                                @else
                                                    <span class="badge-status bg-secondary">0%</span>
                                                @endif
                                            @else
                                                <span class="badge-status bg-secondary">—</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="fas fa-chart-simple"></i>
                            <h6>No Data Available</h6>
                            <p class="text-muted small">Sales data will appear here.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('styles')
<style>
/* ============================================================
   STATS CARDS
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
}

/* Stats Card Colors */
.stats-card-purple .stats-icon {
    background: rgba(139, 92, 246, 0.12);
    color: #8B5CF6;
}
.stats-card-green .stats-icon {
    background: rgba(16, 185, 129, 0.12);
    color: #10B981;
}
.stats-card-blue .stats-icon {
    background: rgba(59, 130, 246, 0.12);
    color: #3B82F6;
}
.stats-card-orange .stats-icon {
    background: rgba(245, 158, 11, 0.12);
    color: #F59E0B;
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

/* ============================================================
   RANK BADGES
============================================================ */
.rank-badge {
    font-size: 18px;
}
.rank-number {
    font-size: 12px;
    font-weight: 600;
    color: var(--text-muted);
    padding: 0 6px;
}

/* ============================================================
   PRODUCT THUMB
============================================================ */
.product-thumb {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    object-fit: cover;
    border: 1px solid var(--border-color);
}
.product-thumb-placeholder {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    background: var(--bg-body);
    border: 1px solid var(--border-color);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-muted);
    font-size: 14px;
}

.product-name {
    font-weight: 500;
    color: var(--text-primary);
}
.product-category {
    font-size: 11px;
    color: var(--text-muted);
}

/* ============================================================
   MONTH NAME
============================================================ */
.month-name {
    font-weight: 500;
    color: var(--text-primary);
}
.month-year {
    font-size: 10px;
    color: var(--text-muted);
    font-weight: 400;
    margin-left: 2px;
}

/* ============================================================
   BADGE STATUS
============================================================ */
.badge-status {
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
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
[data-theme="dark"] .product-name {
    color: #e2e0f0;
}
[data-theme="dark"] .month-name {
    color: #e2e0f0;
}
[data-theme="dark"] .stats-footer {
    border-top-color: rgba(255, 255, 255, 0.04);
}
[data-theme="dark"] .card-header-custom {
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
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ============================================================
    // SALES CHART
    // ============================================================
    var salesCtx = document.getElementById('salesChart').getContext('2d');
    
    var gradient = salesCtx.createLinearGradient(0, 0, 0, 280);
    gradient.addColorStop(0, 'rgba(139, 92, 246, 0.25)');
    gradient.addColorStop(1, 'rgba(139, 92, 246, 0.02)');
    
    // ✅ Properly encode data
    var monthlyLabels = {!! json_encode($monthlyLabels ?? ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']) !!};
    var monthlyRevenueData = {!! json_encode($monthlyRevenueData ?? [12500, 15200, 16800, 14200, 18900, 21400, 23500, 22800, 25600, 28900, 31200, 34800]) !!};
    
    new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: monthlyLabels,
            datasets: [{
                label: 'Revenue ($)',
                data: monthlyRevenueData,
                borderColor: '#8B5CF6',
                backgroundColor: gradient,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#8B5CF6',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 7,
                borderWidth: 3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            interaction: {
                intersect: false,
                mode: 'index'
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0,0,0,0.85)',
                    titleFont: { size: 12, weight: '600' },
                    bodyFont: { size: 13 },
                    padding: 12,
                    cornerRadius: 8,
                    callbacks: {
                        label: function(context) {
                            return '$' + context.raw.toLocaleString();
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '$' + value.toLocaleString();
                        },
                        font: { size: 10 }
                    },
                    grid: {
                        color: 'rgba(0,0,0,0.04)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: { size: 10 }
                    }
                }
            }
        }
    });

    // ============================================================
    // CATEGORY CHART
    // ============================================================
    var categoryCtx = document.getElementById('categoryChart').getContext('2d');
    
    var categoryLabels = {!! json_encode($categoryLabels ?? ['Electronics', 'Fashion', 'Books', 'Home Decor', 'Sports']) !!};
    var categoryData = {!! json_encode($categoryData ?? [30, 25, 20, 15, 10]) !!};
    var categoryColors = ['#8B5CF6', '#10B981', '#F59E0B', '#3B82F6', '#EC4899', '#14B8A6'];
    
    new Chart(categoryCtx, {
        type: 'doughnut',
        data: {
            labels: categoryLabels,
            datasets: [{
                data: categoryData,
                backgroundColor: categoryColors.slice(0, categoryLabels.length),
                borderWidth: 0,
                hoverOffset: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 12,
                        font: { size: 11 },
                        padding: 12,
                        usePointStyle: true,
                        pointStyle: 'circle'
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0,0,0,0.85)',
                    titleFont: { size: 12, weight: '600' },
                    bodyFont: { size: 13 },
                    padding: 12,
                    cornerRadius: 8,
                    callbacks: {
                        label: function(context) {
                            var total = context.dataset.data.reduce(function(a, b) { return a + b; }, 0);
                            var percentage = total > 0 ? ((context.raw / total) * 100).toFixed(1) : 0;
                            return context.label + ': ' + context.raw + ' products (' + percentage + '%)';
                        }
                    }
                }
            },
            cutout: '65%'
        }
    });
});

console.log('%c📊 Analytics Page Loaded', 'color: #8B5CF6; font-size: 13px; font-weight: bold;');
</script>
@endpush