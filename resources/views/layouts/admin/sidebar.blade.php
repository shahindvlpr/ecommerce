{{-- resources/views/layouts/admin/sidebar.blade.php --}}

<div class="admin-sidebar" id="adminSidebar">

    {{-- Brand --}}
    <div class="sb-brand">
        <div class="sb-logo">
            <i class="fas fa-crown"></i>
        </div>
        <div>
            <div class="sb-name">EktaMart</div>
            <div class="sb-tag">Admin Panel</div>
        </div>
    </div>

    {{-- Admin Info --}}
    <div class="sb-admin">
        <div class="sb-avatar">
            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
        </div>
        <div style="flex:1;min-width:0">
            <div class="sb-admin-name">{{ Str::limit(Auth::user()->name, 16) }}</div>
            <div class="sb-admin-role">{{ Auth::user()->email }}</div>
        </div>
        <div class="sb-online" title="Online"></div>
    </div>

    {{-- Navigation --}}
    <div class="sb-body">

        {{-- Main --}}
        <div class="sb-section">Main</div>
        <a href="{{ route('admin.dashboard') }}"
           class="sb-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-th-large"></i> Dashboard
        </a>
        <a href="{{ route('admin.analytics') }}"
           class="sb-item {{ request()->routeIs('admin.analytics') ? 'active' : '' }}">
            <i class="fas fa-chart-bar"></i> Analytics
        </a>

        {{-- Catalogue --}}
        <div class="sb-section">Catalogue</div>
        <a href="{{ route('admin.categories.index') }}"
           class="sb-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
            <i class="fas fa-layer-group"></i> Categories
        </a>
        <a href="{{ route('admin.brands.index') }}"
           class="sb-item {{ request()->routeIs('admin.brands.*') ? 'active' : '' }}">
            <i class="fas fa-tag"></i> Brands
        </a>
        <a href="{{ route('admin.products.index') }}"
           class="sb-item {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
            <i class="fas fa-box"></i> Products
            @php $lowStock = \App\Models\Product::where('stock', '<', 10)->count(); @endphp
            @if($lowStock > 0)
                <span class="sb-badge amber">{{ $lowStock }}</span>
            @endif
        </a>
        <a href="{{ route('admin.attributes.index') }}"
           class="sb-item {{ request()->routeIs('admin.attributes.*') ? 'active' : '' }}">
            <i class="fas fa-list-check"></i> Attributes
        </a>
        <a href="{{ route('admin.attribute-values.index') }}"
        class="sb-item {{ request()->routeIs('admin.attribute-values.*') ? 'active' : '' }}"
        style="padding-left: 2rem;">
            <i class="fas fa-tag"></i> Attribute Values
        </a>

        {{-- Sales --}}
        <div class="sb-section">Sales</div>
        <a href="{{ route('admin.orders.index') }}"
           class="sb-item {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
            <i class="fas fa-shopping-bag"></i> Orders
            @php $pendingOrders = \App\Models\Order::where('status', 'pending')->count(); @endphp
            @if($pendingOrders > 0)
                <span class="sb-badge red">{{ $pendingOrders }}</span>
            @endif
        </a>
        <a href="{{ route('admin.orders.index') }}"
           class="sb-item">
            <i class="fas fa-credit-card"></i> Payments
        </a>

        {{-- Marketing --}}
        <div class="sb-section">Marketing</div>
        <a href="{{ route('admin.coupons.index') }}"
           class="sb-item {{ request()->routeIs('admin.coupons.*') ? 'active' : '' }}">
            <i class="fas fa-ticket-alt"></i> Coupons
        </a>
        <a href="{{ route('admin.banners.index') }}"
           class="sb-item {{ request()->routeIs('admin.banners.*') ? 'active' : '' }}">
            <i class="fas fa-image"></i> Banners
        </a>

        {{-- Users --}}
        <div class="sb-section">Users</div>
        <a href="{{ route('admin.customers.index') }}"
           class="sb-item {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
            <i class="fas fa-users"></i> Customers
        </a>
        <a href="{{ route('admin.vendors.index') }}"
           class="sb-item {{ request()->routeIs('admin.vendors.*') ? 'active' : '' }}">
            <i class="fas fa-store"></i> Vendors
            @php $pendingVendors = \App\Models\User::where('role', 'vendor')->where('status', 'pending')->count(); @endphp
            @if($pendingVendors > 0)
                <span class="sb-badge amber">{{ $pendingVendors }}</span>
            @endif
        </a>

        {{-- Content --}}
        <div class="sb-section">Content</div>
        <a href="{{ route('admin.reviews.index') }}"
           class="sb-item {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
            <i class="fas fa-star"></i> Reviews
            @php $pendingReviews = \App\Models\Review::where('is_approved', false)->count(); @endphp
            @if($pendingReviews > 0)
                <span class="sb-badge red">{{ $pendingReviews }}</span>
            @endif
        </a>

        {{-- Reports --}}
        <div class="sb-section">Reports</div>
        <a href="{{ route('admin.reports.sales') }}"
           class="sb-item {{ request()->routeIs('admin.reports.sales') ? 'active' : '' }}">
            <i class="fas fa-chart-line"></i> Sales Report
        </a>
        <a href="{{ route('admin.reports.products') }}"
           class="sb-item {{ request()->routeIs('admin.reports.products') ? 'active' : '' }}">
            <i class="fas fa-chart-pie"></i> Product Report
        </a>
        <a href="{{ route('admin.reports.users') }}"
           class="sb-item {{ request()->routeIs('admin.reports.users') ? 'active' : '' }}">
            <i class="fas fa-users"></i> User Report
        </a>

        {{-- System --}}
        <div class="sb-section">System</div>
        <a href="{{ route('admin.settings.index') }}"
           class="sb-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
            <i class="fas fa-cog"></i> Settings
        </a>
        <a href="{{ route('admin.backup.index') }}"
           class="sb-item {{ request()->routeIs('admin.backup.*') ? 'active' : '' }}">
            <i class="fas fa-database"></i> Backup
        </a>
        <a href="{{ route('admin.notifications.index') }}"
           class="sb-item {{ request()->routeIs('admin.notifications.*') ? 'active' : '' }}">
            <i class="fas fa-bell"></i> Notifications
        </a>

    </div>

    {{-- Footer --}}
    <div class="sb-footer">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="sb-logout-btn">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </form>
        <div class="sb-version">EktaMart v1.0.0</div>
    </div>

