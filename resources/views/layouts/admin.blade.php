<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel - EktaMart')</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        /* ============================================================
           ROOT VARIABLES
        ============================================================ */
        :root {
            --primary: #8b5cf6;
            --primary-dark: #7c3aed;
            --primary-light: #a78bfa;
            --secondary: #6366f1;
            --bg-body: #f0f2f5;
            --bg-card: #ffffff;
            --text-primary: #1a1a2e;
            --text-secondary: #64748b;
            --text-muted: #94a3b8;
            --border-color: rgba(0, 0, 0, 0.06);
            --shadow-sm: 0 2px 12px rgba(0, 0, 0, 0.04);
            --shadow-md: 0 4px 20px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 8px 40px rgba(0, 0, 0, 0.1);
            --radius-sm: 0.75rem;
            --radius-md: 1rem;
            --radius-lg: 1.25rem;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background: var(--bg-body);
            min-height: 100vh;
            display: flex;
        }
        
        /* ============================================================
           SIDEBAR - GLASSMORPHISM
        ============================================================ */
        .admin-sidebar {
            width: 250px;
            background: linear-gradient(180deg, #0f0c29 0%, #1a1730 50%, #1a1a3e 100%);
            color: #fff;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            overflow-y: auto;
            padding: 1.2rem 0.8rem;
            z-index: 1000;
            transition: all 0.3s ease;
            border-right: 1px solid rgba(255, 255, 255, 0.04);
        }
        .admin-sidebar::-webkit-scrollbar {
            width: 3px;
        }
        .admin-sidebar::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 10px;
        }
        
        .admin-sidebar .brand {
            font-size: 1.1rem;
            font-weight: 700;
            padding: 0 0.5rem 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            margin-bottom: 1rem;
        }
        .admin-sidebar .brand i {
            color: var(--primary);
            font-size: 1.3rem;
        }
        .admin-sidebar .brand small {
            display: block;
            font-size: 0.6rem;
            color: #7F77DD;
            font-weight: 400;
            letter-spacing: 0.5px;
            margin-top: 2px;
        }
        
        .admin-sidebar .nav-section {
            font-size: 0.6rem;
            text-transform: uppercase;
            color: #7F77DD;
            padding: 0.6rem 0.8rem 0.3rem;
            letter-spacing: 1.2px;
            font-weight: 700;
        }
        
        .admin-sidebar .nav-link {
            color: #9896b0;
            padding: 0.5rem 0.8rem;
            border-radius: 8px;
            transition: var(--transition);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.85rem;
            font-weight: 500;
            margin: 2px 0;
            position: relative;
        }
        .admin-sidebar .nav-link:hover {
            color: #e2e0f0;
            background: rgba(255, 255, 255, 0.04);
        }
        .admin-sidebar .nav-link.active {
            color: #CECBF6;
            background: rgba(139, 92, 246, 0.15);
        }
        .admin-sidebar .nav-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 24px;
            background: linear-gradient(180deg, #8b5cf6, #6366f1);
            border-radius: 0 4px 4px 0;
        }
        .admin-sidebar .nav-link i {
            width: 18px;
            font-size: 0.9rem;
            text-align: center;
        }
        
        .admin-sidebar .logout-btn {
            margin-top: auto;
            padding-top: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
        }
        .admin-sidebar .logout-btn button {
            color: #9896b0;
            padding: 0.5rem 0.8rem;
            border-radius: 8px;
            transition: var(--transition);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.85rem;
            font-weight: 500;
            background: none;
            border: none;
            width: 100%;
            cursor: pointer;
        }
        .admin-sidebar .logout-btn button:hover {
            color: #f87171;
            background: rgba(239, 68, 68, 0.08);
        }
        

        
        /* ============================================================
           MAIN CONTENT
        ============================================================ */
        .main-content {
            margin-left: 250px;
            padding-top: 75px;
            padding-left: 24px;
            padding-right: 24px;
            padding-bottom: 24px;
            min-height: 100vh;
            background: var(--bg-body);
            width: 100%;
        }
        
        /* ============================================================
           STATS CARDS - COMPACT & PREMIUM
        ============================================================ */
        .stat-card {
            background: var(--bg-card);
            border-radius: var(--radius-md);
            padding: 1rem 1.2rem;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-color);
            transition: var(--transition);
            height: 100%;
            position: relative;
            overflow: hidden;
        }
        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
        }
        .stat-card .stat-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
        }
        .stat-card .stat-value {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--text-primary);
            line-height: 1.2;
        }
        .stat-card .stat-label {
            color: var(--text-secondary);
            font-size: 0.7rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        .stat-card .stat-change {
            font-size: 0.6rem;
            font-weight: 600;
            padding: 0.1rem 0.5rem;
            border-radius: 2rem;
            display: inline-block;
        }
        .stat-card .stat-change.up {
            background: #dcfce7;
            color: #16a34a;
        }
        .stat-card .stat-change.down {
            background: #fee2e2;
            color: #dc2626;
        }
        .stat-card .stat-decoration {
            position: absolute;
            right: -5px;
            bottom: -5px;
            font-size: 3rem;
            opacity: 0.04;
            pointer-events: none;
        }
        
        /* Stat Card Colors */
        .stat-icon.purple { background: rgba(139, 92, 246, 0.12); color: #8b5cf6; }
        .stat-icon.green { background: rgba(16, 185, 129, 0.12); color: #10b981; }
        .stat-icon.orange { background: rgba(245, 158, 11, 0.12); color: #f59e0b; }
        .stat-icon.blue { background: rgba(59, 130, 246, 0.12); color: #3b82f6; }
        .stat-icon.red { background: rgba(239, 68, 68, 0.12); color: #ef4444; }
        .stat-icon.pink { background: rgba(236, 72, 153, 0.12); color: #ec4899; }
        
        /* ============================================================
           TABLE
        ============================================================ */
        .table-premium {
            border-radius: var(--radius-md);
            overflow: hidden;
        }
        .table-premium thead {
            background: #f8fafc;
        }
        .table-premium thead th {
            font-weight: 600;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-secondary);
            padding: 0.6rem 1rem;
            border-bottom: 2px solid var(--border-color);
        }
        .table-premium tbody td {
            padding: 0.6rem 1rem;
            color: var(--text-primary);
            vertical-align: middle;
            font-size: 0.85rem;
        }
        .table-premium tbody tr {
            transition: var(--transition);
        }
        .table-premium tbody tr:hover {
            background: rgba(139, 92, 246, 0.03);
        }
        
        /* ============================================================
           BADGE
        ============================================================ */
        .badge-premium {
            padding: 0.2rem 0.7rem;
            border-radius: 2rem;
            font-weight: 600;
            font-size: 0.65rem;
        }
        .badge-premium.bg-pending { background: #fef3c7; color: #d97706; }
        .badge-premium.bg-processing { background: #dbeafe; color: #2563eb; }
        .badge-premium.bg-delivered { background: #dcfce7; color: #16a34a; }
        .badge-premium.bg-cancelled { background: #fee2e2; color: #dc2626; }
        
        /* ============================================================
           RESPONSIVE
        ============================================================ */
        @media (max-width: 992px) {
            .admin-navbar {
                left: 0;
            }
            .main-content {
                margin-left: 0;
                padding-top: 70px;
                padding-left: 16px;
                padding-right: 16px;
            }
        }
        
        @media (max-width: 768px) {
            .admin-sidebar {
                transform: translateX(-100%);
                width: 280px;
            }
            .admin-sidebar.open {
                transform: translateX(0);
            }
            .admin-navbar {
                left: 0;
                padding: 0.5rem 1rem;
                height: 56px;
            }
            .main-content {
                padding-top: 64px;
                padding-left: 12px;
                padding-right: 12px;
                padding-bottom: 12px;
            }
            .admin-navbar .user-info span {
                display: none;
            }
            .stat-card .stat-value {
                font-size: 1.1rem;
            }
        }
        
        @media (max-width: 576px) {
            .admin-navbar .navbar-title {
                font-size: 0.85rem;
            }
            .stat-card {
                padding: 0.8rem;
            }
            .stat-card .stat-value {
                font-size: 1rem;
            }
            .stat-card .stat-icon {
                width: 32px;
                height: 32px;
                font-size: 0.8rem;
            }
        }
        
        /* ============================================================
           DARK MODE SUPPORT
        ============================================================ */
        [data-theme="dark"] {
            --bg-body: #0f0c29;
            --bg-card: #1a1a3e;
            --text-primary: #f1f5f9;
            --text-secondary: #94a3b8;
            --text-muted: #64748b;
            --border-color: rgba(255, 255, 255, 0.06);
            --shadow-sm: 0 2px 12px rgba(0, 0, 0, 0.3);
            --shadow-md: 0 4px 20px rgba(0, 0, 0, 0.4);
        }
        [data-theme="dark"] .admin-navbar {
            background: rgba(26, 23, 48, 0.9);
            border-bottom-color: rgba(255, 255, 255, 0.06);
        }
        [data-theme="dark"] .table-premium thead {
            background: #2d2a4a;
        }
        [data-theme="dark"] .table-premium thead th {
            color: #7F77DD;
        }
        [data-theme="dark"] .table-premium tbody td {
            color: #e2e0f0;
            border-color: rgba(255, 255, 255, 0.04);
        }
        [data-theme="dark"] .table-premium tbody tr:hover {
            background: rgba(139, 92, 246, 0.05);
        }
        
        /* ============================================================
           UTILITY
        ============================================================ */
        .shadow-premium {
            box-shadow: var(--shadow-sm);
        }
        .shadow-premium:hover {
            box-shadow: var(--shadow-md);
        }
        .transition-premium {
            transition: var(--transition);
        }
        .text-purple-600 {
            color: #8b5cf6;
        }
        .bg-purple-50 {
            background: #f5f3ff;
        }
        .gap-2 {
            gap: 0.5rem;
        }
        .gap-3 {
            gap: 1rem;
        }
        .gap-4 {
            gap: 1.5rem;
        }
        
        /* Dark Mode Toggle Button */
        .theme-toggle {
            position: fixed;
            bottom: 25px;
            right: 25px;
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: linear-gradient(135deg, #8b5cf6, #6366f1);
            color: #fff;
            border: none;
            box-shadow: var(--shadow-lg);
            cursor: pointer;
            z-index: 999;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }
        .theme-toggle:hover {
            transform: scale(1.1) rotate(15deg);
        }
    </style>
</head>
<body>

    {{-- ============================================================
         SIDEBAR
    ============================================================ --}}
    <div class="admin-sidebar" id="adminSidebar">
        <div class="brand">
            <i class="fas fa-crown me-2"></i>EktaMart
            <small>Admin Panel</small>
        </div>
        
        <div class="nav-section">Main</div>
        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-th-large"></i> Dashboard
        </a>
        <a href="{{ route('admin.analytics') }}" class="nav-link {{ request()->routeIs('admin.analytics') ? 'active' : '' }}">
            <i class="fas fa-chart-bar"></i> Analytics
        </a>
        
        <div class="nav-section">Catalogue</div>
        <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
            <i class="fas fa-layer-group"></i> Categories
        </a>
        <a href="{{ route('admin.brands.index') }}" class="nav-link {{ request()->routeIs('admin.brands.*') ? 'active' : '' }}">
            <i class="fas fa-tag"></i> Brands
        </a>
        <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
            <i class="fas fa-box"></i> Products
        </a>
        <a href="{{ route('admin.attributes.index') }}" class="nav-link {{ request()->routeIs('admin.attributes.*') ? 'active' : '' }}">
            <i class="fas fa-list-check"></i> Attributes
        </a>
        
        <div class="nav-section">Sales</div>
        <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
            <i class="fas fa-shopping-bag"></i> Orders
        </a>
        <a href="{{ route('admin.payments.index') }}" class="nav-link {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
            <i class="fas fa-credit-card"></i> Payments
        </a>
        
        <div class="nav-section">Users</div>
        <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <i class="fas fa-users"></i> Users
        </a>
        <a href="{{ route('admin.vendors.index') }}" class="nav-link {{ request()->routeIs('admin.vendors.*') ? 'active' : '' }}">
            <i class="fas fa-store"></i> Vendors
        </a>
        
        <div class="nav-section">System</div>
        <a href="{{ route('admin.notifications.index') }}" class="nav-link {{ request()->routeIs('admin.notifications.*') ? 'active' : '' }}">
            <i class="fas fa-bell"></i> Notifications
        </a>
        <a href="{{ route('admin.settings.index') }}" class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
            <i class="fas fa-cog"></i> Settings
        </a>
        <a href="{{ route('admin.reports.sales') }}" class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
            <i class="fas fa-chart-line"></i> Reports
        </a>
        
        <div class="logout-btn">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </div>
    </div>

    {{-- ============================================================
         NAVBAR
    ============================================================ --}}
    @include('layouts.admin.navbar')

    {{-- ============================================================
         sidebar
    ============================================================ }}
    
    @include('layouts.admin.sidebar')




    {{-- ============================================================
         MAIN CONTENT
    ============================================================ --}}
    <div class="main-content" id="mainContent">
        @yield('content')
    </div>

    {{-- ============================================================
         DARK MODE TOGGLE
    ============================================================ --}}
    <button class="theme-toggle" id="themeToggle" title="Toggle Dark Mode">
        <i class="fas fa-moon" id="themeIcon"></i>
    </button>

    {{-- ============================================================
         SCRIPTS
    ============================================================ --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // ============================================================
        // DARK MODE TOGGLE
        // ============================================================
        document.addEventListener('DOMContentLoaded', function() {
            const themeToggle = document.getElementById('themeToggle');
            const themeIcon = document.getElementById('themeIcon');
            
            // Check saved theme
            const savedTheme = localStorage.getItem('adminTheme') || 'light';
            document.documentElement.setAttribute('data-theme', savedTheme);
            updateThemeIcon(savedTheme);
            
            if (themeToggle) {
                themeToggle.addEventListener('click', function() {
                    const currentTheme = document.documentElement.getAttribute('data-theme');
                    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                    
                    document.documentElement.setAttribute('data-theme', newTheme);
                    localStorage.setItem('adminTheme', newTheme);
                    updateThemeIcon(newTheme);
                    
                    // Animation
                    this.style.transform = 'scale(0.8)';
                    setTimeout(() => {
                        this.style.transform = 'scale(1)';
                    }, 200);
                });
            }
            
            function updateThemeIcon(theme) {
                if (theme === 'dark') {
                    themeIcon.className = 'fas fa-sun';
                    themeToggle.style.background = 'linear-gradient(135deg, #f59e0b, #f97316)';
                } else {
                    themeIcon.className = 'fas fa-moon';
                    themeToggle.style.background = 'linear-gradient(135deg, #8b5cf6, #6366f1)';
                }
            }
        });

        // ============================================================
        // MOBILE SIDEBAR TOGGLE
        // ============================================================
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('adminSidebar');
            
            // Close sidebar on outside click (mobile)
            document.addEventListener('click', function(e) {
                if (window.innerWidth <= 768) {
                    if (sidebar && !sidebar.contains(e.target) && !e.target.closest('.navbar-toggler') && !e.target.closest('.sidebar-toggle')) {
                        sidebar.classList.remove('open');
                    }
                }
            });
        });
        
        function toggleSidebar() {
            const sidebar = document.getElementById('adminSidebar');
            if (sidebar) {
                sidebar.classList.toggle('open');
            }
        }

        // ============================================================
        // CONSOLE GREETING
        // ============================================================
        console.log('%c✨ EktaMart Admin Panel v3.0 ✨', 'color: #8b5cf6; font-size: 18px; font-weight: bold;');
        console.log('%c🚀 Glassmorphism • Dark Mode • Fully Responsive', 'color: #6366f1; font-size: 13px;');
        console.log('%c💡 Click the moon/sun icon for dark mode!', 'color: #10b981; font-size: 12px;');
    </script>
</body>
</html>