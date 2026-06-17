@extends('layouts.app')

@section('title', 'My Reviews - EktaMart')

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
        color: #f59e0b;
    }

    .review-card {
        background: white;
        border-radius: var(--radius);
        padding: 1rem 1.2rem;
        box-shadow: var(--shadow-sm);
        border: 1px solid rgba(0,0,0,0.02);
        transition: all 0.3s ease;
        margin-bottom: 0.8rem;
    }
    .review-card:hover {
        box-shadow: var(--shadow-hover);
        transform: translateY(-2px);
    }

    .review-product {
        font-weight: 700;
        font-size: 0.9rem;
        color: #1a1a2e;
    }
    .review-rating {
        color: #f59e0b;
        font-size: 0.8rem;
        letter-spacing: 1px;
    }
    .review-title {
        font-weight: 600;
        font-size: 0.85rem;
        margin: 0.2rem 0;
    }
    .review-comment {
        color: #4b5563;
        font-size: 0.8rem;
        margin-bottom: 0.2rem;
    }
    .review-date {
        color: #6b7280;
        font-size: 0.7rem;
    }

    .review-status {
        padding: 0.15rem 0.6rem;
        border-radius: 2rem;
        font-size: 0.6rem;
        font-weight: 600;
        display: inline-block;
    }
    .review-status.approved { background: #dcfce7; color: #16a34a; }
    .review-status.pending { background: #fef3c7; color: #d97706; }

    .review-actions .btn-sm {
        padding: 0.15rem 0.6rem;
        font-size: 0.65rem;
        border-radius: 0.4rem;
        border: none;
        font-weight: 500;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }
    .review-actions .btn-edit {
        background: #dbeafe;
        color: #2563eb;
    }
    .review-actions .btn-edit:hover {
        background: #2563eb;
        color: white;
        transform: translateY(-2px);
    }
    .review-actions .btn-delete {
        background: #fee2e2;
        color: #dc2626;
    }
    .review-actions .btn-delete:hover {
        background: #dc2626;
        color: white;
        transform: translateY(-2px);
    }

    .empty-state {
        text-align: center;
        padding: 4rem 1rem;
        background: white;
        border-radius: var(--radius);
        box-shadow: var(--shadow-sm);
    }
    .empty-state .icon-wrapper {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.1), rgba(217, 119, 6, 0.1));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        font-size: 2.2rem;
        color: #f59e0b;
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
        .page-header {
            flex-direction: column;
            align-items: flex-start;
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
                            <a href="{{ route('customer.reviews') }}" class="active">
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
                        <i class="fas fa-star"></i> My Reviews
                        <span class="badge bg-secondary rounded-pill ms-2" style="font-size: 0.7rem;">
                            {{ isset($reviews) ? $reviews->total() : 0 }} Reviews
                        </span>
                    </h2>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(isset($reviews) && $reviews->count() > 0)
                    @foreach($reviews as $review)
                    <div class="review-card">
                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-1">
                            <div>
                                <div class="review-product">{{ $review->product->name ?? 'Product' }}</div>
                                <div class="review-rating">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $review->rating ? '' : 'text-muted' }}"></i>
                                    @endfor
                                    <span class="text-muted ms-1" style="font-size: 0.7rem;">({{ $review->rating }})</span>
                                </div>
                                @if($review->title)
                                    <div class="review-title">{{ $review->title }}</div>
                                @endif
                                <div class="review-comment">{{ $review->comment }}</div>
                                <div class="review-date">
                                    <i class="far fa-calendar-alt me-1"></i>
                                    {{ $review->created_at->format('M d, Y') }}
                                </div>
                            </div>
                            <div class="text-end">
                                <span class="review-status {{ $review->is_approved ? 'approved' : 'pending' }}">
                                    {{ $review->is_approved ? 'Approved' : 'Pending' }}
                                </span>
                                <div class="review-actions mt-1">
                                    @if(!$review->is_approved)
                                        <span class="text-muted" style="font-size: 0.65rem;">
                                            <i class="fas fa-clock me-1"></i> Awaiting approval
                                        </span>
                                    @endif
                                    <form method="POST" action="{{ route('customer.reviews.destroy', $review->id) }}" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-sm btn-delete" onclick="return confirm('Delete this review?')">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    <div class="mt-3">
                        {{ $reviews->links() }}
                    </div>
                @else
                    <div class="empty-state">
                        <div class="icon-wrapper">
                            <i class="fas fa-star"></i>
                        </div>
                        <h5>No Reviews Yet</h5>
                        <p>Share your experience with products you've purchased</p>
                        <a href="{{ route('shop.index') }}" class="btn" style="background: var(--primary-gradient); color: white; border: none; border-radius: 0.75rem; padding: 0.6rem 1.8rem; font-weight: 600; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);">
                            <i class="fas fa-shopping-cart me-2"></i> Start Shopping
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection