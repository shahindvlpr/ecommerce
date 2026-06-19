{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.admin')

@section('title', 'Dashboard - EktaMart Admin')

@section('content')
<div class="container-fluid px-4 py-3">

<style>
:root {
    --card-radius: 1rem;
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* ============================================================
   ANIMATIONS
============================================================ */
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
@keyframes slideInRight {
    from { opacity: 0; transform: translateX(20px); }
    to { opacity: 1; transform: translateX(0); }
}
@keyframes shimmer {
    0% { background-position: -1000px 0; }
    100% { background-position: 1000px 0; }
}
.animate-fade-up { animation: fadeInUp 0.5s ease-out forwards; }
.animate-slide-right { animation: slideInRight 0.4s ease-out forwards; }

/* ============================================================
   STATS CARDS - COMPACT & MODERN
============================================================ */
.stats-card {
    border: none;
    border-radius: var(--card-radius);
    overflow: hidden;
    transition: var(--transition);
    position: relative;
    cursor: pointer;
    height: 100%;
    min-height: 100px;
}
.stats-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 30px rgba(0,0,0,0.12);
}
.stats-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
    transition: left 0.5s ease;
}
.stats-card:hover::before { left: 100%; }

.stats-card .card-inner {
    padding: 1rem 1.25rem;
    position: relative;
    z-index: 1;
    display: flex;
    align-items: center;
    gap: 0.8rem;
}

.stats-card .stats-icon {
    width: 44px;
    height: 44px;
    border-radius: 0.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    flex-shrink: 0;
    background: rgba(255,255,255,0.2);
    color: white;
}

.stats-card .stats-content {
    flex: 1;
    min-width: 0;
}

.stats-card .stats-content .stats-label {
    font-size: 0.7rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    opacity: 0.75;
    font-weight: 600;
    margin-bottom: 0.1rem;
}

.stats-card .stats-content .stats-value {
    font-size: 1.5rem;
    font-weight: 700;
    line-height: 1.2;
    margin-bottom: 0.05rem;
}

.stats-card .stats-content .stats-change {
    font-size: 0.65rem;
    display: inline-flex;
    align-items: center;
    gap: 0.2rem;
    opacity: 0.85;
    font-weight: 500;
}