</div>

<style>
/* ============================================================
   ADMIN SIDEBAR - MAIN
============================================================ */
.admin-sidebar {
    width: 240px;
    background: #1a1730;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1000;
    transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    flex-shrink: 0;
}

/* ✅ Scrollable Body Container */
.admin-sidebar {
    overflow: hidden; /* Prevents body scroll */
}

/* ✅ Scrollbar Styling */
.admin-sidebar::-webkit-scrollbar {
    width: 4px;
}
.admin-sidebar::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.02);
    border-radius: 4px;
}
.admin-sidebar::-webkit-scrollbar-thumb {
    background: rgba(83, 74, 183, 0.4);
    border-radius: 4px;
}
.admin-sidebar::-webkit-scrollbar-thumb:hover {
    background: rgba(83, 74, 183, 0.6);
}

/* Firefox Scrollbar */
.admin-sidebar {
    scrollbar-width: thin;
    scrollbar-color: rgba(83, 74, 183, 0.4) transparent;
}

/* ✅ Collapsed Sidebar */
.admin-sidebar.collapsed {
    width: 72px;
}

.admin-sidebar.collapsed .sb-brand > div,
.admin-sidebar.collapsed .sb-admin > div,
.admin-sidebar.collapsed .sb-admin .sb-online,
.admin-sidebar.collapsed .sb-section,
.admin-sidebar.collapsed .sb-item span,
.admin-sidebar.collapsed .sb-badge,
.admin-sidebar.collapsed .sb-footer .sb-version,
.admin-sidebar.collapsed .sb-logout-btn span {
    display: none;
}

.admin-sidebar.collapsed .sb-brand {
    justify-content: center;
    padding: 1.1rem 0.5rem;
}

.admin-sidebar.collapsed .sb-admin {
    justify-content: center;
    padding: 0.85rem 0.5rem;
}

.admin-sidebar.collapsed .sb-item {
    justify-content: center;
    padding: 7px 0.5rem;
}

