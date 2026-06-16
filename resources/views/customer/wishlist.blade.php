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

    .wishlist-item {
        background: white;
        border-radius: var(--radius-sm);
        padding: 0.8rem 1rem;
        box-shadow: var(--shadow-sm);
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: all 0.3s ease;
        margin-bottom: 0.6rem;
        border: 1px solid rgba(0,0,0,0.02);
    }
    .wishlist-item:hover {
        box-shadow: var(--shadow-hover);
        transform: translateY(-2px);
    }

    .wishlist-img {
        width: 60px;
        height: 60px;
        border-radius: 0.5rem;
        background: #f3f4f6;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        overflow: hidden;
    }
    .wishlist-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .wishlist-img i {
        font-size: 1.5rem;
        color: #9ca3af;
    }

    .wishlist-info {
        flex: 1;
        min-width: 0;
    }
    .wishlist-name {
        font-weight: 600;
        font-size: 0.85rem;
    }
    .wishlist-category {
        color: #6b7280;
        font-size: 0.7rem;
    }
    .wishlist-price {
        font-weight: 700;
        color: #667eea;
        font-size: 0.9rem;
    }

    .wishlist-actions {
        display: flex;
        gap: 0.4rem;
        flex-shrink: 0;
    }
    .wishlist-actions .btn-sm {
        padding: 0.2rem 0.6rem;
        font-size: 0.7rem;
        border-radius: 0.4rem;
        border: none;
        font-weight: 500;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
        cursor: pointer;
    }
    .wishlist-actions .btn-cart {
        background: var(--primary-gradient);
        color: white;
    }
    .wishlist-actions .btn-cart:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        color: white;
    }
    .wishlist-actions .btn-remove {
        background: #fee2e2;
        color: #dc2626;
    }
    .wishlist-actions .btn-remove:hover {
        background: #dc2626;
        color: white;
    }

    @media (max-width: 576px) {
        .wishlist-item { flex-wrap: wrap; justify-content: center; text-align: center; }
        .wishlist-actions { width: 100%; justify-content: center; }
    }
</style>

<div class="page-wrapper">
    <div class="container">
        <h5 style="font-weight: 700; font-size: 1.1rem; margin-bottom: 1rem;">
            <i class="fas fa-heart" style="color: #ef4444;"></i> My Wishlist
            @if(isset($wishlist) && $wishlist->count() > 0)
                <span class="badge bg-secondary ms-2" style="font-size: 0.7rem;">{{ $wishlist->count() }} items</span>
            @endif
        </h5>

        @if(isset($wishlist) && $wishlist->count() > 0)
            @foreach($wishlist as $item)
            <div class="wishlist-item" id="wishlist-item-{{ $item->id }}">
                <div class="wishlist-img">
                    @if($item->product && $item->product->thumbnail)
                        <img src="{{ asset('storage/' . $item->product->thumbnail) }}" alt="{{ $item->product->name }}">
                    @else
                        <i class="fas fa-image"></i>
                    @endif
                </div>
                <div class="wishlist-info">
                    <div class="wishlist-name">{{ $item->product->name ?? 'Product' }}</div>
                    <div class="wishlist-category">{{ $item->product->category->name ?? 'Uncategorized' }}</div>
                    <div class="wishlist-price">${{ number_format($item->product->price ?? 0, 2) }}</div>
                </div>
                <div class="wishlist-actions">
                    @if($item->product && $item->product->status)
                        <a href="{{ route('cart.add', $item->product_id) }}" class="btn-sm btn-cart" onclick="event.preventDefault(); document.getElementById('add-cart-{{ $item->id }}').submit();">
                            <i class="fas fa-shopping-cart me-1"></i> Add to Cart
                        </a>
                        <form id="add-cart-{{ $item->id }}" method="POST" action="{{ route('cart.add') }}" style="display: none;">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                            <input type="hidden" name="quantity" value="1">
                        </form>
                    @endif
                    <form method="POST" action="{{ route('wishlist.remove', $item->id) }}" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-sm btn-remove" onclick="return confirm('Remove this item from wishlist?')">
                            <i class="fas fa-trash me-1"></i> Remove
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        @else
            <div class="text-center py-4" style="background: white; border-radius: var(--radius); box-shadow: var(--shadow-sm);">
                <div style="width: 50px; height: 50px; background: #f3f4f6; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 0.6rem;">
                    <i class="fas fa-heart fa-2x" style="color: #9ca3af;"></i>
                </div>
                <h6 style="color: #4b5563; font-weight: 600; font-size: 0.9rem;">Your wishlist is empty</h6>
                <p style="color: #6b7280; font-size: 0.8rem;">Save your favorite products here</p>
                <a href="{{ route('shop.index') }}" class="btn" style="background: var(--primary-gradient); color: white; border: none; border-radius: 0.6rem; padding: 0.4rem 1.2rem; font-size: 0.8rem;">
                    <i class="fas fa-shopping-cart me-1"></i> Start Shopping
                </a>
            </div>
        @endif
    </div>
</div>
@endsection