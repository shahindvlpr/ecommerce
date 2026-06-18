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
        --transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    /* Dark Mode Variables */
    [data-theme="dark"] {
        --bg-primary: #1a1a2e;
        --bg-secondary: #16213e;
        --bg-card: #1f2937;
        --text-primary: #f3f4f6;
        --text-secondary: #9ca3af;
        --border-color: #374151;
    }

    [data-theme="light"] {
        --bg-primary: #f5f6fa;
        --bg-secondary: #ffffff;
        --bg-card: #ffffff;
        --text-primary: #111827;
        --text-secondary: #6b7280;
        --border-color: #e5e7eb;
    }

    .dashboard-wrapper {
        background: var(--bg-primary);
        min-height: 100vh;
        padding: 1.5rem 0;
        transition: var(--transition);
    }

    /* ============================================
       WELCOME SECTION
    ============================================ */
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
        animation: float 8s ease-in-out infinite;
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
        animation: float 6s ease-in-out infinite reverse;
    }
    @keyframes float {
        0%, 100% { transform: translate(0, 0); }
        50% { transform: translate(-20px, 20px); }
    }

    .welcome-text h2 {
        font-weight: 700;
        font-size: 1.4rem;
        margin-bottom: 0.15rem;
        position: relative;
        z-index: 1;
    }
    .welcome-text h2 .wave {
        display: inline-block;
        animation: wave 2s ease-in-out infinite;
    }
    @keyframes wave {
        0%, 100% { transform: rotate(0deg); }
        25% { transform: rotate(15deg); }
        75% { transform: rotate(-10deg); }
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
        transition: var(--transition);
    }
    .welcome-stat-item:hover {
        background: rgba(255,255,255,0.2);
        transform: translateY(-2px) scale(1.02);
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

    /* ============================================
       DARK MODE TOGGLE
    ============================================ */
    .theme-toggle {
        position: fixed;
        bottom: 20px;
        right: 20px;
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: var(--primary-gradient);
        color: white;
        border: none;
        box-shadow: 0 4px 20px rgba(102, 126, 234, 0.4);
        cursor: pointer;
        z-index: 999;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }
    .theme-toggle:hover {
        transform: scale(1.1) rotate(30deg);
        box-shadow: 0 6px 30px rgba(102, 126, 234, 0.6);
    }

    /* ============================================
       PROFILE SIDEBAR
    ============================================ */
    .profile-sidebar {
        background: var(--bg-card);
        border-radius: var(--radius);
        padding: 1.2rem;
        box-shadow: var(--shadow-sm);
        position: sticky;
        top: 1.5rem;
        transition: var(--transition);
        border: 1px solid var(--border-color);
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
        transition: var(--transition);
        position: relative;
    }
    .profile-avatar .online-dot {
        position: absolute;
        bottom: 2px;
        right: 2px;
        width: 12px;
        height: 12px;
        background: #10b981;
        border-radius: 50%;
        border: 2px solid white;
        animation: pulse-dot 2s ease-in-out infinite;
    }
    @keyframes pulse-dot {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.2); opacity: 0.7; }
    }

    .profile-name {
        text-align: center;
        font-weight: 600;
        font-size: 0.95rem;
        margin-bottom: 0.1rem;
        color: var(--text-primary);
    }
    .profile-email {
        text-align: center;
        color: var(--text-secondary);
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

    /* Profile Completion Progress */
    .profile-completion {
        background: #f3f4f6;
        border-radius: 0.5rem;
        padding: 0.5rem 0.8rem;
        margin-bottom: 0.8rem;
    }
    [data-theme="dark"] .profile-completion {
        background: #374151;
    }
    .profile-completion .progress-label {
        display: flex;
        justify-content: space-between;
        font-size: 0.6rem;
        color: var(--text-secondary);
        margin-bottom: 0.2rem;
    }
    .profile-completion .progress-bar-custom {
        height: 4px;
        background: #e5e7eb;
        border-radius: 1rem;
        overflow: hidden;
    }
    .profile-completion .progress-bar-custom .progress-fill {
        height: 100%;
        background: var(--primary-gradient);
        border-radius: 1rem;
        transition: width 1s ease;
    }

    /* Sidebar Navigation */
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
        color: var(--text-secondary);
        text-decoration: none;
        transition: var(--transition);
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
        transition: var(--transition);
    }
    .sidebar-nav a:hover {
        background: rgba(102, 126, 234, 0.08);
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
        margin-left: auto;
    }
    @keyframes badgePulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    /* ============================================
       STATS CARDS
    ============================================ */
    .stat-card {
        background: var(--bg-card);
        border-radius: var(--radius-sm);
        padding: 0.8rem 1rem;
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
        border: 1px solid var(--border-color);
        position: relative;
        cursor: pointer;
        height: 100%;
        display: flex;
        align-items: center;
        gap: 0.8rem;
    }
    .stat-card:hover {
        transform: translateY(-3px) scale(1.01);
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
        transition: var(--transition);
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
        color: var(--text-primary);
        line-height: 1.2;
    }
    .stat-card .stat-label {
        color: var(--text-secondary);
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

    /* ============================================
       ORDERS CARD
    ============================================ */
    .orders-card {
        background: var(--bg-card);
        border-radius: var(--radius);
        padding: 1.2rem 1.2rem 0.8rem 1.2rem;
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
        border: 1px solid var(--border-color);
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
        border-bottom: 1px solid var(--border-color);
    }
    .orders-card .card-header-custom h5 {
        font-weight: 600;
        margin: 0;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 0.4rem;
        color: var(--text-primary);
    }
    .orders-card .card-header-custom h5 i {
        font-size: 0.9rem;
    }
    .orders-card .card-header-custom a {
        color: #667eea;
        font-weight: 500;
        font-size: 0.7rem;
        text-decoration: none;
        transition: var(--transition);
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
        color: var(--text-secondary);
        padding: 0.5rem 0.6rem;
        border-bottom: 1px solid var(--border-color);
    }
    .table td {
        padding: 0.5rem 0.6rem;
        font-size: 0.8rem;
        vertical-align: middle;
        border-bottom: 1px solid var(--border-color);
        color: var(--text-primary);
    }
    .table tbody tr {
        transition: var(--transition);
        cursor: default;
    }
    .table tbody tr:hover {
        background: rgba(102, 126, 234, 0.04);
        transform: scale(1.002);
    }

    /* ============================================
       QUICK ACTIONS
    ============================================ */
    .quick-action {
        background: var(--bg-card);
        border-radius: var(--radius-sm);
        padding: 0.8rem 1rem;
        text-align: center;
        border: 1px solid var(--border-color);
        transition: var(--transition);
        cursor: pointer;
        text-decoration: none;
        color: var(--text-primary);
        display: block;
        box-shadow: var(--shadow-sm);
        height: 100%;
    }
    .quick-action:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-hover);
        color: var(--text-primary);
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
        transition: var(--transition);
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
        color: var(--text-secondary);
        font-size: 0.6rem;
    }

    /* ============================================
       ACTIVITY FEED
    ============================================ */
    .activity-feed {
        background: var(--bg-card);
        border-radius: var(--radius);
        padding: 1.2rem;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border-color);
        margin-top: 1.5rem;
    }
    .activity-feed .activity-item {
        display: flex;
        align-items: center;
        gap: 0.8rem;
        padding: 0.4rem 0;
        border-bottom: 1px solid var(--border-color);
        transition: var(--transition);
    }
    .activity-feed .activity-item:last-child {
        border-bottom: none;
    }
    .activity-feed .activity-item:hover {
        background: rgba(102, 126, 234, 0.04);
        padding-left: 0.5rem;
        border-radius: 0.4rem;
    }
    .activity-feed .activity-icon {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 0.7rem;
    }
    .activity-feed .activity-content {
        flex: 1;
    }
    .activity-feed .activity-text {
        font-size: 0.75rem;
        color: var(--text-primary);
        margin-bottom: 0.1rem;
    }
    .activity-feed .activity-time {
        font-size: 0.6rem;
        color: var(--text-secondary);
    }

    /* ============================================
       RESPONSIVE
    ============================================ */
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
        .activity-feed { padding: 0.8rem; }
        .activity-feed .activity-text { font-size: 0.65rem; }
        .theme-toggle { bottom: 15px; right: 15px; width: 40px; height: 40px; font-size: 1rem; }
    }

    @media (max-width: 576px) {
        .stat-card .stat-change { display: none; }
        .stat-card .stat-icon-bg { display: none; }
        .welcome-stats .welcome-stat-item:last-child { display: none; }
        .quick-action { padding: 0.6rem; }
        .quick-action .icon-circle { width: 35px; height: 35px; font-size: 0.8rem; }
    }

    /* ============================================
       ANIMATIONS
    ============================================ */
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

