{{-- resources/views/layouts/admin/sidebar.blade.php --}}
<style>
    /* Premium Sidebar Styles */
    .sidebar {
        position: fixed;
        left: 0;
        top: 0;
        height: 100vh;
        width: 280px;
        background: linear-gradient(180deg, #0f0c29 0%, #1a1a3e 50%, #24243e 100%);
        color: #fff;
        transition: all 0.3s ease;
        z-index: 1000;
        overflow-y: auto;
        overflow-x: hidden;
        box-shadow: 5px 0 30px rgba(0, 0, 0, 0.3);
    }
    
    /* Custom Scrollbar */
    .sidebar::-webkit-scrollbar {
        width: 5px;
    }
    
    .sidebar::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.05);
    }
    
    .sidebar::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, #8b5cf6, #6366f1);
        border-radius: 10px;
    }
    
    /* Logo Section */
    .sidebar-logo {
        padding: 1.5rem 1rem;
        text-align: center;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
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
        0%, 100% {
            box-shadow: 0 8px 20px rgba(139, 92, 246, 0.4);
        }
        50% {
            box-shadow: 0 8px 30px rgba(139, 92, 246, 0.7);
        }
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
        font-size: 0.65rem;
        color: rgba(255, 255, 255, 0.5);
        margin: 0;
        margin-top: 0.25rem;
    }
    
    /* User Profile Section */
    .user-profile {
        padding: 1rem;
        margin: 0 1rem 1rem 1rem;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 1rem;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.08);
    }
    
    .user-avatar {
        width: 45px;
        height: 45px;
        background: linear-gradient(135deg, #8b5cf6, #6366f1);
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.25rem;
    }
    
    .user-info h6 {
        margin: 0;
        font-weight: 600;
        font-size: 0.9rem;
    }
    
    .user-info small {
        font-size: 0.7rem;
        color: rgba(255, 255, 255, 0.5);
    }
    
    /* Navigation Sections */
    .sidebar-nav {
        padding: 0 1rem;
    }
    
    .nav-section {
        margin-bottom: 1.5rem;
    }
    
    .nav-section-title {
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: rgba(255, 255, 255, 0.4);
        padding: 0.5rem 1rem;
        margin-bottom: 0.5rem;
        font-weight: 700;
    }
    
    /* Menu Items */
    .sidebar a {
        display: flex;
        align-items: center;
        gap: 0.875rem;
        padding: 0.75rem 1rem;
        margin: 0.25rem 0;
        color: rgba(255, 255, 255, 0.7);
        text-decoration: none;
        border-radius: 0.75rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        font-weight: 500;
        font-size: 0.9rem;
    }
    
    /* Hover Effect */
    .sidebar a::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.08), transparent);
        transition: left 0.5s ease;
    }
    
    .sidebar a:hover::before {
        left: 100%;
    }
    
    .sidebar a:hover {
        background: rgba(139, 92, 246, 0.15);
        color: white;
        transform: translateX(5px);
    }
    
    /* Active Menu Item */
    .sidebar a.active {
        background: linear-gradient(135deg, #8b5cf6, #6366f1);
        color: white;
        box-shadow: 0 4px 15px rgba(139, 92, 246, 0.3);
    }
    
    .sidebar a.active i {
        color: white;
    }
    
    .sidebar a i {
        width: 24px;
        font-size: 1.1rem;
        text-align: center;
        transition: all 0.3s ease;
    }
    
    .sidebar a:hover i {
        transform: scale(1.1);
    }
    
    /* Badge for notifications */
    .menu-badge {
        margin-left: auto;
        background: #ef4444;
        color: white;
        font-size: 0.65rem;
        padding: 0.2rem 0.5rem;
        border-radius: 1rem;
        font-weight: 600;
    }
    
    /* Collapsible Submenu */
    .has-submenu {
        cursor: pointer;
    }
    
    .submenu {
        margin-left: 2.5rem;
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease;
    }
    
    .submenu a {
        padding: 0.6rem 1rem;
        font-size: 0.85rem;
    }
    
    .submenu a i {
        font-size: 0.85rem;
        width: 20px;
    }
    
    .submenu-open .submenu {
        max-height: 300px;
    }
    
    .chevron-icon {
        margin-left: auto;
        transition: transform 0.3s ease;
    }
    
    .submenu-open .chevron-icon {
        transform: rotate(90deg);
    }
    
    /* Divider */
    .sidebar-divider {
        height: 1px;
        background: rgba(255, 255, 255, 0.08);
        margin: 1rem 0;
    }
    
    /* Footer Section */
    .sidebar-footer {
        padding: 1rem;
        margin-top: 1rem;
        border-top: 1px solid rgba(255, 255, 255, 0.08);
    }
    
    .sidebar-footer a {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.6rem 1rem;
        color: rgba(255, 255, 255, 0.6);
        text-decoration: none;
        border-radius: 0.75rem;
        transition: all 0.3s ease;
        font-size: 0.85rem;
    }
    
    .sidebar-footer a:hover {
        background: rgba(239, 68, 68, 0.15);
        color: #ef4444;
    }
    
    /* Tooltip for collapsed sidebar (optional) */
    .sidebar.collapsed {
        width: 80px;
    }
    
    .sidebar.collapsed .sidebar-logo h4,
    .sidebar.collapsed .sidebar-logo p,
    .sidebar.collapsed .user-info,
    .sidebar.collapsed .nav-section-title,
    .sidebar.collapsed a span,
    .sidebar.collapsed .menu-badge,
    .sidebar.collapsed .chevron-icon {
        display: none;
    }
    
    .sidebar.collapsed a {
        justify-content: center;
        padding: 0.75rem;
    }
    
    .sidebar.collapsed a i {
        margin: 0;
        font-size: 1.25rem;
    }
    
    .sidebar.collapsed .user-profile {
        justify-content: center;
    }
    
    .sidebar.collapsed .user-avatar {
        margin: 0;
    }
    
    /* Toggle Button */
    .sidebar-toggle {
        position: fixed;
        left: 290px;
        top: 20px;
        z-index: 1001;
        background: linear-gradient(135deg, #8b5cf6, #6366f1);
        border: none;
        width: 35px;
        height: 35px;
        border-radius: 0.75rem;
        color: white;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 10px rgba(0,0,0,0.2);
    }
    
    .sidebar-toggle:hover {
        transform: scale(1.05);
    }
    
    .sidebar.collapsed + .sidebar-toggle {
        left: 95px;
    }
    
    /* Main Content Shift */
    .main-content {
        margin-left: 280px;
        transition: margin-left 0.3s ease;
    }
    
    .main-content.expanded {
        margin-left: 80px;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .sidebar {
            transform: translateX(-100%);
        }
        
        .sidebar.mobile-open {
            transform: translateX(0);
        }
        
        .main-content {
            margin-left: 0;
        }
        
        .sidebar-toggle {
            left: auto;
            right: 20px;
        }
    }
</style>

<!-- Sidebar Toggle Button -->
<button class="sidebar-toggle" id="sidebarToggle">
    <i class="fas fa-chevron-left"></i>
</button>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    
    <!-- Logo Section -->
    <div class="sidebar-logo">
        <div class="logo-icon">
            <i class="fas fa-store"></i>
        </div>
        <h4>Ekta<span style="color: #a78bfa;">Mart</span></h4>
        <p>Ecommerce Management System</p>
    </div>
    
    <!-- User Profile Section -->
    <div class="user-profile d-flex align-items-center gap-3">
        <div class="user-avatar">
            A
        </div>
        <div class="user-info">
            <h6>Admin User</h6>
            <small>Administrator</small>
        </div>
    </div>
    
    <!-- Navigation -->
    <div class="sidebar-nav">
        
        <!-- Main Section -->
        <div class="nav-section">
            <div class="nav-section-title">
                <i class="fas fa-chart-line me-1"></i> MAIN
            </div>
            
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-pie"></i>
                <span>Dashboard</span>
            </a>
        </div>
        
        <!-- Shop Section -->
        <div class="nav-section">
            <div class="nav-section-title">
                <i class="fas fa-store me-1"></i> SHOP
            </div>
            
            <a href="{{ route('categories.index') }}" class="{{ request()->routeIs('categories.*') ? 'active' : '' }}">
                <i class="fas fa-tags"></i>
                <span>Categories</span>
            </a>
            
            <a href="{{ route('brands.index') }}" class="{{ request()->routeIs('brands.*') ? 'active' : '' }}">
                <i class="fas fa-trademark"></i>
                <span>Brands</span>
            </a>
            
            <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'active' : '' }}">
                <i class="fas fa-box"></i>
                <span>Products</span>
                @php
                    $lowStockCount = \App\Models\Product::where('stock', '<', 10)->count();
                @endphp
                @if($lowStockCount > 0)
                    <span class="menu-badge">{{ $lowStockCount }}</span>
                @endif
            </a>
        </div>
        
        <!-- Orders Section -->
        <div class="nav-section">
            <div class="nav-section-title">
                <i class="fas fa-shopping-cart me-1"></i> SALES
            </div>
            
            <div class="has-submenu" id="ordersMenu">
                <a href="javascript:void(0)" class="d-flex align-items-center">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Orders</span>
                    <i class="fas fa-chevron-right chevron-icon ms-auto"></i>
                </a>
                <div class="submenu">
                    <a href="{{ route('orders.index') }}">
                        <i class="fas fa-list"></i>
                        <span>All Orders</span>
                    </a>
                    <a href="{{ route('orders.pending') }}">
                        <i class="fas fa-clock"></i>
                        <span>Pending Orders</span>
                    </a>
                    <a href="{{ route('orders.completed') }}">
                        <i class="fas fa-check-circle"></i>
                        <span>Completed Orders</span>
                    </a>
                </div>
            </div>
            
            <a href="{{ route('invoices.index') }}">
                <i class="fas fa-file-invoice"></i>
                <span>Invoices</span>
            </a>
        </div>
        
        <!-- Users Section -->
        <div class="nav-section">
            <div class="nav-section-title">
                <i class="fas fa-users me-1"></i> USERS
            </div>
            
            <div class="has-submenu" id="customersMenu">
                <a href="javascript:void(0)" class="d-flex align-items-center">
                    <i class="fas fa-users"></i>
                    <span>Customers</span>
                    <i class="fas fa-chevron-right chevron-icon ms-auto"></i>
                </a>
                <div class="submenu">
                    <a href="{{ route('customers.index') }}">
                        <i class="fas fa-list"></i>
                        <span>All Customers</span>
                    </a>
                    <a href="{{ route('customers.new') }}">
                        <i class="fas fa-user-plus"></i>
                        <span>New Customers</span>
                        @php
                            $newCustomersCount = \App\Models\User::whereDate('created_at', today())->count();
                        @endphp
                        @if($newCustomersCount > 0)
                            <span class="menu-badge">{{ $newCustomersCount }}</span>
                        @endif
                    </a>
                </div>
            </div>
            
            <a href="{{ route('vendors.index') }}">
                <i class="fas fa-user-tie"></i>
                <span>Vendors</span>
            </a>
            
            <a href="{{ route('staff.index') }}">
                <i class="fas fa-user-cog"></i>
                <span>Staff Management</span>
            </a>
        </div>
        
        <!-- Reports Section -->
        <div class="nav-section">
            <div class="nav-section-title">
                <i class="fas fa-chart-bar me-1"></i> REPORTS
            </div>
            
            <a href="{{ route('reports.sales') }}">
                <i class="fas fa-chart-line"></i>
                <span>Sales Report</span>
            </a>
            
            <a href="{{ route('reports.products') }}">
                <i class="fas fa-boxes"></i>
                <span>Product Report</span>
            </a>
            
            <a href="{{ route('reports.customers') }}">
                <i class="fas fa-user-chart"></i>
                <span>Customer Report</span>
            </a>
        </div>
        
        <!-- Settings Section -->
        <div class="nav-section">
            <div class="nav-section-title">
                <i class="fas fa-cog me-1"></i> SETTINGS
            </div>
            
            <div class="has-submenu" id="settingsMenu">
                <a href="javascript:void(0)" class="d-flex align-items-center">
                    <i class="fas fa-sliders-h"></i>
                    <span>General Settings</span>
                    <i class="fas fa-chevron-right chevron-icon ms-auto"></i>
                </a>
                <div class="submenu">
                    <a href="{{ route('settings.general') }}">
                        <i class="fas fa-globe"></i>
                        <span>General</span>
                    </a>
                    <a href="{{ route('settings.shipping') }}">
                        <i class="fas fa-truck"></i>
                        <span>Shipping</span>
                    </a>
                    <a href="{{ route('settings.payment') }}">
                        <i class="fas fa-credit-card"></i>
                        <span>Payment</span>
                    </a>
                </div>
            </div>
            
            <a href="{{ route('settings.seo') }}">
                <i class="fas fa-search"></i>
                <span>SEO Settings</span>
            </a>
        </div>
    </div>
    
    <div class="sidebar-divider"></div>
    
    <!-- Footer Links -->
    <div class="sidebar-footer">
        <a href="{{ route('profile.edit') }}">
            <i class="fas fa-user-circle"></i>
            <span>My Profile</span>
        </a>
        
        <form method="POST" action="{{ route('logout') }}" id="logout-form-sidebar">
            @csrf
            <a href="javascript:void(0)" onclick="document.getElementById('logout-form-sidebar').submit();" style="color: #ef4444;">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </form>
    </div>
    
    <!-- Version Info -->
    <div class="text-center py-3">
        <small style="color: rgba(255,255,255,0.3); font-size: 0.65rem;">
            <i class="fas fa-code-branch"></i> v2.0.0 | EktaMart
        </small>
    </div>
