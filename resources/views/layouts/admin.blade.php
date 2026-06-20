<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', 'EktaMart Admin Panel')">
    <title>@yield('title', 'Admin Panel - EktaMart')</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts - Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        /* ============================================================
           ROOT VARIABLES
        ============================================================ */
        :root {
            --primary: #8B5CF6;
            --primary-dark: #7C3AED;
            --primary-light: #A78BFA;
            --secondary: #6366F1;
            --success: #10B981;
            --danger: #EF4444;
            --warning: #F59E0B;
            --info: #3B82F6;

            --sidebar-width: 260px;
            --sidebar-collapsed: 72px;
            --navbar-height: 64px;

            --bg-body: #F8FAFC;
            --bg-card: #FFFFFF;
            --bg-sidebar: #0F0C29;

            --text-primary: #1A1A2E;
            --text-secondary: #475569;
            --text-muted: #94A3B8;
            --text-white: #FFFFFF;

            --border-color: #E2E8F0;
            --border-light: rgba(255, 255, 255, 0.06);

            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.04);
            --shadow-md: 0 4px 20px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 8px 40px rgba(0, 0, 0, 0.1);
            --shadow-xl: 0 12px 60px rgba(0, 0, 0, 0.15);

            --radius-sm: 0.5rem;
            --radius-md: 0.75rem;
            --radius-lg: 1rem;
            --radius-xl: 1.25rem;

            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --transition-slow: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);

            --font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        /* ============================================================
           DARK MODE
        ============================================================ */
        [data-theme="dark"] {
            --bg-body: #0F0C29;
            --bg-card: #1A1A3E;
            --text-primary: #F1F5F9;
            --text-secondary: #94A3B8;
            --text-muted: #64748B;
            --border-color: rgba(255, 255, 255, 0.06);
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.2);
            --shadow-md: 0 4px 20px rgba(0, 0, 0, 0.3);
            --shadow-lg: 0 8px 40px rgba(0, 0, 0, 0.4);
            --shadow-xl: 0 12px 60px rgba(0, 0, 0, 0.5);
            --bg-sidebar: #0F0C29;
        }

        /* ============================================================
           GLOBAL RESET
        ============================================================ */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-family);
            background: var(--bg-body);
            color: var(--text-primary);
            min-height: 100vh;
            transition: background 0.3s ease;
        }

        /* ============================================================
           SCROLLBAR
        ============================================================ */
        ::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }
        ::-webkit-scrollbar-track {
            background: var(--bg-body);
        }
        ::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-dark);
        }

        /* ============================================================
           UTILITY CLASSES
        ============================================================ */
        .text-primary-custom { color: var(--primary); }
        .bg-primary-custom { background: var(--primary); }
        .border-primary-custom { border-color: var(--primary); }

        .shadow-premium { box-shadow: var(--shadow-sm); }
        .shadow-premium:hover { box-shadow: var(--shadow-md); }

        .rounded-premium { border-radius: var(--radius-lg); }
        .rounded-premium-sm { border-radius: var(--radius-sm); }

        .transition-premium { transition: var(--transition); }

        .gap-2 { gap: 0.5rem; }
        .gap-3 { gap: 1rem; }
        .gap-4 { gap: 1.5rem; }

        /* ============================================================
           ANIMATIONS
        ============================================================ */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(20px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        @keyframes shimmer {
            0% { background-position: -1000px 0; }
            100% { background-position: 1000px 0; }
        }

        .animate-fade-in { animation: fadeIn 0.4s ease-out forwards; }
        .animate-slide-right { animation: slideInRight 0.3s ease-out forwards; }
        .animate-slide-down { animation: slideDown 0.3s ease-out forwards; }
        .animate-pulse { animation: pulse 2s ease-in-out infinite; }

        /* ============================================================
           MAIN CONTENT
        ============================================================ */
        .main-content {
            margin-left: var(--sidebar-width);
            padding-top: var(--navbar-height);
            min-height: 100vh;
            background: var(--bg-body);
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .main-content.expanded {
            margin-left: var(--sidebar-collapsed);
        }

        .content-wrapper {
            padding: 24px 28px 28px 28px;
            animation: fadeIn 0.4s ease-out;
        }

        /* ============================================================
           RESPONSIVE
        ============================================================ */
        @media (max-width: 992px) {
            .main-content {
                margin-left: 0 !important;
            }
            .content-wrapper {
                padding: 16px 16px 20px 16px;
            }
        }

        @media (max-width: 768px) {
            .content-wrapper {
                padding: 12px 12px 16px 12px;
            }
        }

        @media (max-width: 576px) {
            .content-wrapper {
                padding: 8px 8px 12px 8px;
            }
        }

        /* ============================================================
           THEME TOGGLE BUTTON
        ============================================================ */
        .theme-toggle-btn {
            position: fixed;
            bottom: 28px;
            right: 28px;
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: var(--primary);
            color: #fff;
            border: none;
            box-shadow: var(--shadow-lg);
            cursor: pointer;
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            transition: var(--transition);
        }
        .theme-toggle-btn:hover {
            transform: scale(1.1) rotate(20deg);
            box-shadow: 0 8px 35px rgba(139, 92, 246, 0.4);
        }

        @media (max-width: 768px) {
            .theme-toggle-btn {
                bottom: 16px;
                right: 16px;
                width: 38px;
                height: 38px;
                font-size: 1rem;
            }
        }
    </style>

    @stack('styles')
</head>
<body>

    {{-- Sidebar --}}
    @include('layouts.admin.sidebar')

    {{-- Navbar --}}
    @include('layouts.admin.navbar')

    {{-- Main Content --}}
    <div class="main-content" id="mainContent">
        <div class="content-wrapper">
            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show animate-slide-down" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show animate-slide-down" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('warning'))
                <div class="alert alert-warning alert-dismissible fade show animate-slide-down" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i> {{ session('warning') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('info'))
                <div class="alert alert-info alert-dismissible fade show animate-slide-down" role="alert">
                    <i class="fas fa-info-circle me-2"></i> {{ session('info') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Page Content --}}
            @yield('content')
        </div>
    </div>

    {{-- Theme Toggle --}}
    <button class="theme-toggle-btn" id="themeToggle" title="Toggle Theme">
        <i class="fas fa-moon" id="themeIcon"></i>
    </button>

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // ============================================================
        // THEME TOGGLE
        // ============================================================
        (function() {
            const toggle = document.getElementById('themeToggle');
            const icon = document.getElementById('themeIcon');
            const html = document.documentElement;

            const savedTheme = localStorage.getItem('adminTheme') || 'light';
            html.setAttribute('data-theme', savedTheme);
            updateIcon(savedTheme);

            toggle?.addEventListener('click', function() {
                const current = html.getAttribute('data-theme');
                const next = current === 'dark' ? 'light' : 'dark';

                html.setAttribute('data-theme', next);
                localStorage.setItem('adminTheme', next);
                updateIcon(next);

                this.style.transform = 'scale(0.8)';
                setTimeout(() => {
                    this.style.transform = 'scale(1)';
                }, 200);
            });

            function updateIcon(theme) {
                if (!icon) return;
                if (theme === 'dark') {
                    icon.className = 'fas fa-sun';
                    toggle.style.background = 'linear-gradient(135deg, #F59E0B, #F97316)';
                } else {
                    icon.className = 'fas fa-moon';
                    toggle.style.background = 'linear-gradient(135deg, #8B5CF6, #6366F1)';
                }
            }
        })();

        // ============================================================
        // SIDEBAR TOGGLE
        // ============================================================
        function toggleSidebar() {
            const sidebar = document.getElementById('adminSidebar');
            const main = document.getElementById('mainContent');
            const navbar = document.getElementById('adminNavbar');

            if (!sidebar) return;

            const isCollapsed = sidebar.classList.toggle('collapsed');

            if (main) {
                main.classList.toggle('expanded', isCollapsed);
            }

            if (navbar) {
                navbar.classList.toggle('sidebar-collapsed', isCollapsed);
            }

            localStorage.setItem('sidebarCollapsed', isCollapsed);
            window.dispatchEvent(new CustomEvent('sidebarToggled', {
                detail: { collapsed: isCollapsed }
            }));
        }

        // Load saved sidebar state
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('adminSidebar');
            const main = document.getElementById('mainContent');
            const navbar = document.getElementById('adminNavbar');
            const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';

            if (sidebar && isCollapsed) {
                sidebar.classList.add('collapsed');
                if (main) main.classList.add('expanded');
                if (navbar) navbar.classList.add('sidebar-collapsed');
            }
        });

        // ============================================================
        // GLOBAL TOAST NOTIFICATION
        // ============================================================
        window.showToast = function(message, type = 'success') {
            const colors = {
                success: '#10B981',
                error: '#EF4444',
                warning: '#F59E0B',
                info: '#3B82F6'
            };
            const icons = {
                success: 'check-circle',
                error: 'exclamation-circle',
                warning: 'exclamation-triangle',
                info: 'info-circle'
            };

            const toast = document.createElement('div');
            toast.style.cssText = `
                position: fixed;
                top: 80px;
                right: 24px;
                background: ${colors[type]};
                color: #fff;
                padding: 14px 20px;
                border-radius: 12px;
                box-shadow: 0 8px 30px rgba(0,0,0,0.15);
                z-index: 99999;
                font-family: Inter, sans-serif;
                font-weight: 500;
                font-size: 0.875rem;
                display: flex;
                align-items: center;
                gap: 12px;
                max-width: 400px;
                animation: slideInRight 0.4s ease;
                border: 1px solid rgba(255,255,255,0.15);
            `;
            toast.innerHTML = `
                <i class="fas fa-${icons[type]}"></i>
                <span>${message}</span>
                <button onclick="this.parentElement.remove()" style="
                    background: transparent;
                    border: none;
                    color: #fff;
                    opacity: 0.7;
                    cursor: pointer;
                    margin-left: auto;
                    font-size: 1.1rem;
                    padding: 4px;
                ">
                    <i class="fas fa-times"></i>
                </button>
            `;
            document.body.appendChild(toast);

            setTimeout(() => {
                if (toast.parentElement) {
                    toast.style.opacity = '0';
                    toast.style.transform = 'translateX(100px)';
                    toast.style.transition = 'all 0.3s ease';
                    setTimeout(() => toast.remove(), 300);
                }
            }, 4000);
        };

        // ============================================================
        // CONSOLE GREETING
        // ============================================================
        console.log('%c✨ EktaMart Admin Panel v3.0', 'color: #8B5CF6; font-size: 18px; font-weight: bold;');
        console.log('%c🚀 Premium Dashboard • Dark/Light Mode • Fully Responsive', 'color: #6366F1; font-size: 13px;');
        console.log('%c💡 Tip: Click the sidebar toggle to collapse/expand sidebar', 'color: #10B981; font-size: 12px;');
    </script>

    @stack('scripts')
</body>
</html>