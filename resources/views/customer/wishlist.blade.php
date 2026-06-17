@extends('layouts.app')

@section('title', 'My Wishlist - EktaMart')

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
        color: #ef4444;
    }
    .page-header .item-count {
        background: white;
        padding: 0.3rem 1rem;
        border-radius: 2rem;
        font-size: 0.8rem;
        font-weight: 600;
        color: #4b5563;
        box-shadow: var(--shadow-sm);
    }

    .wishlist-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 1.2rem;
    }

    .wishlist-item {
        background: white;
        border-radius: var(--radius);
        padding: 1rem;
        box-shadow: var(--shadow-sm);
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        border: 1px solid rgba(0,0,0,0.02);
        position: relative;
        text-align: center;
    }
    .wishlist-item:hover {
        box-shadow: var(--shadow-hover);
        transform: translateY(-5px);
    }

    .wishlist-item .product-image {
        width: 100%;
        height: 160px;
        background: #f3f4f6;
        border-radius: 0.6rem;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 0.8rem;
        position: relative;
    }
    .wishlist-item .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: all 0.3s ease;
    }
    .wishlist-item:hover .product-image img {
        transform: scale(1.05);
    }
    .wishlist-item .product-image .no-image {
        font-size: 2rem;
        color: #9ca3af;
    }

    .wishlist-item .product-name {
        font-weight: 600;
        font-size: 0.85rem;
        color: #1a1a2e;
        margin-bottom: 0.3rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .wishlist-item .product-category {
        color: #6b7280;
        font-size: 0.7rem;
        margin-bottom: 0.4rem;
    }

    .wishlist-item .product-price {
        font-weight: 700;
        font-size: 1rem;
        color: #667eea;
        margin-bottom: 0.6rem;
    }

    .wishlist-item .product-actions {
        display: flex;
        gap: 0.4rem;
        justify-content: center;
        flex-wrap: wrap;
    }
    .wishlist-item .product-actions .btn-sm {
        padding: 0.25rem 0.8rem;
        font-size: 0.65rem;
        font-weight: 600;
        border-radius: 0.5rem;
        border: none;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        cursor: pointer;
    }
    .wishlist-item .product-actions .btn-cart {
        background: var(--primary-gradient);
        color: white;
        box-shadow: 0 2px 10px rgba(102, 126, 234, 0.2);
    }
    .wishlist-item .product-actions .btn-cart:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.35);
    }
    .wishlist-item .product-actions .btn-remove {
        background: #fee2e2;
        color: #dc2626;
    }
    .wishlist-item .product-actions .btn-remove:hover {
        background: #dc2626;
        color: white;
        transform: translateY(-2px);
    }

    .wishlist-item .remove-icon {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
        background: rgba(255,255,255,0.9);
        border-radius: 50%;
        width: 28px;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        border: none;
        color: #6b7280;
        box-shadow: var(--shadow-sm);
    }
    .wishlist-item .remove-icon:hover {
        background: #fee2e2;
        color: #dc2626;
        transform: scale(1.1);
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
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.1), rgba(220, 38, 38, 0.1));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.2rem;
        font-size: 2.5rem;
        color: #ef4444;
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
    }

    @media (max-width: 576px) {
        .wishlist-grid {
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 0.8rem;
        }
        .wishlist-item .product-image {
            height: 120px;
        }
        .wishlist-item .product-actions .btn-sm {
            font-size: 0.6rem;
            padding: 0.2rem 0.6rem;
        }
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
                            <a href="{{ route('customer.orders') }}">
                                <i class="fas fa-shopping-bag"></i> My Orders
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('customer.wishlist') }}" class="active">
                                <i class="fas fa-heart"></i> Wishlist
                                @if(isset($wishlist) && $wishlist->count() > 0)
                                    <span class="badge bg-danger rounded-pill ms-auto">{{ $wishlist->count() }}</span>
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
                <div class="page-header">
                    <h2>
                        <i class="fas fa-heart"></i> My Wishlist
                        <span class="item-count">
                            <i class="fas fa-heart me-1" style="color: #ef4444;"></i>
                            {{ isset($wishlist) ? $wishlist->count() : 0 }} Items
                        </span>
                    </h2>
                    @if(isset($wishlist) && $wishlist->count() > 0)
                        <form method="POST" action="{{ route('customer.wishlist.clear') }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm" style="background: #fee2e2; color: #dc2626; border: none; border-radius: 0.5rem; padding: 0.3rem 1rem; font-size: 0.75rem; font-weight: 600;" onclick="return confirm('Are you sure you want to clear your wishlist?')">
                                <i class="fas fa-trash me-1"></i> Clear All
                            </button>
                        </form>
                    @endif
                </div>

                @if(isset($wishlist) && $wishlist->count() > 0)
                    <div class="wishlist-grid">
                        @foreach($wishlist as $item)
                        <div class="wishlist-item" id="wishlist-item-{{ $item->id }}">
                            <button class="remove-icon" onclick="removeFromWishlist('{{ $item->id }}')" title="Remove from wishlist">
                                <i class="fas fa-times"></i>
                            </button>

                            <div class="product-image">
                                @if($item->product && $item->product->thumbnail)
                                    <img src="{{ asset('storage/' . $item->product->thumbnail) }}" alt="{{ $item->product->name }}">
                                @else
                                    <div class="no-image"><i class="fas fa-image"></i></div>
                                @endif
                            </div>

                            <div class="product-name">{{ $item->product->name ?? 'Product' }}</div>
                            <div class="product-category">{{ $item->product->category->name ?? 'Uncategorized' }}</div>
                            <div class="product-price">${{ number_format($item->product->price ?? 0, 2) }}</div>

                            <div class="product-actions">
                                @if($item->product && $item->product->status)
                                    <form method="POST" action="{{ route('cart.add') }}" style="display: inline;">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="btn-sm btn-cart">
                                            <i class="fas fa-shopping-cart"></i> Add to Cart
                                        </button>
                                    </form>
                                @endif
                                <form method="POST" action="{{ route('customer.wishlist.remove', $item->id) }}" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-sm btn-remove">
                                        <i class="fas fa-trash"></i> Remove
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <div class="icon-wrapper">
                            <i class="fas fa-heart"></i>
                        </div>
                        <h5>Your Wishlist is Empty</h5>
                        <p>Start adding your favorite products to your wishlist!</p>
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
    function removeFromWishlist(id) {
        if (confirm('Remove this item from wishlist?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/customer/wishlist/remove/' + id;
            
            const csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = '{{ csrf_token() }}';
            form.appendChild(csrf);
            
            const method = document.createElement('input');
            method.type = 'hidden';
            method.name = '_method';
            method.value = 'DELETE';
            form.appendChild(method);
            
            document.body.appendChild(form);
            form.submit();
        }
    }

    console.log('%c❤️ EktaMart Wishlist Page Loaded', 'color: #ef4444; font-size: 14px; font-weight: bold;');
</script>
@endsection