
{{-- resources/views/layouts/partials/navbar.blade.php --}}

<nav class="lc-nav">
    <div class="lc-nav__inner">

        {{-- ── BRAND ── --}}
        <a href="{{ route('home') }}" class="lc-brand">
            <span class="lc-brand__icon-wrap">
                <i class="fas fa-crown lc-brand__crown"></i>
                <span class="lc-brand__pulse"></span>
            </span>
            <span class="lc-brand__text">
                Ekta<span class="lc-brand__accent">Mart</span>
            </span>
        </a>

        {{-- ── DESKTOP NAV LINKS ── --}}
        <ul class="lc-nav__links">
            @auth
                @if(auth()->user()->is_admin || auth()->user()->role === 'admin')
                    <li><a href="{{ route('admin.dashboard') }}" class="lc-navlink"><i class="fas fa-chart-pie"></i><span>Dashboard</span></a></li>
                    <li><a href="{{ route('admin.categories.index') }}" class="lc-navlink"><i class="fas fa-tags"></i><span>Categories</span></a></li>
                    <li><a href="{{ route('admin.products.index') }}" class="lc-navlink"><i class="fas fa-box"></i><span>Products</span></a></li>
                    <li><a href="{{ route('admin.orders.index') }}" class="lc-navlink"><i class="fas fa-shopping-cart"></i><span>Orders</span></a></li>
                @elseif(auth()->user()->role === 'vendor')
                    <li><a href="{{ route('vendor.dashboard') }}" class="lc-navlink"><i class="fas fa-store"></i><span>Dashboard</span></a></li>
                    <li><a href="{{ route('vendor.products.index') }}" class="lc-navlink"><i class="fas fa-box"></i><span>Products</span></a></li>
                    <li><a href="{{ route('vendor.orders.index') }}" class="lc-navlink"><i class="fas fa-shopping-cart"></i><span>Orders</span></a></li>
                @else
                    <li><a href="{{ route('shop.index') }}" class="lc-navlink"><i class="fas fa-store"></i><span>Shop</span></a></li>
                    <li><a href="{{ route('about') }}" class="lc-navlink"><i class="fas fa-info-circle"></i><span>About</span></a></li>
                    <li><a href="{{ route('contact') }}" class="lc-navlink"><i class="fas fa-envelope"></i><span>Contact</span></a></li>
                @endif
            @else
                <li><a href="{{ route('shop.index') }}" class="lc-navlink"><i class="fas fa-store"></i><span>Shop</span></a></li>
                <li><a href="{{ route('about') }}" class="lc-navlink"><i class="fas fa-info-circle"></i><span>About</span></a></li>
                <li><a href="{{ route('contact') }}" class="lc-navlink"><i class="fas fa-envelope"></i><span>Contact</span></a></li>
            @endauth
        </ul>

        {{-- ── RIGHT ACTIONS ── --}}
        <div class="lc-nav__actions">

            @auth
                {{-- Cart Button (Only for Customers) --}}
                @if(auth()->user()->role === 'customer')
                <a href="{{ route('cart.index') }}" class="lc-cart-btn" aria-label="Shopping cart">
                    <i class="fas fa-shopping-bag"></i>
                    <span id="navCartCount" class="lc-cart-badge">0</span>
                </a>
                @endif

                {{-- Chat Button (Only for Customers) --}}
                @if(auth()->user()->role === 'customer')
                <a href="{{ route('customer.chat.index') }}" class="lc-cart-btn" aria-label="Live Chat" title="Live Chat">
                    <i class="fas fa-comment-dots" style="color: #a78bfa;"></i>
                    @php
                        $unreadChatCount = 0;
                        if (auth()->check()) {
                            $unreadChatCount = \App\Models\ChatMessage::where('user_id', auth()->id())
                                ->where('sender_type', 'admin')
                                ->where('is_read', false)
                                ->count();
                        }
                    @endphp
                    @if($unreadChatCount > 0)
                        <span id="unreadChatBadge" class="lc-cart-badge" style="background: linear-gradient(135deg, #ef4444, #f97316); animation: lc-badge-bounce 0.5s ease;">
                            {{ $unreadChatCount }}
                        </span>
                    @else
                        <span id="unreadChatBadge" class="lc-cart-badge" style="display: none; background: linear-gradient(135deg, #ef4444, #f97316);">0</span>
                    @endif
                </a>
                @endif

                {{-- ─────────────────────────────────────────────
                     PREMIUM USER DROPDOWN
                ───────────────────────────────────────────── --}}
                <div class="lc-dropdown" id="userDropdown">

                    {{-- Trigger --}}
                    <button class="lc-dropdown__trigger" id="dropdownTrigger" aria-expanded="false" aria-haspopup="true">
                        <span class="lc-avatar">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            <span class="lc-avatar__dot"></span>
                        </span>
                        <span class="lc-dropdown__name">{{ Str::limit(Auth::user()->name, 14) }}</span>
                        <span class="lc-dropdown__chevron">
                            <svg viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd"/></svg>
                        </span>
                    </button>

                    {{-- ── DROPDOWN PANEL ── --}}
                    <div class="lc-dropdown__panel" id="dropdownPanel" role="menu" aria-labelledby="dropdownTrigger">

                        {{-- Shimmer top bar --}}
                        <div class="lc-dp__shimmer-bar"></div>

                        {{-- Profile card --}}
                        <div class="lc-dp__profile">
                            <div class="lc-dp__avatar-wrap">
                                <div class="lc-dp__avatar">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <span class="lc-dp__avatar-ring"></span>
                                <span class="lc-dp__online-dot"></span>
                            </div>
                            <div class="lc-dp__profile-info">
                                <p class="lc-dp__username">{{ Auth::user()->name }}</p>
                                <p class="lc-dp__email">{{ Auth::user()->email }}</p>
                                <div class="lc-dp__badges">
                                    <span class="lc-badge lc-badge--role">
                                        <i class="fas fa-shield-alt"></i>
                                        {{ ucfirst(auth()->user()->role ?? 'Customer') }}
                                    </span>
                                    <span class="lc-badge lc-badge--active">
                                        <span class="lc-badge__dot"></span>
                                        Active
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Divider --}}
                        <div class="lc-dp__divider"></div>

                        {{-- Quick Stats (for customers only) --}}
                        @if(auth()->user()->role === 'customer')
                        <div class="lc-dp__stats">
                            <a href="{{ route('customer.orders') }}" class="lc-dp__stat-item">
                                <span class="lc-dp__stat-icon lc-dp__stat-icon--orders">
                                    <i class="fas fa-box-open"></i>
                                </span>
                                <span class="lc-dp__stat-label">Orders</span>
                                <span class="lc-dp__stat-badge">→</span>
                            </a>
                            <a href="{{ route('customer.wishlist') }}" class="lc-dp__stat-item">
                                <span class="lc-dp__stat-icon lc-dp__stat-icon--wish">
                                    <i class="fas fa-heart"></i>
                                </span>
                                <span class="lc-dp__stat-label">Wishlist</span>
                                <span class="lc-dp__stat-badge">→</span>
                            </a>
                            <a href="{{ route('cart.index') }}" class="lc-dp__stat-item">
                                <span class="lc-dp__stat-icon lc-dp__stat-icon--cart">
                                    <i class="fas fa-shopping-bag"></i>
                                </span>
                                <span class="lc-dp__stat-label">Cart</span>
                                <span class="lc-dp__stat-badge">→</span>
                            </a>
                        </div>
                        <div class="lc-dp__divider"></div>
                        @endif

                        {{-- Menu items --}}
                        <nav class="lc-dp__menu">
                            @if(auth()->user()->is_admin || auth()->user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="lc-dp__item" role="menuitem">
                                    <span class="lc-dp__item-icon" style="--icon-color: 139,92,246;">
                                        <i class="fas fa-th-large"></i>
                                    </span>
                                    <span class="lc-dp__item-content">
                                        <span class="lc-dp__item-label">Admin Panel</span>
                                        <span class="lc-dp__item-desc">Manage your store</span>
                                    </span>
                                    <span class="lc-dp__item-arrow"><i class="fas fa-arrow-right"></i></span>
                                </a>
                            @elseif(auth()->user()->role === 'vendor')
                                <a href="{{ route('vendor.dashboard') }}" class="lc-dp__item" role="menuitem">
                                    <span class="lc-dp__item-icon" style="--icon-color: 16,185,129;">
                                        <i class="fas fa-store"></i>
                                    </span>
                                    <span class="lc-dp__item-content">
                                        <span class="lc-dp__item-label">Vendor Panel</span>
                                        <span class="lc-dp__item-desc">Manage your store</span>
                                    </span>
                                    <span class="lc-dp__item-arrow"><i class="fas fa-arrow-right"></i></span>
                                </a>
                            @else
                                <a href="{{ route('dashboard') }}" class="lc-dp__item" role="menuitem">
                                    <span class="lc-dp__item-icon" style="--icon-color: 99,102,241;">
                                        <i class="fas fa-th-large"></i>
                                    </span>
                                    <span class="lc-dp__item-content">
                                        <span class="lc-dp__item-label">Dashboard</span>
                                        <span class="lc-dp__item-desc">Your overview</span>
                                    </span>
                                    <span class="lc-dp__item-arrow"><i class="fas fa-arrow-right"></i></span>
                                </a>
                            @endif

                            @php
                                $user = Auth::user();
                                $profileRoute = route('profile.edit'); // default
                                
                                if ($user->role === 'admin') {
                                    $profileRoute = route('profile.edit');                                } elseif ($user->role === 'vendor') {
                                    $profileRoute = route('vendor.profile');
                                } elseif ($user->role === 'customer') {
                                    $profileRoute = route('customer.profile');
                                }
                            @endphp

                            <a href="{{ $profileRoute }}" class="lc-dp__item" role="menuitem">
                                <span class="lc-dp__item-icon" style="--icon-color: 59,130,246;">
                                    <i class="fas fa-user-circle"></i>
                                </span>
                                <span class="lc-dp__item-content">
                                    <span class="lc-dp__item-label">My Profile</span>
                                    <span class="lc-dp__item-desc">Edit personal info</span>
                                </span>
                                <span class="lc-dp__item-arrow"><i class="fas fa-arrow-right"></i></span>
                            </a>

                            @if(auth()->user()->role === 'customer')
                                <a href="{{ route('customer.orders') }}" class="lc-dp__item" role="menuitem">
                                    <span class="lc-dp__item-icon" style="--icon-color: 16,185,129;">
                                        <i class="fas fa-shopping-bag"></i>
                                    </span>
                                    <span class="lc-dp__item-content">
                                        <span class="lc-dp__item-label">My Orders</span>
                                        <span class="lc-dp__item-desc">Track & manage</span>
                                    </span>
                                    <span class="lc-dp__item-arrow"><i class="fas fa-arrow-right"></i></span>
                                </a>

                                <a href="{{ route('customer.wishlist') }}" class="lc-dp__item" role="menuitem">
                                    <span class="lc-dp__item-icon" style="--icon-color: 244,63,94;">
                                        <i class="fas fa-heart"></i>
                                    </span>
                                    <span class="lc-dp__item-content">
                                        <span class="lc-dp__item-label">Wishlist</span>
                                        <span class="lc-dp__item-desc">Saved products</span>
                                    </span>
                                    <span class="lc-dp__item-arrow"><i class="fas fa-arrow-right"></i></span>
                                </a>

                                <a href="{{ route('customer.chat.index') }}" class="lc-dp__item" role="menuitem">
                                    <span class="lc-dp__item-icon" style="--icon-color: 168,85,247;">
                                        <i class="fas fa-comment-dots"></i>
                                    </span>
                                    <span class="lc-dp__item-content">
                                        <span class="lc-dp__item-label">Live Chat</span>
                                        <span class="lc-dp__item-desc">Get support</span>
                                    </span>
                                    <span class="lc-dp__item-arrow"><i class="fas fa-arrow-right"></i></span>
                                </a>
                            @endif

                            @if(auth()->user()->role === 'vendor')
                                <a href="{{ route('vendor.products.index') }}" class="lc-dp__item" role="menuitem">
                                    <span class="lc-dp__item-icon" style="--icon-color: 139,92,246;">
                                        <i class="fas fa-box"></i>
                                    </span>
                                    <span class="lc-dp__item-content">
                                        <span class="lc-dp__item-label">My Products</span>
                                        <span class="lc-dp__item-desc">Manage inventory</span>
                                    </span>
                                    <span class="lc-dp__item-arrow"><i class="fas fa-arrow-right"></i></span>
                                </a>

                                <a href="{{ route('vendor.orders.index') }}" class="lc-dp__item" role="menuitem">
                                    <span class="lc-dp__item-icon" style="--icon-color: 16,185,129;">
                                        <i class="fas fa-shopping-cart"></i>
                                    </span>
                                    <span class="lc-dp__item-content">
                                        <span class="lc-dp__item-label">My Orders</span>
                                        <span class="lc-dp__item-desc">Track orders</span>
                                    </span>
                                    <span class="lc-dp__item-arrow"><i class="fas fa-arrow-right"></i></span>
                                </a>
                            @endif
                        </nav>

                        <div class="lc-dp__divider"></div>

                        {{-- Logout --}}
                        <div class="lc-dp__footer">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="lc-dp__logout" role="menuitem">
                                    <span class="lc-dp__item-icon lc-dp__item-icon--logout">
                                        <i class="fas fa-sign-out-alt"></i>
                                    </span>
                                    <span class="lc-dp__item-content">
                                        <span class="lc-dp__item-label">Sign Out</span>
                                        <span class="lc-dp__item-desc">See you soon</span>
                                    </span>
                                    <span class="lc-dp__item-arrow"><i class="fas fa-arrow-right"></i></span>
                                </button>
                            </form>
                        </div>

                        {{-- Decorative glow orbs --}}
                        <span class="lc-dp__orb lc-dp__orb--1"></span>
                        <span class="lc-dp__orb lc-dp__orb--2"></span>
                    </div>
                </div>

            @else
                {{-- Guest buttons --}}
                <div class="lc-auth-btns">
                    <a href="{{ route('login') }}" class="lc-btn lc-btn--solid">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </a>
                    <a href="{{ route('register') }}" class="lc-btn lc-btn--ghost">
                        <i class="fas fa-user-plus"></i> Register
                    </a>
                </div>
            @endauth
        </div>

        {{-- ── MOBILE CONTROLS ── --}}
        <div class="lc-mob-controls">
            @auth
                @if(auth()->user()->role === 'customer')
                <a href="{{ route('cart.index') }}" class="lc-cart-btn lc-cart-btn--mob">
                    <i class="fas fa-shopping-bag"></i>
                    <span id="mobileCartCount" class="lc-cart-badge">0</span>
                </a>

                <a href="{{ route('customer.chat.index') }}" class="lc-cart-btn lc-cart-btn--mob" style="position: relative;">
                    <i class="fas fa-comment-dots" style="color: #a78bfa;"></i>
                    @php
                        $mobileUnreadCount = 0;
                        if (auth()->check()) {
                            $mobileUnreadCount = \App\Models\ChatMessage::where('user_id', auth()->id())
                                ->where('sender_type', 'admin')
                                ->where('is_read', false)
                                ->count();
                        }
                    @endphp
                    @if($mobileUnreadCount > 0)
                        <span class="lc-cart-badge" style="background: linear-gradient(135deg, #ef4444, #f97316); font-size: 0.55rem;">
                            {{ $mobileUnreadCount }}
                        </span>
                    @endif
                </a>
                @endif
            @endauth
            <button class="lc-hamburger" id="mobileMenuToggle" aria-label="Toggle menu" aria-expanded="false">
                <span></span><span></span><span></span>
            </button>
        </div>
    </div>

    {{-- ── MOBILE MENU ── --}}
    <div class="lc-mob-menu" id="mobileMenu" hidden>
        <div class="lc-mob-menu__inner">

            @auth
                <div class="lc-mob-profile">
                    <div class="lc-mob-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                    <div>
                        <p class="lc-mob-profile__name">{{ Auth::user()->name }}</p>
                        <p class="lc-mob-profile__email">{{ Auth::user()->email }}</p>
                    </div>
                    <span class="lc-mob-role-badge">{{ ucfirst(auth()->user()->role ?? 'User') }}</span>
                </div>
                <div class="lc-mob-divider"></div>
            @endauth

            @if(auth()->check() && (auth()->user()->is_admin || auth()->user()->role === 'admin'))
                <a href="{{ route('admin.dashboard') }}" class="lc-mob-link"><div class="lc-mob-link__icon" style="background:rgba(139,92,246,.15)"><i class="fas fa-chart-pie" style="color:#a78bfa"></i></div><span>Dashboard</span><i class="fas fa-chevron-right lc-mob-link__chevron"></i></a>
                <a href="{{ route('admin.categories.index') }}" class="lc-mob-link"><div class="lc-mob-link__icon" style="background:rgba(139,92,246,.15)"><i class="fas fa-tags" style="color:#a78bfa"></i></div><span>Categories</span><i class="fas fa-chevron-right lc-mob-link__chevron"></i></a>
                <a href="{{ route('admin.products.index') }}" class="lc-mob-link"><div class="lc-mob-link__icon" style="background:rgba(139,92,246,.15)"><i class="fas fa-box" style="color:#a78bfa"></i></div><span>Products</span><i class="fas fa-chevron-right lc-mob-link__chevron"></i></a>
                <a href="{{ route('admin.orders.index') }}" class="lc-mob-link"><div class="lc-mob-link__icon" style="background:rgba(16,185,129,.15)"><i class="fas fa-shopping-cart" style="color:#34d399"></i></div><span>Orders</span><i class="fas fa-chevron-right lc-mob-link__chevron"></i></a>
            @elseif(auth()->check() && auth()->user()->role === 'vendor')
                <a href="{{ route('vendor.dashboard') }}" class="lc-mob-link"><div class="lc-mob-link__icon" style="background:rgba(139,92,246,.15)"><i class="fas fa-store" style="color:#a78bfa"></i></div><span>Dashboard</span><i class="fas fa-chevron-right lc-mob-link__chevron"></i></a>
                <a href="{{ route('vendor.products.index') }}" class="lc-mob-link"><div class="lc-mob-link__icon" style="background:rgba(139,92,246,.15)"><i class="fas fa-box" style="color:#a78bfa"></i></div><span>Products</span><i class="fas fa-chevron-right lc-mob-link__chevron"></i></a>
                <a href="{{ route('vendor.orders.index') }}" class="lc-mob-link"><div class="lc-mob-link__icon" style="background:rgba(16,185,129,.15)"><i class="fas fa-shopping-cart" style="color:#34d399"></i></div><span>Orders</span><i class="fas fa-chevron-right lc-mob-link__chevron"></i></a>
            @else
                <a href="{{ route('shop.index') }}" class="lc-mob-link"><div class="lc-mob-link__icon" style="background:rgba(139,92,246,.15)"><i class="fas fa-store" style="color:#a78bfa"></i></div><span>Shop</span><i class="fas fa-chevron-right lc-mob-link__chevron"></i></a>
                <a href="{{ route('about') }}" class="lc-mob-link"><div class="lc-mob-link__icon" style="background:rgba(59,130,246,.15)"><i class="fas fa-info-circle" style="color:#60a5fa"></i></div><span>About</span><i class="fas fa-chevron-right lc-mob-link__chevron"></i></a>
                <a href="{{ route('contact') }}" class="lc-mob-link"><div class="lc-mob-link__icon" style="background:rgba(244,63,94,.15)"><i class="fas fa-envelope" style="color:#fb7185"></i></div><span>Contact</span><i class="fas fa-chevron-right lc-mob-link__chevron"></i></a>
            @endif

            @auth
                <div class="lc-mob-divider"></div>
                <a href="{{ route('profile.edit') }}" class="lc-mob-link"><div class="lc-mob-link__icon" style="background:rgba(59,130,246,.15)"><i class="fas fa-user" style="color:#60a5fa"></i></div><span>Profile</span><i class="fas fa-chevron-right lc-mob-link__chevron"></i></a>
                
                @if(auth()->user()->role === 'customer')
                    <a href="{{ route('customer.orders') }}" class="lc-mob-link"><div class="lc-mob-link__icon" style="background:rgba(16,185,129,.15)"><i class="fas fa-shopping-bag" style="color:#34d399"></i></div><span>My Orders</span><i class="fas fa-chevron-right lc-mob-link__chevron"></i></a>
                    <a href="{{ route('customer.wishlist') }}" class="lc-mob-link"><div class="lc-mob-link__icon" style="background:rgba(244,63,94,.15)"><i class="fas fa-heart" style="color:#fb7185"></i></div><span>Wishlist</span><i class="fas fa-chevron-right lc-mob-link__chevron"></i></a>
                    <a href="{{ route('customer.chat.index') }}" class="lc-mob-link">
                        <div class="lc-mob-link__icon" style="background:rgba(168,85,247,.15)">
                            <i class="fas fa-comment-dots" style="color:#a78bfa"></i>
                        </div>
                        <span>Live Chat</span>
                        <i class="fas fa-chevron-right lc-mob-link__chevron"></i>
                    </a>
                @endif

                @if(auth()->user()->role === 'vendor')
                    <a href="{{ route('vendor.products.index') }}" class="lc-mob-link"><div class="lc-mob-link__icon" style="background:rgba(139,92,246,.15)"><i class="fas fa-box" style="color:#a78bfa"></i></div><span>My Products</span><i class="fas fa-chevron-right lc-mob-link__chevron"></i></a>
                    <a href="{{ route('vendor.orders.index') }}" class="lc-mob-link"><div class="lc-mob-link__icon" style="background:rgba(16,185,129,.15)"><i class="fas fa-shopping-cart" style="color:#34d399"></i></div><span>My Orders</span><i class="fas fa-chevron-right lc-mob-link__chevron"></i></a>
                @endif

                <div class="lc-mob-divider"></div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="lc-mob-link lc-mob-link--logout">
                        <div class="lc-mob-link__icon" style="background:rgba(244,63,94,.15)"><i class="fas fa-sign-out-alt" style="color:#fb7185"></i></div>
                        <span>Sign Out</span>
                        <i class="fas fa-chevron-right lc-mob-link__chevron"></i>
                    </button>
                </form>
            @else
                <div class="lc-mob-divider"></div>
                <a href="{{ route('login') }}" class="lc-mob-auth-btn lc-mob-auth-btn--solid"><i class="fas fa-sign-in-alt"></i> Login</a>
                <a href="{{ route('register') }}" class="lc-mob-auth-btn lc-mob-auth-btn--ghost"><i class="fas fa-user-plus"></i> Register</a>
            @endauth
        </div>
    </div>
</nav>

<style>
/* ================================================================
   LARACOMMERCE PREMIUM NAVBAR  — Full Custom Design System
   ================================================================ */

/* ── CSS Custom Properties ── */
:root {
    --nav-h: 72px;
    --nav-bg: linear-gradient(135deg, #0f0c29 0%, #1a0533 50%, #0f0c29 100%);
    --nav-border: rgba(139,92,246,.18);
    --nav-blur: blur(24px);

    /* Dropdown */
    --dp-w: 340px;
    --dp-bg: rgba(15,12,41,.88);
    --dp-border: rgba(139,92,246,.22);
    --dp-radius: 20px;
    --dp-shadow:
        0 0 0 1px rgba(139,92,246,.15),
        0 20px 60px rgba(0,0,0,.55),
        0 8px 24px rgba(139,92,246,.18);

    /* Accent */
    --p: #a855f7;
    --p-dim: rgba(168,85,247,.12);
    --p-bright: #c084fc;
}

/* ── Base nav ── */
.lc-nav {
    position: sticky;
    top: 0;
    z-index: 9999;
    background: var(--nav-bg);
    border-bottom: 1px solid var(--nav-border);
    backdrop-filter: var(--nav-blur);
    -webkit-backdrop-filter: var(--nav-blur);
}
.lc-nav__inner {
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 1.25rem;
    height: var(--nav-h);
    display: flex;
    align-items: center;
    gap: 1rem;
}

/* ── Brand ── */
.lc-brand {
    display: flex;
    align-items: center;
    gap: .6rem;
    text-decoration: none;
    flex-shrink: 0;
}
.lc-brand__icon-wrap {
    position: relative;
    width: 38px;
    height: 38px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.lc-brand__crown {
    font-size: 1.3rem;
    color: #fbbf24;
    position: relative;
    z-index: 1;
    filter: drop-shadow(0 0 8px rgba(251,191,36,.5));
    animation: lc-float 3s ease-in-out infinite;
}
.lc-brand__pulse {
    position: absolute;
    inset: 0;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(251,191,36,.15) 0%, transparent 70%);
    animation: lc-pulse-brand 2.5s ease-in-out infinite;
}
.lc-brand__text {
    font-size: 1.35rem;
    font-weight: 800;
    color: #fff;
    letter-spacing: -.02em;
    line-height: 1;
}
.lc-brand__accent {
    background: linear-gradient(135deg, #a855f7, #ec4899);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* ── Desktop nav links ── */
.lc-nav__links {
    display: none;
    list-style: none;
    margin: 0 auto;
    padding: 0;
    gap: .25rem;
}
@media (min-width: 768px) { .lc-nav__links { display: flex; } }

.lc-navlink {
    display: flex;
    align-items: center;
    gap: .45rem;
    padding: .55rem .9rem;
    border-radius: 12px;
    color: rgba(255,255,255,.65);
    text-decoration: none;
    font-size: .875rem;
    font-weight: 500;
    position: relative;
    transition: color .25s, background .25s;
    border: 1px solid transparent;
}
.lc-navlink i { font-size: .8rem; color: var(--p); transition: color .25s; }
.lc-navlink:hover {
    color: #fff;
    background: rgba(168,85,247,.1);
    border-color: rgba(168,85,247,.2);
}
.lc-navlink:hover i { color: var(--p-bright); }
.lc-navlink::after {
    content: '';
    position: absolute;
    bottom: 6px;
    left: 50%;
    transform: translateX(-50%) scaleX(0);
    width: 50%;
    height: 2px;
    border-radius: 2px;
    background: linear-gradient(90deg, var(--p), #ec4899);
    transition: transform .3s cubic-bezier(.34,1.56,.64,1);
}
.lc-navlink:hover::after { transform: translateX(-50%) scaleX(1); }

/* ── Right actions ── */
.lc-nav__actions {
    display: none;
    align-items: center;
    gap: .5rem;
    flex-shrink: 0;
}
@media (min-width: 768px) { .lc-nav__actions { display: flex; } }

/* ── Cart button ── */
.lc-cart-btn {
    position: relative;
    width: 42px;
    height: 42px;
    border-radius: 13px;
    background: rgba(255,255,255,.06);
    border: 1px solid rgba(255,255,255,.1);
    display: flex;
    align-items: center;
    justify-content: center;
    color: rgba(255,255,255,.75);
    text-decoration: none;
    font-size: 1.05rem;
    transition: background .25s, color .25s, transform .2s, border-color .25s;
}
.lc-cart-btn:hover {
    background: var(--p-dim);
    border-color: var(--nav-border);
    color: #fff;
    transform: translateY(-2px);
}
.lc-cart-badge {
    position: absolute;
    top: -5px;
    right: -5px;
    min-width: 20px;
    height: 20px;
    padding: 0 4px;
    border-radius: 10px;
    background: linear-gradient(135deg, #ef4444, #f97316);
    color: #fff;
    font-size: .65rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid #0f0c29;
    box-shadow: 0 2px 8px rgba(239,68,68,.5);
    animation: lc-badge-bounce .5s ease;
}

/* ── Guest auth buttons ── */
.lc-auth-btns { display: flex; gap: .5rem; }
.lc-btn {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    padding: .5rem 1rem;
    border-radius: 12px;
    font-size: .85rem;
    font-weight: 600;
    text-decoration: none;
    transition: all .25s;
}
.lc-btn--solid {
    background: linear-gradient(135deg, #7c3aed, #6d28d9);
    color: #fff;
    border: 1px solid rgba(255,255,255,.1);
    box-shadow: 0 4px 16px rgba(124,58,237,.35);
}
.lc-btn--solid:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(124,58,237,.5); }
.lc-btn--ghost {
    background: transparent;
    color: rgba(255,255,255,.75);
    border: 1px solid rgba(255,255,255,.18);
}
.lc-btn--ghost:hover { background: rgba(255,255,255,.08); color: #fff; transform: translateY(-2px); }

/* ════════════════════════════════════════════
   PREMIUM DROPDOWN
════════════════════════════════════════════ */

.lc-dropdown { position: relative; }

/* Trigger */
.lc-dropdown__trigger {
    display: flex;
    align-items: center;
    gap: .55rem;
    padding: .35rem .7rem .35rem .35rem;
    background: rgba(255,255,255,.05);
    border: 1px solid rgba(255,255,255,.1);
    border-radius: 50px;
    cursor: pointer;
    color: #fff;
    transition: all .3s;
    position: relative;
    overflow: hidden;
}
.lc-dropdown__trigger::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(168,85,247,.08), rgba(236,72,153,.08));
    opacity: 0;
    transition: opacity .3s;
}
.lc-dropdown__trigger:hover { border-color: rgba(168,85,247,.4); }
.lc-dropdown__trigger:hover::before { opacity: 1; }
.lc-dropdown__trigger[aria-expanded="true"] {
    border-color: rgba(168,85,247,.5);
    background: rgba(168,85,247,.1);
}
.lc-dropdown__trigger[aria-expanded="true"] .lc-dropdown__chevron svg {
    transform: rotate(180deg);
}

/* Avatar in trigger */
.lc-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: linear-gradient(135deg, #7c3aed, #db2777);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: .85rem;
    font-weight: 700;
    color: #fff;
    position: relative;
    flex-shrink: 0;
    box-shadow: 0 0 0 2px rgba(168,85,247,.3), 0 4px 12px rgba(124,58,237,.35);
}
.lc-avatar__dot {
    position: absolute;
    bottom: 1px;
    right: 1px;
    width: 9px;
    height: 9px;
    background: #10b981;
    border-radius: 50%;
    border: 2px solid #0f0c29;
    box-shadow: 0 0 6px rgba(16,185,129,.6);
    animation: lc-pulse-dot 2s ease-in-out infinite;
}
.lc-dropdown__name {
    font-size: .82rem;
    font-weight: 600;
    color: rgba(255,255,255,.9);
    display: none;
}
@media (min-width: 1024px) { .lc-dropdown__name { display: block; } }
.lc-dropdown__chevron svg {
    width: 16px;
    height: 16px;
    color: rgba(255,255,255,.5);
    transition: transform .35s cubic-bezier(.34,1.56,.64,1);
    flex-shrink: 0;
}

/* ── Panel ── */
.lc-dropdown__panel {
    position: absolute;
    top: calc(100% + 12px);
    right: 0;
    width: var(--dp-w);
    background: var(--dp-bg);
    border: 1px solid var(--dp-border);
    border-radius: var(--dp-radius);
    box-shadow: var(--dp-shadow);
    backdrop-filter: blur(32px);
    -webkit-backdrop-filter: blur(32px);
    overflow: hidden;
    pointer-events: none;
    opacity: 0;
    transform: translateY(16px) scale(.96);
    transform-origin: top right;
    transition:
        opacity .35s cubic-bezier(.4,0,.2,1),
        transform .35s cubic-bezier(.34,1.56,.64,1);
    z-index: 10000;
}
.lc-dropdown__panel.is-open {
    opacity: 1;
    transform: translateY(0) scale(1);
    pointer-events: auto;
}

/* Shimmer top bar */
.lc-dp__shimmer-bar {
    height: 3px;
    background: linear-gradient(90deg, #7c3aed, #a855f7, #ec4899, #a855f7, #7c3aed);
    background-size: 200% 100%;
    animation: lc-shimmer-bar 3s linear infinite;
}

/* Profile card */
.lc-dp__profile {
    padding: 1.1rem 1.1rem .9rem;
    display: flex;
    align-items: center;
    gap: .9rem;
    position: relative;
}
.lc-dp__avatar-wrap {
    position: relative;
    flex-shrink: 0;
}
.lc-dp__avatar {
    width: 56px;
    height: 56px;
    border-radius: 16px;
    background: linear-gradient(135deg, #7c3aed, #db2777);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    font-weight: 700;
    color: #fff;
    box-shadow: 0 8px 24px rgba(124,58,237,.4);
    position: relative;
    z-index: 1;
}
.lc-dp__avatar-ring {
    position: absolute;
    inset: -4px;
    border-radius: 20px;
    background: linear-gradient(135deg, rgba(168,85,247,.4), rgba(236,72,153,.4));
    z-index: 0;
    animation: lc-ring-spin 4s linear infinite;
}
.lc-dp__online-dot {
    position: absolute;
    bottom: -2px;
    right: -2px;
    width: 14px;
    height: 14px;
    background: #10b981;
    border-radius: 50%;
    border: 2.5px solid rgba(15,12,41,.9);
    z-index: 2;
    box-shadow: 0 0 10px rgba(16,185,129,.7);
    animation: lc-pulse-dot 2s ease-in-out infinite;
}
.lc-dp__profile-info { flex: 1; min-width: 0; }
.lc-dp__username {
    font-size: .95rem;
    font-weight: 700;
    color: #fff;
    margin: 0 0 .15rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.lc-dp__email {
    font-size: .75rem;
    color: rgba(255,255,255,.45);
    margin: 0 0 .5rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.lc-dp__badges { display: flex; gap: .4rem; flex-wrap: wrap; }
.lc-badge {
    display: inline-flex;
    align-items: center;
    gap: .3rem;
    padding: .2rem .6rem;
    border-radius: 20px;
    font-size: .65rem;
    font-weight: 700;
    letter-spacing: .03em;
    text-transform: uppercase;
}
.lc-badge--role {
    background: rgba(168,85,247,.15);
    color: #c084fc;
    border: 1px solid rgba(168,85,247,.25);
}
.lc-badge--role i { font-size: .6rem; }
.lc-badge--active {
    background: rgba(16,185,129,.12);
    color: #34d399;
    border: 1px solid rgba(16,185,129,.2);
}
.lc-badge__dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #10b981;
    animation: lc-pulse-dot 1.5s ease-in-out infinite;
}

/* Divider */
.lc-dp__divider {
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(168,85,247,.2), rgba(236,72,153,.15), transparent);
    margin: 0 .8rem;
}

/* Quick stats */
.lc-dp__stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: .5rem;
    padding: .8rem 1rem;
}
.lc-dp__stat-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: .4rem;
    padding: .7rem .4rem;
    background: rgba(255,255,255,.04);
    border: 1px solid rgba(255,255,255,.07);
    border-radius: 14px;
    text-decoration: none;
    transition: all .25s;
    cursor: pointer;
    position: relative;
    overflow: hidden;
}
.lc-dp__stat-item::before {
    content: '';
    position: absolute;
    inset: 0;
    opacity: 0;
    transition: opacity .25s;
    border-radius: 14px;
}
.lc-dp__stat-item:hover { border-color: rgba(168,85,247,.3); transform: translateY(-2px); }
.lc-dp__stat-item:hover::before { opacity: 1; background: rgba(168,85,247,.06); }
.lc-dp__stat-icon {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: .9rem;
    transition: transform .25s;
}
.lc-dp__stat-item:hover .lc-dp__stat-icon { transform: scale(1.1) rotate(-5deg); }
.lc-dp__stat-icon--orders { background: rgba(99,102,241,.15); color: #818cf8; border: 1px solid rgba(99,102,241,.2); }
.lc-dp__stat-icon--wish   { background: rgba(244,63,94,.15);  color: #fb7185; border: 1px solid rgba(244,63,94,.2); }
.lc-dp__stat-icon--cart   { background: rgba(16,185,129,.15); color: #34d399; border: 1px solid rgba(16,185,129,.2); }
.lc-dp__stat-label {
    font-size: .7rem;
    color: rgba(255,255,255,.55);
    font-weight: 500;
}
.lc-dp__stat-badge {
    font-size: .65rem;
    color: rgba(168,85,247,.6);
    font-weight: 600;
    transition: color .25s;
}
.lc-dp__stat-item:hover .lc-dp__stat-badge { color: var(--p); }

/* Menu items */
.lc-dp__menu {
    padding: .5rem .65rem;
    display: flex;
    flex-direction: column;
    gap: .25rem;
}
.lc-dp__item {
    display: flex;
    align-items: center;
    gap: .75rem;
    padding: .7rem .75rem;
    border-radius: 14px;
    text-decoration: none;
    border: 1px solid transparent;
    transition: all .25s cubic-bezier(.34,1.56,.64,1);
    position: relative;
    overflow: hidden;
    cursor: pointer;
}
.lc-dp__item::before {
    content: '';
    position: absolute;
    inset: 0;
    border-radius: 14px;
    background: rgba(255,255,255,.0);
    transition: background .25s;
}
.lc-dp__item:hover::before { background: rgba(255,255,255,.04); }
.lc-dp__item:hover {
    border-color: rgba(255,255,255,.08);
    transform: translateX(4px);
}
.lc-dp__item-icon {
    width: 38px;
    height: 38px;
    border-radius: 12px;
    background: rgba(var(--icon-color),.12);
    border: 1px solid rgba(var(--icon-color),.18);
    display: flex;
    align-items: center;
    justify-content: center;
    color: rgb(var(--icon-color));
    font-size: .9rem;
    flex-shrink: 0;
    transition: transform .3s cubic-bezier(.34,1.56,.64,1);
}
.lc-dp__item:hover .lc-dp__item-icon { transform: scale(1.1) rotate(-6deg); }
.lc-dp__item-content { flex: 1; min-width: 0; }
.lc-dp__item-label {
    display: block;
    font-size: .875rem;
    font-weight: 600;
    color: rgba(255,255,255,.85);
    transition: color .2s;
}
.lc-dp__item:hover .lc-dp__item-label { color: #fff; }
.lc-dp__item-desc {
    display: block;
    font-size: .72rem;
    color: rgba(255,255,255,.35);
    margin-top: .05rem;
}
.lc-dp__item-arrow {
    font-size: .7rem;
    color: rgba(255,255,255,.18);
    transition: color .2s, transform .3s cubic-bezier(.34,1.56,.64,1);
    flex-shrink: 0;
}
.lc-dp__item:hover .lc-dp__item-arrow { color: rgba(168,85,247,.7); transform: translateX(3px); }

/* Footer / Logout */
.lc-dp__footer { padding: .5rem .65rem .8rem; }
.lc-dp__logout {
    width: 100%;
    display: flex;
    align-items: center;
    gap: .75rem;
    padding: .7rem .75rem;
    border-radius: 14px;
    background: transparent;
    border: 1px solid transparent;
    cursor: pointer;
    transition: all .25s cubic-bezier(.34,1.56,.64,1);
}
.lc-dp__logout:hover {
    background: rgba(239,68,68,.08);
    border-color: rgba(239,68,68,.18);
    transform: translateX(4px);
}
.lc-dp__logout .lc-dp__item-icon--logout {
    width: 38px;
    height: 38px;
    border-radius: 12px;
    background: rgba(239,68,68,.12);
    border: 1px solid rgba(239,68,68,.18);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #f87171;
    font-size: .9rem;
    flex-shrink: 0;
    transition: transform .3s cubic-bezier(.34,1.56,.64,1);
}
.lc-dp__logout:hover .lc-dp__item-icon--logout { transform: scale(1.1) rotate(6deg); }
.lc-dp__logout .lc-dp__item-label { color: rgba(248,113,113,.85); }
.lc-dp__logout:hover .lc-dp__item-label { color: #fca5a5; }
.lc-dp__logout .lc-dp__item-desc { color: rgba(248,113,113,.35); }
.lc-dp__logout .lc-dp__item-arrow { color: rgba(239,68,68,.25); }
.lc-dp__logout:hover .lc-dp__item-arrow { color: rgba(239,68,68,.65); transform: translateX(3px); }

/* Decorative orbs */
.lc-dp__orb {
    position: absolute;
    border-radius: 50%;
    filter: blur(40px);
    pointer-events: none;
    z-index: 0;
}
.lc-dp__orb--1 {
    width: 120px; height: 120px;
    top: -30px; left: -20px;
    background: rgba(124,58,237,.12);
}
.lc-dp__orb--2 {
    width: 100px; height: 100px;
    bottom: -20px; right: -10px;
    background: rgba(236,72,153,.1);
}

/* ════════════════════════════════════════════
   MOBILE CONTROLS
════════════════════════════════════════════ */

.lc-mob-controls {
    display: flex;
    align-items: center;
    gap: .5rem;
    margin-left: auto;
}
@media (min-width: 768px) { .lc-mob-controls { display: none; } }

.lc-cart-btn--mob { width: 38px; height: 38px; font-size: .9rem; }

/* Hamburger */
.lc-hamburger {
    width: 42px;
    height: 42px;
    background: rgba(255,255,255,.06);
    border: 1px solid rgba(255,255,255,.12);
    border-radius: 13px;
    cursor: pointer;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 5px;
    padding: 0;
    transition: border-color .25s, background .25s;
}
.lc-hamburger:hover { background: var(--p-dim); border-color: rgba(168,85,247,.3); }
.lc-hamburger span {
    display: block;
    width: 20px;
    height: 2px;
    background: rgba(255,255,255,.75);
    border-radius: 2px;
    transition: all .35s cubic-bezier(.34,1.56,.64,1);
}
.lc-hamburger.is-open span:nth-child(1) { transform: translateY(7px) rotate(45deg); }
.lc-hamburger.is-open span:nth-child(2) { opacity: 0; transform: scaleX(0); }
.lc-hamburger.is-open span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }

/* ════════════════════════════════════════════
   MOBILE MENU
════════════════════════════════════════════ */

.lc-mob-menu {
    overflow: hidden;
    max-height: 0;
    opacity: 0;
    transition: max-height .4s cubic-bezier(.4,0,.2,1), opacity .3s;
    background: linear-gradient(180deg, rgba(15,12,41,.97) 0%, rgba(26,5,51,.97) 100%);
    border-top: 1px solid rgba(168,85,247,.12);
}
.lc-mob-menu.is-open {
    max-height: 85vh;
    opacity: 1;
    overflow-y: auto;
}
.lc-mob-menu__inner { padding: 1rem; }

/* Mobile profile */
.lc-mob-profile {
    display: flex;
    align-items: center;
    gap: .75rem;
    padding: .9rem 1rem;
    background: rgba(168,85,247,.07);
    border: 1px solid rgba(168,85,247,.15);
    border-radius: 16px;
    margin-bottom: .75rem;
}
.lc-mob-avatar {
    width: 46px;
    height: 46px;
    border-radius: 13px;
    background: linear-gradient(135deg, #7c3aed, #db2777);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    font-weight: 700;
    color: #fff;
    flex-shrink: 0;
}
.lc-mob-profile__name { font-size: .9rem; font-weight: 700; color: #fff; margin: 0 0 .2rem; }
.lc-mob-profile__email { font-size: .72rem; color: rgba(255,255,255,.4); margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.lc-mob-role-badge {
    margin-left: auto;
    flex-shrink: 0;
    padding: .25rem .7rem;
    background: rgba(168,85,247,.15);
    color: #c084fc;
    border: 1px solid rgba(168,85,247,.25);
    border-radius: 20px;
    font-size: .65rem;
    font-weight: 700;
    text-transform: uppercase;
}

/* Mobile divider */
.lc-mob-divider {
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(168,85,247,.2), transparent);
    margin: .6rem 0;
}

/* Mobile link */
.lc-mob-link {
    display: flex;
    align-items: center;
    gap: .75rem;
    padding: .75rem .9rem;
    border-radius: 14px;
    color: rgba(255,255,255,.7);
    text-decoration: none;
    font-size: .88rem;
    font-weight: 500;
    border: 1px solid transparent;
    transition: all .25s;
    background: transparent;
    cursor: pointer;
    width: 100%;
    text-align: left;
}
.lc-mob-link:hover {
    background: rgba(168,85,247,.08);
    border-color: rgba(168,85,247,.15);
    color: #fff;
    padding-left: 1.1rem;
}
.lc-mob-link__icon {
    width: 36px;
    height: 36px;
    border-radius: 11px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-size: .9rem;
    transition: transform .25s;
}
.lc-mob-link:hover .lc-mob-link__icon { transform: scale(1.1) rotate(-5deg); }
.lc-mob-link__chevron { margin-left: auto; font-size: .7rem; color: rgba(255,255,255,.2); transition: transform .25s, color .25s; }
.lc-mob-link:hover .lc-mob-link__chevron { transform: translateX(4px); color: rgba(168,85,247,.6); }
.lc-mob-link--logout { color: rgba(248,113,113,.8); }
.lc-mob-link--logout:hover { background: rgba(239,68,68,.08); border-color: rgba(239,68,68,.15); color: #fca5a5; }

/* Mobile auth buttons */
.lc-mob-auth-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: .5rem;
    padding: .85rem;
    border-radius: 14px;
    font-size: .9rem;
    font-weight: 600;
    text-decoration: none;
    transition: all .25s;
    margin-bottom: .5rem;
}
.lc-mob-auth-btn--solid {
    background: linear-gradient(135deg, #7c3aed, #6d28d9);
    color: #fff;
    border: 1px solid rgba(255,255,255,.1);
    box-shadow: 0 4px 16px rgba(124,58,237,.3);
}
.lc-mob-auth-btn--solid:hover { box-shadow: 0 8px 24px rgba(124,58,237,.45); transform: translateY(-1px); }
.lc-mob-auth-btn--ghost {
    background: transparent;
    color: rgba(255,255,255,.7);
    border: 1px solid rgba(255,255,255,.15);
}
.lc-mob-auth-btn--ghost:hover { background: rgba(255,255,255,.06); color: #fff; }

/* ════════════════════════════════════════════
   SCROLLBAR (mobile menu)
════════════════════════════════════════════ */
.lc-mob-menu::-webkit-scrollbar { width: 4px; }
.lc-mob-menu::-webkit-scrollbar-track { background: transparent; }
.lc-mob-menu::-webkit-scrollbar-thumb { background: rgba(168,85,247,.3); border-radius: 4px; }

/* ════════════════════════════════════════════
   KEYFRAMES
════════════════════════════════════════════ */
@keyframes lc-float {
    0%,100% { transform: translateY(0) rotate(-3deg); }
    50%      { transform: translateY(-3px) rotate(3deg); }
}
@keyframes lc-pulse-brand {
    0%,100% { transform: scale(1); opacity: .5; }
    50%      { transform: scale(1.4); opacity: 1; }
}
@keyframes lc-pulse-dot {
    0%,100% { box-shadow: 0 0 0 0 rgba(16,185,129,.6); }
    50%      { box-shadow: 0 0 0 5px rgba(16,185,129,0); }
}
@keyframes lc-badge-bounce {
    0%   { transform: scale(0); }
    70%  { transform: scale(1.2); }
    100% { transform: scale(1); }
}
@keyframes lc-shimmer-bar {
    0%   { background-position: -200% 0; }
    100% { background-position: 200% 0; }
}
@keyframes lc-ring-spin {
    0%   { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>

<script>
(function () {
    'use strict';

    /* ── Cart count ── */
    function updateCartBadges() {
        fetch('{{ route("cart.count") }}')
            .then(r => r.json())
            .then(({ count = 0 }) => {
                document.querySelectorAll('#navCartCount,#mobileCartCount').forEach(el => {
                    if (!el) return;
                    el.textContent = count;
                    el.style.display = count > 0 ? 'flex' : 'none';
                });
            }).catch(() => {});
    }

    /* ── Chat unread count ── */
    function updateUnreadChatBadge() {
        fetch('{{ route("customer.chat.unread") }}')
            .then(r => r.json())
            .then(({ count = 0 }) => {
                document.querySelectorAll('#unreadChatBadge').forEach(el => {
                    if (!el) return;
                    if (count > 0) {
                        el.textContent = count;
                        el.style.display = 'flex';
                        el.style.animation = 'lc-badge-bounce 0.5s ease';
                    } else {
                        el.style.display = 'none';
                    }
                });
            }).catch(() => {});
    }

    /* ── Dropdown ── */
    function initDropdown() {
        const trigger = document.getElementById('dropdownTrigger');
        const panel   = document.getElementById('dropdownPanel');
        if (!trigger || !panel) return;

        let open = false;

        function openDropdown() {
            open = true;
            panel.classList.add('is-open');
            trigger.setAttribute('aria-expanded', 'true');
        }
        function closeDropdown() {
            open = false;
            panel.classList.remove('is-open');
            trigger.setAttribute('aria-expanded', 'false');
        }
        function toggle() { open ? closeDropdown() : openDropdown(); }

        trigger.addEventListener('click', e => { e.stopPropagation(); toggle(); });

        document.addEventListener('click', e => {
            if (open && !trigger.contains(e.target) && !panel.contains(e.target)) closeDropdown();
        });

        document.addEventListener('keydown', e => {
            if (e.key === 'Escape' && open) closeDropdown();
        });

        panel.querySelectorAll('a, button').forEach(el => {
            el.addEventListener('click', () => closeDropdown());
        });
    }

    /* ── Mobile menu ── */
    function initMobileMenu() {
        const btn  = document.getElementById('mobileMenuToggle');
        const menu = document.getElementById('mobileMenu');
        if (!btn || !menu) return;

        let open = false;

        function openMenu() {
            open = true;
            menu.hidden = false;
            menu.removeAttribute('hidden');
            requestAnimationFrame(() => menu.classList.add('is-open'));
            btn.classList.add('is-open');
            btn.setAttribute('aria-expanded', 'true');
        }
        function closeMenu() {
            open = false;
            menu.classList.remove('is-open');
            btn.classList.remove('is-open');
            btn.setAttribute('aria-expanded', 'false');
            setTimeout(() => { if (!open) menu.hidden = true; }, 400);
        }

        btn.addEventListener('click', e => { e.stopPropagation(); open ? closeMenu() : openMenu(); });

        document.addEventListener('click', e => {
            if (open && !btn.contains(e.target) && !menu.contains(e.target)) closeMenu();
        });

        menu.querySelectorAll('a, button[type="submit"]').forEach(el => {
            el.addEventListener('click', () => closeMenu());
        });

        window.addEventListener('resize', () => {
            if (window.innerWidth >= 768 && open) closeMenu();
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        updateCartBadges();
        updateUnreadChatBadge();
        initDropdown();
        initMobileMenu();
    });

    window.updateNavCartCount = updateCartBadges;
    window.updateUnreadChatBadge = updateUnreadChatBadge;
})();
</script>