</div>

<script>
    // Sidebar Toggle Functionality
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const mainContent = document.querySelector('.main-content');
    const toggleIcon = sidebarToggle.querySelector('i');
    
    // Load saved state
    const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
    if (isCollapsed) {
        sidebar.classList.add('collapsed');
        if (mainContent) mainContent.classList.add('expanded');
        toggleIcon.classList.remove('fa-chevron-left');
        toggleIcon.classList.add('fa-chevron-right');
    }
    
    sidebarToggle.addEventListener('click', () => {
        sidebar.classList.toggle('collapsed');
        if (mainContent) mainContent.classList.toggle('expanded');
        
        const collapsed = sidebar.classList.contains('collapsed');
        localStorage.setItem('sidebarCollapsed', collapsed);
        
        if (collapsed) {
            toggleIcon.classList.remove('fa-chevron-left');
            toggleIcon.classList.add('fa-chevron-right');
        } else {
            toggleIcon.classList.remove('fa-chevron-right');
            toggleIcon.classList.add('fa-chevron-left');
        }
    });
    
    // Collapsible Submenu Functionality
    const submenuTriggers = document.querySelectorAll('.has-submenu > a');
    
    submenuTriggers.forEach(trigger => {
        trigger.addEventListener('click', (e) => {
            e.preventDefault();
            const parent = trigger.parentElement;
            parent.classList.toggle('submenu-open');
            
            // Save state to localStorage
            const menuId = parent.id;
            if (menuId) {
                const isOpen = parent.classList.contains('submenu-open');
                localStorage.setItem(`sidebar_${menuId}`, isOpen);
            }
        });
        
        // Load saved state
        const parent = trigger.parentElement;
        const menuId = parent.id;
        if (menuId && localStorage.getItem(`sidebar_${menuId}`) === 'true') {
            parent.classList.add('submenu-open');
        }
    });
    
    // Mobile Responsive
    let overlay = null;
    
    function createOverlay() {
        if (!overlay) {
            overlay = document.createElement('div');
            overlay.style.position = 'fixed';
            overlay.style.top = '0';
            overlay.style.left = '0';
            overlay.style.width = '100%';
            overlay.style.height = '100%';
            overlay.style.background = 'rgba(0,0,0,0.5)';
            overlay.style.zIndex = '999';
            overlay.style.display = 'none';
            overlay.addEventListener('click', () => {
                sidebar.classList.remove('mobile-open');
                overlay.style.display = 'none';
            });
            document.body.appendChild(overlay);
        }
        return overlay;
    }
    
    // For mobile view, add a menu button in header if needed
    function checkMobile() {
        if (window.innerWidth <= 768) {
            if (!document.querySelector('.mobile-menu-btn')) {
                const mobileBtn = document.createElement('button');
                mobileBtn.className = 'mobile-menu-btn';
                mobileBtn.innerHTML = '<i class="fas fa-bars"></i>';
                mobileBtn.style.cssText = `
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
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    box-shadow: 0 2px 10px rgba(0,0,0,0.2);
                `;
                mobileBtn.addEventListener('click', () => {
                    sidebar.classList.toggle('mobile-open');
                    const overlayElem = createOverlay();
                    overlayElem.style.display = sidebar.classList.contains('mobile-open') ? 'block' : 'none';
                });
                document.body.appendChild(mobileBtn);
            }
        } else {
            const mobileBtn = document.querySelector('.mobile-menu-btn');
            if (mobileBtn) mobileBtn.remove();
            if (overlay) overlay.style.display = 'none';
            sidebar.classList.remove('mobile-open');
        }
    }
    
    window.addEventListener('resize', checkMobile);
    checkMobile();
    
    // Set active class based on current URL
    const currentUrl = window.location.pathname;
    document.querySelectorAll('.sidebar a').forEach(link => {
        const href = link.getAttribute('href');
        if (href && href !== 'javascript:void(0)' && currentUrl === href) {
            link.classList.add('active');
            // Expand parent submenu if any
            const parentSubmenu = link.closest('.submenu');
            if (parentSubmenu) {
                parentSubmenu.parentElement?.classList.add('submenu-open');
            }
        }
    });
    
    // Console greeting
    console.log('%c✨ EktaMart Admin Sidebar | Premium Navigation Loaded ✨', 'color: #8b5cf6; font-size: 14px; font-weight: bold;');
</script>