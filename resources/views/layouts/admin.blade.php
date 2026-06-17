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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
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
            background: #f0f2f5;
            min-height: 100vh;
            display: flex;
        }
        
        /* ============================================================
           MAIN CONTENT WRAPPER
        ============================================================ */
        .main-content {
            margin-left: 280px;
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: #f0f2f5;
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
            background: white;
            border-radius: 1.25rem;
            padding: 1.25rem 1.75rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
            border: 1px solid rgba(0, 0, 0, 0.03);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }
        
        .page-header h4 {
            font-weight: 700;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: #1a1a2e;
        }
        
        .page-header h4 i {
            color: #8b5cf6;
        }
        
        .page-header .breadcrumb {
            margin: 0;
            background: transparent;
            padding: 0;
        }
        
        .page-header .breadcrumb-item a {
            color: #8b5cf6;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .page-header .breadcrumb-item a:hover {
            color: #6366f1;
        }
        
        .page-header .breadcrumb-item.active {
            color: #64748b;
            font-weight: 500;
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
        
        .loading-overlay .loading-text {
            color: white;
            font-weight: 500;
            font-size: 1rem;
            letter-spacing: 0.5px;
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
            border-radius: 1rem;
            padding: 1rem 1.25rem;
            font-weight: 500;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            animation: slideDown 0.4s ease;
        }
        
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .alert-premium.alert-success {
            background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
            color: #166534;
            border-left: 4px solid #10b981;
        }
        
        .alert-premium.alert-danger {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            color: #991b1b;
            border-left: 4px solid #ef4444;
        }
        
        .alert-premium.alert-warning {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            color: #92400e;
            border-left: 4px solid #f59e0b;
        }
        
        .alert-premium.alert-info {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            color: #1e40af;
            border-left: 4px solid #3b82f6;
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
        }
        
        @media (max-width: 576px) {
            .content-wrapper {
                padding: 0.5rem;
            }
            
            .page-header {
                padding: 0.75rem 1rem;
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
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        }
        
        .shadow-premium-hover:hover {
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }
        
        .transition-premium {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        /* ============================================================
           SCROLLBAR
        ============================================================ */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #8b5cf6, #6366f1);
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #7c3aed, #4f46e5);
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
        @include('layouts.partials.navbar')
        
        <!-- ============================================================
             PAGE CONTENT
        ============================================================ -->
        <div class="content-wrapper">
            @yield('content')
        </div>
        
        <!-- ============================================================
             INCLUDE UNIVERSAL FOOTER (Single Source of Truth)
        ============================================================ -->
        @include('layouts.partials.footer')
    </div>

    <!-- ============================================================
         SCRIPTS
    ============================================================ -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
        // ============================================================
        // 1. SIDEBAR TOGGLE SYNC
        // ============================================================
        (function() {
            const sidebar = document.getElementById('sidebar');
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
        // 2. LOADING OVERLAY ON FORM SUBMIT
        // ============================================================
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', function() {
                    const overlay = document.getElementById('loadingOverlay');
                    if (overlay) {
                        overlay.style.display = 'flex';
                        setTimeout(() => {
                            overlay.style.display = 'none';
                        }, 10000);
                    }
                });
            });
        });

        // ============================================================
        // 3. AUTO-HIDE FLASH MESSAGES
        // ============================================================
        setTimeout(() => {
            document.querySelectorAll('.alert-premium, .alert').forEach(alert => {
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
        // 4. TOAST NOTIFICATION (Global)
        // ============================================================
        function showToast(message, type = 'success') {
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
        }

        // ============================================================
        // 5. ACTIVE ROUTE DETECTION FOR SIDEBAR
        // ============================================================
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            document.querySelectorAll('.sidebar-nav a').forEach(link => {
                const href = link.getAttribute('href');
                if (href && currentPath.includes(href) && href !== '#') {
                    link.classList.add('active');
                }
            });
        });

        console.log('%c✨ EktaMart Admin Panel | Premium Version Loaded ✨', 'color: #8b5cf6; font-size: 16px; font-weight: bold;');
        console.log('%c⚡ Features: Universal Navbar & Footer • Glassmorphism • Smooth animations • Responsive', 'color: #6366f1; font-size: 12px;');
        console.log('%c🚀 Admin Panel Ready | EktaMart v2.0', 'color: #a855f7; font-size: 14px; font-weight: bold;');
    </script>
    
    @stack('scripts')
</body>
</html>