<div class="dashboard-wrapper" id="dashboardWrapper">
    <div class="container">
        <!-- ============================================
             WELCOME SECTION
        ============================================ -->
        <div class="welcome-section animate-in">
            <div class="row align-items-center g-2">
                <div class="col-md-7 welcome-text">
                    <h2>
                        <span class="wave">👋</span> Welcome, {{ Auth::user()->name }}!
                    </h2>
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
            <!-- ============================================
                 SIDEBAR
            ============================================ -->
            <div class="col-lg-3 animate-slide delay-1">
                <div class="profile-sidebar">
                    <div class="profile-avatar" id="avatar">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        <span class="online-dot"></span>
                    </div>
                    <div class="profile-name">{{ Auth::user()->name }}</div>
                    <div class="profile-email">{{ Auth::user()->email }}</div>
                    <div class="profile-badge">✦ Customer</div>

                    <!-- Profile Completion -->
                    @php
                        $completion = 0;
                        $fields = ['name', 'email', 'phone', 'address', 'city', 'state', 'postal_code', 'country'];
                        $filled = 0;
                        foreach ($fields as $field) {
                            if (!empty(Auth::user()->$field)) $filled++;
                        }
                        $completion = round(($filled / count($fields)) * 100);
                    @endphp
                    <div class="profile-completion">
                        <div class="progress-label">
                            <span>Profile Completion</span>
                            <span>{{ $completion }}%</span>
                        </div>
                        <div class="progress-bar-custom">
                            <div class="progress-fill" style="width: {{ $completion }}%;"></div>
                        </div>
                    </div>

                    <ul class="sidebar-nav">
                        <li><a href="{{ route('customer.dashboard') }}" class="active"><i class="fas fa-th-large"></i> Dashboard</a></li>
                        <li>
                            <a href="{{ route('customer.orders') }}">
                                <i class="fas fa-shopping-bag"></i> My Orders
                                @if(($pendingOrders ?? 0) > 0)
                                    <span class="badge bg-danger rounded-pill">{{ $pendingOrders }}</span>
                                @endif
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('customer.wishlist') }}">
                                <i class="fas fa-heart"></i> Wishlist
                                @if(($wishlistCount ?? 0) > 0)
                                    <span class="badge bg-danger rounded-pill">{{ $wishlistCount }}</span>
                                @endif
                            </a>
                        </li>
                        <li><a href="{{ route('customer.profile') }}"><i class="fas fa-user-cog"></i> Profile</a></li>
                        <li><a href="{{ route('customer.addresses') }}"><i class="fas fa-map-marker-alt"></i> Addresses</a></li>
                        <li><a href="{{ route('customer.reviews') }}"><i class="fas fa-star"></i> Reviews</a></li>
                        <li style="margin-top: 0.3rem; padding-top: 0.3rem; border-top: 1px solid var(--border-color);">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="sidebar-nav a logout" style="background: none; border: none; width: 100%; text-align: left; padding: 0.5rem 0.75rem; border-radius: 0.6rem; transition: var(--transition); font-weight: 500; font-size: 0.8rem; display: flex; align-items: center; gap: 0.6rem; cursor: pointer;">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- ============================================
                 MAIN CONTENT
            ============================================ -->
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
                            <h6 style="color: var(--text-secondary); font-weight: 600; font-size: 0.9rem;">No orders yet</h6>
                            <p style="color: var(--text-secondary); font-size: 0.75rem; margin-bottom: 0.5rem;">Start shopping to see your orders</p>
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
                        <a href="{{ route('customer.profile') }}" class="quick-action">
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

                <!-- Activity Feed -->
                <div class="activity-feed animate-in delay-5">
                    <h5 class="fw-bold mb-3" style="font-size: 0.9rem; color: var(--text-primary);">
                        <i class="fas fa-bell" style="color: #667eea;"></i> Recent Activity
                    </h5>
                    
                    @if(isset($recentActivities) && $recentActivities->count() > 0)
                        @foreach($recentActivities as $activity)
                        <div class="activity-item">
                            <div class="activity-icon" style="background: {{ $activity->color ?? 'rgba(102, 126, 234, 0.12)' }}; color: {{ $activity->color ?? '#667eea' }};">
                                <i class="{{ $activity->icon ?? 'fas fa-circle' }}"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-text">{{ $activity->text ?? 'New activity' }}</div>
                                <div class="activity-time">{{ $activity->created_at->diffForHumans() ?? 'Just now' }}</div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center py-2">
                            <p class="text-muted" style="font-size: 0.8rem;">No recent activities</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============================================
     DARK MODE TOGGLE BUTTON
