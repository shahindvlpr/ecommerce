{{-- resources/views/layouts/admin/navbar.blade.php --}}

<nav class="admin-navbar" id="adminNavbar">

    {{-- Sidebar Toggle --}}
    <button class="nb-toggle" id="sidebarToggleBtn" onclick="toggleSidebar()" aria-label="Toggle sidebar">
        <i class="fas fa-bars"></i>
    </button>

    {{-- Search --}}
    <div class="nb-search">
        <i class="fas fa-search"></i>
        <input type="text" id="adminSearch" placeholder="Search orders, products, users..."
               onkeyup="handleAdminSearch(this.value)">
        <div class="nb-search-results" id="searchResults"></div>
    </div>

    {{-- Right Side --}}
    <div class="nb-right">

        {{-- Pending Orders Quick Link --}}
        @php $pendingOrders = \App\Models\Order::where('status','pending')->count(); @endphp
        <a href="{{ route('admin.orders.index') }}" class="nb-btn" title="Pending Orders">
            <i class="fas fa-shopping-bag"></i>
            @if($pendingOrders > 0)
                <span class="nb-dot amber"></span>
            @endif
        </a>

        {{-- Notifications --}}
        @php $pendingReviews = \App\Models\Review::where('is_approved', false)->count(); @endphp
        <div class="nb-dropdown">
            <button class="nb-btn" id="notifToggle" aria-label="Notifications">
                <i class="fas fa-bell"></i>
                @php $totalNotif = $pendingOrders + $pendingReviews; @endphp
                @if($totalNotif > 0)
                    <span class="nb-badge">{{ $totalNotif > 9 ? '9+' : $totalNotif }}</span>
                @endif
            </button>
            <div class="nb-dropdown-menu notif-menu" id="notifMenu">
                <div class="notif-header">
                    <span class="notif-title">Notifications</span>
                    <a href="{{ route('admin.notifications.index') }}" class="notif-see-all">See all</a>
                </div>

                @if($pendingOrders > 0)
                <a href="{{ route('admin.orders.index') }}" class="notif-item unread">
                    <div class="notif-icon" style="background:#FAEEDA;color:#633806">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <div>
                        <div class="notif-text">{{ $pendingOrders }} new order{{ $pendingOrders > 1 ? 's' : '' }} pending</div>
                        <div class="notif-time">Needs your attention</div>
                    </div>
                </a>
                @endif

                @if($pendingReviews > 0)
                <a href="{{ route('admin.reviews.pending') }}" class="notif-item unread">
                    <div class="notif-icon" style="background:#FCEBEB;color:#501313">
                        <i class="fas fa-star"></i>
                    </div>
                    <div>
                        <div class="notif-text">{{ $pendingReviews }} review{{ $pendingReviews > 1 ? 's' : '' }} pending approval</div>
                        <div class="notif-time">Needs moderation</div>
                    </div>
                </a>
                @endif

                @php
                    $lowStock = \App\Models\Product::where('stock', '<', 5)->where('stock', '>', 0)->count();
                @endphp
                @if($lowStock > 0)
                <a href="{{ route('admin.reports.low-stock') }}" class="notif-item">
                    <div class="notif-icon" style="background:#EAF3DE;color:#27500A">
                        <i class="fas fa-box"></i>
                    </div>
                    <div>
                        <div class="notif-text">{{ $lowStock }} product{{ $lowStock > 1 ? 's' : '' }} low on stock</div>
                        <div class="notif-time">Restock needed</div>
                    </div>
                </a>
                @endif

                @if($pendingOrders == 0 && $pendingReviews == 0 && $lowStock == 0)
                <div class="notif-empty">
                    <i class="fas fa-check-circle"></i>
                    <span>All caught up!</span>
                </div>
                @endif
            </div>
        </div>

        <div class="nb-divider"></div>

        {{-- Profile Dropdown --}}
        <div class="nb-dropdown">
            <div class="nb-profile" id="profileToggle">
                <div class="nb-avatar">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
                <div class="nb-profile-info">
                    <div class="nb-profile-name">{{ Str::limit(Auth::user()->name, 14) }}</div>
                    <div class="nb-profile-role">Administrator</div>
                </div>
                <i class="fas fa-chevron-down nb-chevron"></i>
            </div>
            <div class="nb-dropdown-menu profile-menu" id="profileMenu">
                <div class="drop-header">
                    <div class="drop-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
                    <div>
                        <div class="drop-name">{{ Auth::user()->name }}</div>
                        <div class="drop-email">{{ Auth::user()->email }}</div>
                    </div>
                </div>
                <hr class="drop-divider">
                <a href="{{ route('admin.settings.index') }}" class="drop-item">
                    <i class="fas fa-user-cog"></i> My Profile
                </a>
                <a href="{{ route('admin.settings.index') }}" class="drop-item">
                    <i class="fas fa-cog"></i> Settings
                </a>
                <a href="{{ route('home') }}" target="_blank" class="drop-item">
                    <i class="fas fa-external-link-alt"></i> View Store
                </a>
                <hr class="drop-divider">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="drop-item danger">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </div>

    </div>