/* Stats Card Colors */
.stats-card-purple { background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); color: white; }
.stats-card-green { background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; }
.stats-card-orange { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; }
.stats-card-red { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; }
.stats-card-blue { background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; }
.stats-card-teal { background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%); color: white; }
.stats-card-pink { background: linear-gradient(135deg, #ec4899 0%, #db2777 100%); color: white; }

/* ============================================================
   WELCOME CARD
============================================================ */
.welcome-card {
    background: linear-gradient(135deg, #8b5cf6 0%, #6366f1 50%, #4f46e5 100%);
    border: none;
    border-radius: var(--card-radius);
    color: white;
    overflow: hidden;
    position: relative;
    padding: 1.25rem 1.5rem;
}
.welcome-card::after {
    content: '';
    position: absolute;
    top: -50%;
    right: -30%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
    pointer-events: none;
}
.welcome-card .welcome-text h4 {
    font-weight: 700;
    margin-bottom: 0.1rem;
    font-size: 1.1rem;
}
.welcome-card .welcome-text p {
    opacity: 0.8;
    font-size: 0.85rem;
    margin-bottom: 0;
}
.welcome-card .welcome-time {
    text-align: right;
    font-size: 0.75rem;
    opacity: 0.8;
}
.welcome-card .welcome-time i { margin-right: 0.3rem; }

/* ============================================================
   CHART CARDS
============================================================ */
.chart-card {
    border: none;
    border-radius: var(--card-radius);
    background: white;
    transition: var(--transition);
    height: 100%;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
}
.chart-card:hover {
    box-shadow: 0 8px 25px rgba(0,0,0,0.08);
    transform: translateY(-2px);
}
.chart-card .card-header-custom {
    padding: 0.8rem 1.2rem;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 0.5rem;
}
.chart-card .card-header-custom h5 {
    font-weight: 600;
    font-size: 0.85rem;
    color: #1e293b;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.4rem;
}
.chart-card .card-header-custom h5 i { color: #8b5cf6; }
.chart-card .card-body-custom { padding: 1rem 1.2rem; }

/* ============================================================
   RECENT ORDERS TABLE
============================================================ */
.recent-table { border-radius: var(--card-radius); overflow: hidden; }
.recent-table thead { background: #f8fafc; }
.recent-table thead th {
    font-weight: 600;
    font-size: 0.7rem;
    text-transform: uppercase;
    letter-spacing: 0.3px;
    color: #64748b;
    border: none;
    padding: 0.6rem 0.8rem;
}
.recent-table tbody td {
    padding: 0.5rem 0.8rem;
    vertical-align: middle;
    font-size: 0.8rem;
    border-bottom: 1px solid #f1f5f9;
}
.recent-table tbody tr { transition: var(--transition); }
.recent-table tbody tr:hover { background: #f8fafc; }
.recent-table tbody tr:last-child td { border-bottom: none; }

/* ============================================================
   BADGES
============================================================ */
.badge-status {
    padding: 0.2rem 0.6rem;
    border-radius: 2rem;
    font-size: 0.65rem;
    font-weight: 600;
}
.badge-paid { background: #dcfce7; color: #166534; }
.badge-pending { background: #fed7aa; color: #9a3412; }
.badge-delivered { background: #dbeafe; color: #1e40af; }
.badge-cancelled { background: #fee2e2; color: #991b1b; }
.badge-shipped { background: #e0e7ff; color: #3730a3; }
.badge-processing { background: #fef3c7; color: #92400e; }

/* ============================================================
   QUICK ACTIONS
============================================================ */
.quick-action {
    display: flex;
    align-items: center;
    gap: 0.8rem;
    padding: 0.7rem 1rem;
    border-radius: 0.75rem;
    background: #f8fafc;
    border: 1px solid #f1f5f9;
    text-decoration: none;
    transition: var(--transition);
    color: #1e293b;
}
.quick-action:hover {
    transform: translateX(4px);
    color: white;
    border-color: transparent;
}
.quick-action .qa-icon {
    width: 36px;
    height: 36px;
    border-radius: 0.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.9rem;
    flex-shrink: 0;
}
.quick-action .qa-content strong { font-size: 0.8rem; display: block; }
.quick-action .qa-content small { font-size: 0.65rem; opacity: 0.7; }

.quick-action:hover .qa-content small { color: rgba(255,255,255,0.8) !important; }

.qa-purple:hover { background: linear-gradient(135deg, #8b5cf6, #7c3aed); }
.qa-purple .qa-icon { background: rgba(139,92,246,0.15); color: #8b5cf6; }
.qa-purple:hover .qa-icon { background: rgba(255,255,255,0.2); color: white; }

.qa-green:hover { background: linear-gradient(135deg, #10b981, #059669); }
.qa-green .qa-icon { background: rgba(16,185,129,0.15); color: #10b981; }
.qa-green:hover .qa-icon { background: rgba(255,255,255,0.2); color: white; }

.qa-orange:hover { background: linear-gradient(135deg, #f59e0b, #d97706); }
.qa-orange .qa-icon { background: rgba(245,158,11,0.15); color: #f59e0b; }
.qa-orange:hover .qa-icon { background: rgba(255,255,255,0.2); color: white; }

.qa-blue:hover { background: linear-gradient(135deg, #3b82f6, #2563eb); }
.qa-blue .qa-icon { background: rgba(59,130,246,0.15); color: #3b82f6; }
.qa-blue:hover .qa-icon { background: rgba(255,255,255,0.2); color: white; }

/* ============================================================
   PERFORMANCE SUMMARY
============================================================ */
.perf-item {
    padding: 0.7rem 1rem;
    background: #f8fafc;
    border-radius: 0.75rem;
    text-align: center;
    border: 1px solid #f1f5f9;
    transition: var(--transition);
}
.perf-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.06);
}
.perf-item .perf-icon { font-size: 1.2rem; margin-bottom: 0.2rem; }
.perf-item .perf-label { font-size: 0.65rem; color: #64748b; font-weight: 500; text-transform: uppercase; letter-spacing: 0.3px; }
.perf-item .perf-value { font-size: 1.1rem; font-weight: 700; color: #1e293b; }

/* ============================================================
   RESPONSIVE
============================================================ */
@media (max-width: 768px) {
    .stats-card .card-inner { padding: 0.8rem 1rem; }
    .stats-card .stats-value { font-size: 1.2rem; }
    .stats-card .stats-icon { width: 38px; height: 38px; font-size: 0.9rem; }
    .welcome-card { padding: 1rem; }
    .welcome-card .welcome-text h4 { font-size: 0.95rem; }
    .welcome-card .welcome-time { text-align: left; margin-top: 0.5rem; }
    .chart-card .card-body-custom { padding: 0.8rem; }
    .quick-action { padding: 0.5rem 0.8rem; }
    .perf-item { padding: 0.5rem 0.8rem; }
    .perf-item .perf-value { font-size: 0.95rem; }
}

@media (max-width: 576px) {
    .stats-card .card-inner { flex-direction: column; text-align: center; }
    .stats-card .stats-icon { width: 32px; height: 32px; font-size: 0.8rem; }
    .recent-table thead th, .recent-table tbody td { padding: 0.4rem 0.5rem; font-size: 0.7rem; }
    .badge-status { font-size: 0.55rem; padding: 0.1rem 0.4rem; }
}
</style>

{{-- ============================================================
     WELCOME SECTION
============================================================ --}}
<div class="welcome-card animate-fade-up mb-3">
    <div class="row align-items-center g-2">
        <div class="col-md-8 welcome-text">
            <h4>👋 Welcome back, <span id="adminName">{{ Auth::user()->name ?? 'Admin' }}</span>!</h4>
            <p>Here's what's happening with your store today.</p>
        </div>
        <div class="col-md-4 welcome-time">
            <div><i class="fas fa-calendar-alt"></i><span id="currentDate"></span></div>
            <div><i class="fas fa-clock"></i><span id="currentTime"></span></div>
        </div>
    </div>
</div>

{{-- ============================================================
     STATS CARDS - COMPACT
============================================================ --}}
<div class="row g-3 mb-3">
    <div class="col-6 col-md-4 col-xl-2 animate-slide-right" style="animation-delay:0.05s">
        <div class="stats-card stats-card-purple">
            <div class="card-inner">
                <div class="stats-icon"><i class="fas fa-layer-group"></i></div>
                <div class="stats-content">
                    <div class="stats-label">Categories</div>
                    <div class="stats-value" id="totalCategories">{{ \App\Models\Category::count() }}</div>
                    <div class="stats-change"><i class="fas fa-arrow-up"></i> 12%</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-md-4 col-xl-2 animate-slide-right" style="animation-delay:0.10s">
        <div class="stats-card stats-card-green">
            <div class="card-inner">
                <div class="stats-icon"><i class="fas fa-boxes"></i></div>
                <div class="stats-content">
                    <div class="stats-label">Products</div>
                    <div class="stats-value" id="totalProducts">{{ \App\Models\Product::count() }}</div>
                    <div class="stats-change"><i class="fas fa-arrow-up"></i> 8%</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-md-4 col-xl-2 animate-slide-right" style="animation-delay:0.15s">
        <div class="stats-card stats-card-orange">
            <div class="card-inner">
                <div class="stats-icon"><i class="fas fa-shopping-cart"></i></div>
                <div class="stats-content">
                    <div class="stats-label">Orders</div>
                    <div class="stats-value" id="totalOrders">{{ \App\Models\Order::count() }}</div>
                    <div class="stats-change"><i class="fas fa-arrow-up"></i> 23%</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-md-4 col-xl-2 animate-slide-right" style="animation-delay:0.20s">
        <div class="stats-card stats-card-red">
            <div class="card-inner">
                <div class="stats-icon"><i class="fas fa-users"></i></div>
                <div class="stats-content">
                    <div class="stats-label">Users</div>
                    <div class="stats-value" id="totalUsers">{{ \App\Models\User::count() }}</div>
                    <div class="stats-change"><i class="fas fa-arrow-up"></i> 5%</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-md-4 col-xl-2 animate-slide-right" style="animation-delay:0.25s">
        <div class="stats-card stats-card-blue">
            <div class="card-inner">
                <div class="stats-icon"><i class="fas fa-dollar-sign"></i></div>
                <div class="stats-content">
                    <div class="stats-label">Revenue</div>
                    <div class="stats-value">${{ number_format(\App\Models\Order::sum('total') ?? 0, 0) }}</div>
                    <div class="stats-change"><i class="fas fa-arrow-up"></i> 18%</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-md-4 col-xl-2 animate-slide-right" style="animation-delay:0.30s">
        <div class="stats-card stats-card-pink">
            <div class="card-inner">
                <div class="stats-icon"><i class="fas fa-star"></i></div>
                <div class="stats-content">
                    <div class="stats-label">Reviews</div>
                    <div class="stats-value">{{ \App\Models\Review::count() }}</div>
                    <div class="stats-change"><i class="fas fa-arrow-up"></i> 15%</div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ============================================================
     CHARTS SECTION
============================================================ --}}
<div class="row g-3 mb-3">
    <div class="col-lg-8 animate-fade-up">
        <div class="chart-card">
            <div class="card-header-custom">
                <h5><i class="fas fa-chart-line"></i> Sales Overview</h5>
                <span class="badge bg-success bg-opacity-10 text-success">+12.5%</span>
            </div>
            <div class="card-body-custom">
                <canvas id="salesChart" height="220"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-4 animate-fade-up">
        <div class="chart-card">
            <div class="card-header-custom">
                <h5><i class="fas fa-chart-pie"></i> Category Distribution</h5>
            </div>
            <div class="card-body-custom">
                <canvas id="categoryChart" height="220"></canvas>
            </div>
        </div>
    </div>
</div>

{{-- ============================================================
     RECENT ORDERS & QUICK ACTIONS
============================================================ --}}
<div class="row g-3">
    <div class="col-lg-8 animate-fade-up">
        <div class="chart-card">
            <div class="card-header-custom">
                <h5><i class="fas fa-clock"></i> Recent Orders</h5>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                    View All <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="card-body-custom p-0">
                <div class="table-responsive">
                    <table class="table recent-table mb-0">
                        <thead>
                            <tr>
                                <th>Order</th>
                                <th>Customer</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th class="text-end">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $recentOrders = \App\Models\Order::with('user')->latest()->take(5)->get(); @endphp
                            @forelse($recentOrders as $order)
                            <tr>
                                <td><span class="fw-semibold">#{{ $order->order_number ?? $order->id }}</span></td>
                                <td>{{ $order->user->name ?? 'Guest' }}</td>
                                <td class="fw-semibold text-success">${{ number_format($order->total ?? 0, 2) }}</td>
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
                                    <span class="badge-status {{ $statusClass }}">{{ ucfirst($order->status ?? 'Pending') }}</span>
                                </td>
                                <td class="text-end text-muted"><small>{{ $order->created_at?->diffForHumans() ?? 'N/A' }}</small></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    <i class="fas fa-inbox fa-2x d-block mb-2"></i>No orders found
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 animate-fade-up">
        <div class="chart-card">
            <div class="card-header-custom">
                <h5><i class="fas fa-bolt"></i> Quick Actions</h5>
            </div>
            <div class="card-body-custom d-grid gap-2">
                <a href="{{ route('admin.products.create') }}" class="quick-action qa-purple">
                    <div class="qa-icon"><i class="fas fa-plus"></i></div>
                    <div class="qa-content">
                        <strong>Add Product</strong>
                        <small>Add new product to store</small>
                    </div>
                </a>
                <a href="{{ route('admin.categories.create') }}" class="quick-action qa-green">
                    <div class="qa-icon"><i class="fas fa-tag"></i></div>
                    <div class="qa-content">
                        <strong>New Category</strong>
                        <small>Organize products</small>
                    </div>
                </a>
                <a href="{{ route('admin.orders.index') }}" class="quick-action qa-orange">
                    <div class="qa-icon"><i class="fas fa-truck"></i></div>
                    <div class="qa-content">
                        <strong>Process Orders</strong>
                        <small>Manage pending orders</small>
                    </div>
                </a>
                <a href="{{ route('admin.users.index') }}" class="quick-action qa-blue">
                    <div class="qa-icon"><i class="fas fa-users"></i></div>
                    <div class="qa-content">
                        <strong>Manage Users</strong>
                        <small>View all customers</small>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

{{-- ============================================================
     PERFORMANCE SUMMARY
============================================================ --}}
<div class="row g-3 mt-1 animate-fade-up">
    <div class="col-12">
        <div class="chart-card">
            <div class="card-header-custom">
                <h5><i class="fas fa-chart-bar"></i> Store Performance</h5>
            </div>
            <div class="card-body-custom">
                <div class="row g-2">
                    <div class="col-3 col-md-3">
                        <div class="perf-item">
                            <div class="perf-icon text-success"><i class="fas fa-dollar-sign"></i></div>
                            <div class="perf-value">${{ number_format(\App\Models\Order::sum('total') ?? 0, 0) }}</div>
                            <div class="perf-label">Revenue</div>
                        </div>
                    </div>
                    <div class="col-3 col-md-3">
                        <div class="perf-item">
                            <div class="perf-icon text-warning"><i class="fas fa-clock"></i></div>
                            <div class="perf-value">{{ \App\Models\Order::where('status','pending')->count() }}</div>
                            <div class="perf-label">Pending</div>
                        </div>
                    </div>
                    <div class="col-3 col-md-3">
                        <div class="perf-item">
                            <div class="perf-icon text-info"><i class="fas fa-star"></i></div>
                            <div class="perf-value">{{ \App\Models\Review::where('is_approved', 0)->count() }}</div>
                            <div class="perf-label">Reviews</div>
                        </div>
                    </div>
                    <div class="col-3 col-md-3">
                        <div class="perf-item">
                            <div class="perf-icon text-primary"><i class="fas fa-box"></i></div>
                            <div class="perf-value">{{ \App\Models\Product::count() }}</div>
                            <div class="perf-label">Products</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>

{{-- ============================================================
     SCRIPTS
============================================================ --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// ============================================================
// 1. DATE & TIME
// ============================================================
function updateDateTime() {
    const now = new Date();
    document.getElementById('currentDate').textContent =
        now.toLocaleDateString('en-US', { weekday:'short', month:'short', day:'numeric', year:'numeric' });
    document.getElementById('currentTime').textContent =
        now.toLocaleTimeString('en-US', { hour:'2-digit', minute:'2-digit', second:'2-digit' });
}
updateDateTime();
setInterval(updateDateTime, 1000);

// ============================================================
// 2. SALES CHART
// ============================================================
new Chart(document.getElementById('salesChart').getContext('2d'), {
    type: 'line',
    data: {
        labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
        datasets: [{
            label: 'Revenue ($)',
            data: [12500,15200,16800,14200,18900,21400,23500,22800,25600,28900,31200,34800],
            borderColor: '#8b5cf6',
            backgroundColor: 'rgba(139,92,246,0.08)',
            borderWidth: 2.5,
            fill: true,
            tension: 0.4,
            pointBackgroundColor: '#8b5cf6',
            pointBorderColor: '#fff',
            pointBorderWidth: 1.5,
            pointRadius: 4,
            pointHoverRadius: 6
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: { display: false },
            tooltip: {
                callbacks: {
                    label: ctx => '$' + ctx.raw.toLocaleString()
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: { callback: v => '$' + v.toLocaleString(), font: { size: 10 } },
                grid: { color: 'rgba(0,0,0,0.04)' }
            },
            x: {
                grid: { display: false },
                ticks: { font: { size: 9 } }
            }
        }
    }
});

// ============================================================
// 3. CATEGORY CHART
// ============================================================
const categoryLabels = {!! json_encode(\App\Models\Category::limit(5)->pluck('name')) !!};
const categoryData = {!! json_encode(\App\Models\Category::withCount('products')->limit(5)->get()->pluck('products_count')) !!};

new Chart(document.getElementById('categoryChart').getContext('2d'), {
    type: 'doughnut',
    data: {
        labels: categoryLabels,
        datasets: [{
            data: categoryData,
            backgroundColor: ['#8b5cf6','#10b981','#f59e0b','#ef4444','#3b82f6'],
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
                labels: { boxWidth: 12, font: { size: 10 }, padding: 8 }
            },
            tooltip: {
                callbacks: {
                    label: ctx => ctx.label + ': ' + ctx.raw + ' products'
                }
            }
        },
        cutout: '65%'
    }
});

// ============================================================
// 4. REAL-TIME STATS UPDATE
// ============================================================
setInterval(function() {
    fetch('{{ route("admin.dashboard.stats") }}')
        .then(r => r.json())
        .then(data => {
            document.getElementById('totalCategories').textContent = data.categories || 0;
            document.getElementById('totalProducts').textContent = data.products || 0;
            document.getElementById('totalOrders').textContent = data.orders || 0;
            document.getElementById('totalUsers').textContent = data.users || 0;
        })
        .catch(() => {});
}, 30000);

// ============================================================
// 5. CONSOLE GREETING
// ============================================================
console.log('%c📊 EktaMart Admin Dashboard v2.0', 'color: #8b5cf6; font-size: 14px; font-weight: bold;');
console.log('%c🚀 Real-time stats • Modern UI • Responsive', 'color: #6366f1; font-size: 12px;');
</script>
@endsection