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
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: #f1f5f9;
            overflow-x: hidden;
        }
        
        /* Main Content Wrapper */
        .main-content {
            margin-left: 280px;
            transition: margin-left 0.3s ease;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        .main-content.expanded {
            margin-left: 80px;
        }
        
        .content-wrapper {
            flex: 1;
            padding: 1rem;
        }
        
        /* Page Header */
        .page-header {
            background: white;
            border-radius: 1rem;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
            }
            
            .content-wrapper {
                padding: 0.5rem;
            }
        }
        
        /* Loading Overlay */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 9999;
            display: none;
            justify-content: center;
            align-items: center;
        }
        
        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 3px solid rgba(139,92,246,0.3);
            border-top-color: #8b5cf6;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
    
    @stack('styles')
</head>
<body>

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
    </div>

    <!-- Include Sidebar -->
    @include('layouts.admin.sidebar')
    
    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Include Navbar -->
        @include('layouts.admin.navbar')
        
        <!-- Page Content -->
        <div class="content-wrapper">
            @yield('content')
        </div>
        
        <!-- Include Footer -->
        @include('layouts.admin.footer')
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
        // Sidebar Toggle Sync
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        
        function syncSidebarState() {
            const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            if (isCollapsed) {
                if (sidebar) sidebar.classList.add('collapsed');
                if (mainContent) mainContent.classList.add('expanded');
            }
        }
        
        syncSidebarState();
        
        // Listen for sidebar toggle events
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
        
        // Show loading on form submit
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function() {
                const loadingOverlay = document.getElementById('loadingOverlay');
                if (loadingOverlay) {
                    loadingOverlay.style.display = 'flex';
                }
            });
        });
        
        // Auto-hide flash messages
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(alert => {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);
        
        console.log('%c✨ EktaMart Admin Panel | Fully Loaded ✨', 'color: #8b5cf6; font-size: 14px; font-weight: bold;');
    </script>
    
    @stack('scripts')
</body>
</html>