</nav>

<style>
/* ============================================================
   ADMIN NAVBAR - MAIN
============================================================ */
.admin-navbar {
    height: 56px;
    background: #fff;
    border-bottom: 0.5px solid #e5e7eb;
    display: flex;
    align-items: center;
    padding: 0 1.25rem;
    gap: 12px;
    position: fixed;
    top: 0;
    right: 0;
    z-index: 100;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    
    /* ✅ Sidebar এর সাথে align */
    margin-left: 240px;
    transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1), width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    width: calc(100% - 240px);
}

/* ✅ Sidebar collapsed হলে Navbar adjust */
.admin-navbar.sidebar-collapsed {
    margin-left: 72px;
    width: calc(100% - 72px);
}

/* ============================================================
   NAVBAR COMPONENTS
============================================================ */
.nb-toggle {
    width: 34px; height: 34px;
    border: 0.5px solid #e5e7eb;
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; background: transparent;
    color: #6b7280; font-size: 16px; flex-shrink: 0;
    transition: all .15s;
}
.nb-toggle:hover { background: #f9fafb; color: #374151; }

.nb-search {
    flex: 1; max-width: 340px;
    display: flex; align-items: center; gap: 8px;
    background: #f9fafb;
    border: 0.5px solid #e5e7eb;
    border-radius: 8px;
    padding: 0 10px; height: 34px;
    position: relative;
}
.nb-search i { font-size: 13px; color: #9ca3af; }
.nb-search input {
    border: none; background: transparent; outline: none;
    font-size: 13px; color: #374151; width: 100%;
}
.nb-search input::placeholder { color: #9ca3af; }
.nb-search-results {
    position: absolute; top: calc(100% + 6px); left: 0; right: 0;
    background: #fff; border: 0.5px solid #e5e7eb; border-radius: 8px;
    max-height: 300px; overflow-y: auto; display: none;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08); z-index: 200;
}
.nb-search-results.show { display: block; }

.nb-right { margin-left: auto; display: flex; align-items: center; gap: 8px; }

.nb-btn {
    width: 34px; height: 34px;
    border: 0.5px solid #e5e7eb; border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; background: transparent;
    color: #6b7280; font-size: 15px;
    position: relative; flex-shrink: 0;
    text-decoration: none; transition: all .15s;
}
.nb-btn:hover { background: #f9fafb; color: #374151; }

.nb-dot {
    position: absolute; top: 7px; right: 7px;
    width: 7px; height: 7px; border-radius: 50%;
    border: 1.5px solid #fff;
}
.nb-dot.amber { background: #f59e0b; }
.nb-dot.red { background: #ef4444; }

.nb-badge {
    position: absolute; top: -4px; right: -4px;
    background: #dc2626; color: #fff;
    font-size: 9px; font-weight: 600;
    padding: 1px 4px; border-radius: 20px;
    min-width: 16px; text-align: center;
    border: 1.5px solid #fff;
}

.nb-divider { width: 0.5px; height: 24px; background: #e5e7eb; margin: 0 4px; }

/* ============================================================
   DROPDOWN
============================================================ */
.nb-dropdown { position: relative; }
.nb-dropdown-menu {
    position: absolute; top: calc(100% + 8px); right: 0;
    background: #fff; border: 0.5px solid #e5e7eb;
    border-radius: 12px; padding: .5rem;
    min-width: 200px; display: none;
    box-shadow: 0 8px 30px rgba(0,0,0,0.1); z-index: 200;
}
.nb-dropdown-menu.show { display: block; }

.notif-menu { min-width: 290px; }
.notif-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 6px 10px 8px;
    border-bottom: 0.5px solid #e5e7eb; margin-bottom: 4px;
}
.notif-title { font-size: 13px; font-weight: 600; color: #111827; }
.notif-see-all { font-size: 11px; color: #534AB7; text-decoration: none; }

.notif-item {
    display: flex; align-items: flex-start; gap: 10px;
    padding: 8px 10px; border-radius: 8px;
    text-decoration: none; cursor: pointer;
}
.notif-item:hover { background: #f9fafb; }
.notif-item.unread { background: #fafafe; }
.notif-icon {
    width: 32px; height: 32px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 13px; flex-shrink: 0;
}
.notif-text { font-size: 12px; color: #374151; line-height: 1.4; }
.notif-time { font-size: 10px; color: #9ca3af; margin-top: 2px; }
.notif-empty {
    display: flex; align-items: center; justify-content: center;
    gap: 6px; padding: 1rem;
    font-size: 13px; color: #6b7280;
}
.notif-empty i { color: #10b981; }

.nb-profile {
    display: flex; align-items: center; gap: 8px;
    padding: 4px 8px 4px 4px;
    border: 0.5px solid #e5e7eb; border-radius: 8px;
    cursor: pointer; transition: all .15s;
}
.nb-profile:hover { background: #f9fafb; }
.nb-avatar {
    width: 28px; height: 28px; border-radius: 50%;
    background: #EEEDFE; color: #3C3489;
    font-size: 11px; font-weight: 600;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.nb-profile-name { font-size: 12px; font-weight: 600; color: #111827; line-height: 1.2; }
.nb-profile-role { font-size: 10px; color: #6b7280; }
.nb-chevron { font-size: 11px; color: #9ca3af; }

.drop-header {
    display: flex; align-items: center; gap: 10px;
    padding: 8px 10px 10px;
    border-bottom: 0.5px solid #e5e7eb; margin-bottom: 4px;
}
.drop-avatar {
    width: 36px; height: 36px; border-radius: 50%;
    background: #EEEDFE; color: #3C3489;
    font-size: 13px; font-weight: 600;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.drop-name { font-size: 13px; font-weight: 600; color: #111827; }
.drop-email { font-size: 11px; color: #6b7280; }

.drop-item {
    display: flex; align-items: center; gap: 8px;
    padding: 7px 10px; border-radius: 8px;
    font-size: 13px; color: #374151;
    text-decoration: none; cursor: pointer;
    background: none; border: none; width: 100%;
    transition: background .15s;
}
.drop-item:hover { background: #f9fafb; }
.drop-item i { font-size: 14px; color: #6b7280; width: 16px; }
.drop-item.danger { color: #dc2626; }
.drop-item.danger i { color: #dc2626; }
.drop-divider { border: none; border-top: 0.5px solid #e5e7eb; margin: .35rem 0; }

/* ============================================================
   RESPONSIVE
============================================================ */
@media (max-width: 992px) {
    .admin-navbar {
        margin-left: 0 !important;
        width: 100% !important;
        position: sticky;
    }
}

@media (max-width: 768px) {
    .admin-navbar {
        padding: 0 0.8rem;
        gap: 8px;
        height: 50px;
    }
    .nb-search {
        max-width: 160px;
        height: 30px;
    }
    .nb-search input {
        font-size: 12px;
    }
    .nb-profile-info {
        display: none;
    }
    .nb-profile {
        padding: 4px;
    }
    .nb-avatar {
        width: 28px;
        height: 28px;
        font-size: 10px;
    }
    .notif-menu {
        min-width: 260px;
    }
}

@media (max-width: 576px) {
    .admin-navbar {
        padding: 0 0.5rem;
        gap: 4px;
    }
    .nb-search {
        max-width: 120px;
        padding: 0 6px;
    }
    .nb-search input {
        font-size: 11px;
    }
    .nb-toggle {
        width: 30px;
        height: 30px;
        font-size: 14px;
    }
    .nb-btn {
        width: 30px;
        height: 30px;
        font-size: 13px;
    }
    .nb-right {
        gap: 4px;
    }
}

/* ============================================================
   DARK MODE
============================================================ */
[data-theme="dark"] .admin-navbar {
    background: #1a1730;
    border-bottom-color: rgba(255,255,255,0.07);
}
[data-theme="dark"] .nb-toggle,
[data-theme="dark"] .nb-btn,
[data-theme="dark"] .nb-profile {
    border-color: rgba(255,255,255,0.1);
    color: #9896b0;
}
[data-theme="dark"] .nb-toggle:hover,
[data-theme="dark"] .nb-btn:hover,
[data-theme="dark"] .nb-profile:hover {
    background: rgba(255,255,255,0.05);
    color: #e2e0f0;
}
[data-theme="dark"] .nb-search {
    background: rgba(255,255,255,0.05);
    border-color: rgba(255,255,255,0.1);
}
[data-theme="dark"] .nb-search input {
    color: #e2e0f0;
}
[data-theme="dark"] .nb-profile-name {
    color: #e2e0f0;
}
[data-theme="dark"] .nb-dropdown-menu {
    background: #1a1730;
    border-color: rgba(255,255,255,0.1);
}
[data-theme="dark"] .drop-item {
    color: #9896b0;
}
[data-theme="dark"] .drop-item:hover {
    background: rgba(255,255,255,0.05);
    color: #e2e0f0;
}
[data-theme="dark"] .drop-name {
    color: #e2e0f0;
}
[data-theme="dark"] .notif-item:hover,
[data-theme="dark"] .notif-item.unread {
    background: rgba(255,255,255,0.03);
}
[data-theme="dark"] .notif-text {
    color: #9896b0;
}
[data-theme="dark"] .nb-divider {
    background: rgba(255,255,255,0.07);
}
</style>

<script>
// Dropdown toggle
document.getElementById('notifToggle')?.addEventListener('click', function(e) {
    e.stopPropagation();
    document.getElementById('notifMenu').classList.toggle('show');
    document.getElementById('profileMenu').classList.remove('show');
});

document.getElementById('profileToggle')?.addEventListener('click', function(e) {
    e.stopPropagation();
    document.getElementById('profileMenu').classList.toggle('show');
    document.getElementById('notifMenu').classList.remove('show');
});

document.addEventListener('click', function() {
    document.getElementById('notifMenu')?.classList.remove('show');
    document.getElementById('profileMenu')?.classList.remove('show');
});

// ============================================================
// SIDEBAR TOGGLE - FIXED
// ============================================================
function toggleSidebar() {
    const sidebar = document.getElementById('adminSidebar');
    const navbar = document.getElementById('adminNavbar');
    const mainContent = document.getElementById('mainContent');
    
    if (!sidebar) return;
    
    const isCollapsed = sidebar.classList.toggle('collapsed');
    
    // ✅ Navbar adjust - add/remove class
    if (navbar) {
        if (isCollapsed) {
            navbar.classList.add('sidebar-collapsed');
        } else {
            navbar.classList.remove('sidebar-collapsed');
        }
    }
    
    // ✅ Main content adjust
    if (mainContent) {
        if (isCollapsed) {
            mainContent.classList.add('expanded');
        } else {
            mainContent.classList.remove('expanded');
        }
    }
    
    localStorage.setItem('sidebarCollapsed', isCollapsed);
    window.dispatchEvent(new CustomEvent('sidebarToggled', { 
        detail: { collapsed: isCollapsed } 
    }));
}

// ✅ Load saved state on page load
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('adminSidebar');
    const navbar = document.getElementById('adminNavbar');
    const mainContent = document.getElementById('mainContent');
    const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
    
    if (sidebar && isCollapsed) {
        sidebar.classList.add('collapsed');
        if (navbar) navbar.classList.add('sidebar-collapsed');
        if (mainContent) mainContent.classList.add('expanded');
    }
});

// Admin search
let searchTimeout;
function handleAdminSearch(query) {
    clearTimeout(searchTimeout);
    const resultsEl = document.getElementById('searchResults');
    if (query.length < 2) { resultsEl.classList.remove('show'); return; }
    searchTimeout = setTimeout(() => {
        fetch(`/ajax/products/search?q=${encodeURIComponent(query)}`)
            .then(r => r.json())
            .then(data => {
                if (data.length === 0) {
                    resultsEl.innerHTML = `<div style="padding:12px;font-size:13px;color:#6b7280;text-align:center">No results found</div>`;
                } else {
                    resultsEl.innerHTML = data.map(p => `
                        <a href="/admin/products/${p.id}/edit"
                           style="display:flex;align-items:center;gap:8px;padding:8px 12px;text-decoration:none;font-size:13px;color:#374151;border-bottom:0.5px solid #f3f4f6">
                            <i class="fas fa-box" style="color:#9ca3af;font-size:12px"></i>
                            ${p.name}
                            <span style="margin-left:auto;font-size:11px;color:#9ca3af">$${p.price}</span>
                        </a>
                    `).join('');
                }
                resultsEl.classList.add('show');
            })
            .catch(() => resultsEl.classList.remove('show'));
    }, 400);
}

// Close search on outside click
document.addEventListener('click', function(e) {
    if (!e.target.closest('.nb-search')) {
        document.getElementById('searchResults')?.classList.remove('show');
    }
});

console.log('%c🔧 EktaMart Admin Navbar Loaded', 'color: #8b5cf6; font-size: 13px; font-weight: bold;');
</script>