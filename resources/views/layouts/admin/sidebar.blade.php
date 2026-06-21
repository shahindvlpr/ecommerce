{{-- resources/views/layouts/admin/sidebar.blade.php --}}

<div class="admin-sidebar" id="adminSidebar">
    {{-- Brand Logo --}}
    <div class="sidebar-brand">
        <div class="brand-icon">
            <i class="fas fa-crown"></i>
        </div>
        <div class="brand-text">
            <span class="brand-name">EktaMart</span>
            <span class="brand-tag">Admin Panel</span>
        </div>
    </div>

    {{-- User Info --}}
    <div class="sidebar-user">
        <div class="user-avatar">
            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
        </div>
        <div class="user-info">
            <div class="user-name">{{ Str::limit(Auth::user()->name, 16) }}</div>
            <div class="user-role">Super Admin</div>
        </div>
        <div class="user-status"></div>
    </div>

    {{-- Navigation --}}
    <nav class="sidebar-nav">
        <div class="nav-section">Main</div>
        <a href="{{ route('admin.dashboard') }}"
           class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-th-large"></i>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('admin.analytics') }}"
           class="nav-link {{ request()->routeIs('admin.analytics') ? 'active' : '' }}">
            <i class="fas fa-chart-bar"></i>
            <span>Analytics</span>
        </a>

        <div class="nav-section">Catalog</div>
        <a href="{{ route('admin.categories.index') }}"
           class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
            <i class="fas fa-layer-group"></i>
            <span>Categories</span>
        </a>
        <a href="{{ route('admin.brands.index') }}"
           class="nav-link {{ request()->routeIs('admin.brands.*') ? 'active' : '' }}">
            <i class="fas fa-tag"></i>
            <span>Brands</span>
        </a>
        <a href="{{ route('admin.products.index') }}"
           class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
            <i class="fas fa-box"></i>
            <span>Products</span>
        </a>
        <a href="{{ route('admin.attributes.index') }}"
           class="nav-link {{ request()->routeIs('admin.attributes.*') ? 'active' : '' }}">
            <i class="fas fa-list-check"></i>
            <span>Attributes</span>
        </a>

        <div class="nav-section">Orders</div>
        <a href="{{ route('admin.orders.index') }}"
           class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
            <i class="fas fa-shopping-bag"></i>
            <span>Orders</span>
        </a>
        <a href="{{ route('admin.returns.index') }}" class="nav-link">
            <i class="fas fa-undo-alt"></i> <span>Returns</span>
        </a>
        <a href="{{ route('admin.invoices.index') }}" class="nav-link">
            <i class="fas fa-file-invoice"></i> <span>Invoices</span>
        </a>

        <div class="nav-section">Customers</div>
        <a href="{{ route('admin.customers.index') }}"
           class="nav-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
            <i class="fas fa-users"></i>
            <span>Customers</span>
        </a>
        <a href="{{ route('admin.reviews.index') }}"
           class="nav-link {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
            <i class="fas fa-star"></i>
            <span>Reviews</span>
        </a>

        <div class="nav-section">Vendors</div>
        <a href="{{ route('admin.vendors.index') }}"
           class="nav-link {{ request()->routeIs('admin.vendors.*') ? 'active' : '' }}">
            <i class="fas fa-store"></i>
            <span>Vendor List</span>
        </a>

        <div class="nav-section">Marketing</div>
        <a href="{{ route('admin.coupons.index') }}"
           class="nav-link {{ request()->routeIs('admin.coupons.*') ? 'active' : '' }}">
            <i class="fas fa-ticket"></i>
            <span>Coupons</span>
        </a>
        <a href="{{ route('admin.banners.index') }}"
           class="nav-link {{ request()->routeIs('admin.banners.*') ? 'active' : '' }}">
            <i class="fas fa-image"></i>
            <span>Banners</span>
        </a>

        <div class="nav-section">Payments</div>
        <a href="{{ route('admin.payments.index') }}"
           class="nav-link {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
            <i class="fas fa-credit-card"></i>
            <span>Transactions</span>
        </a>

        <div class="nav-section">Reports</div>
        <a href="{{ route('admin.reports.sales') }}"
           class="nav-link {{ request()->routeIs('admin.reports.sales') ? 'active' : '' }}">
            <i class="fas fa-chart-line"></i>
            <span>Sales Report</span>
        </a>
        <a href="{{ route('admin.reports.products') }}"
           class="nav-link {{ request()->routeIs('admin.reports.products') ? 'active' : '' }}">
            <i class="fas fa-chart-pie"></i>
            <span>Product Report</span>
        </a>

        <div class="nav-section">Settings</div>
        <a href="{{ route('admin.settings.general') }}"
           class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
            <i class="fas fa-cog"></i>
            <span>General Settings</span>
        </a>
        <a href="#" class="nav-link">
            <i class="fas fa-credit-card"></i>
            <span>Payment Settings</span>
        </a>
        <a href="#" class="nav-link">
            <i class="fas fa-envelope"></i>
            <span>Email Settings</span>
        </a>

        {{-- Logout --}}
        <div class="nav-footer">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-link logout-btn">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </button>
            </form>
            <div class="nav-version">v2.0.0</div>
        </div>
    </nav>
