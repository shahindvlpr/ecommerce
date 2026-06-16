@extends('layouts.app')

@section('title', 'Dashboard - EktaMart')

@section('content')
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --shadow-sm: 0 2px 12px rgba(0, 0, 0, 0.06);
        --shadow-hover: 0 8px 30px rgba(0, 0, 0, 0.1);
        --radius: 1rem;
        --radius-sm: 0.75rem;
    }

    .dashboard-wrapper {
        background: #f5f6fa;
        min-height: 100vh;
        padding: 1.5rem 0;
    }

    /* Welcome Section - Compact */
    .welcome-section {
        background: var(--primary-gradient);
        border-radius: var(--radius);
        padding: 1.5rem 2rem;
        color: white;
        position: relative;
        overflow: hidden;
        margin-bottom: 1.5rem;
        box-shadow: 0 10px 40px rgba(102, 126, 234, 0.25);
    }
    .welcome-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
    }
    .welcome-section::after {
        content: '';
        position: absolute;
        bottom: -40%;
        left: -5%;
        width: 250px;
        height: 250px;
        background: rgba(255,255,255,0.03);
        border-radius: 50%;
    }
    .welcome-text h2 {
        font-weight: 700;
        font-size: 1.4rem;
        margin-bottom: 0.15rem;
        position: relative;
        z-index: 1;
    }
    .welcome-text p {
        opacity: 0.85;
        font-size: 0.85rem;
        margin-bottom: 0;
        position: relative;
        z-index: 1;
    }
    .welcome-stats {
        display: flex;
        gap: 1.2rem;
        flex-wrap: wrap;
        position: relative;
        z-index: 1;
    }
    .welcome-stat-item {
        text-align: center;
        background: rgba(255,255,255,0.1);
        backdrop-filter: blur(8px);
        padding: 0.4rem 1rem;
        border-radius: 0.75rem;
        border: 1px solid rgba(255,255,255,0.1);
        min-width: 70px;
        transition: all 0.3s ease;
    }
    .welcome-stat-item:hover {
        background: rgba(255,255,255,0.2);
        transform: translateY(-2px);
    }
    .welcome-stat-item .number {
        font-size: 1.2rem;
        font-weight: 700;
        display: block;
        line-height: 1.3;
    }
    .welcome-stat-item .label {
        font-size: 0.6rem;
        opacity: 0.8;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Sidebar - Compact */
    .profile-sidebar {
        background: white;
        border-radius: var(--radius);
        padding: 1.2rem;
        box-shadow: var(--shadow-sm);
        position: sticky;
        top: 1.5rem;
        transition: all 0.3s ease;
    }
    .profile-sidebar:hover {
        box-shadow: var(--shadow-hover);
    }
    .profile-avatar {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: var(--primary-gradient);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 0.6rem;
        font-size: 1.8rem;
        color: white;
        font-weight: 700;
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.25);
        transition: all 0.3s ease;
    }
    .profile-name {
        text-align: center;
        font-weight: 600;
        font-size: 0.95rem;
        margin-bottom: 0.1rem;
        color: #1a1a2e;
    }
    .profile-email {
        text-align: center;
        color: #6b7280;
        font-size: 0.7rem;
        margin-bottom: 0.6rem;
        word-break: break-all;
    }
    .profile-badge {
        display: inline-block;
        background: var(--primary-gradient);
        color: white;
        padding: 0.15rem 1rem;
        border-radius: 2rem;
        font-size: 0.6rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin: 0 auto 0.8rem;
        display: table;
    }
    .sidebar-nav {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .sidebar-nav li {
        margin-bottom: 0.15rem;
    }
    .sidebar-nav a {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        padding: 0.5rem 0.75rem;
        border-radius: 0.6rem;
        color: #4b5563;
        text-decoration: none;
        transition: all 0.3s ease;
        font-weight: 500;
        font-size: 0.8rem;
        position: relative;
    }
    .sidebar-nav a::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        width: 3px;
        height: 100%;
        background: var(--primary-gradient);
        transform: scaleY(0);
        transition: transform 0.3s ease;
        border-radius: 0 3px 3px 0;
    }
    .sidebar-nav a:hover::before,
    .sidebar-nav a.active::before {
        transform: scaleY(1);
    }
    .sidebar-nav a i {
        width: 18px;
        text-align: center;
        font-size: 0.85rem;
        transition: all 0.3s ease;
    }
    .sidebar-nav a:hover {
        background: #f3f4f6;
        color: #667eea;
        transform: translateX(3px);
    }
    .sidebar-nav a.active {
        background: var(--primary-gradient);
        color: white;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.25);
    }
    .sidebar-nav a.active::before {
        background: white;
    }
    .sidebar-nav a.logout {
        color: #ef4444;
    }
    .sidebar-nav a.logout:hover {
        background: #fef2f2;
        color: #dc2626;
    }
    .sidebar-nav .badge {
        font-size: 0.6rem;
        padding: 0.15rem 0.5rem;
        animation: badgePulse 2s ease-in-out infinite;
    }
    @keyframes badgePulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    /* Stats Cards - Compact */
    .stat-card {
        background: white;
        border-radius: var(--radius-sm);
        padding: 0.8rem 1rem;
        box-shadow: var(--shadow-sm);
        transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        border: 1px solid rgba(0,0,0,0.02);
        position: relative;
        cursor: pointer;
        height: 100%;
        display: flex;
        align-items: center;
        gap: 0.8rem;
    }
    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-hover);
    }
    .stat-card .icon-wrapper {
        width: 40px;
        height: 40px;
        border-radius: 0.6rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        flex-shrink: 0;
        transition: all 0.3s ease;
    }
    .stat-card:hover .icon-wrapper {
        transform: scale(1.05) rotate(-3deg);
    }
    .stat-card .stat-info {
        flex: 1;
        min-width: 0;
    }
    .stat-card .stat-value {
        font-size: 1.3rem;
        font-weight: 700;
        color: #111827;
        line-height: 1.2;
    }
    .stat-card .stat-label {
        color: #6b7280;
        font-size: 0.65rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    .stat-card .stat-change {
        font-size: 0.6rem;
        font-weight: 600;
        padding: 0.15rem 0.5rem;
        border-radius: 2rem;
        background: #dcfce7;
        color: #16a34a;
        white-space: nowrap;
        flex-shrink: 0;
    }
    .stat-card .stat-change.down {
        background: #fee2e2;
        color: #dc2626;
    }
    .stat-card .stat-icon-bg {
        position: absolute;
        right: -5px;
        bottom: -5px;
        font-size: 3rem;
        opacity: 0.03;
        pointer-events: none;
    }

    /* Orders Card */
    .orders-card {
        background: white;
        border-radius: var(--radius);
        padding: 1.2rem 1.2rem 0.8rem 1.2rem;
        box-shadow: var(--shadow-sm);
        transition: all 0.3s ease;
    }
    .orders-card:hover {
        box-shadow: var(--shadow-hover);
    }
    .orders-card .card-header-custom {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        padding-bottom: 0.6rem;
        border-bottom: 1px solid #f3f4f6;
    }
    .orders-card .card-header-custom h5 {
        font-weight: 600;
        margin: 0;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }
    .orders-card .card-header-custom h5 i {
        font-size: 0.9rem;
    }
    .orders-card .card-header-custom a {
        color: #667eea;
        font-weight: 500;
        font-size: 0.7rem;
        text-decoration: none;
        transition: all 0.3s ease;
        padding: 0.2rem 0.6rem;
        border-radius: 2rem;
        background: rgba(102, 126, 234, 0.08);
    }
    .orders-card .card-header-custom a:hover {
        background: var(--primary-gradient);
        color: white;
    }

    .order-status {
        padding: 0.2rem 0.6rem;
        border-radius: 2rem;
        font-size: 0.6rem;
        font-weight: 600;
        text-transform: capitalize;
        display: inline-block;
    }
    .order-status.delivered { background: #dcfce7; color: #16a34a; }
    .order-status.pending { background: #fef3c7; color: #d97706; }
    .order-status.processing { background: #dbeafe; color: #2563eb; }
    .order-status.cancelled { background: #fee2e2; color: #dc2626; }
    .order-status.shipped { background: #e0e7ff; color: #4f46e5; }

    .table th {
        font-size: 0.65rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        color: #6b7280;
        padding: 0.5rem 0.6rem;
        border-bottom: 1px solid #f3f4f6;
    }
    .table td {
        padding: 0.5rem 0.6rem;
        font-size: 0.8rem;
        vertical-align: middle;
        border-bottom: 1px solid #f3f4f6;
    }
    .table tbody tr {
        transition: all 0.3s ease;
        cursor: default;
    }
    .table tbody tr:hover {
        background: #f9fafb;
        transform: scale(1.002);
    }

    /* Quick Actions - Compact */
    .quick-action {
        background: white;
        border-radius: var(--radius-sm);
        padding: 0.8rem 1rem;
        text-align: center;
        border: 1px solid rgba(0,0,0,0.02);
        transition: all 0.3s ease;
        cursor: pointer;
        text-decoration: none;
        color: inherit;
        display: block;
        box-shadow: var(--shadow-sm);
        height: 100%;
    }
    .quick-action:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-hover);
        color: inherit;
    }
    .quick-action .icon-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 0.4rem;
        font-size: 1rem;
        transition: all 0.3s ease;
    }
    .quick-action:hover .icon-circle {
        transform: scale(1.05) rotate(5deg);
    }
    .quick-action .action-title {
        font-weight: 600;
        font-size: 0.75rem;
        margin-bottom: 0.1rem;
    }
    .quick-action .action-desc {
        color: #6b7280;
        font-size: 0.6rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .welcome-section { padding: 1rem 1.2rem; }
        .welcome-text h2 { font-size: 1.1rem; }
        .welcome-stats { gap: 0.5rem; }
        .welcome-stat-item { min-width: 60px; padding: 0.2rem 0.6rem; }
        .welcome-stat-item .number { font-size: 0.9rem; }
        .profile-sidebar { position: static; margin-bottom: 1rem; }
        .stat-card { padding: 0.6rem 0.8rem; }
        .stat-card .stat-value { font-size: 1rem; }
        .orders-card { padding: 0.8rem; }
        .table td { font-size: 0.7rem; padding: 0.3rem 0.4rem; }
        .table th { font-size: 0.55rem; padding: 0.3rem 0.4rem; }
    }

    @media (max-width: 576px) {
        .stat-card .stat-change { display: none; }
        .stat-card .stat-icon-bg { display: none; }
        .welcome-stats .welcome-stat-item:last-child { display: none; }
    }

    /* Animations */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(15px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes slideInLeft {
        from { opacity: 0; transform: translateX(-20px); }
        to { opacity: 1; transform: translateX(0); }
    }
    .animate-in { animation: fadeInUp 0.5s ease forwards; opacity: 0; }
    .animate-slide { animation: slideInLeft 0.5s ease forwards; opacity: 0; }
    .delay-1 { animation-delay: 0.08s; }
    .delay-2 { animation-delay: 0.12s; }
    .delay-3 { animation-delay: 0.16s; }
    .delay-4 { animation-delay: 0.20s; }
    .delay-5 { animation-delay: 0.24s; }
</style>

<div class="dashboard-wrapper">
    <div class="container">
        <!-- Welcome Section -->
        <div class="welcome-section animate-in">
            <div class="row align-items-center g-2">
                <div class="col-md-7 welcome-text">
                    <h2>👋 Welcome, {{ Auth::user()->name }}!</h2>
                    <p>Here's your store activity summary</p>
                </div>
                <div class="col-md-5">
                    <div class="welcome-stats justify-content-md-end">
                        <div class="welcome-stat-item">
                            <span class="number counter" data-target="{{ $totalOrders ?? 0 }}">0</span>
                            <span class="label">Orders</span>
                        </div>
                        <div class="welcome-stat-item">
                            <span class="number">$<span class="counter" data-target="{{ $totalSpent ?? 0 }}">0</span></span>
                            <span class="label">Spent</span>
                        </div>
                        <div class="welcome-stat-item">
                            <span class="number counter" data-target="{{ $pendingOrders ?? 0 }}">0</span>
                            <span class="label">Pending</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3 animate-slide delay-1">
                <div class="profile-sidebar">
                    <div class="profile-avatar" id="avatar">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="profile-name">{{ Auth::user()->name }}</div>
                    <div class="profile-email">{{ Auth::user()->email }}</div>
                    <div class="profile-badge">✦ Customer</div>

                    <ul class="sidebar-nav">
                        <li><a href="{{ route('customer.dashboard') }}" class="active"><i class="fas fa-th-large"></i> Dashboard</a></li>
                        <li><a href="{{ route('customer.orders') }}"><i class="fas fa-shopping-bag"></i> My Orders</a></li>
                        <li>
                            <a href="{{ route('wishlist.index') }}">
                                <i class="fas fa-heart"></i> Wishlist
                                @if(($wishlistCount ?? 0) > 0)
                                    <span class="badge bg-danger rounded-pill ms-auto">{{ $wishlistCount }}</span>
                                @endif
                            </a>
                        </li>
                        <li><a href="{{ route('profile.edit') }}"><i class="fas fa-user-cog"></i> Profile</a></li>
                        <li><a href="{{ route('profile.addresses') }}"><i class="fas fa-map-marker-alt"></i> Addresses</a></li>
                        <li><a href="{{ route('customer.reviews') }}"><i class="fas fa-star"></i> Reviews</a></li>
                        <li style="margin-top: 0.3rem; padding-top: 0.3rem; border-top: 1px solid #f3f4f6;">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="sidebar-nav a logout" style="background: none; border: none; width: 100%; text-align: left; padding: 0.5rem 0.75rem; border-radius: 0.6rem; transition: all 0.3s ease; font-weight: 500; font-size: 0.8rem; display: flex; align-items: center; gap: 0.6rem; cursor: pointer;">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-9">
                <!-- Stats Cards -->
                <div class="row g-3 mb-4">
                    <div class="col-md-3 col-6 animate-in delay-2">
                        <div class="stat-card" data-card="orders">
                            <div class="icon-wrapper" style="background: rgba(102, 126, 234, 0.12); color: #667eea;">
                                <i class="fas fa-shopping-bag"></i>
                            </div>
                            <div class="stat-info">
                                <div class="stat-value counter" data-target="{{ $totalOrders ?? 0 }}">0</div>
                                <div class="stat-label">Total Orders</div>
                            </div>
                            @if(($completedOrders ?? 0) > 0)
                                <span class="stat-change"><i class="fas fa-check me-1"></i>{{ $completedOrders }}</span>
                            @endif
                            <div class="stat-icon-bg"><i class="fas fa-shopping-bag"></i></div>
                        </div>
                    </div>

                    <div class="col-md-3 col-6 animate-in delay-3">
                        <div class="stat-card" data-card="pending">
                            <div class="icon-wrapper" style="background: rgba(251, 191, 36, 0.12); color: #f59e0b;">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="stat-info">
                                <div class="stat-value counter" data-target="{{ $pendingOrders ?? 0 }}">0</div>
                                <div class="stat-label">Pending</div>
                            </div>
                            @if(($pendingOrders ?? 0) > 0)
                                <span class="stat-change down"><i class="fas fa-clock me-1"></i>{{ $pendingOrders }}</span>
                            @endif
                            <div class="stat-icon-bg"><i class="fas fa-clock"></i></div>
                        </div>
                    </div>

                    <div class="col-md-3 col-6 animate-in delay-4">
                        <div class="stat-card" data-card="wishlist">
                            <div class="icon-wrapper" style="background: rgba(239, 68, 68, 0.12); color: #ef4444;">
                                <i class="fas fa-heart"></i>
                            </div>
                            <div class="stat-info">
                                <div class="stat-value counter" data-target="{{ $wishlistCount ?? 0 }}">0</div>
                                <div class="stat-label">Wishlist</div>
                            </div>
                            @if(($wishlistCount ?? 0) > 0)
                                <span class="stat-change"><i class="fas fa-heart me-1"></i>{{ $wishlistCount }}</span>
                            @endif
                            <div class="stat-icon-bg"><i class="fas fa-heart"></i></div>
                        </div>
                    </div>

                    <div class="col-md-3 col-6 animate-in delay-5">
                        <div class="stat-card" data-card="spent">
                            <div class="icon-wrapper" style="background: rgba(16, 185, 129, 0.12); color: #10b981;">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                            <div class="stat-info">
                                <div class="stat-value">$<span class="counter" data-target="{{ $totalSpent ?? 0 }}">0</span></div>
                                <div class="stat-label">Total Spent</div>
                            </div>
                            @if(($totalSpent ?? 0) > 0)
                                <span class="stat-change"><i class="fas fa-arrow-up me-1"></i>Lifetime</span>
                            @endif
                            <div class="stat-icon-bg"><i class="fas fa-dollar-sign"></i></div>
                        </div>
                    </div>
                </div>

                <!-- Recent Orders -->
                <div class="orders-card animate-in delay-4">
                    <div class="card-header-custom">
                        <h5><i class="fas fa-history" style="color: #667eea;"></i> Recent Orders</h5>
                        <a href="{{ route('customer.orders') }}">View All →</a>
                    </div>

                    @if(isset($recentOrders) && $recentOrders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Order</th>
                                        <th>Date</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentOrders as $order)
                                    <tr>
                                        <td><strong>#{{ $order->order_number ?? $order->id }}</strong></td>
                                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                                        <td><strong>${{ number_format($order->total, 2) }}</strong></td>
                                        <td><span class="order-status {{ $order->status }}">{{ $order->status }}</span></td>
                                        <td class="text-center">
                                            <a href="{{ route('customer.orders.show', $order->id) }}" 
                                               class="btn btn-sm btn-primary" 
                                               style="background: var(--primary-gradient); border: none; border-radius: 0.4rem; padding: 0.15rem 0.6rem; font-size: 0.7rem;">
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <div style="width: 50px; height: 50px; background: #f3f4f6; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 0.6rem;">
                                <i class="fas fa-shopping-bag fa-2x" style="color: #9ca3af;"></i>
                            </div>
                            <h6 style="color: #4b5563; font-weight: 600; font-size: 0.9rem;">No orders yet</h6>
                            <p style="color: #6b7280; font-size: 0.75rem; margin-bottom: 0.5rem;">Start shopping to see your orders</p>
                            <a href="{{ route('shop.index') }}" class="btn btn-sm" style="background: var(--primary-gradient); color: white; border: none; border-radius: 0.6rem; padding: 0.3rem 1rem; font-size: 0.75rem;">
                                Start Shopping
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Quick Actions -->
                <div class="row g-3 mt-3">
                    <div class="col-md-4 animate-in delay-2">
                        <a href="{{ route('shop.index') }}" class="quick-action">
                            <div class="icon-circle" style="background: rgba(102, 126, 234, 0.12); color: #667eea;">
                                <i class="fas fa-store"></i>
                            </div>
                            <div class="action-title">Browse Products</div>
                            <div class="action-desc">Explore collection</div>
                        </a>
                    </div>
                    <div class="col-md-4 animate-in delay-3">
                        <a href="{{ route('profile.edit') }}" class="quick-action">
                            <div class="icon-circle" style="background: rgba(16, 185, 129, 0.12); color: #10b981;">
                                <i class="fas fa-user-edit"></i>
                            </div>
                            <div class="action-title">Update Profile</div>
                            <div class="action-desc">Manage account</div>
                        </a>
                    </div>
                    <div class="col-md-4 animate-in delay-4">
                        <a href="{{ route('customer.orders') }}" class="quick-action">
                            <div class="icon-circle" style="background: rgba(251, 191, 36, 0.12); color: #f59e0b;">
                                <i class="fas fa-truck"></i>
                            </div>
                            <div class="action-title">Track Orders</div>
                            <div class="action-desc">Check status</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // ============================================
    // 1. COUNTER ANIMATION
    // ============================================
    document.addEventListener('DOMContentLoaded', function() {
        const counters = document.querySelectorAll('.counter');
        
        counters.forEach(counter => {
            const target = parseFloat(counter.getAttribute('data-target'));
            const isCurrency = counter.closest('.stat-card')?.getAttribute('data-card') === 'spent';
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        animateCounter(counter, target, isCurrency);
                        observer.unobserve(counter);
                    }
                });
            }, { threshold: 0.2 });
            
            observer.observe(counter);
        });
        
        function animateCounter(element, target, isCurrency = false) {
            const duration = 800;
            const startTime = performance.now();
            
            function updateCounter(currentTime) {
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / duration, 1);
                const easeOutQuart = 1 - Math.pow(1 - progress, 4);
                const current = easeOutQuart * target;
                
                if (isCurrency) {
                    element.textContent = current.toFixed(2);
                } else {
                    element.textContent = Math.round(current);
                }
                
                if (progress < 1) {
                    requestAnimationFrame(updateCounter);
                } else {
                    if (isCurrency) {
                        element.textContent = target.toFixed(2);
                    } else {
                        element.textContent = target;
                    }
                }
            }
            
            requestAnimationFrame(updateCounter);
        }
    });

    // ============================================
    // 2. STAT CARD HOVER EFFECT
    // ============================================
    document.querySelectorAll('.stat-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-3px)';
            this.style.boxShadow = '0 8px 30px rgba(0,0,0,0.1)';
        });
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '0 2px 12px rgba(0,0,0,0.06)';
        });
    });

    // ============================================
    // 3. AVATAR COLOR CHANGE
    // ============================================
    const avatar = document.getElementById('avatar');
    if (avatar) {
        const colors = ['#667eea', '#764ba2', '#f093fb', '#4facfe', '#f5576c'];
        setInterval(() => {
            const randomColor = colors[Math.floor(Math.random() * colors.length)];
            avatar.style.background = `linear-gradient(135deg, ${randomColor}, ${colors[Math.floor(Math.random() * colors.length)]})`;
        }, 4000);
    }

    // ============================================
    // 4. CONSOLE GREETING
    // ============================================
    console.log('%c✨ EktaMart Dashboard ✨', 'color: #667eea; font-size: 16px; font-weight: bold;');
    console.log('%c👋 Welcome, {{ Auth::user()->name }}!', 'color: #764ba2; font-size: 13px;');
</script>
@endsection