.admin-sidebar.collapsed .sb-item i {
    font-size: 1.2rem;
    width: auto;
}

.admin-sidebar.collapsed .sb-footer {
    text-align: center;
}

.admin-sidebar.collapsed .sb-logout-btn {
    justify-content: center;
    padding: 6px 0;
}

.admin-sidebar.collapsed .sb-logout-btn i {
    font-size: 1.2rem;
}

/* ============================================================
   SIDEBAR COMPONENTS
============================================================ */
.sb-brand {
    padding: 1.1rem 1.25rem;
    border-bottom: 0.5px solid rgba(255,255,255,0.07);
    display: flex;
    align-items: center;
    gap: 10px;
    flex-shrink: 0;
}
.sb-logo {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    background: #534AB7;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 15px;
    color: #EEEDFE;
    flex-shrink: 0;
}
.sb-name { font-size: 15px; font-weight: 600; color: #fff; }
.sb-tag { font-size: 10px; color: #7F77DD; }

.sb-admin {
    padding: .85rem 1.25rem;
    border-bottom: 0.5px solid rgba(255,255,255,0.07);
    display: flex;
    align-items: center;
    gap: 10px;
    flex-shrink: 0;
}
.sb-avatar {
    width: 34px; height: 34px;
    border-radius: 50%;
    background: #534AB7;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: 600;
    color: #EEEDFE;
    flex-shrink: 0;
}
.sb-admin-name { font-size: 13px; color: #e2e0f0; font-weight: 500; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.sb-admin-role { font-size: 10px; color: #7F77DD; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.sb-online { width: 8px; height: 8px; border-radius: 50%; background: #1D9E75; margin-left: auto; flex-shrink: 0; }

/* ✅ Scrollable Body - FIXED */
.sb-body {
    flex: 1 1 auto;
    padding: 0.5rem 0;
    overflow-y: auto;
    overflow-x: hidden;
    min-height: 0;
    max-height: calc(100vh - 220px);
}

.sb-section {
    padding: .6rem 1.25rem .2rem;
    font-size: 10px;
    font-weight: 600;
    color: #534AB7;
    text-transform: uppercase;
    letter-spacing: .8px;
    margin-top: .25rem;
}

.sb-item {
    display: flex;
    align-items: center;
    gap: 9px;
    padding: 7px 1.25rem;
    font-size: 13px;
    color: #9896b0;
    cursor: pointer;
    position: relative;
    transition: all .15s;
    text-decoration: none;
    border: none;
    background: none;
    width: 100%;
}
.sb-item i { font-size: 14px; width: 16px; flex-shrink: 0; }
.sb-item:hover { color: #e2e0f0; background: rgba(255,255,255,0.04); }
.sb-item.active { color: #CECBF6; background: rgba(83,74,183,0.2); }
.sb-item.active::before {
    content: '';
    position: absolute;
    left: 0; top: 0; bottom: 0;
    width: 3px;
    background: #534AB7;
    border-radius: 0 3px 3px 0;
}

.sb-badge {
    margin-left: auto;
    font-size: 10px;
    padding: 2px 6px;
    border-radius: 20px;
    font-weight: 600;
    flex-shrink: 0;
}
.sb-badge.red { background: rgba(163,45,45,0.3); color: #F09595; }
.sb-badge.amber { background: rgba(133,79,11,0.3); color: #FAC775; }
.sb-badge.green { background: rgba(15,110,86,0.3); color: #5DCAA5; }

.sb-footer {
    padding: .75rem 1.25rem;
    border-top: 0.5px solid rgba(255,255,255,0.07);
    flex-shrink: 0;
}
.sb-logout-btn {
    display: flex;
    align-items: center;
    gap: 9px;
    font-size: 13px;
    color: #9896b0;
    cursor: pointer;
    background: none;
    border: none;
    padding: 6px 0;
    width: 100%;
    transition: color .15s;
}
.sb-logout-btn:hover { color: #F09595; }
.sb-logout-btn i { font-size: 14px; }
.sb-version { font-size: 10px; color: #534AB7; margin-top: 6px; text-align: center; }

/* ============================================================
   MAIN CONTENT MARGIN
============================================================ */
.main-content {
    margin-left: 240px;
    transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    min-height: 100vh;
    padding-top: 56px;
}

.main-content.expanded {
    margin-left: 72px;
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
    .main-content {
        margin-left: 0 !important;
        padding-top: 56px;
    }
    .admin-sidebar.collapsed {
        width: 280px;
    }
    .admin-sidebar.collapsed .sb-brand > div,
    .admin-sidebar.collapsed .sb-admin > div,
    .admin-sidebar.collapsed .sb-admin .sb-online,
    .admin-sidebar.collapsed .sb-section,
    .admin-sidebar.collapsed .sb-item span,
    .admin-sidebar.collapsed .sb-badge,
    .admin-sidebar.collapsed .sb-footer .sb-version,
    .admin-sidebar.collapsed .sb-logout-btn span {
        display: block;
    }
    .admin-sidebar.collapsed .sb-brand { padding: 1.1rem 1.25rem; justify-content: flex-start; }
    .admin-sidebar.collapsed .sb-admin { padding: .85rem 1.25rem; justify-content: flex-start; }
    .admin-sidebar.collapsed .sb-item { padding: 7px 1.25rem; justify-content: flex-start; }
    .admin-sidebar.collapsed .sb-item i { font-size: 14px; width: 16px; }
    .admin-sidebar.collapsed .sb-footer { text-align: left; }
    .admin-sidebar.collapsed .sb-logout-btn { justify-content: flex-start; padding: 6px 0; }
    .admin-sidebar.collapsed .sb-logout-btn i { font-size: 14px; }
    
    .sb-body {
        max-height: calc(100vh - 200px);
    }
}

@media (max-width: 576px) {
    .admin-sidebar {
        width: 280px;
    }
    .sb-body {
        max-height: calc(100vh - 190px);
    }
}

/* ============================================================
   DARK MODE
============================================================ */
[data-theme="dark"] .admin-sidebar {
    background: #0f0c29;
}
</style>

<script>
// ============================================================
// SIDEBAR TOGGLE - SYNC WITH NAVBAR
// ============================================================
function toggleSidebar() {
    const sidebar = document.getElementById('adminSidebar');
    const mainContent = document.getElementById('mainContent');
    const navbar = document.getElementById('adminNavbar');
    
    if (!sidebar) return;
    
    const isCollapsed = sidebar.classList.toggle('collapsed');
    
    // ✅ Main content adjust
    if (mainContent) {
        mainContent.classList.toggle('expanded', isCollapsed);
    }
    
    // ✅ Navbar adjust - add/remove class
    if (navbar) {
        if (isCollapsed) {
            navbar.classList.add('sidebar-collapsed');
        } else {
            navbar.classList.remove('sidebar-collapsed');
        }
    }
    
    localStorage.setItem('sidebarCollapsed', isCollapsed);
    window.dispatchEvent(new CustomEvent('sidebarToggled', { 
        detail: { collapsed: isCollapsed } 
    }));
}

// ============================================================
// LOAD SAVED STATE ON PAGE LOAD
// ============================================================
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('adminSidebar');
    const mainContent = document.getElementById('mainContent');
    const navbar = document.getElementById('adminNavbar');
    const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
    
    if (sidebar && isCollapsed) {
        sidebar.classList.add('collapsed');
        if (mainContent) mainContent.classList.add('expanded');
        if (navbar) navbar.classList.add('sidebar-collapsed');
    }
});

// ============================================================
// MOBILE SIDEBAR TOGGLE
// ============================================================
function toggleMobileSidebar() {
    const sidebar = document.getElementById('adminSidebar');
    if (sidebar) {
        sidebar.classList.toggle('open');
    }
}

// ============================================================
// CLOSE SIDEBAR ON OUTSIDE CLICK (Mobile)
// ============================================================
document.addEventListener('click', function(e) {
    const sidebar = document.getElementById('adminSidebar');
    const toggleBtn = document.querySelector('.nb-toggle');
    
    if (window.innerWidth <= 992 && sidebar && sidebar.classList.contains('open')) {
        if (!sidebar.contains(e.target) && !toggleBtn?.contains(e.target)) {
            sidebar.classList.remove('open');
        }
    }
});

console.log('%c📁 EktaMart Admin Sidebar Loaded', 'color: #8b5cf6; font-size: 13px; font-weight: bold;');
</script>