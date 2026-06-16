{{-- resources/views/layouts/admin/navbar.blade.php --}}
<style>
    /* Premium Navbar Styles */
    .admin-navbar {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        padding: 0.75rem 1.5rem;
        position: sticky;
        top: 0;
        z-index: 999;
        backdrop-filter: blur(10px);
    }
    
    /* Brand Logo */
    .navbar-brand-premium {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .brand-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #8b5cf6, #6366f1);
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 10px rgba(139, 92, 246, 0.3);
    }
    
    .brand-icon i {
        font-size: 1.25rem;
        color: white;
    }
    
    .brand-text {
        font-weight: 800;
        font-size: 1.25rem;
        background: linear-gradient(135deg, #1e293b, #475569);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
    }
    
    .brand-subtitle {
        font-size: 0.7rem;
        color: #94a3b8;
        margin-top: -0.25rem;
    }
    
    /* Search Bar */
    .search-container {
        position: relative;
        width: 300px;
    }
    
    .search-input {
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        border-radius: 2rem;
        padding: 0.6rem 1rem 0.6rem 2.5rem;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        width: 100%;
    }
    
    .search-input:focus {
        background: white;
        border-color: #8b5cf6;
        box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
        outline: none;
    }
    
    .search-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 0.9rem;
    }
    
    .search-shortcut {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        background: #e2e8f0;
        padding: 0.2rem 0.5rem;
        border-radius: 0.5rem;
        font-size: 0.65rem;
        font-weight: 600;
        color: #64748b;
    }
    
    /* Notification Icon */
    .notification-icon {
        position: relative;
        cursor: pointer;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.75rem;
        transition: all 0.3s ease;
        background: transparent;
    }
    
    .notification-icon:hover {
        background: #f1f5f9;
        transform: scale(1.05);
    }
    
    .notification-badge {
        position: absolute;
        top: 5px;
        right: 5px;
        background: #ef4444;
        color: white;
        font-size: 0.6rem;
        padding: 0.2rem 0.4rem;
        border-radius: 1rem;
        font-weight: 700;
        min-width: 18px;
        text-align: center;
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.1);
        }
    }
    
    /* User Profile Dropdown */
    .user-dropdown {
        cursor: pointer;
        padding: 0.5rem 1rem;
        border-radius: 2rem;
        transition: all 0.3s ease;
        background: transparent;
    }
    
    .user-dropdown:hover {
        background: #f1f5f9;
    }
    
    .user-avatar-nav {
        width: 38px;
        height: 38px;
        background: linear-gradient(135deg, #8b5cf6, #6366f1);
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 1rem;
    }
    
    .user-info-nav h6 {
        margin: 0;
        font-size: 0.85rem;
        font-weight: 600;
        color: #1e293b;
    }
    
    .user-info-nav small {
        font-size: 0.7rem;
        color: #94a3b8;
    }
    
    /* Dropdown Menu Custom */
    .dropdown-menu-premium {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        padding: 0.5rem;
        margin-top: 0.5rem;
        min-width: 220px;
        animation: fadeInDown 0.3s ease;
    }
    
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .dropdown-item-premium {
        padding: 0.6rem 1rem;
        border-radius: 0.5rem;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        color: #334155;
    }
    
    .dropdown-item-premium:hover {
        background: #f1f5f9;
        transform: translateX(5px);
    }
    
    .dropdown-item-premium i {
        width: 20px;
        color: #8b5cf6;
    }
    
    .dropdown-divider-premium {
        height: 1px;
        background: #e2e8f0;
        margin: 0.5rem 0;
    }
    
    .dropdown-header-premium {
        padding: 0.5rem 1rem;
        font-size: 0.7rem;
        font-weight: 700;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    /* Logout Button in Dropdown */
    .logout-item {
        color: #ef4444;
    }
    
    .logout-item i {
        color: #ef4444;
    }
    
    .logout-item:hover {
        background: #fef2f2;
    }
    
    /* Mobile Responsive */
    @media (max-width: 768px) {
        .admin-navbar {
            padding: 0.75rem 1rem;
        }
        
        .search-container {
            width: 100%;
            margin: 0.5rem 0;
        }
        
        .brand-subtitle {
            display: none;
        }
        
        .user-info-nav {
            display: none;
        }
        
        .user-dropdown {
            padding: 0.25rem;
        }
    }
    
    /* Dark Mode Support (Optional) */
    @media (prefers-color-scheme: dark) {
        .admin-navbar {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
        }
        
        .brand-text {
            background: linear-gradient(135deg, #f1f5f9, #cbd5e1);
            -webkit-background-clip: text;
            background-clip: text;
        }
        
        .search-input {
            background: #334155;
            border-color: #475569;
            color: white;
        }
        
        .search-input:focus {
            background: #1e293b;
        }
        
        .user-info-nav h6 {
            color: #f1f5f9;
        }
    }
</style>

<nav class="admin-navbar">
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            
            <!-- Left Side: Brand -->
            <div class="navbar-brand-premium">
                <div class="brand-icon">
                    <i class="fas fa-store"></i>
                </div>
                <div>
                    <div class="brand-text">
                        Ekta<span style="color: #8b5cf6;">Mart</span>
                    </div>
                    <div class="brand-subtitle">
                        Admin Dashboard
                    </div>
                </div>
            </div>
            
            <!-- Center: Search Bar (Optional - can be shown/hidden on mobile) -->
            <div class="search-container d-none d-lg-block">
                <i class="fas fa-search search-icon"></i>
                <input type="text" 
                       class="search-input" 
                       placeholder="Search products, orders, customers..." 
                       id="globalSearch">
                <span class="search-shortcut">
                    <i class="fas fa-command"></i> K
                </span>
            </div>
            
            <!-- Right Side: User Actions -->
            <div class="d-flex align-items-center gap-3">
                
                <!-- Notification Bell -->
                <div class="notification-icon" id="notificationBell">
                    <i class="fas fa-bell fa-lg" style="color: #64748b;"></i>
                    <span class="notification-badge" id="notificationCount">3</span>
                </div>
                
                <!-- User Dropdown -->
                <div class="dropdown">
                    <div class="user-dropdown d-flex align-items-center gap-2" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="user-avatar-nav">
                            {{ substr(Auth::user()->name ?? 'Admin', 0, 1) }}
                        </div>
                        <div class="user-info-nav">
                            <h6>{{ Auth::user()->name ?? 'Administrator' }}</h6>
                            <small>
                                <i class="fas fa-user-shield"></i> 
                                {{ Auth::user()->role ?? 'Super Admin' }}
                            </small>
                        </div>
                        <i class="fas fa-chevron-down fa-xs" style="color: #94a3b8;"></i>
                    </div>
                    
                    <ul class="dropdown-menu dropdown-menu-premium dropdown-menu-end">
                        <li class="dropdown-header-premium">
                            <i class="fas fa-user-circle me-1"></i> Account
                        </li>
                        <li>
                            <a class="dropdown-item-premium" href="{{ route('profile.edit') }}">
                                <i class="fas fa-user"></i>
                                My Profile
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item-premium" href="{{ route('profile.settings') }}">
                                <i class="fas fa-cog"></i>
                                Account Settings
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item-premium" href="{{ route('profile.security') }}">
                                <i class="fas fa-shield-alt"></i>
                                Security
                            </a>
                        </li>
                        
                        <li class="dropdown-divider-premium"></li>
                        
                        <li class="dropdown-header-premium">
                            <i class="fas fa-chart-line me-1"></i> Analytics
                        </li>
                        <li>
                            <a class="dropdown-item-premium" href="{{ route('reports.daily') }}">
                                <i class="fas fa-calendar-day"></i>
                                Daily Report
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item-premium" href="{{ route('reports.monthly') }}">
                                <i class="fas fa-calendar-alt"></i>
                                Monthly Report
                            </a>
                        </li>
                        
                        <li class="dropdown-divider-premium"></li>
                        
                        <li>
                            <form action="{{ route('logout') }}" method="POST" id="logout-form-navbar">
                                @csrf
                                <a class="dropdown-item-premium logout-item" href="javascript:void(0)" onclick="document.getElementById('logout-form-navbar').submit();">
                                    <i class="fas fa-sign-out-alt"></i>
                                    <span>Logout</span>
                                </a>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        
        <!-- Mobile Search (Visible only on mobile) -->
        <div class="search-container d-lg-none mt-3">
            <i class="fas fa-search search-icon"></i>
            <input type="text" 
                   class="search-input" 
                   placeholder="Search..." 
                   id="mobileSearch">
        </div>
    </div>
</nav>

<!-- Notifications Dropdown Panel -->
<div class="notification-panel" id="notificationPanel" style="display: none;">
    <style>
        .notification-panel {
            position: absolute;
            top: 70px;
            right: 20px;
            width: 320px;
            background: white;
            border-radius: 1rem;
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
            z-index: 1000;
            overflow: hidden;
            animation: slideInRight 0.3s ease;
        }
        
        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        .notification-header {
            padding: 1rem;
            background: linear-gradient(135deg, #8b5cf6, #6366f1);
            color: white;
        }
        
        .notification-list {
            max-height: 400px;
            overflow-y: auto;
        }
        
        .notification-item {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #e2e8f0;
            transition: all 0.2s ease;
            cursor: pointer;
        }
        
        .notification-item:hover {
            background: #f8fafc;
        }
        
        .notification-item.unread {
            background: #eff6ff;
        }
        
        .notification-footer {
            padding: 0.75rem;
            text-align: center;
            background: #f8fafc;
        }
        
        @media (max-width: 768px) {
            .notification-panel {
                width: calc(100% - 40px);
                right: 20px;
                left: 20px;
            }
        }
    </style>
    
    <div class="notification-header d-flex justify-content-between align-items-center">
        <span>
            <i class="fas fa-bell me-2"></i>
            <strong>Notifications</strong>
        </span>
        <button class="btn btn-sm btn-link text-white" id="markAllRead" style="text-decoration: none;">
            Mark all read
        </button>
    </div>
    
    <div class="notification-list" id="notificationList">
        <div class="notification-item unread">
            <div class="d-flex gap-2">
                <div class="rounded-circle bg-primary bg-opacity-10 p-2">
                    <i class="fas fa-shopping-cart text-primary"></i>
                </div>
                <div>
                    <small class="fw-bold">New Order Received</small>
                    <br>
                    <small class="text-muted">Order #12345 from John Doe</small>
                    <br>
                    <small class="text-muted" style="font-size: 0.7rem;">2 minutes ago</small>
                </div>
            </div>
        </div>
        
        <div class="notification-item unread">
            <div class="d-flex gap-2">
                <div class="rounded-circle bg-success bg-opacity-10 p-2">
                    <i class="fas fa-user-plus text-success"></i>
                </div>
                <div>
                    <small class="fw-bold">New Customer Registered</small>
                    <br>
                    <small class="text-muted">Jane Smith joined as customer</small>
                    <br>
                    <small class="text-muted" style="font-size: 0.7rem;">15 minutes ago</small>
                </div>
            </div>
        </div>
        
        <div class="notification-item">
            <div class="d-flex gap-2">
                <div class="rounded-circle bg-warning bg-opacity-10 p-2">
                    <i class="fas fa-exclamation-triangle text-warning"></i>
                </div>
                <div>
                    <small class="fw-bold">Low Stock Alert</small>
                    <br>
                    <small class="text-muted">5 products are running low</small>
                    <br>
                    <small class="text-muted" style="font-size: 0.7rem;">1 hour ago</small>
                </div>
            </div>
        </div>
    </div>
    
    <div class="notification-footer">
        <a href="{{ route('notifications.index') }}" class="text-decoration-none small">
            View all notifications <i class="fas fa-arrow-right ms-1"></i>
        </a>
    </div>
</div>

<script>
    // Search functionality (Ctrl + K)
    const searchInput = document.getElementById('globalSearch');
    const mobileSearch = document.getElementById('mobileSearch');
    
    // Keyboard shortcut for search
    document.addEventListener('keydown', (e) => {
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            if (searchInput) searchInput.focus();
        }
    });
    
    // Search handler (can be extended for live search)
    function handleSearch(query) {
        if (query.length > 2) {
            console.log('Searching for:', query);
            // Implement search logic here
            // window.location.href = `/admin/search?q=${encodeURIComponent(query)}`;
        }
    }
    
    if (searchInput) {
        searchInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                handleSearch(e.target.value);
            }
        });
    }
    
    if (mobileSearch) {
        mobileSearch.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                handleSearch(e.target.value);
            }
        });
    }
    
    // Notification Panel Toggle
    const notificationBell = document.getElementById('notificationBell');
    const notificationPanel = document.getElementById('notificationPanel');
    
    if (notificationBell) {
        notificationBell.addEventListener('click', (e) => {
            e.stopPropagation();
            const isVisible = notificationPanel.style.display === 'block';
            notificationPanel.style.display = isVisible ? 'none' : 'block';
            
            // Close when clicking outside
            if (!isVisible) {
                setTimeout(() => {
                    document.addEventListener('click', function closePanel(e) {
                        if (!notificationPanel.contains(e.target) && !notificationBell.contains(e.target)) {
                            notificationPanel.style.display = 'none';
                            document.removeEventListener('click', closePanel);
                        }
                    });
                }, 100);
            }
        });
    }
    
    // Mark all notifications as read
    const markAllRead = document.getElementById('markAllRead');
    if (markAllRead) {
        markAllRead.addEventListener('click', () => {
            const unreadItems = document.querySelectorAll('.notification-item.unread');
            unreadItems.forEach(item => {
                item.classList.remove('unread');
            });
            const badge = document.getElementById('notificationCount');
            if (badge) badge.style.display = 'none';
            notificationPanel.style.display = 'none';
        });
    }
    
    // Auto-hide notification panel on scroll
    let scrollTimeout;
    window.addEventListener('scroll', () => {
        if (notificationPanel.style.display === 'block') {
            clearTimeout(scrollTimeout);
            scrollTimeout = setTimeout(() => {
                notificationPanel.style.display = 'none';
            }, 500);
        }
    });
    
    // Update notification count (dynamic example)
    function updateNotificationCount(count) {
        const badge = document.getElementById('notificationCount');
        if (badge) {
            if (count > 0) {
                badge.textContent = count > 99 ? '99+' : count;
                badge.style.display = 'inline-block';
            } else {
                badge.style.display = 'none';
            }
        }
    }
    
    // Example: Auto-refresh notifications every 30 seconds (optional)
    // setInterval(() => {
    //     fetch('/admin/notifications/unread-count')
    //         .then(res => res.json())
    //         .then(data => updateNotificationCount(data.count));
    // }, 30000);
    
    // Welcome greeting in console
    const hour = new Date().getHours();
    let greeting = '';
    if (hour < 12) greeting = 'Good Morning';
    else if (hour < 18) greeting = 'Good Afternoon';
    else greeting = 'Good Evening';
    
    console.log(`%c✨ ${greeting}, ${'{{ Auth::user()->name ?? 'Admin' }}'}! ✨`, 'color: #8b5cf6; font-size: 14px; font-weight: bold;');
    console.log('%c⚡ EktaMart Admin Panel | Premium Navigation Loaded', 'color: #6366f1; font-size: 12px;');
    
    // Add active class to dropdown items based on current route
    const currentPath = window.location.pathname;
    document.querySelectorAll('.dropdown-item-premium').forEach(item => {
        const href = item.getAttribute('href');
        if (href && href !== 'javascript:void(0)' && currentPath.includes(href)) {
            item.style.background = '#f1f5f9';
        }
    });
</script>