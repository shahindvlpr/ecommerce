@extends('layouts.app')

@section('title', 'My Orders - EktaMart')

@section('content')
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --shadow-sm: 0 2px 12px rgba(0, 0, 0, 0.06);
        --shadow-hover: 0 8px 30px rgba(0, 0, 0, 0.1);
        --radius: 1rem;
        --radius-sm: 0.75rem;
    }

    .page-wrapper {
        background: #f5f6fa;
        min-height: 100vh;
        padding: 1.5rem 0;
    }

    /* Sidebar Styles */
    .profile-sidebar {
        background: white;
        border-radius: var(--radius);
        padding: 1.2rem;
        box-shadow: var(--shadow-sm);
        position: sticky;
        top: 1.5rem;
        transition: all 0.3s ease;
    }
    .profile-sidebar:hover {
        box-shadow: var(--shadow-hover);
    }
    .profile-avatar {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: var(--primary-gradient);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 0.6rem;
        font-size: 1.8rem;
        color: white;
        font-weight: 700;
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.25);
        transition: all 0.3s ease;
    }
    .profile-avatar:hover {
        transform: scale(1.05);
    }
    .profile-name {
        text-align: center;
        font-weight: 600;
        font-size: 0.95rem;
        margin-bottom: 0.1rem;
        color: #1a1a2e;
    }
    .profile-email {
        text-align: center;
        color: #6b7280;
        font-size: 0.7rem;
        margin-bottom: 0.6rem;
        word-break: break-all;
    }
    .profile-badge {
        display: inline-block;
        background: var(--primary-gradient);
        color: white;
        padding: 0.15rem 1rem;
        border-radius: 2rem;
        font-size: 0.6rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin: 0 auto 0.8rem;
        display: table;
    }
    .sidebar-nav {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .sidebar-nav li {
        margin-bottom: 0.15rem;
    }
    .sidebar-nav a {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        padding: 0.5rem 0.75rem;
        border-radius: 0.6rem;
        color: #4b5563;
        text-decoration: none;
        transition: all 0.3s ease;
        font-weight: 500;
        font-size: 0.8rem;
        position: relative;
    }
    .sidebar-nav a::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        width: 3px;
        height: 100%;
        background: var(--primary-gradient);
        transform: scaleY(0);
        transition: transform 0.3s ease;
        border-radius: 0 3px 3px 0;
    }
    .sidebar-nav a:hover::before,
    .sidebar-nav a.active::before {
        transform: scaleY(1);
    }
    .sidebar-nav a i {
        width: 18px;
        text-align: center;
        font-size: 0.85rem;
        transition: all 0.3s ease;
    }
    .sidebar-nav a:hover {
        background: #f3f4f6;
        color: #667eea;
        transform: translateX(3px);
    }
    .sidebar-nav a.active {
        background: var(--primary-gradient);
        color: white;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.25);
    }
    .sidebar-nav a.active::before {
        background: white;
    }
    .sidebar-nav a.logout {
        color: #ef4444;
    }
    .sidebar-nav a.logout:hover {
        background: #fef2f2;
        color: #dc2626;
    }
    .sidebar-nav .badge {
        font-size: 0.6rem;
        padding: 0.15rem 0.5rem;
        animation: badgePulse 2s ease-in-out infinite;
    }
    @keyframes badgePulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    /* Page Header */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
        gap: 0.8rem;
    }
    .page-header h2 {
        font-weight: 700;
        font-size: 1.4rem;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }
    .page-header h2 i {
        color: #667eea;
    }
    .page-header .order-count {
        background: white;
        padding: 0.3rem 1rem;
        border-radius: 2rem;
        font-size: 0.8rem;
        font-weight: 600;
        color: #4b5563;
        box-shadow: var(--shadow-sm);
    }

    .filter-section {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    .filter-section .btn-filter {
        padding: 0.35rem 1rem;
        border-radius: 2rem;
        font-size: 0.7rem;
        font-weight: 600;
        border: 1.5px solid #e5e7eb;
        background: white;
        color: #4b5563;
        transition: all 0.3s ease;
        cursor: pointer;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    .filter-section .btn-filter:hover {
        border-color: #667eea;
        color: #667eea;
        transform: translateY(-2px);
    }
    .filter-section .btn-filter.active {
        background: var(--primary-gradient);
        color: white;
        border-color: transparent;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        transform: translateY(-2px);
    }

    .order-card {
        background: white;
        border-radius: var(--radius);
        padding: 1.2rem 1.5rem;
        box-shadow: var(--shadow-sm);
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        margin-bottom: 0.8rem;
        border: 1px solid rgba(0,0,0,0.02);
        position: relative;
        overflow: hidden;
        cursor: pointer;
    }
    .order-card::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        width: 4px;
        height: 100%;
        background: var(--primary-gradient);
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .order-card:hover::before {
        opacity: 1;
    }
    .order-card:hover {
        box-shadow: var(--shadow-hover);
        transform: translateY(-3px);
    }

    .order-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-bottom: 0.6rem;
    }
    .order-id {
        font-weight: 700;
        font-size: 0.95rem;
        color: #1a1a2e;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .order-id .badge-copy {
        font-size: 0.55rem;
        background: #f3f4f6;
        padding: 0.1rem 0.5rem;
        border-radius: 2rem;
        color: #6b7280;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .order-id .badge-copy:hover {
        background: #667eea;
        color: white;
    }
    .order-date {
        color: #6b7280;
        font-size: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }

    .order-status {
        padding: 0.25rem 0.9rem;
        border-radius: 2rem;
        font-size: 0.65rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-block;
        transition: all 0.3s ease;
    }
    .order-status.delivered { background: #dcfce7; color: #16a34a; box-shadow: 0 2px 8px rgba(22, 163, 74, 0.15); }
    .order-status.pending { background: #fef3c7; color: #d97706; box-shadow: 0 2px 8px rgba(217, 119, 6, 0.15); }
    .order-status.processing { background: #dbeafe; color: #2563eb; box-shadow: 0 2px 8px rgba(37, 99, 235, 0.15); }
    .order-status.cancelled { background: #fee2e2; color: #dc2626; box-shadow: 0 2px 8px rgba(220, 38, 38, 0.15); }
    .order-status.shipped { background: #e0e7ff; color: #4f46e5; box-shadow: 0 2px 8px rgba(79, 70, 229, 0.15); }

    .order-body {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.5rem;
        padding-top: 0.6rem;
        border-top: 1px solid #f3f4f6;
    }
    .order-items {
        color: #6b7280;
        font-size: 0.8rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .order-items strong {
        color: #1a1a2e;
    }
    .order-items .item-dot {
        width: 4px;
        height: 4px;
        background: #d1d5db;
        border-radius: 50%;
        display: inline-block;
    }
    .order-total {
        font-weight: 700;
        font-size: 1.1rem;
        color: #667eea;
    }

    .order-action {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }
    .order-action .btn-view {
        background: var(--primary-gradient);
        color: white;
        border: none;
        border-radius: 0.5rem;
        padding: 0.3rem 1rem;
        font-size: 0.7rem;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        cursor: pointer;
        box-shadow: 0 2px 10px rgba(102, 126, 234, 0.2);
    }
    .order-action .btn-view:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.35);
        color: white;
    }
    .order-action .btn-cancel {
        background: #fee2e2;
        color: #dc2626;
        border: none;
        border-radius: 0.5rem;
        padding: 0.3rem 0.8rem;
        font-size: 0.65rem;
        font-weight: 600;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    .order-action .btn-cancel:hover {
        background: #dc2626;
        color: white;
        transform: translateY(-2px);
    }

    .order-products-preview {
        display: flex;
        gap: 0.3rem;
        margin-top: 0.5rem;
        padding-top: 0.5rem;
        border-top: 1px dashed #e5e7eb;
        flex-wrap: wrap;
    }
    .order-products-preview .product-thumb {
        width: 32px;
        height: 32px;
        border-radius: 0.4rem;
        background: #f3f4f6;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #e5e7eb;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    .order-products-preview .product-thumb:hover {
        transform: scale(1.2);
        border-color: #667eea;
        z-index: 10;
    }
    .order-products-preview .product-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .order-products-preview .product-thumb i {
        font-size: 0.7rem;
        color: #9ca3af;
    }
    .order-products-preview .more-items {
        font-size: 0.6rem;
        color: #6b7280;
        display: flex;
        align-items: center;
        background: #f3f4f6;
        padding: 0 0.5rem;
        border-radius: 2rem;
    }

    .pagination-custom {
        margin-top: 1.5rem;
        display: flex;
        justify-content: center;
    }
    .pagination-custom .pagination {
        gap: 0.3rem;
    }
    .pagination-custom .page-link {
        border: none;
        border-radius: 0.5rem;
        padding: 0.4rem 0.8rem;
        font-size: 0.8rem;
        font-weight: 500;
        color: #4b5563;
        background: white;
        box-shadow: var(--shadow-sm);
        transition: all 0.3s ease;
    }
    .pagination-custom .page-link:hover {
        background: var(--primary-gradient);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }
    .pagination-custom .active .page-link {
        background: var(--primary-gradient);
        color: white;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    .empty-state {
        text-align: center;
        padding: 4rem 1rem;
        background: white;
        border-radius: var(--radius);
        box-shadow: var(--shadow-sm);
    }
    .empty-state .icon-wrapper {
        width: 90px;
        height: 90px;
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.2rem;
        font-size: 2.5rem;
        color: #667eea;
        animation: float 3s ease-in-out infinite;
    }
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    .empty-state h5 {
        font-weight: 700;
        color: #1a1a2e;
        font-size: 1.1rem;
        margin-bottom: 0.3rem;
    }
    .empty-state p {
        color: #6b7280;
        font-size: 0.85rem;
        margin-bottom: 1rem;
    }

    @media (max-width: 768px) {
        .profile-sidebar {
            position: static;
            margin-bottom: 1rem;
        }
        .order-header { flex-direction: column; align-items: flex-start; }
        .order-body { flex-direction: column; align-items: flex-start; }
        .order-action { width: 100%; }
        .order-action .btn-view { flex: 1; justify-content: center; }
        .page-header { flex-direction: column; align-items: flex-start; }
        .filter-section { width: 100%; overflow-x: auto; padding-bottom: 0.5rem; flex-wrap: nowrap; }
        .filter-section .btn-filter { white-space: nowrap; }
    }

    @media (max-width: 576px) {
        .order-card { padding: 0.8rem 1rem; }
        .order-total { font-size: 0.95rem; }
    }
</style>

<div class="page-wrapper">
    <div class="container">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3">
                <div class="profile-sidebar">
                    <div class="profile-avatar">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="profile-name">{{ Auth::user()->name }}</div>
                    <div class="profile-email">{{ Auth::user()->email }}</div>
                    <div class="profile-badge">✦ Customer</div>

                    <ul class="sidebar-nav">
                        <li>
                            <a href="{{ route('customer.dashboard') }}">
                                <i class="fas fa-th-large"></i> Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('customer.orders') }}" class="active">
                                <i class="fas fa-shopping-bag"></i> My Orders
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('customer.wishlist') }}">
                                <i class="fas fa-heart"></i> Wishlist
                                @php
                                    $wishlistCount = \App\Models\Wishlist::where('user_id', Auth::id())->count();
                                @endphp
                                @if($wishlistCount > 0)
                                    <span class="badge bg-danger rounded-pill ms-auto">{{ $wishlistCount }}</span>
                                @endif
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('customer.profile') }}">
                                <i class="fas fa-user-cog"></i> Profile Settings
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('customer.addresses') }}">
                                <i class="fas fa-map-marker-alt"></i> Addresses
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('customer.reviews') }}">
                                <i class="fas fa-star"></i> My Reviews
                            </a>
                        </li>
                        <li style="margin-top: 0.3rem; padding-top: 0.3rem; border-top: 1px solid #f3f4f6;">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="sidebar-nav a logout" style="background: none; border: none; width: 100%; text-align: left; padding: 0.5rem 0.75rem; border-radius: 0.6rem; transition: all 0.3s ease; font-weight: 500; font-size: 0.8rem; display: flex; align-items: center; gap: 0.6rem; cursor: pointer;">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-9">
                <!-- Page Header -->
                <div class="page-header">
                    <div>
                        <h2>
                            <i class="fas fa-shopping-bag"></i> My Orders
                            <span class="order-count">
                                <i class="fas fa-receipt me-1"></i>
                                {{ isset($orders) ? $orders->total() : 0 }} Orders
                            </span>
                        </h2>
                    </div>
                    <div class="filter-section" id="filterSection">
                        <button class="btn-filter active" data-filter="all">All</button>
                        <button class="btn-filter" data-filter="pending">Pending</button>
                        <button class="btn-filter" data-filter="processing">Processing</button>
                        <button class="btn-filter" data-filter="shipped">Shipped</button>
                        <button class="btn-filter" data-filter="delivered">Delivered</button>
                        <button class="btn-filter" data-filter="cancelled">Cancelled</button>
                    </div>
                </div>

                <!-- Orders List -->
                @if(isset($orders) && $orders->count() > 0)
                    @foreach($orders as $order)
                    <div class="order-card" data-status="{{ $order->status }}" data-id="{{ $order->id }}">
                        <div class="order-header">
                            <div class="order-id">
                                <span>#{{ $order->order_number ?? $order->id }}</span>
                                <span class="badge-copy" onclick="copyToClipboard('{{ $order->order_number ?? $order->id }}')" title="Copy Order ID">
                                    <i class="fas fa-copy"></i>
                                </span>
                            </div>
                            <div class="d-flex align-items-center gap-3 flex-wrap">
                                <span class="order-date">
                                    <i class="far fa-calendar-alt"></i>
                                    {{ $order->created_at->format('M d, Y') }}
                                    <span class="text-muted" style="font-size: 0.65rem;">{{ $order->created_at->format('h:i A') }}</span>
                                </span>
                                <span class="order-status {{ $order->status }}">{{ $order->status }}</span>
                            </div>
                        </div>

                        <!-- Products Preview -->
                        <div class="order-products-preview">
                            @php
                                $items = $order->items->take(4);
                                $remaining = $order->items->count() - 4;
                            @endphp
                            @foreach($items as $item)
                            <div class="product-thumb" title="{{ $item->product->name ?? 'Product' }}">
                                @if($item->product && $item->product->thumbnail)
                                    <img src="{{ asset('storage/' . $item->product->thumbnail) }}" alt="{{ $item->product->name }}">
                                @else
                                    <i class="fas fa-image"></i>
                                @endif
                            </div>
                            @endforeach
                            @if($remaining > 0)
                                <span class="more-items">+{{ $remaining }} more</span>
                            @endif
                        </div>

                        <div class="order-body">
                            <div class="order-items">
                                <strong>{{ $order->items->count() }}</strong> items
                                <span class="item-dot"></span>
                                <span>Payment: <span class="text-capitalize">{{ $order->payment_status }}</span></span>
                            </div>
                            <div class="order-total">${{ number_format($order->total, 2) }}</div>
                            <div class="order-action">
                                @if(in_array($order->status, ['pending', 'processing']))
                                    <form method="POST" action="{{ route('customer.orders.cancel', ['order' => $order->id]) }}" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn-cancel" onclick="return confirm('Are you sure you want to cancel this order?')">
                                            <i class="fas fa-times me-1"></i> Cancel
                                        </button>
                                    </form>
                                @endif
                                <a href="{{ route('customer.orders.show', ['order' => $order->id]) }}" class="btn-view">
                                    <i class="fas fa-eye me-1"></i> View Details
                                    <i class="fas fa-arrow-right ms-1" style="font-size: 0.6rem;"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    <!-- Pagination -->
                    <div class="pagination-custom">
                        {{ $orders->links() }}
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="empty-state">
                        <div class="icon-wrapper">
                            <i class="fas fa-shopping-bag"></i>
                        </div>
                        <h5>No Orders Yet</h5>
                        <p>You haven't placed any orders. Start exploring our collection!</p>
                        <a href="{{ route('shop.index') }}" class="btn" style="background: var(--primary-gradient); color: white; border: none; border-radius: 0.75rem; padding: 0.6rem 1.8rem; font-weight: 600; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);">
                            <i class="fas fa-shopping-cart me-2"></i> Start Shopping
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            const badge = event.target.closest('.badge-copy');
            const original = badge.innerHTML;
            badge.innerHTML = '<i class="fas fa-check"></i>';
            setTimeout(() => {
                badge.innerHTML = original;
            }, 2000);
        });
    }

    document.querySelectorAll('.btn-filter').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.btn-filter').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            const filter = this.dataset.filter;
            document.querySelectorAll('.order-card').forEach(card => {
                if (filter === 'all' || card.dataset.status === filter) {
                    card.style.display = 'block';
                    card.style.animation = 'fadeInUp 0.3s ease';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });

    document.querySelectorAll('.order-card').forEach(card => {
        card.addEventListener('click', function(e) {
            if (e.target.closest('.order-action') || e.target.closest('form')) {
                return;
            }
            const orderId = this.dataset.id;
            if (orderId) {
                window.location.href = "/customer/orders/" + orderId;
            }
        });
    });

    const styleSheet = document.createElement("style");
    styleSheet.textContent = `
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    `;
    document.head.appendChild(styleSheet);

    console.log('%c📦 EktaMart Orders Page Loaded', 'color: #667eea; font-size: 14px; font-weight: bold;');
</script>
@endsection