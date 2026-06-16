{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.admin')

@section('title', 'Dashboard - EktaMart Admin')

@section('content')
<div class="container-fluid px-4 py-4">
    
    <style>
        /* Custom Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        @keyframes shimmer {
            0% { background-position: -1000px 0; }
            100% { background-position: 1000px 0; }
        }
        
        .animate-fade-up {
            animation: fadeInUp 0.6s ease-out forwards;
        }
        
        .animate-slide-right {
            animation: slideInRight 0.5s ease-out forwards;
        }
        
        /* Stats Cards */
        .stats-card {
            border: none;
            border-radius: 1.25rem;
            overflow: hidden;
            transition: all 0.3s ease;
            position: relative;
            cursor: pointer;
        }
        
        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }
        
        .stats-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s ease;
        }
        
        .stats-card:hover::before {
            left: 100%;
        }
        
        .card-stats {
            padding: 1.5rem;
            position: relative;
            z-index: 1;
        }
        
        .stats-icon {
            position: absolute;
            right: 1.5rem;
            bottom: 1rem;
            opacity: 0.2;
            font-size: 4rem;
        }
        
        .stats-card h5 {
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .stats-card h2 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 0;
        }
        
        .stats-growth {
            font-size: 0.75rem;
            margin-top: 0.5rem;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }
        
        /* Chart Cards */
        .chart-card {
            border: none;
            border-radius: 1.25rem;
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            transition: all 0.3s ease;
            height: 100%;
        }
        
        .chart-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }
        
        .chart-header {
            background: transparent;
            border-bottom: 2px solid #e2e8f0;
            padding: 1rem 1.5rem;
        }
        
        .chart-header h5 {
            font-weight: 700;
            color: #1e293b;
            margin: 0;
        }
        
        /* Welcome Section */
        .welcome-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 1.25rem;
            color: white;
            overflow: hidden;
            position: relative;
        }
        
        .welcome-card::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            pointer-events: none;
        }
        
        .welcome-content {
            padding: 1.5rem;
            position: relative;
            z-index: 1;
        }
        
        .welcome-icon {
            font-size: 3rem;
            margin-bottom: 0.5rem;
        }
        
        .date-time {
            font-size: 0.85rem;
            opacity: 0.9;
        }
        
        /* Recent Activity Table */
        .recent-table {
            border-radius: 1rem;
            overflow: hidden;
        }
        
        .recent-table thead {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
        }
        
        .recent-table thead th {
            color: white;
            font-weight: 600;
            font-size: 0.85rem;
            border: none;
            padding: 1rem;
        }
        
        .recent-table tbody tr {
            transition: all 0.3s ease;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .recent-table tbody tr:hover {
            background: #f8fafc;
            transform: scale(1.01);
        }
        
        .recent-table tbody td {
            padding: 1rem;
            vertical-align: middle;
        }
        
        /* Badge Styles */
        .badge-status {
            padding: 0.35rem 0.75rem;
            border-radius: 2rem;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .badge-paid {
            background: #dcfce7;
            color: #166534;
        }
        
        .badge-pending {
            background: #fed7aa;
            color: #9a3412;
        }
        
        .badge-delivered {
            background: #dbeafe;
            color: #1e40af;
        }
        
        /* Progress Bar */
        .progress-custom {
            height: 8px;
            border-radius: 1rem;
            background: #e2e8f0;
        }
        
        .progress-bar-custom {
            background: linear-gradient(90deg, #8b5cf6, #6366f1);
            border-radius: 1rem;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .stats-card h2 {
                font-size: 1.75rem;
            }
            
            .stats-icon {
                font-size: 3rem;
            }
            
            .welcome-content {
                padding: 1rem;
            }
            
            .welcome-icon {
                font-size: 2rem;
            }
        }
        
        /* Loading Skeleton */
        .skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
            border-radius: 0.5rem;
        }
    </style>

    <!-- Welcome Section -->
    <div class="welcome-card mb-4 animate-fade-up">
        <div class="welcome-content d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <div class="welcome-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3 class="mb-1 fw-bold">Welcome back, Admin!</h3>
                <p class="mb-0 opacity-75">Here's what's happening with your store today.</p>
            </div>
            <div class="text-end">
                <div class="date-time">
                    <i class="fas fa-calendar-alt me-1"></i>
                    <span id="currentDate"></span>
                </div>
                <div class="date-time mt-1">
                    <i class="fas fa-clock me-1"></i>
                    <span id="currentTime"></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards Row -->
    <div class="row g-4 mb-4">
        <div class="col-md-6 col-xl-3 animate-slide-right" style="animation-delay: 0.1s">
            <div class="stats-card bg-gradient-primary">
                <div class="card-stats">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h5 class="text-white opacity-75">TOTAL CATEGORIES</h5>
                            <h2 class="text-white" id="totalCategories">{{ \App\Models\Category::count() }}</h2>
                            <span class="stats-growth text-white">
                                <i class="fas fa-arrow-up"></i> +12% this month
                            </span>
                        </div>
                        <div class="stats-icon">
                            <i class="fas fa-layer-group text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3 animate-slide-right" style="animation-delay: 0.2s">
            <div class="stats-card bg-gradient-success">
                <div class="card-stats">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h5 class="text-white opacity-75">TOTAL PRODUCTS</h5>
                            <h2 class="text-white" id="totalProducts">{{ \App\Models\Product::count() }}</h2>
                            <span class="stats-growth text-white">
                                <i class="fas fa-arrow-up"></i> +8% this month
                            </span>
                        </div>
                        <div class="stats-icon">
                            <i class="fas fa-boxes text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3 animate-slide-right" style="animation-delay: 0.3s">
            <div class="stats-card bg-gradient-warning">
                <div class="card-stats">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h5 class="text-white opacity-75">TOTAL ORDERS</h5>
                            <h2 class="text-white" id="totalOrders">{{ \App\Models\Order::count() }}</h2>
                            <span class="stats-growth text-white">
                                <i class="fas fa-arrow-up"></i> +23% this month
                            </span>
                        </div>
                        <div class="stats-icon">
                            <i class="fas fa-shopping-cart text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3 animate-slide-right" style="animation-delay: 0.4s">
            <div class="stats-card bg-gradient-danger">
                <div class="card-stats">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h5 class="text-white opacity-75">TOTAL USERS</h5>
                            <h2 class="text-white" id="totalUsers">{{ \App\Models\User::count() }}</h2>
                            <span class="stats-growth text-white">
                                <i class="fas fa-arrow-up"></i> +5% this month
                            </span>
                        </div>
                        <div class="stats-icon">
                            <i class="fas fa-users text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-4 mb-4">
        <div class="col-lg-8 animate-fade-up">
            <div class="card chart-card">
                <div class="chart-header">
                    <h5>
                        <i class="fas fa-chart-line text-primary me-2"></i>
                        Sales Overview
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="salesChart" height="300"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-4 animate-fade-up">
            <div class="card chart-card">
                <div class="chart-header">
                    <h5>
                        <i class="fas fa-chart-pie text-primary me-2"></i>
                        Category Distribution
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="categoryChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders & Quick Actions -->
    <div class="row g-4">
        <div class="col-lg-8 animate-fade-up">
            <div class="card chart-card">
                <div class="chart-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h5>
                        <i class="fas fa-clock text-primary me-2"></i>
                        Recent Orders
                    </h5>
                    <a href="{{ route('orders.index') }}" class="btn btn-sm btn-outline-primary rounded-pill">
                        View All Orders <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table recent-table mb-0">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody id="recentOrdersTable">
                                @php
                                    $recentOrders = \App\Models\Order::with('user')->latest()->take(5)->get();
                                @endphp
                                @forelse($recentOrders as $order)
                                <tr>
                                    <td>
                                        <code>#{{ $order->id }}</code>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="rounded-circle bg-primary bg-opacity-10 p-2">
                                                <i class="fas fa-user text-primary fa-sm"></i>
                                            </div>
                                            {{ $order->user ? $order->user->name : 'Guest User' }}
                                        </div>
                                    </td>
                                    <td class="fw-bold text-success">${{ number_format($order->total_amount ?? 0, 2) }}</td>
                                    <td>
                                        @php
                                            $statusClass = match($order->status ?? 'pending') {
                                                'paid', 'delivered' => 'badge-paid',
                                                'pending' => 'badge-pending',
                                                default => 'badge-delivered'
                                            };
                                            $statusText = ucfirst($order->status ?? 'pending');
                                        @endphp
                                        <span class="badge-status {{ $statusClass }}">
                                            {{ $statusText }}
                                        </span>
                                    </td>
                                    <td>
                                        <small>{{ $order->created_at ? $order->created_at->diffForHumans() : 'N/A' }}</small>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                        No orders found
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
            <div class="card chart-card">
                <div class="chart-header">
                    <h5>
                        <i class="fas fa-bolt text-primary me-2"></i>
                        Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-3">
                        <a href="{{ route('products.create') }}" class="btn btn-gradient-primary text-start d-flex align-items-center gap-3 py-3">
                            <i class="fas fa-plus-circle fa-2x"></i>
                            <div>
                                <strong>Add New Product</strong><br>
                                <small class="text-muted">Add products to your store</small>
                            </div>
                        </a>
                        <a href="{{ route('categories.create') }}" class="btn btn-gradient-success text-start d-flex align-items-center gap-3 py-3">
                            <i class="fas fa-tag fa-2x"></i>
                            <div>
                                <strong>Create Category</strong><br>
                                <small class="text-muted">Organize products with categories</small>
                            </div>
                        </a>
                        <a href="{{ route('orders.index') }}" class="btn btn-gradient-warning text-start d-flex align-items-center gap-3 py-3">
                            <i class="fas fa-truck fa-2x"></i>
                            <div>
                                <strong>Manage Orders</strong><br>
                                <small class="text-muted">View and process orders</small>
                            </div>
                        </a>
                        <a href="{{ route('users.index') }}" class="btn btn-gradient-info text-start d-flex align-items-center gap-3 py-3">
                            <i class="fas fa-users fa-2x"></i>
                            <div>
                                <strong>Manage Users</strong><br>
                                <small class="text-muted">View all registered customers</small>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Store Performance Summary -->
    <div class="row mt-4">
        <div class="col-12 animate-fade-up">
            <div class="card chart-card">
                <div class="chart-header">
                    <h5>
                        <i class="fas fa-chart-simple text-primary me-2"></i>
                        Store Performance Summary
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3 mb-3 mb-md-0">
                            <div class="p-3 rounded-3 bg-light">
                                <i class="fas fa-dollar-sign fa-2x text-success mb-2"></i>
                                <h6 class="text-muted mb-1">Total Revenue</h6>
                                <h4 class="fw-bold mb-0">${{ number_format(\App\Models\Order::sum('total_amount') ?? 0, 2) }}</h4>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3 mb-md-0">
                            <div class="p-3 rounded-3 bg-light">
                                <i class="fas fa-chart-line fa-2x text-primary mb-2"></i>
                                <h6 class="text-muted mb-1">Conversion Rate</h6>
                                <h4 class="fw-bold mb-0">24.5%</h4>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3 mb-md-0">
                            <div class="p-3 rounded-3 bg-light">
                                <i class="fas fa-star fa-2x text-warning mb-2"></i>
                                <h6 class="text-muted mb-1">Avg. Rating</h6>
                                <h4 class="fw-bold mb-0">4.8 <span class="fs-6 text-muted">/ 5</span></h4>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-3 rounded-3 bg-light">
                                <i class="fas fa-users fa-2x text-info mb-2"></i>
                                <h6 class="text-muted mb-1">Active Users Today</h6>
                                <h4 class="fw-bold mb-0">{{ rand(50, 200) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Real-time Date and Time
    function updateDateTime() {
        const now = new Date();
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        document.getElementById('currentDate').innerHTML = now.toLocaleDateString('en-US', options);
        document.getElementById('currentTime').innerHTML = now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
    }
    updateDateTime();
    setInterval(updateDateTime, 1000);

    // Sales Chart
    const ctx = document.getElementById('salesChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Sales Revenue ($)',
                data: [12500, 15200, 16800, 14200, 18900, 21400, 23500, 22800, 25600, 28900, 31200, 34800],
                borderColor: '#8b5cf6',
                backgroundColor: 'rgba(139, 92, 246, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#8b5cf6',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Sales: $' + context.raw.toLocaleString();
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
                        }
                    }
                }
            }
        }
    });

    // Category Distribution Chart
    const categoryCtx = document.getElementById('categoryChart').getContext('2d');
    new Chart(categoryCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode(\App\Models\Category::where('status', 1)->limit(5)->pluck('name')) !!},
            datasets: [{
                data: {!! json_encode(\App\Models\Category::where('status', 1)->limit(5)->withCount('products')->get()->pluck('products_count')) !!},
                backgroundColor: ['#8b5cf6', '#10b981', '#f59e0b', '#ef4444', '#06b6d4'],
                borderWidth: 0,
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.raw + ' products';
                        }
                    }
                }
            }
        }
    });

    // Animate stats cards on load
    const statsCards = document.querySelectorAll('.stats-card');
    statsCards.forEach((card, index) => {
        setTimeout(() => {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, 100 * index);
    });

    // Console greeting
    console.log('%c✨ EktaMart Admin Dashboard | Welcome Back! ✨', 'color: #8b5cf6; font-size: 16px; font-weight: bold;');
    console.log('%c⚡ Features: Real-time stats • Interactive charts • Recent orders • Quick actions', 'color: #6366f1; font-size: 12px;');
</script>

<style>
    /* Gradient Backgrounds for Stats Cards */
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .bg-gradient-success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }
    
    .bg-gradient-warning {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }
    
    .bg-gradient-danger {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    }
    
    /* Quick Action Buttons */
    .btn-gradient-primary {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        color: #1e293b;
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
    }
    
    .btn-gradient-primary:hover {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        transform: translateX(5px);
        border-color: transparent;
    }
    
    .btn-gradient-success:hover {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
    }
    
    .btn-gradient-warning:hover {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
    }
    
    .btn-gradient-info:hover {
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
        color: white;
    }
    
    .btn-gradient-primary:hover i,
    .btn-gradient-primary:hover small {
        color: white;
    }
    
    /* Animation Delays */
    .animate-slide-right {
        opacity: 0;
        transform: translateX(30px);
        animation-fill-mode: forwards;
    }
    
    .animate-fade-up {
        opacity: 0;
        transform: translateY(30px);
        animation-fill-mode: forwards;
    }
    
    /* Hover Effects */
    .stats-card {
        cursor: pointer;
    }
    
    /* Scrollbar */
    .table-responsive::-webkit-scrollbar {
        height: 8px;
    }
    
    .table-responsive::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 10px;
    }
    
    .table-responsive::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, #8b5cf6, #6366f1);
        border-radius: 10px;
    }
</style>

@push('scripts')
<script>
    // Auto-refresh data every 30 seconds (optional)
    setInterval(function() {
        fetch('/admin/dashboard/stats')
            .then(response => response.json())
            .then(data => {
                document.getElementById('totalCategories').innerText = data.categories;
                document.getElementById('totalProducts').innerText = data.products;
                document.getElementById('totalOrders').innerText = data.orders;
                document.getElementById('totalUsers').innerText = data.users;
            })
            .catch(err => console.log('Stats refresh failed:', err));
    }, 30000);
</script>
@endpush
@endsection