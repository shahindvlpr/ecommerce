<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Vendor Panel') - EktaMart</title>

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Font Awesome 6 --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --sidebar-width: 260px;
            --sidebar-collapsed: 0px;
            --header-height: 64px;
            --primary-color: #4f46e5;
            --primary-dark: #4338ca;
        }

        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            background: #f1f5f9;
            overflow-x: hidden;
            margin: 0;
            padding: 0;
        }

        /* ============================================================ */
        /* SIDEBAR */
        /* ============================================================ */
        #sidebar-wrapper {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(180deg, #1e1b4b 0%, #312e81 100%);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1050;
            overflow-y: auto;
            overflow-x: hidden;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.1);
        }

        /* ✅ Sidebar Collapsed State */
        #sidebar-wrapper.collapsed {
            width: 0;
            overflow: hidden;
            padding: 0;
            margin: 0;
            box-shadow: none;
        }

        #sidebar-wrapper::-webkit-scrollbar {
            width: 4px;
        }

        #sidebar-wrapper::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }

        #sidebar-wrapper::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 4px;
        }

        /* Sidebar Brand */
        .sidebar-brand {
            padding: 1.25rem 1.25rem;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .sidebar-brand h4 {
            color: white;
            font-weight: 800;
            margin: 0;
            font-size: 20px;
            letter-spacing: -0.5px;
        }

        .sidebar-brand h4 span {
            color: #818cf8;
        }

        .sidebar-brand small {
            color: rgba(255, 255, 255, 0.4);
            font-size: 10px;
            display: block;
            margin-top: 2px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        /* Sidebar User */
        .sidebar-user {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar-user .avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: linear-gradient(135deg, #4f46e5, #818cf8);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 16px;
            flex-shrink: 0;
        }

        .sidebar-user .info {
            flex: 1;
            min-width: 0;
        }

        .sidebar-user .info .name {
            color: white;
            font-weight: 600;
            font-size: 14px;
            display: block;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sidebar-user .info .role {
            color: rgba(255, 255, 255, 0.5);
            font-size: 11px;
            display: block;
        }

        .sidebar-user .badge-status {
            background: #10b981;
            color: white;
            font-size: 9px;
            padding: 2px 10px;
            border-radius: 20px;
            font-weight: 500;
            flex-shrink: 0;
        }

        /* Sidebar Navigation */
        .sidebar-nav {
            padding: 0.75rem 0;
        }

        .sidebar-nav .nav-section {
            padding: 0.75rem 1.25rem 0.4rem;
            color: rgba(255, 255, 255, 0.25);
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-weight: 700;
        }

        .sidebar-nav .nav-item {
            margin: 1px 8px;
        }

        .sidebar-nav .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.6rem 1rem;
            color: rgba(255, 255, 255, 0.6);
            border-radius: 10px;
            text-decoration: none;
            transition: all 0.2s ease;
            font-size: 14px;
            font-weight: 500;
            position: relative;
            white-space: nowrap;
        }

        .sidebar-nav .nav-link:hover {
            background: rgba(255, 255, 255, 0.08);
            color: white;
            transform: translateX(4px);
        }

        .sidebar-nav .nav-link.active {
            background: rgba(79, 70, 229, 0.3);
            color: white;
            box-shadow: 0 2px 8px rgba(79, 70, 229, 0.2);
        }

        .sidebar-nav .nav-link i {
            width: 20px;
            text-align: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        .sidebar-nav .nav-link .badge {
            margin-left: auto;
            background: #ef4444;
            color: white;
            font-size: 10px;
            padding: 2px 8px;
            border-radius: 20px;
            font-weight: 600;
        }

        .sidebar-nav .nav-link .arrow {
            margin-left: auto;
            transition: transform 0.3s ease;
            font-size: 12px;
        }

        .sidebar-nav .nav-link.collapsed .arrow {
            transform: rotate(-90deg);
        }

        .sidebar-nav .sub-menu {
            padding-left: 48px;
            list-style: none;
        }

        .sidebar-nav .sub-menu .nav-link {
            padding: 0.35rem 0.8rem;
            font-size: 13px;
            color: rgba(255, 255, 255, 0.45);
        }

        .sidebar-nav .sub-menu .nav-link:hover {
            color: white;
        }

        .sidebar-nav .sub-menu .nav-link.active {
            color: #818cf8;
            background: transparent;
        }

        /* ============================================================ */
        /* PAGE CONTENT */
        /* ============================================================ */
        #page-content-wrapper {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* ✅ When Sidebar is Collapsed */
        #page-content-wrapper.expanded {
            margin-left: 0;
        }

        /* ============================================================ */
        /* NAVBAR */
        /* ============================================================ */
        .vendor-navbar {
            background: white;
            padding: 0 1.5rem;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
            position: sticky;
            top: 0;
            z-index: 1040;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: var(--header-height);
            border-bottom: 1px solid #f1f5f9;
        }

        .vendor-navbar .navbar-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .vendor-navbar .navbar-left .toggle-btn {
            background: none;
            border: none;
            font-size: 20px;
            color: #4b5563;
            cursor: pointer;
            padding: 6px 10px;
            border-radius: 8px;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .vendor-navbar .navbar-left .toggle-btn:hover {
            background: #f3f4f6;
        }

        .vendor-navbar .navbar-left .page-title {
            font-weight: 600;
            font-size: 18px;
            color: #1f2937;
            margin: 0;
        }

        .vendor-navbar .navbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .vendor-navbar .navbar-right .btn-icon {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            border: none;
            background: #f3f4f6;
            color: #4b5563;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            position: relative;
        }

        .vendor-navbar .navbar-right .btn-icon:hover {
            background: #e5e7eb;
        }

        .vendor-navbar .navbar-right .btn-icon .badge-dot {
            position: absolute;
            top: 4px;
            right: 4px;
            width: 8px;
            height: 8px;
            background: #ef4444;
            border-radius: 50%;
            border: 2px solid white;
        }

        .vendor-navbar .navbar-right .dropdown-user {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 4px 12px 4px 4px;
            border-radius: 50px;
            background: #f3f4f6;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            color: #1f2937;
            border: none;
        }

        .vendor-navbar .navbar-right .dropdown-user:hover {
            background: #e5e7eb;
        }

        .vendor-navbar .navbar-right .dropdown-user .avatar-sm {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, #4f46e5, #818cf8);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 12px;
            flex-shrink: 0;
        }

        .vendor-navbar .navbar-right .dropdown-user .user-name {
            font-weight: 500;
            font-size: 13px;
            display: block;
        }

        .vendor-navbar .navbar-right .dropdown-user .user-arrow {
            font-size: 10px;
            color: #6b7280;
        }

        /* Dropdown Menu */
        .dropdown-menu-custom {
            border: none;
            border-radius: 12px;
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12);
            padding: 0.5rem;
            min-width: 200px;
            margin-top: 8px;
        }

        .dropdown-menu-custom .dropdown-item {
            padding: 0.6rem 1rem;
            border-radius: 8px;
            font-size: 14px;
            color: #4b5563;
            transition: all 0.2s ease;
        }

        .dropdown-menu-custom .dropdown-item:hover {
            background: #f3f4f6;
            color: #1f2937;
        }

        .dropdown-menu-custom .dropdown-item i {
            width: 20px;
            margin-right: 10px;
            color: #6b7280;
        }

        .dropdown-menu-custom .dropdown-divider {
            margin: 0.3rem 0;
        }

        /* ============================================================ */
        /* MAIN CONTENT */
        /* ============================================================ */
        .main-content {
            padding: 1.5rem;
        }

        /* ============================================================ */
        /* RESPONSIVE */
        /* ============================================================ */
        @media (max-width: 992px) {
            #sidebar-wrapper {
                transform: translateX(-100%);
                width: var(--sidebar-width);
            }

            #sidebar-wrapper.show {
                transform: translateX(0);
            }

            #sidebar-wrapper.collapsed {
                transform: translateX(-100%);
                width: var(--sidebar-width);
            }

            #page-content-wrapper {
                margin-left: 0 !important;
            }

            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.4);
                z-index: 1049;
            }

            .sidebar-overlay.show {
                display: block;
            }
        }

        @media (max-width: 576px) {
            .vendor-navbar {
                padding: 0.5rem 1rem;
            }

            .vendor-navbar .navbar-left .page-title {
                font-size: 15px;
            }

            .vendor-navbar .navbar-right .dropdown-user .user-name {
                display: none;
            }

            .main-content {
                padding: 1rem;
            }
        }

        /* ============================================================ */
        /* TOAST */
        /* ============================================================ */
        .toast-container-custom {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 99999;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .toast-custom {
            padding: 14px 24px;
            border-radius: 12px;
            color: white;
            font-weight: 500;
            font-size: 14px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
            animation: slideInRight 0.3s ease;
            max-width: 400px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .toast-custom.success { background: #10b981; }
        .toast-custom.error { background: #ef4444; }
        .toast-custom.warning { background: #f59e0b; }
        .toast-custom.info { background: #3b82f6; }

        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(100px); }
            to { opacity: 1; transform: translateX(0); }
        }
    </style>

    @stack('styles')
</head>
<body>

    {{-- Sidebar Overlay (Mobile) --}}
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div id="wrapper">
        {{-- Sidebar --}}
        @include('vendor.layouts.sidebar')

        {{-- Page Content --}}
        <div id="page-content-wrapper">
            {{-- Navbar --}}
            @include('vendor.layouts.navbar')

            {{-- Main Content --}}
            <div class="main-content">
                @yield('content')
            </div>
        </div>
    </div>

    {{-- Toast Container --}}
    <div class="toast-container-custom" id="toastContainer"></div>

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        // ============================================================
        // ✅ SIDEBAR TOGGLE - CORRECTED
        // ============================================================
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar-wrapper');
            const content = document.getElementById('page-content-wrapper');
            const overlay = document.getElementById('sidebarOverlay');
            const toggleBtn = document.getElementById('sidebarToggle');

            // Check if sidebar was collapsed before (localStorage)
            const isCollapsed = localStorage.getItem('vendor_sidebar_collapsed') === 'true';
            if (isCollapsed && window.innerWidth > 992) {
                sidebar.classList.add('collapsed');
                content.classList.add('expanded');
            }

            toggleBtn?.addEventListener('click', function() {
                const isMobile = window.innerWidth <= 992;

                if (isMobile) {
                    // Mobile: Toggle show/hide
                    sidebar.classList.toggle('show');
                    overlay.classList.toggle('show');
                } else {
                    // Desktop: Toggle collapse/expand
                    sidebar.classList.toggle('collapsed');
                    content.classList.toggle('expanded');

                    // Save state to localStorage
                    const collapsed = sidebar.classList.contains('collapsed');
                    localStorage.setItem('vendor_sidebar_collapsed', collapsed);
                }
            });

            // Close sidebar on overlay click (mobile)
            overlay?.addEventListener('click', function() {
                sidebar.classList.remove('show');
                this.classList.remove('show');
            });

            // Handle window resize
            window.addEventListener('resize', function() {
                const isMobile = window.innerWidth <= 992;

                if (isMobile) {
                    // On mobile, remove collapsed state and reset
                    sidebar.classList.remove('collapsed');
                    content.classList.remove('expanded');
                    sidebar.classList.remove('show');
                    overlay.classList.remove('show');
                } else {
                    // On desktop, apply saved state
                    const collapsed = localStorage.getItem('vendor_sidebar_collapsed') === 'true';
                    if (collapsed) {
                        sidebar.classList.add('collapsed');
                        content.classList.add('expanded');
                    } else {
                        sidebar.classList.remove('collapsed');
                        content.classList.remove('expanded');
                    }
                    // Hide overlay if visible
                    overlay.classList.remove('show');
                }
            });
        });

        // ============================================================
        // TOAST NOTIFICATION
        // ============================================================
        window.showToast = function(message, type = 'success') {
            const container = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            toast.className = `toast-custom ${type}`;

            const icons = {
                success: 'fa-check-circle',
                error: 'fa-exclamation-circle',
                warning: 'fa-exclamation-triangle',
                info: 'fa-info-circle'
            };

            toast.innerHTML = `<i class="fas ${icons[type] || 'fa-check-circle'} me-2"></i> ${message}`;
            container.appendChild(toast);

            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transition = 'opacity 0.3s ease';
                setTimeout(() => toast.remove(), 300);
            }, 4000);
        };

        // ============================================================
        // CONSOLE DEBUG
        // ============================================================
        console.log('%c🏪 Vendor Panel Loaded', 'color: #4f46e5; font-size: 16px; font-weight: bold;');
        console.log(`%c👤 Welcome, {{ Auth::user()->name ?? 'Vendor' }}`, 'color: #6b7280; font-size: 12px;');
        console.log('💡 Tip: Click the hamburger icon to toggle sidebar');
    </script>

    @stack('scripts')
</body>
</html>