</div>

<style>
/* ============================================================
   SIDEBAR
============================================================ */
.admin-sidebar {
    width: var(--sidebar-width);
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1050;
    background: var(--bg-sidebar);
    color: #fff;
    display: flex;
    flex-direction: column;
    transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    overflow: hidden;
    border-right: 1px solid rgba(255, 255, 255, 0.04);
}

.admin-sidebar.collapsed {
    width: var(--sidebar-collapsed);
}

/* ============================================================
   BRAND
============================================================ */
.sidebar-brand {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 18px 20px 16px 20px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    flex-shrink: 0;
    min-height: 64px;
}

.brand-icon {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    color: #fff;
    flex-shrink: 0;
}

.brand-text {
    display: flex;
    flex-direction: column;
    transition: opacity 0.2s ease;
}

.brand-name {
    font-size: 16px;
    font-weight: 700;
    color: #fff;
    line-height: 1.2;
}

.brand-tag {
    font-size: 9px;
    color: #7F77DD;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    font-weight: 600;
}

.admin-sidebar.collapsed .brand-text {
    opacity: 0;
    width: 0;
    overflow: hidden;
}

.admin-sidebar.collapsed .sidebar-brand {
    justify-content: center;
    padding: 18px 0;
}

.admin-sidebar.collapsed .brand-icon {
    width: 36px;
    height: 36px;
    font-size: 16px;
}

/* ============================================================
   USER INFO
============================================================ */
.sidebar-user {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 20px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    flex-shrink: 0;
}

.user-avatar {
    width: 34px;
    height: 34px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: 700;
    color: #fff;
    flex-shrink: 0;
}

.user-info {
    flex: 1;
    min-width: 0;
    transition: opacity 0.2s ease;
}

.user-name {
    font-size: 13px;
    font-weight: 600;
    color: #e2e0f0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.user-role {
    font-size: 10px;
    color: #7F77DD;
    font-weight: 500;
}

.user-status {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #10B981;
    flex-shrink: 0;
    border: 1.5px solid rgba(255, 255, 255, 0.1);
}

.admin-sidebar.collapsed .user-info {
    opacity: 0;
    width: 0;
    overflow: hidden;
}

.admin-sidebar.collapsed .sidebar-user {
    justify-content: center;
    padding: 12px 0;
}

.admin-sidebar.collapsed .user-avatar {
    width: 32px;
    height: 32px;
    font-size: 11px;
}

.admin-sidebar.collapsed .user-status {
    display: none;
}

/* ============================================================
   NAVIGATION
============================================================ */
.sidebar-nav {
    flex: 1;
    overflow-y: auto;
    overflow-x: hidden;
    padding: 8px 12px 16px 12px;
    scrollbar-width: thin;
    scrollbar-color: rgba(139, 92, 246, 0.3) transparent;
}

.sidebar-nav::-webkit-scrollbar {
    width: 3px;
}
.sidebar-nav::-webkit-scrollbar-track {
    background: transparent;
}
.sidebar-nav::-webkit-scrollbar-thumb {
    background: rgba(139, 92, 246, 0.3);
    border-radius: 10px;
}

.nav-section {
    font-size: 9px;
    text-transform: uppercase;
    color: #7F77DD;
    padding: 12px 12px 4px 12px;
    letter-spacing: 1.2px;
    font-weight: 700;
    transition: opacity 0.2s ease;
}

.admin-sidebar.collapsed .nav-section {
    opacity: 0;
    height: 0;
    padding: 0;
    margin: 0;
    overflow: hidden;
}

.nav-link {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 8px 12px;
    color: #9896b0;
    text-decoration: none;
    font-size: 13px;
    font-weight: 500;
    border-radius: 8px;
    transition: all 0.2s ease;
    cursor: pointer;
    position: relative;
    margin: 1px 0;
    border: none;
    background: none;
    width: 100%;
    text-align: left;
}

.nav-link:hover {
    color: #e2e0f0;
    background: rgba(255, 255, 255, 0.04);
}

.nav-link.active {
    color: #CECBF6;
    background: rgba(139, 92, 246, 0.15);
}

