{{-- resources/views/layouts/admin/navbar.blade.php --}}

@php
    use App\Models\Notification;
    use App\Models\Order;
    use App\Models\Review;
    use App\Models\Product;
    use Illuminate\Support\Facades\Auth;

    try {
        $latestNotifications = Notification::where('user_id', Auth::id())
            ->latest()
            ->take(5)
            ->get();

        $unreadNotifications = Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->count();

        $pendingOrders = Order::where('status', 'pending')->count();
        $pendingReviews = Review::where('is_approved', false)->count();
        $lowStock = Product::where('stock', '<', 5)->where('stock', '>', 0)->count();

        $totalUnread = $pendingOrders + $pendingReviews + $lowStock + $unreadNotifications;
    } catch (\Exception $e) {
        $latestNotifications = collect([]);
        $unreadNotifications = 0;
        $pendingOrders = 0;
        $pendingReviews = 0;
        $lowStock = 0;
        $totalUnread = 0;
    }
@endphp

<nav class="admin-navbar" id="adminNavbar">
    {{-- Left Side --}}
    <div class="navbar-left">
        <button class="sidebar-toggle-btn" onclick="toggleSidebar()" aria-label="Toggle sidebar">
            <i class="fas fa-bars"></i>
        </button>
        <button class="sidebar-toggle-btn mobile-toggle-btn" onclick="toggleMobileSidebar()" aria-label="Toggle mobile sidebar">
            <i class="fas fa-bars"></i>
        </button>
        <div class="navbar-breadcrumb">
            <i class="fas fa-@yield('icon', 'th-large')"></i>
            <span>@yield('page-title', 'Dashboard')</span>
        </div>
    </div>

    {{-- Right Side --}}
    <div class="navbar-right">

        {{-- Search --}}
        <div class="navbar-search">
            <i class="fas fa-search"></i>
            <input type="text" id="navbarSearch" placeholder="Search anything..." aria-label="Search">
            <div class="search-shortcut">⌘K</div>
        </div>

        {{-- Notifications --}}
        <div class="navbar-dropdown">
            <button class="nav-icon-btn" id="notifToggle" aria-label="Notifications">
                <i class="fas fa-bell"></i>
                @if($totalUnread > 0)
                    <span class="nav-badge pulse" id="notificationBadge">
                        {{ $totalUnread > 9 ? '9+' : $totalUnread }}
                    </span>
                @endif
            </button>
            <div class="dropdown-menu dropdown-notifications" id="notifMenu">
                <div class="dropdown-header">
                    <div class="dropdown-title">
                        <i class="fas fa-bell"></i> Notifications
                        @if($totalUnread > 0)
                            <span class="badge">{{ $totalUnread }}</span>
                        @endif
                    </div>
                    <a href="{{ route('admin.notifications.index') }}" class="dropdown-link">View All</a>
                </div>

                @if($latestNotifications->count() > 0)
                    <div class="dropdown-body">
                        @foreach($latestNotifications as $notif)
                            <a href="{{ $notif->link ?? '#' }}" class="dropdown-item {{ !$notif->is_read ? 'unread' : '' }}">
                                <div class="item-icon" style="background: {{ $notif->color ?? '#8B5CF6' }}20; color: {{ $notif->color ?? '#8B5CF6' }};">
                                    <i class="{{ $notif->icon_class ?? 'fas fa-bell' }}"></i>
                                </div>
                                <div class="item-content">
                                    <div class="item-title">{{ $notif->title }}</div>
                                    <div class="item-time">{{ $notif->created_at->diffForHumans() }}</div>
                                </div>
                                @if(!$notif->is_read)
                                    <span class="item-badge">New</span>
                                @endif
                            </a>
                        @endforeach
                    </div>
                    <div class="dropdown-footer">
                        <a href="{{ route('admin.notifications.index') }}" class="btn btn-sm btn-primary w-100">
                            View All Notifications
                        </a>
                    </div>
                @else
                    <div class="dropdown-empty">
                        <i class="fas fa-check-circle"></i>
                        <span>All caught up!</span>
                    </div>
                @endif
            </div>
        </div>

        {{-- Divider --}}
        <span class="navbar-divider"></span>

        {{-- Profile Dropdown --}}
        <div class="navbar-dropdown">
            <button class="profile-toggle" id="profileToggle">
                <div class="profile-avatar">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
                <div class="profile-info">
                    <div class="profile-name">{{ Auth::user()->name }}</div>
                    <div class="profile-role">Administrator</div>
                </div>
                <i class="fas fa-chevron-down profile-arrow"></i>
            </button>
            <div class="dropdown-menu dropdown-profile" id="profileMenu">
                <div class="dropdown-header">
                    <div class="profile-avatar-lg">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                    <div>
                        <div class="profile-name-lg">{{ Auth::user()->name }}</div>
                        <div class="profile-email-lg">{{ Auth::user()->email }}</div>
                    </div>
                </div>
                <div class="dropdown-divider"></div>
                <a href="{{ route('admin.profile.index') }}" class="dropdown-item-link">
                    <i class="fas fa-user-cog"></i> My Profile
                </a>
                <a href="{{ route('admin.settings.general') }}" class="dropdown-item-link">
                    <i class="fas fa-cog"></i> Settings
                </a>
                <a href="#" class="dropdown-item-link">
                    <i class="fas fa-clipboard-list"></i> Activity Logs
                </a>
                <a href="#" class="dropdown-item-link">
                    <i class="fas fa-lock"></i> Change Password
                </a>
                <div class="dropdown-divider"></div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item-link text-danger">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </div>

    </div>
