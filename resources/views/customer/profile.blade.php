@extends('layouts.app')

@section('title', 'My Profile - EktaMart')

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

    /* Profile Card */
    .profile-card {
        background: white;
        border-radius: var(--radius);
        padding: 1.5rem;
        box-shadow: var(--shadow-sm);
        border: 1px solid rgba(0,0,0,0.02);
        transition: all 0.3s ease;
        margin-bottom: 1rem;
    }
    .profile-card:hover {
        box-shadow: var(--shadow-hover);
    }

    .profile-avatar-lg {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: var(--primary-gradient);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.2rem;
        color: white;
        font-weight: 700;
        margin: 0 auto 0.8rem;
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.25);
        transition: all 0.3s ease;
    }
    .profile-avatar-lg:hover {
        transform: scale(1.05);
    }

    .form-label {
        font-weight: 600;
        font-size: 0.8rem;
        color: #4b5563;
        margin-bottom: 0.2rem;
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }
    .form-label i {
        color: #667eea;
        font-size: 0.8rem;
    }
    .form-control {
        border-radius: 0.6rem;
        border: 1.5px solid #e5e7eb;
        padding: 0.5rem 0.8rem;
        font-size: 0.85rem;
        transition: all 0.3s ease;
    }
    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }
    .form-control:disabled {
        background: #f9fafb;
        cursor: not-allowed;
        opacity: 0.7;
    }

    .btn-save {
        background: var(--primary-gradient);
        color: white;
        border: none;
        border-radius: 0.6rem;
        padding: 0.5rem 1.5rem;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        color: white;
    }

    .section-title {
        font-weight: 700;
        font-size: 0.9rem;
        margin-bottom: 1rem;
        color: #1a1a2e;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #f3f4f6;
    }
    .section-title i {
        color: #667eea;
    }

    .profile-stats {
        display: flex;
        gap: 1.5rem;
        justify-content: center;
        flex-wrap: wrap;
        margin-top: 0.8rem;
        padding-top: 0.8rem;
        border-top: 1px solid #f3f4f6;
    }
    .profile-stats .stat-item {
        text-align: center;
    }
    .profile-stats .stat-item .stat-number {
        font-weight: 700;
        font-size: 1.1rem;
        color: #1a1a2e;
    }
    .profile-stats .stat-item .stat-label {
        font-size: 0.65rem;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    @media (max-width: 768px) {
        .profile-sidebar {
            position: static;
            margin-bottom: 1rem;
        }
    }

    @media (max-width: 576px) {
        .profile-card { padding: 1rem; }
        .profile-stats { gap: 1rem; }
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
                            <a href="{{ route('customer.profile') }}" class="active">
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
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Profile Header -->
                <div class="profile-card text-center">
                    <div class="profile-avatar-lg">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <h5 style="font-weight: 700; font-size: 1.1rem; margin-bottom: 0.1rem;">{{ Auth::user()->name }}</h5>
                    <p style="color: #6b7280; font-size: 0.8rem; margin-bottom: 0.3rem;">{{ Auth::user()->email }}</p>
                    <span class="badge" style="background: var(--primary-gradient); color: white; padding: 0.2rem 1rem; border-radius: 2rem; font-size: 0.7rem;">Customer</span>

                    <div class="profile-stats">
                        <div class="stat-item">
                            <div class="stat-number">{{ \App\Models\Order::where('user_id', Auth::id())->count() }}</div>
                            <div class="stat-label">Orders</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">{{ \App\Models\Wishlist::where('user_id', Auth::id())->count() }}</div>
                            <div class="stat-label">Wishlist</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">{{ \App\Models\Review::where('user_id', Auth::id())->count() }}</div>
                            <div class="stat-label">Reviews</div>
                        </div>
                    </div>
                </div>

                <!-- Profile Form -->
                <form method="POST" action="{{ route('customer.profile.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="profile-card">
                        <h6 class="section-title">
                            <i class="fas fa-user"></i> Personal Information
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fas fa-user-circle"></i> Full Name
                                </label>
                                <input type="text" name="name" class="form-control" value="{{ Auth::user()->name }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fas fa-envelope"></i> Email Address
                                </label>
                                <input type="email" class="form-control" value="{{ Auth::user()->email }}" disabled>
                                <small class="text-muted" style="font-size: 0.6rem;">Email cannot be changed</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fas fa-phone"></i> Phone Number
                                </label>
                                <input type="text" name="phone" class="form-control" value="{{ Auth::user()->phone ?? '' }}" placeholder="Enter phone number">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fas fa-globe"></i> Country
                                </label>
                                <input type="text" name="country" class="form-control" value="{{ Auth::user()->country ?? 'Bangladesh' }}" placeholder="Enter country">
                            </div>
                        </div>
                    </div>

                    <div class="profile-card">
                        <h6 class="section-title">
                            <i class="fas fa-map-marker-alt"></i> Address Information
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label">
                                    <i class="fas fa-location-dot"></i> Street Address
                                </label>
                                <textarea name="address" class="form-control" rows="2" placeholder="Enter your street address">{{ Auth::user()->address ?? '' }}</textarea>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">
                                    <i class="fas fa-city"></i> City
                                </label>
                                <input type="text" name="city" class="form-control" value="{{ Auth::user()->city ?? '' }}" placeholder="Enter city">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">
                                    <i class="fas fa-map"></i> State / Division
                                </label>
                                <input type="text" name="state" class="form-control" value="{{ Auth::user()->state ?? '' }}" placeholder="Enter state">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">
                                    <i class="fas fa-mailbox"></i> Postal Code
                                </label>
                                <input type="text" name="postal_code" class="form-control" value="{{ Auth::user()->postal_code ?? '' }}" placeholder="Enter postal code">
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-3 justify-content-end">
                        <button type="submit" class="btn-save">
                            <i class="fas fa-save me-1"></i> Update Profile
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection