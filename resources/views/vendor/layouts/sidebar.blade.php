<nav id="sidebar-wrapper">
    {{-- Brand --}}
    <div class="sidebar-brand">
        <h4>Ekta<span>Mart</span></h4>
        <small>Vendor Panel</small>
    </div>

    {{-- User Info --}}
    <div class="sidebar-user">
        <div class="avatar">
            {{ strtoupper(substr(Auth::user()->name ?? 'V', 0, 2)) }}
        </div>
        <div class="info">
            <span class="name">{{ Auth::user()->name ?? 'Vendor' }}</span>
            <span class="role">Vendor</span>
        </div>
        <span class="badge-status">
            <i class="fas fa-circle" style="font-size: 6px; margin-right: 4px;"></i>
            {{ Auth::user()->is_vendor_approved ? 'Active' : 'Pending' }}
        </span>
    </div>

    {{-- Navigation --}}
    <div class="sidebar-nav">
        {{-- MAIN --}}
        <div class="nav-section">Main</div>

        <div class="nav-item">
            <a href="{{ route('vendor.dashboard') }}" class="nav-link {{ request()->routeIs('vendor.dashboard') ? 'active' : '' }}">
                <i class="fas fa-th-large"></i>
                <span>Dashboard</span>
            </a>
        </div>

        {{-- CATALOG --}}
        <div class="nav-section">Catalog</div>

        <div class="nav-item">
            <a href="{{ route('vendor.products.index') }}" class="nav-link {{ request()->routeIs('vendor.products.*') ? 'active' : '' }}">
                <i class="fas fa-box"></i>
                <span>Products</span>
                @php
                    $lowStock = \App\Models\Product::where('vendor_id', Auth::id())->where('stock', '<', 10)->count();
                @endphp
                @if($lowStock > 0)
                    <span class="badge">{{ $lowStock }}</span>
                @endif
            </a>
        </div>

        {{-- ORDERS --}}
        <div class="nav-section">Sales</div>

        <div class="nav-item">
            <a href="{{ route('vendor.orders.index') }}" class="nav-link {{ request()->routeIs('vendor.orders.*') ? 'active' : '' }}">
                <i class="fas fa-shopping-cart"></i>
                <span>Orders</span>
                @php
                    $pendingOrders = \App\Models\Order::where('vendor_id', Auth::id())->where('status', 'pending')->count();
                @endphp
                @if($pendingOrders > 0)
                    <span class="badge">{{ $pendingOrders }}</span>
                @endif
            </a>
        </div>

        <div class="nav-item">
            <a href="{{ route('vendor.earnings') }}" class="nav-link {{ request()->routeIs('vendor.earnings') ? 'active' : '' }}">
                <i class="fas fa-money-bill-wave"></i>
                <span>Earnings</span>
            </a>
        </div>

        {{-- REPORTS --}}
        <div class="nav-section">Analytics</div>

        <div class="nav-item">
            <a href="{{ route('vendor.reports.sales') }}" class="nav-link {{ request()->routeIs('vendor.reports.*') ? 'active' : '' }}">
                <i class="fas fa-chart-bar"></i>
                <span>Reports</span>
            </a>
        </div>

        {{-- PROFILE --}}
        <div class="nav-section">Account</div>

        <div class="nav-item">
            <a href="{{ route('vendor.profile') }}" class="nav-link {{ request()->routeIs('vendor.profile') ? 'active' : '' }}">
                <i class="fas fa-user-cog"></i>
                <span>Profile</span>
            </a>
        </div>

        <div class="nav-item">
            <a href="{{ route('logout') }}" class="nav-link text-danger"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>
</nav>