</nav>

<style>
/* ============================================================
   NAVBAR
============================================================ */
.admin-navbar {
    height: var(--navbar-height);
    background: var(--bg-card);
    border-bottom: 1px solid var(--border-color);
    position: fixed;
    top: 0;
    left: var(--sidebar-width);
    right: 0;
    z-index: 1040;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 24px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: var(--shadow-sm);
    backdrop-filter: blur(10px);
}

.admin-navbar.sidebar-collapsed {
    left: var(--sidebar-collapsed);
}

/* ============================================================
   NAVBAR LEFT
============================================================ */
.navbar-left {
    display: flex;
    align-items: center;
    gap: 16px;
}

.sidebar-toggle-btn {
    width: 38px;
    height: 38px;
    border: 1px solid var(--border-color);
    border-radius: 10px;
    background: transparent;
    color: var(--text-secondary);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: var(--transition);
    font-size: 16px;
    flex-shrink: 0;
}
.sidebar-toggle-btn:hover {
    background: var(--bg-body);
    color: var(--text-primary);
}

.mobile-toggle-btn {
    display: none;
}

.navbar-breadcrumb {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    font-weight: 600;
    color: var(--text-primary);
}
.navbar-breadcrumb i {
    color: var(--primary);
    font-size: 16px;
}

/* ============================================================
   NAVBAR RIGHT
============================================================ */
.navbar-right {
    display: flex;
    align-items: center;
    gap: 12px;
}

/* ============================================================
   SEARCH
============================================================ */
.navbar-search {
    display: flex;
    align-items: center;
    gap: 10px;
    background: var(--bg-body);
    border: 1px solid var(--border-color);
    border-radius: 10px;
    padding: 0 14px;
    height: 38px;
    min-width: 200px;
    transition: var(--transition);
    position: relative;
}
.navbar-search:focus-within {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
}
.navbar-search i {
    color: var(--text-muted);
    font-size: 14px;
}
.navbar-search input {
    border: none;
    background: transparent;
    outline: none;
    font-size: 13px;
    color: var(--text-primary);
    width: 100%;
}
.navbar-search input::placeholder {
    color: var(--text-muted);
}
.search-shortcut {
    font-size: 10px;
    color: var(--text-muted);
    background: var(--bg-body);
    padding: 2px 8px;
    border-radius: 4px;
    border: 1px solid var(--border-color);
    font-weight: 500;
    flex-shrink: 0;
}

/* ============================================================
   NAV ICON BUTTON
============================================================ */
.nav-icon-btn {
    width: 38px;
    height: 38px;
    border: 1px solid var(--border-color);
    border-radius: 10px;
    background: transparent;
    color: var(--text-secondary);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: var(--transition);
    font-size: 16px;
    position: relative;
    flex-shrink: 0;
}
.nav-icon-btn:hover {
    background: var(--bg-body);
    color: var(--text-primary);
}

.nav-badge {
    position: absolute;
    top: -4px;
    right: -4px;
    background: var(--danger);
    color: #fff;
    font-size: 9px;
    font-weight: 700;
    padding: 1px 5px;
    border-radius: 50%;
    min-width: 18px;
    text-align: center;
    border: 2px solid var(--bg-card);
}