============================================ -->
<button class="theme-toggle" id="themeToggle" title="Toggle Dark/Light Mode">
    <i class="fas fa-moon" id="themeIcon"></i>
</button>

<script>
    // ============================================
    // 1. DARK MODE TOGGLE
    // ============================================
    const themeToggle = document.getElementById('themeToggle');
    const themeIcon = document.getElementById('themeIcon');
    const dashboard = document.getElementById('dashboardWrapper');
    
    // Check saved theme
    const savedTheme = localStorage.getItem('theme') || 'light';
    document.documentElement.setAttribute('data-theme', savedTheme);
    updateThemeIcon(savedTheme);

    themeToggle.addEventListener('click', function() {
        const currentTheme = document.documentElement.getAttribute('data-theme');
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
        
        document.documentElement.setAttribute('data-theme', newTheme);
        localStorage.setItem('theme', newTheme);
        updateThemeIcon(newTheme);
        
        // Add animation
        this.style.transform = 'scale(0.8)';
        setTimeout(() => {
            this.style.transform = 'scale(1)';
        }, 200);
    });

    function updateThemeIcon(theme) {
        if (theme === 'dark') {
            themeIcon.className = 'fas fa-sun';
            themeToggle.style.background = 'linear-gradient(135deg, #f59e0b, #f97316)';
        } else {
            themeIcon.className = 'fas fa-moon';
            themeToggle.style.background = 'var(--primary-gradient)';
        }
    }

    // ============================================
    // 2. COUNTER ANIMATION
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
    // 3. AVATAR COLOR ANIMATION
    // ============================================
    const avatar = document.getElementById('avatar');
    if (avatar) {
        const colors = ['#667eea', '#764ba2', '#f093fb', '#4facfe', '#f5576c'];
        let colorIndex = 0;
        setInterval(() => {
            colorIndex = (colorIndex + 1) % colors.length;
            const nextColor = colors[(colorIndex + 1) % colors.length];
            avatar.style.background = `linear-gradient(135deg, ${colors[colorIndex]}, ${nextColor})`;
        }, 4000);
    }

    // ============================================
    // 4. STAT CARD CLICK EFFECT
    // ============================================
    document.querySelectorAll('.stat-card').forEach(card => {
        card.addEventListener('click', function() {
            const cardType = this.getAttribute('data-card');
            const routes = {
                'orders': '{{ route("customer.orders") }}',
                'pending': '{{ route("customer.orders") }}',
                'wishlist': '{{ route("customer.wishlist") }}',
                'spent': '{{ route("customer.orders") }}'
            };
            if (routes[cardType]) {
                window.location.href = routes[cardType];
            }
        });
    });

    // ============================================
    // 5. CONSOLE GREETING
    // ============================================
    console.log('%c✨ EktaMart Dashboard ✨', 'color: #667eea; font-size: 16px; font-weight: bold;');
    console.log('%c👋 Welcome, {{ Auth::user()->name }}!', 'color: #764ba2; font-size: 13px;');
    console.log('%c📊 Total Orders: {{ $totalOrders ?? 0 }}', 'color: #10b981; font-size: 12px;');
    console.log('%c⏳ Pending Orders: {{ $pendingOrders ?? 0 }}', 'color: #f59e0b; font-size: 12px;');
    console.log('%c❤️ Wishlist Items: {{ $wishlistCount ?? 0 }}', 'color: #ef4444; font-size: 12px;');
</script>
@endsection