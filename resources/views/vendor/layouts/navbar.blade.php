<nav class="vendor-navbar">
    {{-- Left Side --}}
    <div class="navbar-left">
        <button class="toggle-btn" id="sidebarToggle" title="Toggle Sidebar">
            <i class="fas fa-bars"></i>
        </button>
        <h5 class="page-title">
            @yield('page-title', 'Dashboard')
        </h5>
    </div>

    {{-- Right Side --}}
    <div class="navbar-right">
        {{-- Notifications --}}
        <button class="btn-icon" title="Notifications">
            <i class="fas fa-bell"></i>
            <span class="badge-dot"></span>
        </button>

        {{-- User Dropdown --}}
        <div class="dropdown">
            <button class="dropdown-user" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="avatar-sm">
                    {{ strtoupper(substr(Auth::user()->name ?? 'V', 0, 2)) }}
                </div>
                <span class="user-name">{{ Auth::user()->name ?? 'Vendor' }}</span>
                <i class="fas fa-chevron-down user-arrow"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-custom">
                <li>
                    <a class="dropdown-item" href="{{ route('vendor.profile') }}">
                        <i class="fas fa-user"></i> Profile
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('vendor.earnings') }}">
                        <i class="fas fa-money-bill-wave"></i> Earnings
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('vendor.dashboard') }}">
                        <i class="fas fa-th-large"></i> Dashboard
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>