.navbar-divider {
    width: 1px;
    height: 28px;
    background: var(--border-color);
    flex-shrink: 0;
}

/* ============================================================
   PROFILE
============================================================ */
.profile-toggle {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 4px 8px 4px 4px;
    border: 1px solid var(--border-color);
    border-radius: 10px;
    background: transparent;
    cursor: pointer;
    transition: var(--transition);
    flex-shrink: 0;
}
.profile-toggle:hover {
    background: var(--bg-body);
}

.profile-avatar {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    font-weight: 700;
    flex-shrink: 0;
}

.profile-info {
    text-align: left;
    line-height: 1.2;
}
.profile-name {
    font-size: 13px;
    font-weight: 600;
    color: var(--text-primary);
}
.profile-role {
    font-size: 10px;
    color: var(--text-muted);
}

.profile-arrow {
    font-size: 11px;
    color: var(--text-muted);
    transition: transform 0.2s ease;
}
.profile-toggle.active .profile-arrow {
    transform: rotate(180deg);
}

/* ============================================================
   DROPDOWN
============================================================ */
.navbar-dropdown {
    position: relative;
}

.dropdown-menu {
    position: absolute;
    top: calc(100% + 8px);
    right: 0;
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    border-radius: 12px;
    padding: 8px 0;
    min-width: 320px;
    max-width: 400px;
    max-height: 480px;
    overflow-y: auto;
    display: none;
    box-shadow: var(--shadow-lg);
    z-index: 1060;
    animation: slideDown 0.2s ease;
}
.dropdown-menu.show {
    display: block;
}

.dropdown-menu::-webkit-scrollbar {
    width: 3px;
}
.dropdown-menu::-webkit-scrollbar-track {
    background: transparent;
}
.dropdown-menu::-webkit-scrollbar-thumb {
    background: rgba(139, 92, 246, 0.3);
    border-radius: 10px;
}

.dropdown-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 6px 16px 10px 16px;
    border-bottom: 1px solid var(--border-color);
}
.dropdown-title {
    font-size: 13px;
    font-weight: 600;
    color: var(--text-primary);
    display: flex;
    align-items: center;
    gap: 8px;
}
.dropdown-title .badge {
    font-size: 9px;
    background: var(--primary);
    color: #fff;
    padding: 1px 8px;
    border-radius: 20px;
}
.dropdown-link {
    font-size: 12px;
    color: var(--primary);
    text-decoration: none;
    font-weight: 500;
}
.dropdown-link:hover {
    text-decoration: underline;
}

.dropdown-body {
    padding: 4px 0;
}

.dropdown-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 10px 16px;
    text-decoration: none;
    transition: all 0.2s ease;
    cursor: pointer;
}
.dropdown-item:hover {
    background: var(--bg-body);
}
.dropdown-item.unread {
    background: rgba(139, 92, 246, 0.04);
    border-left: 3px solid var(--primary);
}

.item-icon {
    width: 34px;
    height: 34px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    flex-shrink: 0;
}

.item-content {
    flex: 1;
    min-width: 0;
}
.item-title {
    font-size: 13px;
    font-weight: 500;
    color: var(--text-primary);
}
.item-time {
    font-size: 11px;
    color: var(--text-muted);
    margin-top: 2px;
}
.item-badge {
    font-size: 8px;
    font-weight: 700;
    color: var(--primary);
    background: rgba(139, 92, 246, 0.1);
    padding: 2px 8px;
    border-radius: 20px;
    flex-shrink: 0;
}

.dropdown-footer {
    padding: 8px 16px 4px 16px;
    border-top: 1px solid var(--border-color);
}
.dropdown-footer .btn {
    font-size: 13px;
    font-weight: 600;
    padding: 8px 0;
    border-radius: 8px;
}

.dropdown-empty {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 24px 16px;
    color: var(--text-muted);
    font-size: 14px;
}
.dropdown-empty i {
    color: var(--success);
    font-size: 18px;
}

/* ============================================================
   PROFILE DROPDOWN
============================================================ */
.dropdown-profile {
    min-width: 240px;
}

.profile-avatar-lg {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    font-weight: 700;
    flex-shrink: 0;
}

