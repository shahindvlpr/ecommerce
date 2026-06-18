{{-- resources/views/layouts/admin/sidebar.blade.php --}}
<style>
    /* ============================================================
       PREMIUM SIDEBAR STYLES
    ============================================================ */
    .sidebar {
        position: fixed;
        left: 0;
        top: 0;
        height: 100vh;
        width: 280px;
        background: linear-gradient(180deg, #0f0c29 0%, #1a1a3e 50%, #24243e 100%);
        color: #fff;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        z-index: 1000;
        overflow-y: auto;
        overflow-x: hidden;
        box-shadow: 5px 0 30px rgba(0, 0, 0, 0.3);
    }
    
    /* Custom Scrollbar */
    .sidebar::-webkit-scrollbar {
        width: 4px;
    }
    
    .sidebar::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.05);
    }
    
    .sidebar::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, #8b5cf6, #6366f1);
        border-radius: 10px;
    }
    
    /* ============================================================
       LOGO SECTION
    ============================================================ */
    .sidebar-logo {
        padding: 1.5rem 1rem 1rem;
        text-align: center;
        border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        margin-bottom: 1rem;
        position: relative;
    }
    
    .logo-icon {
        width: 55px;
        height: 55px;
        background: linear-gradient(135deg, #8b5cf6, #6366f1);
        border-radius: 1rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 0.75rem;
        box-shadow: 0 8px 20px rgba(139, 92, 246, 0.4);
        animation: glowPulse 2s infinite;
    }
    
    @keyframes glowPulse {
        0%, 100% { box-shadow: 0 8px 20px rgba(139, 92, 246, 0.4); }
        50% { box-shadow: 0 8px 35px rgba(139, 92, 246, 0.7); }
    }
    
    .logo-icon i {
        font-size: 1.75rem;
        color: white;
    }
    
    .sidebar-logo h4 {
        font-weight: 800;
        background: linear-gradient(135deg, #ffffff, #c4b5fd);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        margin: 0;
        letter-spacing: 1px;
        font-size: 1.25rem;
    }
    
    .sidebar-logo p {
        font-size: 0.6rem;
        color: rgba(255, 255, 255, 0.4);
        margin: 0;
        margin-top: 0.2rem;
        letter-spacing: 0.5px;
    }
    
    /* ============================================================
       USER PROFILE SECTION
    ============================================================ */
    .user-profile {
        padding: 0.8rem 1rem;
        margin: 0 1rem 1rem 1rem;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 1rem;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.06);
        display: flex;
        align-items: center;
        gap: 0.75rem;
        transition: all 0.3s ease;
    }
    
    .user-profile:hover {
        background: rgba(255, 255, 255, 0.08);
        border-color: rgba(139, 92, 246, 0.2);
    }
    
    .user-avatar {
        width: 42px;
        height: 42px;
        background: linear-gradient(135deg, #8b5cf6, #6366f1);
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.1rem;
        flex-shrink: 0;
        box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3);
    }
    
    .user-info {
        flex: 1;
        min-width: 0;
    }
    
    .user-info h6 {
        margin: 0;
        font-weight: 600;
        font-size: 0.85rem;
        color: #fff;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .user-info small {
        font-size: 0.65rem;
        color: rgba(255, 255, 255, 0.5);
        display: block;
    }
    
    .user-info .role-badge {
        font-size: 0.55rem;
        padding: 0.1rem 0.5rem;
        border-radius: 2rem;
        background: rgba(139, 92, 246, 0.2);
        color: #a78bfa;
        display: inline-block;
        margin-top: 0.1rem;
        border: 1px solid rgba(139, 92, 246, 0.15);
    }
    
    /* ============================================================
       NAVIGATION SECTIONS
    ============================================================ */
    .sidebar-nav {
        padding: 0 0.8rem;
    }
    
    .nav-section {
        margin-bottom: 1.2rem;
    }
    
    .nav-section-title {
        font-size: 0.65rem;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        color: rgba(255, 255, 255, 0.3);
        padding: 0.3rem 1rem 0.5rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .nav-section-title i {
        font-size: 0.6rem;
        opacity: 0.5;
    }
    
    /* ============================================================
       MENU ITEMS
    ============================================================ */
    .sidebar a {
        display: flex;
        align-items: center;
        gap: 0.8rem;
        padding: 0.6rem 0.9rem;
        margin: 0.15rem 0;
        color: rgba(255, 255, 255, 0.65);
        text-decoration: none;
        border-radius: 0.75rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        font-weight: 500;
        font-size: 0.85rem;
        cursor: pointer;
        border: 1px solid transparent;
    }
    
    /* Hover Effect */
    .sidebar a::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.06), transparent);
        transition: left 0.5s ease;
    }
    
    .sidebar a:hover::before {
        left: 100%;
    }
    
    .sidebar a:hover {
        background: rgba(139, 92, 246, 0.12);
        color: white;
        transform: translateX(4px);
        border-color: rgba(139, 92, 246, 0.1);
    }
    
    /* Active Menu Item */
    .sidebar a.active {
        background: linear-gradient(135deg, rgba(139, 92, 246, 0.2), rgba(99, 102, 241, 0.15));
        color: white;
        border-color: rgba(139, 92, 246, 0.2);
        box-shadow: 0 4px 15px rgba(139, 92, 246, 0.1);
    }
    
    .sidebar a.active i {
        color: #a78bfa;
    }
    
    .sidebar a i {
        width: 22px;
        font-size: 1rem;
        text-align: center;
        transition: all 0.3s ease;
        color: rgba(255, 255, 255, 0.5);
        flex-shrink: 0;
    }
    
    .sidebar a:hover i,
    .sidebar a.active i {
        color: #a78bfa;
        transform: scale(1.05);
    }
    
    /* Menu Badge */
    .menu-badge {
        margin-left: auto;
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
        font-size: 0.55rem;
        padding: 0.15rem 0.5rem;
        border-radius: 2rem;
        font-weight: 700;
        animation: badgePulse 2s ease-in-out infinite;
        flex-shrink: 0;
    }
    
    @keyframes badgePulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }
    
    /* ============================================================
       SUBMENU
    ============================================================ */
    .has-submenu > a {
        cursor: pointer;
    }
    
    .submenu {
        margin-left: 0.5rem;
        padding-left: 1.5rem;
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border-left: 1px solid rgba(255, 255, 255, 0.06);
    }
    
    .submenu a {
        padding: 0.45rem 0.9rem;
        font-size: 0.8rem;
        border: none !important;
    }
    
    .submenu a i {
        font-size: 0.75rem;
        width: 18px;
        color: rgba(255, 255, 255, 0.35) !important;
    }
    
    .submenu a:hover i {
        color: #a78bfa !important;
    }
    
    .submenu-open .submenu {
        max-height: 300px;
    }
    
    .chevron-icon {
        margin-left: auto;
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        font-size: 0.7rem;
        color: rgba(255, 255, 255, 0.3);
        flex-shrink: 0;
    }
    
    .submenu-open .chevron-icon {
        transform: rotate(90deg);
        color: #a78bfa;
    }
    
    /* ============================================================
       DIVIDER
    ============================================================ */
    .sidebar-divider {
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.06), transparent);
        margin: 0.8rem 1rem;
    }
    
    /* ============================================================
       FOOTER SECTION
    ============================================================ */
    .sidebar-footer {
        padding: 0.5rem 0.8rem 0.8rem;
        margin-top: 0.5rem;
        border-top: 1px solid rgba(255, 255, 255, 0.04);
    }
    
    .sidebar-footer a {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.5rem 0.9rem;
        color: rgba(255, 255, 255, 0.5);
        text-decoration: none;
        border-radius: 0.75rem;
        transition: all 0.3s ease;
        font-size: 0.82rem;
        border: none !important;
    }
    
    .sidebar-footer a:hover {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
        transform: translateX(4px);
    }
    
    .sidebar-footer a i {
        width: 20px;
        text-align: center;
        font-size: 0.9rem;
    }
    
    /* ============================================================
       COLLAPSED SIDEBAR
    ============================================================ */
    .sidebar.collapsed {
        width: 72px;
    }
    
    .sidebar.collapsed .sidebar-logo h4,
    .sidebar.collapsed .sidebar-logo p,
    .sidebar.collapsed .user-info,
    .sidebar.collapsed .nav-section-title,
    .sidebar.collapsed a span,
    .sidebar.collapsed .menu-badge,
    .sidebar.collapsed .chevron-icon,
    .sidebar.collapsed .submenu {
        display: none !important;
    }
    
    .sidebar.collapsed a {
        justify-content: center;
        padding: 0.6rem;
        margin: 0.1rem 0;
        border: none !important;
    }
    
    .sidebar.collapsed a i {
        margin: 0;
        font-size: 1.15rem;
    }
    
    .sidebar.collapsed .user-profile {
        justify-content: center;
        padding: 0.6rem;
        margin: 0 0.5rem 0.8rem 0.5rem;
    }
    
    .sidebar.collapsed .user-avatar {
        margin: 0;
        width: 38px;
        height: 38px;
        font-size: 0.9rem;
    }
    
    .sidebar.collapsed .sidebar-logo {
        padding: 1rem 0.5rem;
    }
    
    .sidebar.collapsed .logo-icon {
        width: 45px;
        height: 45px;
    }
    
    .sidebar.collapsed .logo-icon i {
        font-size: 1.3rem;
    }
    
    .sidebar.collapsed .sidebar-footer a {
        justify-content: center;
        padding: 0.5rem;
    }
    
    .sidebar.collapsed .sidebar-footer a i {
        margin: 0;
        font-size: 1rem;
    }
    
    .sidebar.collapsed .sidebar-footer a span {
        display: none;
    }
    
    .sidebar.collapsed .sidebar-footer {
        padding: 0.3rem 0.3rem 0.6rem;
    }
    
    .sidebar.collapsed .nav-section {
        margin-bottom: 0.6rem;
    }
    
    /* ============================================================
       TOGGLE BUTTON
    ============================================================ */
    .sidebar-toggle {
        position: fixed;
        left: 290px;
        top: 15px;
        z-index: 1001;
        background: linear-gradient(135deg, #8b5cf6, #6366f1);
        border: none;
        width: 32px;
        height: 32px;
        border-radius: 0.6rem;
        color: white;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        font-size: 0.7rem;
    }
    
    .sidebar-toggle:hover {
        transform: scale(1.1);
        box-shadow: 0 4px 20px rgba(139, 92, 246, 0.4);
    }
    
    .sidebar.collapsed + .sidebar-toggle {
        left: 82px;
    }
    
    /* ============================================================
       MOBILE RESPONSIVE
    ============================================================ */
    .mobile-menu-btn {
        display: none;
    }
    
    @media (max-width: 768px) {
        .sidebar {
            transform: translateX(-100%);
            width: 280px;
        }
        
        .sidebar.mobile-open {
            transform: translateX(0);
        }
        
        .sidebar.collapsed {
            width: 280px;
        }
        
        .sidebar.collapsed .sidebar-logo h4,
        .sidebar.collapsed .sidebar-logo p,
        .sidebar.collapsed .user-info,
        .sidebar.collapsed .nav-section-title,
        .sidebar.collapsed a span,
        .sidebar.collapsed .menu-badge,
        .sidebar.collapsed .chevron-icon,
        .sidebar.collapsed .submenu {
            display: block !important;
        }
        
        .sidebar.collapsed a {
            justify-content: flex-start;
            padding: 0.6rem 0.9rem;
        }
        
        .sidebar.collapsed a i {
            margin: 0;
            font-size: 1rem;
        }
        
        .sidebar.collapsed .user-profile {
            justify-content: flex-start;
            padding: 0.8rem 1rem;
            margin: 0 1rem 1rem 1rem;
        }
        
        .sidebar.collapsed .sidebar-logo {
            padding: 1.5rem 1rem 1rem;
        }
        
        .sidebar.collapsed .logo-icon {
            width: 55px;
            height: 55px;
        }
        
        .sidebar.collapsed .logo-icon i {
            font-size: 1.75rem;
        }
        
        .sidebar.collapsed .sidebar-footer a {
            justify-content: flex-start;
            padding: 0.5rem 0.9rem;
        }
        
        .sidebar.collapsed .sidebar-footer a span {
            display: inline;
        }
        
        .sidebar.collapsed .sidebar-footer {
            padding: 0.5rem 0.8rem 0.8rem;
        }
        
        .sidebar-toggle {
            display: none;
        }
        
        .mobile-menu-btn {
            display: flex;
            position: fixed;
            left: 15px;
            top: 15px;
            z-index: 1002;
            background: linear-gradient(135deg, #8b5cf6, #6366f1);
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 0.75rem;
            color: white;
            cursor: pointer;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            font-size: 1.1rem;
        }
        
        .mobile-menu-btn:hover {
            transform: scale(1.05);
        }
        
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 999;
            backdrop-filter: blur(4px);
        }
        
        .sidebar-overlay.active {
            display: block;
        }
    }
    
    @media (max-width: 576px) {
        .sidebar {
            width: 280px;
        }
    }
</style>

<!-- ============================================================
     SIDEBAR OVERLAY (Mobile)
============================================================ -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- ============================================================
     TOGGLE BUTTON
============================================================ -->
<button class="sidebar-toggle" id="sidebarToggle">
    <i class="fas fa-chevron-left"></i>
</button>

<!-- ============================================================
     SIDEBAR
============================================================ -->
<div class="sidebar" id="sidebar">
    
    <!-- ============================================================
         LOGO SECTION
    ============================================================ -->
    <div class="sidebar-logo">
        <div class="logo-icon">
            <i class="fas fa-store"></i>
        </div>
        <h4>Ekta<span style="color: #a78bfa;">Mart</span></h4>
        <p>Admin Panel v2.0</p>
    </div>
    
    <!-- ============================================================
         USER PROFILE SECTION
    ============================================================ -->
    <div class="user-profile">
        <div class="user-avatar">
            {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
        </div>
        <div class="user-info">
            <h6>{{ Auth::user()->name ?? 'Admin' }}</h6>
            <small>
                <span class="role-badge">
                    <i class="fas fa-shield-alt"></i> 
                    {{ ucfirst(Auth::user()->role ?? 'admin') }}
                </span>
            </small>
        </div>
    </div>
    
    <!-- ============================================================
         NAVIGATION
    ============================================================ -->
    <div class="sidebar-nav">
        
        <!-- ===========================
             MAIN SECTION
        ============================ -->
        <div class="nav-section">
            <div class="nav-section-title">
                <i class="fas fa-chart-line"></i> MAIN
            </div>
            
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-pie"></i>
                <span>Dashboard</span>
            </a>
            
            <a href="{{ route('admin.analytics') }}" class="{{ request()->routeIs('admin.analytics') ? 'active' : '' }}">
                <i class="fas fa-chart-bar"></i>
                <span>Analytics</span>
            </a>
        </div>
        
        <!-- ===========================
             SHOP SECTION
        ============================ -->
        <div class="nav-section">
            <div class="nav-section-title">
                <i class="fas fa-store"></i> SHOP
            </div>
            
            <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <i class="fas fa-tags"></i>
                <span>Categories</span>
                @php
                    $pendingCategories = \App\Models\Category::where('status', false)->count();
                @endphp
                @if($pendingCategories > 0)
                    <span class="menu-badge">{{ $pendingCategories }}</span>
                @endif
            </a>
            
            <a href="{{ route('admin.brands.index') }}" class="{{ request()->routeIs('admin.brands.*') ? 'active' : '' }}">
                <i class="fas fa-trademark"></i>
                <span>Brands</span>
            </a>
            
            <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                <i class="fas fa-box"></i>
                <span>Products</span>
                @php
                    $lowStockCount = \App\Models\Product::where('stock', '<', 10)->count();
                @endphp
                @if($lowStockCount > 0)
                    <span class="menu-badge" style="background: linear-gradient(135deg, #f59e0b, #d97706);">{{ $lowStockCount }}</span>
                @endif
            </a>
            
            <a href="{{ route('admin.attributes.index') }}" class="{{ request()->routeIs('admin.attributes.*') ? 'active' : '' }}">
                <i class="fas fa-list-ul"></i>
                <span>Attributes</span>
            </a>
        </div>
        
        <!-- ===========================
             ORDERS SECTION
        ============================ -->
        <div class="nav-section">
            <div class="nav-section-title">
                <i class="fas fa-shopping-cart"></i> SALES
            </div>
            
            <div class="has-submenu" id="ordersMenu">
                <a href="javascript:void(0)" class="d-flex align-items-center {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Orders</span>
                    @php
                        $pendingOrders = \App\Models\Order::where('status', 'pending')->count();
                    @endphp
                    @if($pendingOrders > 0)
                        <span class="menu-badge">{{ $pendingOrders }}</span>
                    @endif
                    <i class="fas fa-chevron-right chevron-icon ms-auto"></i>
                </a>
                <div class="submenu">
                    <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.index') ? 'active' : '' }}">
                        <i class="fas fa-list"></i>
                        <span>All Orders</span>
                    </a>
                    <a href="{{ route('admin.orders.pending') }}" class="{{ request()->routeIs('admin.orders.pending') ? 'active' : '' }}">
                        <i class="fas fa-clock"></i>
                        <span>Pending</span>
                        @if($pendingOrders > 0)
                            <span class="menu-badge">{{ $pendingOrders }}</span>
                        @endif
                    </a>
                    <a href="{{ route('admin.orders.processing') }}" class="{{ request()->routeIs('admin.orders.processing') ? 'active' : '' }}">
                        <i class="fas fa-spinner"></i>
                        <span>Processing</span>
                    </a>
                    <a href="{{ route('admin.orders.completed') }}" class="{{ request()->routeIs('admin.orders.completed') ? 'active' : '' }}">
                        <i class="fas fa-check-circle"></i>
                        <span>Completed</span>
                    </a>
                    <a href="{{ route('admin.orders.cancelled') }}" class="{{ request()->routeIs('admin.orders.cancelled') ? 'active' : '' }}">
                        <i class="fas fa-times-circle"></i>
                        <span>Cancelled</span>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- ===========================
             USERS SECTION
        ============================ -->
        <div class="nav-section">
            <div class="nav-section-title">
                <i class="fas fa-users"></i> USERS
            </div>
            
            <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i>
                <span>All Users</span>
                @php
                    $totalUsers = \App\Models\User::count();
                @endphp
                <span class="menu-badge" style="background: linear-gradient(135deg, #3b82f6, #2563eb);">{{ $totalUsers }}</span>
            </a>
            
            <a href="{{ route('admin.customers.index') }}" class="{{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
                <i class="fas fa-user"></i>
                <span>Customers</span>
            </a>
            
            <a href="{{ route('admin.vendors.index') }}" class="{{ request()->routeIs('admin.vendors.*') ? 'active' : '' }}">
                <i class="fas fa-user-tie"></i>
                <span>Vendors</span>
                @php
                    $pendingVendors = \App\Models\User::where('role', 'vendor')->where('is_approved', false)->count();
                @endphp
                @if($pendingVendors > 0)
                    <span class="menu-badge">{{ $pendingVendors }}</span>
                @endif
            </a>
        </div>
        
        <!-- ===========================
             MARKETING SECTION
        ============================ -->
        <div class="nav-section">
            <div class="nav-section-title">
                <i class="fas fa-bullhorn"></i> MARKETING
            </div>
            
            <a href="{{ route('admin.coupons.index') }}" class="{{ request()->routeIs('admin.coupons.*') ? 'active' : '' }}">
                <i class="fas fa-ticket-alt"></i>
                <span>Coupons</span>
                @php
                    $activeCoupons = \App\Models\Coupon::where('status', true)->where('expires_at', '>', now())->count();
                @endphp
                @if($activeCoupons > 0)
                    <span class="menu-badge" style="background: linear-gradient(135deg, #10b981, #059669);">{{ $activeCoupons }}</span>
                @endif
            </a>
            
            <a href="{{ route('admin.banners.index') }}" class="{{ request()->routeIs('admin.banners.*') ? 'active' : '' }}">
                <i class="fas fa-image"></i>
                <span>Banners</span>
            </a>
        </div>
        
        <!-- ===========================
             REVIEWS SECTION
        ============================ -->
        <div class="nav-section">
            <div class="nav-section-title">
                <i class="fas fa-star"></i> REVIEWS
            </div>
            
            <a href="{{ route('admin.reviews.index') }}" class="{{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
                <i class="fas fa-star"></i>
                <span>All Reviews</span>
                @php
                    $pendingReviews = \App\Models\Review::where('is_approved', false)->count();
                @endphp
                @if($pendingReviews > 0)
                    <span class="menu-badge">{{ $pendingReviews }}</span>
                @endif
            </a>
            
            <a href="{{ route('admin.reviews.pending') }}" class="{{ request()->routeIs('admin.reviews.pending') ? 'active' : '' }}">
                <i class="fas fa-clock"></i>
                <span>Pending Reviews</span>
                @if($pendingReviews > 0)
                    <span class="menu-badge">{{ $pendingReviews }}</span>
                @endif
            </a>
        </div>
        
        <!-- ===========================
             REPORTS SECTION
        ============================ -->
        <div class="nav-section">
            <div class="nav-section-title">
                <i class="fas fa-chart-bar"></i> REPORTS
            </div>
            
            <a href="{{ route('admin.reports.sales') }}" class="{{ request()->routeIs('admin.reports.sales') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i>
                <span>Sales Report</span>
            </a>
            
            <a href="{{ route('admin.reports.products') }}" class="{{ request()->routeIs('admin.reports.products') ? 'active' : '' }}">
                <i class="fas fa-boxes"></i>
                <span>Products Report</span>
            </a>
            
            <a href="{{ route('admin.reports.users') }}" class="{{ request()->routeIs('admin.reports.users') ? 'active' : '' }}">
                <i class="fas fa-users"></i>
                <span>Users Report</span>
            </a>
            
            <a href="{{ route('admin.reports.top-selling') }}" class="{{ request()->routeIs('admin.reports.top-selling') ? 'active' : '' }}">
                <i class="fas fa-trophy"></i>
                <span>Top Selling</span>
            </a>
            
            <a href="{{ route('admin.reports.low-stock') }}" class="{{ request()->routeIs('admin.reports.low-stock') ? 'active' : '' }}">
                <i class="fas fa-exclamation-triangle"></i>
                <span>Low Stock</span>
                @if($lowStockCount > 0)
                    <span class="menu-badge" style="background: linear-gradient(135deg, #ef4444, #dc2626);">{{ $lowStockCount }}</span>
                @endif
            </a>
        </div>
        
        <!-- ===========================
             SETTINGS SECTION
        ============================ -->
        <div class="nav-section">
            <div class="nav-section-title">
                <i class="fas fa-cog"></i> SETTINGS
            </div>
            
            <div class="has-submenu" id="settingsMenu">
                <a href="javascript:void(0)" class="d-flex align-items-center {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                    <i class="fas fa-sliders-h"></i>
                    <span>Settings</span>
                    <i class="fas fa-chevron-right chevron-icon ms-auto"></i>
                </a>
                <div class="submenu">
                    <a href="{{ route('admin.settings.index') }}" class="{{ request()->routeIs('admin.settings.index') ? 'active' : '' }}">
                        <i class="fas fa-globe"></i>
                        <span>General</span>
                    </a>
                    <a href="{{ route('admin.settings.payment') }}" class="{{ request()->routeIs('admin.settings.payment') ? 'active' : '' }}">
                        <i class="fas fa-credit-card"></i>
                        <span>Payment</span>
                    </a>
                    <a href="{{ route('admin.settings.shipping') }}" class="{{ request()->routeIs('admin.settings.shipping') ? 'active' : '' }}">
                        <i class="fas fa-truck"></i>
                        <span>Shipping</span>
                    </a>
                    <a href="{{ route('admin.settings.email') }}" class="{{ request()->routeIs('admin.settings.email') ? 'active' : '' }}">
                        <i class="fas fa-envelope"></i>
                        <span>Email</span>
                    </a>
                    <a href="{{ route('admin.settings.seo') }}" class="{{ request()->routeIs('admin.settings.seo') ? 'active' : '' }}">
                        <i class="fas fa-search"></i>
                        <span>SEO</span>
                    </a>
                    <a href="{{ route('admin.settings.social') }}" class="{{ request()->routeIs('admin.settings.social') ? 'active' : '' }}">
                        <i class="fas fa-share-alt"></i>
                        <span>Social</span>
                    </a>
                </div>
            </div>
            
            <a href="{{ route('admin.backup.index') }}" class="{{ request()->routeIs('admin.backup.*') ? 'active' : '' }}">
                <i class="fas fa-database"></i>
                <span>Backup</span>
            </a>
            
            <a href="{{ route('admin.settings.clear-cache') }}" class="{{ request()->routeIs('admin.settings.clear-cache') ? 'active' : '' }}" onclick="event.preventDefault(); document.getElementById('clear-cache-form').submit();">
                <i class="fas fa-broom"></i>
                <span>Clear Cache</span>
            </a>
            <form id="clear-cache-form" action="{{ route('admin.settings.clear-cache') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>
    
    <!-- ============================================================
         DIVIDER
    ============================================================ -->
    <div class="sidebar-divider"></div>
    
    <!-- ============================================================
         FOOTER LINKS
    ============================================================ -->
    <div class="sidebar-footer">
        <a href="{{ route('profile.edit') }}">
            <i class="fas fa-user-circle"></i>
            <span>My Profile</span>
        </a>
        
        <a href="{{ route('home') }}" target="_blank">
            <i class="fas fa-store"></i>
            <span>View Store</span>
        </a>
        
        <form method="POST" action="{{ route('logout') }}" id="logout-form-sidebar">
            @csrf
            <a href="javascript:void(0)" onclick="document.getElementById('logout-form-sidebar').submit();" style="color: #ef4444;">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </form>
    </div>
    
    <!-- ============================================================
         VERSION INFO
    ============================================================ -->
    <div class="text-center py-2">
        <small style="color: rgba(255,255,255,0.2); font-size: 0.6rem;">
            <i class="fas fa-code-branch"></i> v2.0.0 | <i class="fas fa-heart" style="color: #ef4444;"></i> EktaMart
        </small>
    </div>
</div>

<script>
    // ============================================================
    // 1. SIDEBAR TOGGLE (Collapse/Expand)
    // ============================================================
    (function() {
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('sidebarToggle');
        const toggleIcon = toggleBtn?.querySelector('i');
        const mainContent = document.querySelector('.main-content');
        
        // Load saved state
        const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
        if (isCollapsed) {
            sidebar?.classList.add('collapsed');
            mainContent?.classList.add('expanded');
            if (toggleIcon) {
                toggleIcon.classList.remove('fa-chevron-left');
                toggleIcon.classList.add('fa-chevron-right');
            }
        }
        
        toggleBtn?.addEventListener('click', function() {
            sidebar?.classList.toggle('collapsed');
            mainContent?.classList.toggle('expanded');
            
            const collapsed = sidebar?.classList.contains('collapsed');
            localStorage.setItem('sidebarCollapsed', collapsed);
            
            if (collapsed) {
                toggleIcon?.classList.remove('fa-chevron-left');
                toggleIcon?.classList.add('fa-chevron-right');
            } else {
                toggleIcon?.classList.remove('fa-chevron-right');
                toggleIcon?.classList.add('fa-chevron-left');
            }
        });
    })();
    
    // ============================================================
    // 2. SUBMENU TOGGLE
    // ============================================================
    (function() {
        document.querySelectorAll('.has-submenu > a').forEach(trigger => {
            trigger.addEventListener('click', function(e) {
                e.preventDefault();
                const parent = this.closest('.has-submenu');
                parent?.classList.toggle('submenu-open');
                
                // Save state
                const menuId = parent?.id;
                if (menuId) {
                    const isOpen = parent?.classList.contains('submenu-open');
                    localStorage.setItem(`sidebar_${menuId}`, isOpen);
                }
            });
            
            // Load saved state
            const parent = trigger.closest('.has-submenu');
            const menuId = parent?.id;
            if (menuId && localStorage.getItem(`sidebar_${menuId}`) === 'true') {
                parent?.classList.add('submenu-open');
            }
        });
    })();
    
    // ============================================================
    // 3. MOBILE RESPONSIVE
    // ============================================================
    (function() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        
        function createMobileBtn() {
            if (window.innerWidth <= 768) {
                let mobileBtn = document.querySelector('.mobile-menu-btn');
                if (!mobileBtn) {
                    mobileBtn = document.createElement('button');
                    mobileBtn.className = 'mobile-menu-btn';
                    mobileBtn.innerHTML = '<i class="fas fa-bars"></i>';
                    mobileBtn.addEventListener('click', function() {
                        sidebar?.classList.toggle('mobile-open');
                        overlay?.classList.toggle('active');
                    });
                    document.body.appendChild(mobileBtn);
                }
            } else {
                const mobileBtn = document.querySelector('.mobile-menu-btn');
                if (mobileBtn) mobileBtn.remove();
                if (sidebar) sidebar.classList.remove('mobile-open');
                if (overlay) overlay.classList.remove('active');
            }
        }
        
        // Close sidebar when overlay is clicked
        overlay?.addEventListener('click', function() {
            sidebar?.classList.remove('mobile-open');
            overlay.classList.remove('active');
        });
        
        // Close sidebar on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && sidebar?.classList.contains('mobile-open')) {
                sidebar.classList.remove('mobile-open');
                overlay?.classList.remove('active');
            }
        });
        
        window.addEventListener('resize', createMobileBtn);
        createMobileBtn();
    })();
    
    // ============================================================
    // 4. ACTIVE ROUTE DETECTION
    // ============================================================
    (function() {
        const currentUrl = window.location.pathname;
        
        document.querySelectorAll('.sidebar a[href]').forEach(link => {
            const href = link.getAttribute('href');
            if (href && href !== 'javascript:void(0)' && currentUrl === href) {
                link.classList.add('active');
                // Expand parent submenu
                const parentSubmenu = link.closest('.submenu');
                if (parentSubmenu) {
                    parentSubmenu.closest('.has-submenu')?.classList.add('submenu-open');
                }
            }
        });
    })();
    
    // ============================================================
    // 5. CONSOLE GREETING
    // ============================================================
    console.log('%c✨ EktaMart Admin Sidebar | Premium Navigation Loaded ✨', 'color: #8b5cf6; font-size: 14px; font-weight: bold;');
    console.log('%c🔹 Features: Collapsible • Submenus • Mobile Responsive • Dark Mode Ready', 'color: #a78bfa; font-size: 12px;');
    console.log('%c🔹 All links are dynamic with real data counts', 'color: #6366f1; font-size: 12px;');
</script>