.nav-link.active::before {
    content: '';
    position: absolute;
    left: 0;
    top: 50%;
    transform: translateY(-50%);
    width: 3px;
    height: 24px;
    background: linear-gradient(180deg, var(--primary), var(--secondary));
    border-radius: 0 4px 4px 0;
}

.nav-link i {
    width: 20px;
    font-size: 14px;
    text-align: center;
    flex-shrink: 0;
}

.nav-link span {
    flex: 1;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    transition: opacity 0.2s ease;
}

.admin-sidebar.collapsed .nav-link {
    justify-content: center;
    padding: 8px 0;
}

.admin-sidebar.collapsed .nav-link span {
    opacity: 0;
    width: 0;
    overflow: hidden;
}

.admin-sidebar.collapsed .nav-link i {
    font-size: 18px;
    width: auto;
}

.admin-sidebar.collapsed .nav-link.active::before {
    left: 50%;
    transform: translateX(-50%) translateY(-50%);
    top: 50%;
    width: 20px;
    height: 3px;
    border-radius: 4px;
}

/* ============================================================
   NAV FOOTER
============================================================ */
.nav-footer {
    border-top: 1px solid rgba(255, 255, 255, 0.05);
    margin-top: 8px;
    padding-top: 8px;
}

.logout-btn {
    color: #9896b0;
    font-size: 13px;
    font-weight: 500;
}

.logout-btn:hover {
    color: #f87171;
    background: rgba(239, 68, 68, 0.08);
}

.nav-version {
    font-size: 9px;
    color: #534AB7;
    text-align: center;
    padding: 6px 0 2px 0;
    transition: opacity 0.2s ease;
}

.admin-sidebar.collapsed .nav-version {
    opacity: 0;
}

/* ============================================================
   RESPONSIVE
============================================================ */
@media (max-width: 992px) {
    .admin-sidebar {
        transform: translateX(-100%);
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        width: 280px;
    }
    .admin-sidebar.open {
        transform: translateX(0);
    }
    .admin-sidebar.collapsed {
        transform: translateX(-100%);
        width: 280px;
    }
    .admin-sidebar.collapsed .brand-text,
    .admin-sidebar.collapsed .user-info,
    .admin-sidebar.collapsed .nav-section,
    .admin-sidebar.collapsed .nav-link span,
    .admin-sidebar.collapsed .nav-version,
    .admin-sidebar.collapsed .user-status {
        opacity: 1;
        width: auto;
        height: auto;
        padding: inherit;
        margin: inherit;
        overflow: visible;
    }
    .admin-sidebar.collapsed .sidebar-brand {
        justify-content: flex-start;
        padding: 18px 20px;
    }
    .admin-sidebar.collapsed .brand-icon {
        width: 38px;
        height: 38px;
        font-size: 18px;
    }
    .admin-sidebar.collapsed .sidebar-user {
        justify-content: flex-start;
        padding: 14px 20px;
    }
    .admin-sidebar.collapsed .user-avatar {
        width: 34px;
        height: 34px;
        font-size: 12px;
    }
    .admin-sidebar.collapsed .user-status {
        display: block;
    }
    .admin-sidebar.collapsed .nav-link {
        justify-content: flex-start;
        padding: 8px 12px;
    }
    .admin-sidebar.collapsed .nav-link i {
        font-size: 14px;
        width: 20px;
    }
    .admin-sidebar.collapsed .nav-link span {
        opacity: 1;
        width: auto;
    }
    .admin-sidebar.collapsed .nav-link.active::before {
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 3px;
        height: 24px;
        border-radius: 0 4px 4px 0;
    }
    .admin-sidebar.collapsed .nav-version {
        opacity: 1;
    }
}

@media (max-width: 576px) {
    .admin-sidebar {
        width: 280px;
    }
}

/* ============================================================
   DARK MODE
============================================================ */
[data-theme="dark"] .admin-sidebar {
    background: #0F0C29;
}
</style>

<script>
// ============================================================
// SIDEBAR TOGGLE FUNCTIONS
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

function toggleMobileSidebar() {
    const sidebar = document.getElementById('adminSidebar');
    if (sidebar) {
        sidebar.classList.toggle('open');
    }
}

// Load saved state
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

    // Close sidebar on outside click (mobile)
    document.addEventListener('click', function(e) {
        if (window.innerWidth <= 992) {
            if (sidebar && sidebar.classList.contains('open')) {
                if (!sidebar.contains(e.target) && !e.target.closest('.sidebar-toggle-btn')) {
                    sidebar.classList.remove('open');
                }
            }
        }
    });
});

console.log('%c📁 Admin Sidebar Loaded', 'color: #8B5CF6; font-size: 13px; font-weight: bold;');
</script>