.profile-name-lg {
    font-size: 14px;
    font-weight: 600;
    color: var(--text-primary);
}
.profile-email-lg {
    font-size: 12px;
    color: var(--text-muted);
}

.dropdown-item-link {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 8px 16px;
    color: var(--text-secondary);
    text-decoration: none;
    font-size: 13px;
    font-weight: 500;
    transition: all 0.15s ease;
    border: none;
    background: none;
    width: 100%;
    cursor: pointer;
}
.dropdown-item-link:hover {
    background: var(--bg-body);
    color: var(--text-primary);
}
.dropdown-item-link i {
    width: 18px;
    font-size: 14px;
    color: var(--text-muted);
}
.dropdown-item-link.text-danger {
    color: var(--danger);
}
.dropdown-item-link.text-danger i {
    color: var(--danger);
}

.dropdown-divider {
    border: none;
    border-top: 1px solid var(--border-color);
    margin: 4px 0;
}

/* ============================================================
   RESPONSIVE
============================================================ */
@media (max-width: 992px) {
    .admin-navbar {
        left: 0 !important;
        padding: 0 16px;
    }
    .admin-navbar.sidebar-collapsed {
        left: 0 !important;
    }
    .sidebar-toggle-btn {
        display: none;
    }
    .mobile-toggle-btn {
        display: flex;
    }
    .navbar-search {
        min-width: 120px;
    }
    .navbar-search .search-shortcut {
        display: none;
    }
    .dropdown-menu {
        min-width: 280px;
        max-width: 320px;
        right: -60px;
    }
}

@media (max-width: 768px) {
    .admin-navbar {
        padding: 0 12px;
        height: 56px;
    }
    .navbar-search {
        min-width: 80px;
        padding: 0 10px;
        height: 34px;
    }
    .navbar-search input {
        font-size: 12px;
    }
    .profile-info {
        display: none;
    }
    .profile-toggle {
        padding: 4px;
    }
    .dropdown-menu {
        min-width: 260px;
        max-width: 290px;
        right: -70px;
    }
    .navbar-breadcrumb span {
        font-size: 13px;
    }
}

@media (max-width: 576px) {
    .admin-navbar {
        padding: 0 8px;
        height: 50px;
    }
    .navbar-search {
        min-width: 60px;
        padding: 0 8px;
        height: 30px;
    }
    .navbar-search input {
        font-size: 11px;
        width: 60px;
    }
    .navbar-breadcrumb span {
        font-size: 12px;
    }
    .navbar-breadcrumb i {
        font-size: 13px;
    }
    .nav-icon-btn {
        width: 34px;
        height: 34px;
        font-size: 14px;
    }
    .dropdown-menu {
        min-width: 240px;
        max-width: 260px;
        right: -80px;
    }
}

/* ============================================================
   DARK MODE
============================================================ */
[data-theme="dark"] .admin-navbar {
    background: rgba(26, 23, 48, 0.95);
    border-bottom-color: rgba(255, 255, 255, 0.06);
}
[data-theme="dark"] .sidebar-toggle-btn,
[data-theme="dark"] .nav-icon-btn,
[data-theme="dark"] .profile-toggle {
    border-color: rgba(255, 255, 255, 0.08);
    color: #9896b0;
}
[data-theme="dark"] .sidebar-toggle-btn:hover,
[data-theme="dark"] .nav-icon-btn:hover,
[data-theme="dark"] .profile-toggle:hover {
    background: rgba(255, 255, 255, 0.04);
    color: #e2e0f0;
}
[data-theme="dark"] .navbar-search {
    background: rgba(255, 255, 255, 0.04);
    border-color: rgba(255, 255, 255, 0.08);
}
[data-theme="dark"] .navbar-search input {
    color: #e2e0f0;
}
[data-theme="dark"] .navbar-search input::placeholder {
    color: #64748b;
}
[data-theme="dark"] .search-shortcut {
    background: rgba(255, 255, 255, 0.06);
    border-color: rgba(255, 255, 255, 0.08);
    color: #64748b;
}
[data-theme="dark"] .profile-name {
    color: #e2e0f0;
}
[data-theme="dark"] .navbar-breadcrumb {
    color: #e2e0f0;
}
[data-theme="dark"] .dropdown-item-link {
    color: #9896b0;
}
[data-theme="dark"] .dropdown-item-link:hover {
    background: rgba(255, 255, 255, 0.04);
    color: #e2e0f0;
}
[data-theme="dark"] .dropdown-item.unread {
    background: rgba(139, 92, 246, 0.08);
}
[data-theme="dark"] .dropdown-menu {
    background: #1A1A3E;
    border-color: rgba(255, 255, 255, 0.06);
}
[data-theme="dark"] .dropdown-header {
    border-bottom-color: rgba(255, 255, 255, 0.06);
}
[data-theme="dark"] .dropdown-divider {
    border-top-color: rgba(255, 255, 255, 0.06);
}
[data-theme="dark"] .dropdown-footer {
    border-top-color: rgba(255, 255, 255, 0.06);
}
[data-theme="dark"] .dropdown-item:hover {
    background: rgba(255, 255, 255, 0.04);
}
[data-theme="dark"] .item-title {
    color: #e2e0f0;
}
[data-theme="dark"] .profile-name-lg {
    color: #e2e0f0;
}
</style>

<script>
// ============================================================
// DROPDOWN TOGGLES
// ============================================================
document.addEventListener('DOMContentLoaded', function() {
    // Notifications Dropdown
    const notifToggle = document.getElementById('notifToggle');
    const notifMenu = document.getElementById('notifMenu');
    const profileToggle = document.getElementById('profileToggle');
    const profileMenu = document.getElementById('profileMenu');

    if (notifToggle && notifMenu) {
        notifToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            notifMenu.classList.toggle('show');
            if (profileMenu) profileMenu.classList.remove('show');
            this.classList.toggle('active');
        });
    }

    if (profileToggle && profileMenu) {
        profileToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            profileMenu.classList.toggle('show');
            if (notifMenu) notifMenu.classList.remove('show');
            this.classList.toggle('active');
        });
    }

    // Close dropdowns on outside click
    document.addEventListener('click', function(e) {
        if (notifMenu && !notifMenu.contains(e.target) && e.target !== notifToggle) {
            notifMenu.classList.remove('show');
            if (notifToggle) notifToggle.classList.remove('active');
        }
        if (profileMenu && !profileMenu.contains(e.target) && e.target !== profileToggle) {
            profileMenu.classList.remove('show');
            if (profileToggle) profileToggle.classList.remove('active');
        }
    });

    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            if (notifMenu) notifMenu.classList.remove('show');
            if (notifToggle) notifToggle.classList.remove('active');
            if (profileMenu) profileMenu.classList.remove('show');
            if (profileToggle) profileToggle.classList.remove('active');
        }
    });

    // Keyboard shortcut for search (Cmd+K / Ctrl+K)
    document.addEventListener('keydown', function(e) {
        if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
            e.preventDefault();
            const searchInput = document.querySelector('#navbarSearch');
            if (searchInput) {
                searchInput.focus();
            }
        }
    });
});

// ============================================================
// NOTIFICATION COUNT UPDATE
// ============================================================
function updateNotificationCount() {
    fetch('{{ route("admin.notifications.unread") }}')
        .then(response => response.json())
        .then(data => {
            const badge = document.getElementById('notificationBadge');
            if (badge) {
                if (data.count > 0) {
                    badge.textContent = data.count > 9 ? '9+' : data.count;
                    badge.style.display = 'block';
                } else {
                    badge.style.display = 'none';
                }
            }
        })
        .catch(error => console.error('Error updating notification count:', error));
}

// Update every 30 seconds
setInterval(updateNotificationCount, 30000);

// ============================================================
// SEARCH FOCUS
// ============================================================
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('navbarSearch');
    if (searchInput) {
        searchInput.addEventListener('focus', function() {
            this.parentElement.style.borderColor = '#8B5CF6';
            this.parentElement.style.boxShadow = '0 0 0 3px rgba(139, 92, 246, 0.1)';
        });
        searchInput.addEventListener('blur', function() {
            this.parentElement.style.borderColor = '';
            this.parentElement.style.boxShadow = '';
        });
    }
});

// ============================================================
// CONSOLE GREETING
// ============================================================
console.log('%c🔧 Admin Navbar Loaded', 'color: #8B5CF6; font-size: 13px; font-weight: bold;');
console.log('%c🔔 Total Unread: {{ $totalUnread ?? 0 }}', 'color: #F59E0B; font-size: 12px;');
console.log('%c⌨️  Press Cmd+K or Ctrl+K to focus search', 'color: #10B981; font-size: 11px;');
</script>