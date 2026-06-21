@extends('layouts.admin')

@section('title', 'Sales Report - EktaMart Admin')
@section('page-title', 'Sales Report')
@section('icon', 'chart-line')

@section('content')
<div class="container-fluid">
    
    {{-- ============================================================
         HEADER WITH DATE RANGE FILTER
    ============================================================ --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="report-header">
                <div class="report-header-left">
                    <div class="report-header-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0">Sales Report</h5>
                        <p class="text-muted small mb-0">Track your store's sales performance</p>
                    </div>
                </div>
                <div class="report-header-right">
                    <form action="{{ route('admin.reports.sales') }}" method="GET" class="d-flex gap-2 align-items-center flex-wrap">
                        <div class="date-range-wrapper">
                            <i class="fas fa-calendar-alt"></i>
                            <input type="date" name="start_date" class="form-control form-control-sm date-input" 
                                   value="{{ request('start_date', $startDate) }}" 
                                   placeholder="Start Date">
                            <span class="date-separator">to</span>
                            <input type="date" name="end_date" class="form-control form-control-sm date-input" 
                                   value="{{ request('end_date', $endDate) }}" 
                                   placeholder="End Date">
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm rounded-pill px-3">
                            <i class="fas fa-filter me-1"></i> Apply Filter
                        </button>
                        <a href="{{ route('admin.reports.sales') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                            <i class="fas fa-undo me-1"></i> Reset
                        </a>
                        <a href="{{ route('admin.reports.export.sales') }}{{ request()->getQueryString() ? '?' . request()->getQueryString() : '' }}" 
                           class="btn btn-success btn-sm rounded-pill px-3">
                            <i class="fas fa-file-excel me-1"></i> Export
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- ============================================================
         STATS CARDS - PREMIUM
    ============================================================ --}}
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="stats-card stats-card-purple">
                <div class="stats-card-inner">
                    <div class="stats-icon"><i class="fas fa-dollar-sign"></i></div>
                    <div class="stats-content">
                        <span class="stats-label">Total Revenue</span>
                        <h3 class="stats-value">${{ number_format($totalRevenue, 2) }}</h3>
                        <span class="stats-change up">
                            <i class="fas fa-arrow-up"></i> {{ $revenueGrowth ?? 12.5 }}%
                        </span>
                    </div>
                </div>
                <div class="stats-footer">
                    <span><i class="far fa-calendar-alt me-1"></i> {{ $startDate }} - {{ $endDate }}</span>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="stats-card stats-card-green">
                <div class="stats-card-inner">
                    <div class="stats-icon"><i class="fas fa-shopping-cart"></i></div>
                    <div class="stats-content">
                        <span class="stats-label">Total Orders</span>
                        <h3 class="stats-value">{{ $totalOrders }}</h3>
                        <span class="stats-change up">
                            <i class="fas fa-arrow-up"></i> {{ $ordersGrowth ?? 8.3 }}%
                        </span>
                    </div>
                </div>
                <div class="stats-footer">
                    <span><i class="fas fa-clock me-1"></i> {{ $pendingOrders ?? 0 }} Pending</span>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="stats-card stats-card-blue">
                <div class="stats-card-inner">
                    <div class="stats-icon"><i class="fas fa-calculator"></i></div>
                    <div class="stats-content">
                        <span class="stats-label">Avg Order Value</span>
                        <h3 class="stats-value">${{ number_format($averageOrderValue, 2) }}</h3>
                        <span class="stats-change up">
                            <i class="fas fa-arrow-up"></i> {{ $avgOrderGrowth ?? 5.2 }}%
                        </span>
                    </div>
                </div>
                <div class="stats-footer">
                    <span><i class="fas fa-shopping-bag me-1"></i> {{ number_format($averageOrderValue / ($averageOrderValue - 5 ?? 1), 1) }}x Growth</span>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="stats-card stats-card-orange">
                <div class="stats-card-inner">
                    <div class="stats-icon"><i class="fas fa-users"></i></div>
                    <div class="stats-content">
                        <span class="stats-label">Total Customers</span>
                        <h3 class="stats-value">{{ $totalCustomers ?? 0 }}</h3>
                        <span class="stats-change up">
                            <i class="fas fa-arrow-up"></i> {{ $customerGrowth ?? 3.7 }}%
                        </span>
                    </div>
                </div>
                <div class="stats-footer">
                    <span><i class="fas fa-user-plus me-1"></i> {{ $newCustomers ?? 0 }} New</span>
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
                    <h5><i class="fas fa-chart-line text-primary me-2"></i>Sales Trend</h5>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-primary bg-opacity-10 text-primary">+{{ $revenueGrowth ?? 12.5 }}%</span>
                        <span class="text-muted small">vs previous period</span>
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
                    <h5><i class="fas fa-chart-pie text-primary me-2"></i>Revenue Distribution</h5>
                </div>
                <div class="card-body-custom p-3">
                    <canvas id="distributionChart" height="280"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- ============================================================
         TOP PRODUCTS & CATEGORIES
    ============================================================ --}}
    <div class="row g-3">
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
                                        <th style="width:40px;">#</th>
                                        <th>Product</th>
                                        <th class="text-center">Sold</th>
                                        <th class="text-end">Revenue</th>
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
                                        <td class="text-center fw-semibold">{{ $product->total_sold ?? 0 }}</td>
                                        <td class="text-end fw-semibold text-success">
                                            ${{ number_format($product->total_revenue ?? 0, 2) }}
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
                            <p class="text-muted small">No sales data available for this period.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="card premium-card">
                <div class="card-header-custom">
                    <h5><i class="fas fa-layer-group text-primary me-2"></i>Category Performance</h5>
                    <span class="text-muted small">Top categories by revenue</span>
                </div>
                <div class="card-body-custom p-0">
                    @if(isset($categoryStats) && $categoryStats->count() > 0)
                        <div class="table-responsive">
                            <table class="table premium-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Category</th>
                                        <th class="text-center">Products</th>
                                        <th class="text-end">Revenue</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($categoryStats as $index => $category)
                                    <tr>
                                        <td>
                                            <span class="rank-number">#{{ $index + 1 }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                @if($category->icon)
                                                    <img src="{{ asset('storage/products/' . $category->icon) }}" 
                                                         alt="{{ $category->name }}" 
                                                         class="category-thumb">
                                                @else
                                                    <div class="category-thumb-placeholder">
                                                        <i class="fas fa-layer-group"></i>
                                                    </div>
                                                @endif
                                                <span class="fw-semibold">{{ $category->name }}</span>
                                            </div>
                                        </td>
                                        <td class="text-center">{{ $category->products_count ?? 0 }}</td>
                                        <td class="text-end fw-semibold text-success">
                                            ${{ number_format($category->total_revenue ?? 0, 2) }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="fas fa-layer-group"></i>
                            <h6>No Categories Found</h6>
                            <p class="text-muted small">Category sales data not available.</p>
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
   REPORT HEADER
============================================================ */
.report-header {
    background: var(--bg-card);
    border-radius: 16px;
    padding: 18px 24px;
    border: 1px solid var(--border-color);
    box-shadow: var(--shadow-sm);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
}

.report-header-left {
    display: flex;
    align-items: center;
    gap: 14px;
}
.report-header-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background: linear-gradient(135deg, #8B5CF6, #6366F1);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 18px;
}
.report-header-right {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}

.date-range-wrapper {
    display: flex;
    align-items: center;
    gap: 8px;
    background: var(--bg-body);
    padding: 4px 12px;
    border-radius: 10px;
    border: 1px solid var(--border-color);
}
.date-range-wrapper i {
    color: var(--text-muted);
}
.date-range-wrapper .date-input {
    border: none;
    background: transparent;
    padding: 6px 4px;
    font-size: 13px;
    color: var(--text-primary);
    width: 130px;
}
.date-range-wrapper .date-input:focus {
    outline: none;
}
.date-range-wrapper .date-separator {
    color: var(--text-muted);
    font-size: 12px;
}

/* ============================================================
   STATS CARDS
============================================================ */
.stats-card {
    background: var(--bg-card);
    border-radius: 12px;
    border: 1px solid var(--border-color);
    overflow: hidden;
    transition: all 0.3s ease;
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

.stats-card-purple .stats-icon { background: rgba(139,92,246,0.12); color: #8B5CF6; }
.stats-card-green .stats-icon { background: rgba(16,185,129,0.12); color: #10B981; }
.stats-card-blue .stats-icon { background: rgba(59,130,246,0.12); color: #3B82F6; }
.stats-card-orange .stats-icon { background: rgba(245,158,11,0.12); color: #F59E0B; }

/* ============================================================
   PREMIUM CARD
============================================================ */
.premium-card {
    background: var(--bg-card);
    border-radius: 12px;
    border: 1px solid var(--border-color);
    box-shadow: var(--shadow-sm);
    overflow: hidden;
    /* height: 100%; */
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
.card-body-custom {
    padding: 0;
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
    background: rgba(139,92,246,0.08);
    color: var(--primary-dark);
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
    background: rgba(139,92,246,0.02);
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
.product-thumb,
.category-thumb {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    object-fit: cover;
    border: 1px solid var(--border-color);
}
.product-thumb-placeholder,
.category-thumb-placeholder {
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
   EMPTY STATE
============================================================ */
.empty-state {
    text-align: center;
    padding: 40px 20px;
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
   RESPONSIVE
============================================================ */
@media (max-width: 992px) {
    .report-header {
        flex-direction: column;
        align-items: stretch;
    }
    .report-header-right form {
        flex-wrap: wrap;
    }
    .date-range-wrapper {
        flex-wrap: wrap;
        justify-content: center;
    }
    .date-range-wrapper .date-input {
        width: 100px;
    }
}

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
    .date-range-wrapper .date-input {
        width: 80px;
        font-size: 12px;
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
    .report-header {
        padding: 12px 16px;
    }
    .report-header-icon {
        width: 36px;
        height: 36px;
        font-size: 15px;
    }
    .date-range-wrapper {
        padding: 4px 8px;
    }
    .date-range-wrapper .date-input {
        width: 70px;
        font-size: 11px;
    }
}

/* ============================================================
   DARK MODE
============================================================ */
[data-theme="dark"] .report-header {
    background: #1A1A3E;
    border-color: rgba(255,255,255,0.06);
}
[data-theme="dark"] .stats-card {
    background: #1A1A3E;
    border-color: rgba(255,255,255,0.06);
}
[data-theme="dark"] .stats-card .stats-value {
    color: #f1f5f9;
}
[data-theme="dark"] .premium-card {
    background: #1A1A3E;
    border-color: rgba(255,255,255,0.06);
}
[data-theme="dark"] .premium-table thead th {
    background: rgba(255,255,255,0.03);
    color: #7F77DD;
}
[data-theme="dark"] .premium-table tbody td {
    border-color: rgba(255,255,255,0.04);
    color: #e2e0f0;
}
[data-theme="dark"] .product-name {
    color: #e2e0f0;
}
[data-theme="dark"] .date-range-wrapper {
    background: rgba(255,255,255,0.04);
    border-color: rgba(255,255,255,0.08);
}
[data-theme="dark"] .date-range-wrapper .date-input {
    color: #e2e0f0;
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
    const salesData = @json($salesData ?? []);
    const labels = salesData.map(item => item.date);
    const revenueData = salesData.map(item => item.total_revenue || 0);

    const ctx = document.getElementById('salesChart').getContext('2d');
    
    const gradient = ctx.createLinearGradient(0, 0, 0, 280);
    gradient.addColorStop(0, 'rgba(139, 92, 246, 0.25)');
    gradient.addColorStop(1, 'rgba(139, 92, 246, 0.02)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels.length > 0 ? labels : ['No Data'],
            datasets: [{
                label: 'Revenue ($)',
                data: revenueData.length > 0 ? revenueData : [0],
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
                        font: { size: 10 },
                        maxTicksLimit: 10
                    }
                }
            }
        }
    });

    // ============================================================
    // DISTRIBUTION CHART (Doughnut)
    // ============================================================
    const distributionCtx = document.getElementById('distributionChart').getContext('2d');
    
    // Sample data - you can replace with real data
    const distributionData = {
        labels: ['Products', 'Shipping', 'Tax', 'Discount'],
        datasets: [{
            data: [75, 12, 8, 5],
            backgroundColor: ['#8B5CF6', '#10B981', '#F59E0B', '#EF4444'],
            borderWidth: 0,
            hoverOffset: 8
        }]
    };

    new Chart(distributionCtx, {
        type: 'doughnut',
        data: distributionData,
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
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = total > 0 ? ((context.raw / total) * 100).toFixed(1) : 0;
                            return context.label + ': ' + context.raw + '% (' + percentage + '%)';
                        }
                    }
                }
            },
            cutout: '65%'
        }
    });

    console.log('%c📊 Sales Report Loaded', 'color: #8B5CF6; font-size: 13px; font-weight: bold;');
});
</script>
@endpush