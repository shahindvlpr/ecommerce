@extends('layouts.app')

@section('title', 'My Addresses - EktaMart')

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
    .page-header .address-count {
        background: white;
        padding: 0.3rem 1rem;
        border-radius: 2rem;
        font-size: 0.8rem;
        font-weight: 600;
        color: #4b5563;
        box-shadow: var(--shadow-sm);
    }

    /* Address Card */
    .address-card {
        background: white;
        border-radius: var(--radius);
        padding: 1.2rem 1.5rem;
        box-shadow: var(--shadow-sm);
        border: 1px solid rgba(0,0,0,0.02);
        transition: all 0.3s ease;
        margin-bottom: 0.8rem;
        position: relative;
    }
    .address-card:hover {
        box-shadow: var(--shadow-hover);
        transform: translateY(-3px);
    }
    .address-card.default {
        border: 2px solid #667eea;
        background: linear-gradient(135deg, #ffffff 0%, #f5f3ff 100%);
    }

    .address-card .default-badge {
        position: absolute;
        top: 0.8rem;
        right: 0.8rem;
        background: #667eea;
        color: white;
        padding: 0.2rem 0.8rem;
        border-radius: 2rem;
        font-size: 0.6rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
    }

    .address-name {
        font-weight: 700;
        font-size: 0.95rem;
        color: #1a1a2e;
        margin-bottom: 0.1rem;
    }
    .address-phone {
        color: #6b7280;
        font-size: 0.8rem;
        margin-bottom: 0.1rem;
    }
    .address-phone i {
        color: #667eea;
    }
    .address-text {
        color: #4b5563;
        font-size: 0.85rem;
        margin: 0.2rem 0 0.5rem 0;
        line-height: 1.5;
    }
    .address-type {
        display: inline-block;
        padding: 0.15rem 0.6rem;
        border-radius: 2rem;
        font-size: 0.6rem;
        font-weight: 600;
        background: #f3f4f6;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .address-actions {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
        margin-top: 0.6rem;
        padding-top: 0.6rem;
        border-top: 1px solid #f3f4f6;
    }
    .address-actions .btn-sm {
        padding: 0.25rem 0.8rem;
        font-size: 0.7rem;
        border-radius: 0.5rem;
        border: none;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        cursor: pointer;
    }
    .address-actions .btn-edit {
        background: #dbeafe;
        color: #2563eb;
    }
    .address-actions .btn-edit:hover {
        background: #2563eb;
        color: white;
        transform: translateY(-2px);
    }
    .address-actions .btn-delete {
        background: #fee2e2;
        color: #dc2626;
    }
    .address-actions .btn-delete:hover {
        background: #dc2626;
        color: white;
        transform: translateY(-2px);
    }
    .address-actions .btn-default {
        background: #dcfce7;
        color: #16a34a;
    }
    .address-actions .btn-default:hover {
        background: #16a34a;
        color: white;
        transform: translateY(-2px);
    }

    .add-address-btn {
        background: var(--primary-gradient);
        color: white;
        border: none;
        border-radius: 0.6rem;
        padding: 0.4rem 1.2rem;
        font-size: 0.8rem;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        box-shadow: 0 2px 10px rgba(102, 126, 234, 0.2);
    }
    .add-address-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 20px rgba(102, 126, 234, 0.35);
        color: white;
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
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        font-size: 2.2rem;
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
        .address-actions {
            flex-direction: column;
        }
        .address-actions .btn-sm {
            width: 100%;
            justify-content: center;
        }
        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }
    }

    @media (max-width: 576px) {
        .address-card {
            padding: 0.8rem 1rem;
        }
        .address-card .default-badge {
            position: static;
            display: inline-block;
            margin-top: 0.5rem;
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
                            <a href="{{ route('customer.addresses') }}" class="active">
                                <i class="fas fa-map-marker-alt"></i> Addresses
                                @if(isset($addresses) && $addresses->count() > 0)
                                    <span class="badge bg-primary rounded-pill ms-auto">{{ $addresses->count() }}</span>
                                @endif
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
                        <i class="fas fa-map-marker-alt"></i> My Addresses
                        <span class="address-count">
                            <i class="fas fa-home me-1"></i>
                            {{ isset($addresses) ? $addresses->count() : 0 }} Addresses
                        </span>
                    </h2>
                    <a href="{{ route('customer.addresses.create') }}" class="add-address-btn">
                        <i class="fas fa-plus-circle"></i> Add New Address
                    </a>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(isset($addresses) && $addresses->count() > 0)
                    @foreach($addresses as $address)
                    <div class="address-card {{ $address->is_default ? 'default' : '' }}">
                        @if($address->is_default)
                            <span class="default-badge"><i class="fas fa-check-circle me-1"></i> Default</span>
                        @endif
                        <div class="address-name">{{ $address->name }}</div>
                        <div class="address-phone">
                            <i class="fas fa-phone-alt"></i> {{ $address->phone }}
                            @if($address->email)
                                <span class="mx-2">·</span>
                                <i class="fas fa-envelope"></i> {{ $address->email }}
                            @endif
                        </div>
                        <div class="address-text">
                            <i class="fas fa-location-dot me-1" style="color: #667eea;"></i>
                            {{ $address->full_address }}
                        </div>
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <span class="address-type">{{ $address->type }}</span>
                            <div class="address-actions">
                                <a href="{{ route('customer.addresses.edit', $address->id) }}" class="btn-sm btn-edit">
                                    <i class="fas fa-pen"></i> Edit
                                </a>
                                @if(!$address->is_default)
                                    <form method="POST" action="{{ route('customer.addresses.default', $address->id) }}" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn-sm btn-default">
                                            <i class="fas fa-check"></i> Set Default
                                        </button>
                                    </form>
                                @endif
                                <form method="POST" action="{{ route('customer.addresses.destroy', $address->id) }}" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-sm btn-delete" onclick="return confirm('Are you sure you want to delete this address?')">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="empty-state">
                        <div class="icon-wrapper">
                            <i class="fas fa-map-location-dot"></i>
                        </div>
                        <h5>No Addresses Saved</h5>
                        <p>Add your first address for faster checkout and delivery.</p>
                        <a href="{{ route('customer.addresses.create') }}" class="add-address-btn">
                            <i class="fas fa-plus-circle me-1"></i> Add Your First Address
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection