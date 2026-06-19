{{-- resources/views/layouts/admin.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - EktaMart</title>
    
    <!-- Bootstrap 5 CSS -->
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
            --gradient-primary: linear-gradient(135deg, #8b5cf6 0%, #6366f1 100%);
            --gradient-secondary: linear-gradient(135deg, #a855f7 0%, #ec4899 100%);
            --bg-body: #f0f2f5;
            --bg-card: #ffffff;
            --text-primary: #1a1a2e;
            --text-secondary: #64748b;
            --text-muted: #94a3b8;
            --border-color: rgba(0, 0, 0, 0.06);
            --shadow-sm: 0 2px 12px rgba(0, 0, 0, 0.04);
            --shadow-md: 0 4px 20px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 8px 40px rgba(0, 0, 0, 0.1);
            --shadow-xl: 0 12px 60px rgba(0, 0, 0, 0.15);
            --radius-sm: 0.75rem;
            --radius-md: 1rem;
            --radius-lg: 1.25rem;
            --radius-xl: 1.5rem;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* ============================================================
           DARK MODE VARIABLES
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
            --shadow-lg: 0 8px 40px rgba(0, 0, 0, 0.5);
        }

        /* ============================================================
           GLOBAL RESET & BASE
        ============================================================ */
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
            transition: var(--transition);
        }
        
        /* ============================================================
           MAIN CONTENT WRAPPER
        ============================================================ */
        .main-content {
            margin-left: 240px;
            transition: var(--transition);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: var(--bg-body);
            width: 100%;
        }
        
        .main-content.expanded {
            margin-left: 80px;
        }
        
        .content-wrapper {
            flex: 1;
            padding: 1.5rem;
            animation: fadeIn 0.4s ease;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* ============================================================
           PAGE HEADER
        ============================================================ */
        .page-header {
            background: var(--bg-card);
            border-radius: var(--radius-lg);
            padding: 1.25rem 1.75rem;
            margin-bottom: 1.5rem;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
            transition: var(--transition);
        }
        
        .page-header:hover {
            box-shadow: var(--shadow-md);
        }
        
        .page-header h4 {
            font-weight: 700;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: var(--text-primary);
        }
        
        .page-header h4 i {
            color: var(--primary);
        }
        
        .page-header .breadcrumb {
            margin: 0;
            background: transparent;
            padding: 0;
        }
        
        .page-header .breadcrumb-item a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
        }
        
        .page-header .breadcrumb-item a:hover {
            color: var(--primary-dark);
        }
        
        .page-header .breadcrumb-item.active {
            color: var(--text-secondary);
            font-weight: 500;
        }
        
        .page-header .header-actions {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            flex-wrap: wrap;
        }
        
        .page-header .header-actions .btn-premium {
            background: var(--gradient-primary);
            color: white;
            border: none;
            border-radius: var(--radius-sm);
            padding: 0.45rem 1.2rem;
            font-weight: 600;
            font-size: 0.85rem;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .page-header .header-actions .btn-premium:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(139, 92, 246, 0.35);
        }
        
        .page-header .header-actions .btn-premium-outline {
            background: transparent;
            color: var(--primary);
            border: 2px solid var(--primary);
            border-radius: var(--radius-sm);
            padding: 0.4rem 1.2rem;
            font-weight: 600;
            font-size: 0.85rem;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .page-header .header-actions .btn-premium-outline:hover {
            background: var(--gradient-primary);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(139, 92, 246, 0.3);
        }
        
        /* ============================================================
           LOADING OVERLAY
        ============================================================ */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 12, 41, 0.7);
            backdrop-filter: blur(8px);
            z-index: 9999;
            display: none;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            gap: 1rem;
        }
        
        .loading-overlay.active {
            display: flex;
        }
        
        .loading-overlay .loading-text {
            color: white;
            font-weight: 500;
            font-size: 1rem;
            letter-spacing: 0.5px;
            animation: pulse-text 1.5s ease-in-out infinite;
        }
        
        @keyframes pulse-text {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        
        .loading-spinner {
            width: 60px;
            height: 60px;
            border: 4px solid rgba(139, 92, 246, 0.15);
            border-top-color: #8b5cf6;
            border-right-color: #6366f1;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        /* ============================================================
           ALERT STYLES
        ============================================================ */
        .alert-premium {
            border: none;
            border-radius: var(--radius-md);
            padding: 1rem 1.25rem;
            font-weight: 500;
            box-shadow: var(--shadow-sm);
            animation: slideDown 0.4s ease;
            border-left: 4px solid transparent;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .alert-premium i {
            font-size: 1.2rem;
        }
        
        .alert-premium.alert-success {
            background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
            color: #166534;
            border-left-color: #10b981;
        }
        
        .alert-premium.alert-danger {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            color: #991b1b;
            border-left-color: #ef4444;
        }
        
        .alert-premium.alert-warning {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            color: #92400e;
            border-left-color: #f59e0b;
        }
        
        .alert-premium.alert-info {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            color: #1e40af;
            border-left-color: #3b82f6;
        }
        
        .alert-premium .alert-close {
            margin-left: auto;
            background: transparent;
            border: none;
            color: inherit;
            opacity: 0.5;
            cursor: pointer;
            transition: var(--transition);
            font-size: 1.2rem;
            padding: 0 0.25rem;
        }
        
        .alert-premium .alert-close:hover {
            opacity: 1;
            transform: scale(1.1);
        }
        
        /* ============================================================
           STATS CARDS
        ============================================================ */
        .stat-card {
            background: var(--bg-card);
            border-radius: var(--radius-md);
            padding: 1.25rem;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-color);
            transition: var(--transition);
            height: 100%;
            position: relative;
            overflow: hidden;
        }
        
        .stat-card:hover {
            box-shadow: var(--shadow-lg);
            transform: translateY(-4px);
        }
        
        .stat-card .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            margin-bottom: 0.75rem;
        }
        
        .stat-card .stat-icon.purple {
            background: rgba(139, 92, 246, 0.12);
            color: #8b5cf6;
        }
        
        .stat-card .stat-icon.green {
            background: rgba(16, 185, 129, 0.12);
            color: #10b981;
        }
        
        .stat-card .stat-icon.orange {
            background: rgba(245, 158, 11, 0.12);
            color: #f59e0b;
        }
        
        .stat-card .stat-icon.blue {
            background: rgba(59, 130, 246, 0.12);
            color: #3b82f6;
        }
        
        .stat-card .stat-icon.red {
            background: rgba(239, 68, 68, 0.12);
            color: #ef4444;
        }
        
        .stat-card .stat-value {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--text-primary);
            line-height: 1.2;
        }
        
        .stat-card .stat-label {
            font-size: 0.85rem;
            color: var(--text-secondary);
            font-weight: 500;
        }
        
        .stat-card .stat-change {
            font-size: 0.7rem;
            font-weight: 600;
            padding: 0.15rem 0.5rem;
            border-radius: 2rem;
            display: inline-block;
            margin-top: 0.25rem;
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
            right: -10px;
            bottom: -10px;
            font-size: 4rem;
            opacity: 0.03;
            pointer-events: none;
        }
        
        /* ============================================================
           TABLE STYLES
        ============================================================ */
        .table-premium {
            background: var(--bg-card);
            border-radius: var(--radius-md);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-color);
        }
        
        .table-premium thead {
            background: var(--bg-body);
        }
        
        .table-premium thead th {
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-secondary);
            padding: 0.75rem 1rem;
            border-bottom: 2px solid var(--border-color);
        }
        
        .table-premium tbody td {
            padding: 0.75rem 1rem;
            color: var(--text-primary);
            vertical-align: middle;
            border-bottom: 1px solid var(--border-color);
        }
        
        .table-premium tbody tr {
            transition: var(--transition);
        }
        
        .table-premium tbody tr:hover {
            background: rgba(139, 92, 246, 0.03);
        }
        
        .table-premium tbody tr:last-child td {
            border-bottom: none;
        }
        
        /* ============================================================
           BADGE STYLES
        ============================================================ */
        .badge-premium {
            padding: 0.25rem 0.75rem;
            border-radius: 2rem;
            font-weight: 600;
            font-size: 0.7rem;
            text-transform: capitalize;
        }
        
        .badge-premium.bg-pending {
            background: #fef3c7;
            color: #d97706;
        }
        
        .badge-premium.bg-processing {
            background: #dbeafe;
            color: #2563eb;
        }
        
        .badge-premium.bg-shipped {
            background: #e0e7ff;
            color: #4f46e5;
        }
        
        .badge-premium.bg-delivered {
            background: #dcfce7;
            color: #16a34a;
        }
        
        .badge-premium.bg-cancelled {
            background: #fee2e2;
            color: #dc2626;
        }
        
        .badge-premium.bg-active {
            background: #dcfce7;
            color: #16a34a;
        }
        
        .badge-premium.bg-inactive {
            background: #fee2e2;
            color: #dc2626;
        }
        
        /* ============================================================
           RESPONSIVE
        ============================================================ */
        @media (max-width: 992px) {
            .main-content {
                margin-left: 0;
            }
            
            .main-content.expanded {
                margin-left: 0;
            }
        }
        
        @media (max-width: 768px) {
            .content-wrapper {
                padding: 0.75rem;
            }
            
            .page-header {
                padding: 1rem 1.25rem;
                flex-direction: column;
                align-items: flex-start;
            }
            
            .page-header h4 {
                font-size: 1.1rem;
            }
            
            .page-header .header-actions {
                width: 100%;
            }
            
            .page-header .header-actions .btn-premium,
            .page-header .header-actions .btn-premium-outline {
                flex: 1;
                justify-content: center;
            }
            
            .stat-card .stat-value {
                font-size: 1.4rem;
            }
        }
        
        @media (max-width: 576px) {
            .content-wrapper {
                padding: 0.5rem;
            }
            
            .page-header {
                padding: 0.75rem 1rem;
                border-radius: var(--radius-sm);
            }
            
            .stat-card {
                padding: 0.9rem;
            }
            
            .stat-card .stat-value {
                font-size: 1.2rem;
            }
            
            .table-premium {
                font-size: 0.8rem;
            }
            
            .table-premium thead th,
            .table-premium tbody td {
                padding: 0.4rem 0.6rem;
            }
        }
        
        /* ============================================================
           UTILITY CLASSES
        ============================================================ */
        .text-purple-600 {
            color: #8b5cf6;
        }
        .text-purple-700 {
            color: #7c3aed;
        }
        .bg-purple-50 {
            background: #f5f3ff;
        }
        .bg-purple-100 {
            background: #ede9fe;
        }
        
        .shadow-premium {
            box-shadow: var(--shadow-sm);
        }
        
        .shadow-premium-hover:hover {
            box-shadow: var(--shadow-lg);
            transform: translateY(-4px);
        }
        
        .transition-premium {
            transition: var(--transition);
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
        
        /* ============================================================
           SCROLLBAR
        ============================================================ */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        
        ::-webkit-scrollbar-track {
            background: var(--bg-body);
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: var(--gradient-primary);
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: var(--gradient-secondary);
        }
        
        /* ============================================================
           DARK MODE TOGGLE
        ============================================================ */
        .theme-toggle {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: var(--gradient-primary);
            color: white;
            border: none;
            box-shadow: var(--shadow-lg);
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
            box-shadow: 0 8px 35px rgba(139, 92, 246, 0.5);
        }
    </style>
    
    @stack('styles')
</head>
<body>

    <!-- ============================================================
         LOADING OVERLAY
    ============================================================ -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
        <p class="loading-text">Loading...</p>
    </div>

    <!-- ============================================================
         INCLUDE SIDEBAR
    ============================================================ -->
    @include('layouts.admin.sidebar')
    
    <!-- ============================================================
         MAIN CONTENT
    ============================================================ -->
    <div class="main-content" id="mainContent">
        
        <!-- ============================================================
             INCLUDE UNIVERSAL NAVBAR (Single Source of Truth)
        ============================================================ -->
        @include('layouts.admin.navbar')
        
        <!-- ============================================================
             PAGE CONTENT
        ============================================================ -->
        <div class="content-wrapper">
            
            <!-- Page Header with Breadcrumb -->
            <div class="page-header">
                <div>
                    <h4>
                        <i class="fas fa-@yield('icon', 'dashboard')"></i>
                        @yield('page-title', 'Dashboard')
                    </h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            @yield('breadcrumb')
                        </ol>
                    </nav>
                </div>
                <div class="header-actions">
                    @yield('header-actions')
                </div>
            </div>
            
            <!-- Flash Messages -->
            @if(session('success'))
                <div class="alert-premium alert-success">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                    <button class="alert-close" onclick="this.parentElement.remove()">&times;</button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert-premium alert-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ session('error') }}
                    <button class="alert-close" onclick="this.parentElement.remove()">&times;</button>
                </div>
            @endif
            
            @if(session('warning'))
                <div class="alert-premium alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    {{ session('warning') }}
                    <button class="alert-close" onclick="this.parentElement.remove()">&times;</button>
                </div>
            @endif
            
            @if(session('info'))
                <div class="alert-premium alert-info">
                    <i class="fas fa-info-circle"></i>
                    {{ session('info') }}
                    <button class="alert-close" onclick="this.parentElement.remove()">&times;</button>
                </div>
            @endif
            
            @yield('content')
        </div>
        
        <!-- ============================================================
             INCLUDE UNIVERSAL FOOTER (Single Source of Truth)
        ============================================================ -->
        @include('layouts.partials.footer')
    </div>

    <!-- ============================================================
         DARK MODE TOGGLE BUTTON
    ============================================================ -->
    <button class="theme-toggle" id="themeToggle" title="Toggle Dark/Light Mode">
        <i class="fas fa-moon" id="themeIcon"></i>
    </button>

    <!-- ============================================================
         SCRIPTS
    ============================================================ -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
        // ============================================================
        // 1. DARK MODE TOGGLE
        // ============================================================
        (function() {
            const themeToggle = document.getElementById('themeToggle');
            const themeIcon = document.getElementById('themeIcon');
            
            // Check saved theme
            const savedTheme = localStorage.getItem('adminTheme') || 'light';
            document.documentElement.setAttribute('data-theme', savedTheme);
            updateThemeIcon(savedTheme);

            themeToggle.addEventListener('click', function() {
                const currentTheme = document.documentElement.getAttribute('data-theme');
                const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                
                document.documentElement.setAttribute('data-theme', newTheme);
                localStorage.setItem('adminTheme', newTheme);
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
                    themeToggle.style.background = 'var(--gradient-primary)';
                }
            }
        })();

        // ============================================================
        // 2. SIDEBAR TOGGLE SYNC
        // ============================================================
        (function() {
            const sidebar = document.getElementById('adminSidebar');
            const mainContent = document.getElementById('mainContent');
            
            function syncSidebarState() {
                const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
                if (isCollapsed) {
                    if (sidebar) sidebar.classList.add('collapsed');
                    if (mainContent) mainContent.classList.add('expanded');
                } else {
                    if (sidebar) sidebar.classList.remove('collapsed');
                    if (mainContent) mainContent.classList.remove('expanded');
                }
            }
            
            syncSidebarState();
            
            window.addEventListener('storage', function(e) {
                if (e.key === 'sidebarCollapsed') {
                    const isCollapsed = e.newValue === 'true';
                    if (isCollapsed) {
                        sidebar?.classList.add('collapsed');
                        mainContent?.classList.add('expanded');
                    } else {
                        sidebar?.classList.remove('collapsed');
                        mainContent?.classList.remove('expanded');
                    }
                }
            });
            
            window.addEventListener('sidebarToggled', function(e) {
                const isCollapsed = e.detail?.collapsed || false;
                if (isCollapsed) {
                    mainContent?.classList.add('expanded');
                } else {
                    mainContent?.classList.remove('expanded');
                }
            });
        })();

        // ============================================================
        // 3. LOADING OVERLAY ON FORM SUBMIT
        // ============================================================
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', function() {
                    const overlay = document.getElementById('loadingOverlay');
                    if (overlay) {
                        overlay.classList.add('active');
                        setTimeout(() => {
                            overlay.classList.remove('active');
                        }, 10000);
                    }
                });
            });
            
            // Also show loading on AJAX requests
            $(document).ajaxStart(function() {
                const overlay = document.getElementById('loadingOverlay');
                if (overlay) overlay.classList.add('active');
            });
            
            $(document).ajaxStop(function() {
                const overlay = document.getElementById('loadingOverlay');
                if (overlay) overlay.classList.remove('active');
            });
        });

        // ============================================================
        // 4. AUTO-HIDE FLASH MESSAGES
        // ============================================================
        setTimeout(() => {
            document.querySelectorAll('.alert-premium').forEach(alert => {
                alert.style.transition = 'all 0.5s ease';
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-20px)';
                setTimeout(() => {
                    if (alert.parentElement) {
                        alert.remove();
                    }
                }, 500);
            });
        }, 5000);

        // ============================================================
        // 5. TOAST NOTIFICATION (Global)
        // ============================================================
        window.showToast = function(message, type = 'success') {
            const colors = {
                success: '#10b981',
                error: '#ef4444',
                warning: '#f59e0b',
                info: '#3b82f6'
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
                top: 90px;
                right: 30px;
                background: ${colors[type] || colors.success};
                color: white;
                padding: 14px 24px;
                border-radius: 12px;
                box-shadow: 0 8px 30px rgba(0,0,0,0.15);
                z-index: 9999;
                font-weight: 500;
                font-size: 0.9rem;
                animation: slideInRight 0.4s ease;
                max-width: 400px;
                display: flex;
                align-items: center;
                gap: 12px;
                border: 1px solid rgba(255,255,255,0.15);
                backdrop-filter: blur(10px);
            `;
            
            toast.innerHTML = `
                <i class="fas fa-${icons[type] || icons.success}" style="font-size: 1.2rem;"></i>
                <span>${message}</span>
                <button onclick="this.parentElement.remove()" style="
                    background: transparent;
                    border: none;
                    color: white;
                    opacity: 0.7;
                    cursor: pointer;
                    margin-left: auto;
                    font-size: 1rem;
                    padding: 4px;
                ">
                    <i class="fas fa-times"></i>
                </button>
            `;
            
            document.body.appendChild(toast);
            
            setTimeout(() => {
                if (toast.parentElement) {
                    toast.style.animation = 'slideOutRight 0.3s ease';
                    setTimeout(() => toast.remove(), 300);
                }
            }, 4000);
        };

        // ============================================================
        // 6. ACTIVE ROUTE DETECTION FOR SIDEBAR
        // ============================================================
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            document.querySelectorAll('.sidebar-nav a').forEach(link => {
                const href = link.getAttribute('href');
                if (href && href !== '#' && currentPath.includes(href)) {
                    link.classList.add('active');
                }
            });
            
            // Check for exact match
            document.querySelectorAll('.sidebar-nav a').forEach(link => {
                const href = link.getAttribute('href');
                if (href && href !== '#' && currentPath === href) {
                    link.classList.add('active');
                }
            });
        });

        // ============================================================
        // 7. CONSOLE GREETING
        // ============================================================
        console.log('%c✨ EktaMart Admin Panel | Premium Version Loaded ✨', 'color: #8b5cf6; font-size: 16px; font-weight: bold;');
        console.log('%c⚡ Features: Dark Mode • Universal Navbar & Footer • Glassmorphism • Smooth animations • Responsive', 'color: #6366f1; font-size: 12px;');
        console.log('%c🚀 Admin Panel Ready | EktaMart v2.0', 'color: #a855f7; font-size: 14px; font-weight: bold;');
    </script>
    
    @stack('scripts')
</body>
</html>