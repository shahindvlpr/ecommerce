@extends('layouts.app')

@section('title', 'My Addresses - EktaMart')

@section('content')
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --shadow-sm: 0 2px 12px rgba(0, 0, 0, 0.06);
        --shadow-hover: 0 8px 30px rgba(0, 0, 0, 0.1);
        --radius: 1rem;
    }

    .page-wrapper {
        background: #f5f6fa;
        min-height: 100vh;
        padding: 1.5rem 0;
    }

    .address-card {
        background: white;
        border-radius: var(--radius);
        padding: 1rem 1.2rem;
        box-shadow: var(--shadow-sm);
        border: 1px solid rgba(0,0,0,0.02);
        transition: all 0.3s ease;
        margin-bottom: 0.8rem;
        position: relative;
    }
    .address-card:hover {
        box-shadow: var(--shadow-hover);
        transform: translateY(-2px);
    }
    .address-card.default {
        border: 2px solid #667eea;
    }

    .address-name {
        font-weight: 700;
        font-size: 0.9rem;
    }
    .address-phone {
        color: #6b7280;
        font-size: 0.8rem;
    }
    .address-text {
        color: #4b5563;
        font-size: 0.85rem;
        margin: 0.2rem 0 0.4rem 0;
    }

    .address-actions {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
        margin-top: 0.5rem;
    }
    .address-actions .btn-sm {
        padding: 0.2rem 0.7rem;
        font-size: 0.7rem;
        border-radius: 0.4rem;
        border: none;
        font-weight: 500;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }
    .address-actions .btn-edit {
        background: #dbeafe;
        color: #2563eb;
    }
    .address-actions .btn-edit:hover {
        background: #2563eb;
        color: white;
    }
    .address-actions .btn-delete {
        background: #fee2e2;
        color: #dc2626;
    }
    .address-actions .btn-delete:hover {
        background: #dc2626;
        color: white;
    }
    .address-actions .btn-default {
        background: #dcfce7;
        color: #16a34a;
    }
    .address-actions .btn-default:hover {
        background: #16a34a;
        color: white;
    }

    .default-badge {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
        background: #667eea;
        color: white;
        padding: 0.15rem 0.6rem;
        border-radius: 2rem;
        font-size: 0.6rem;
        font-weight: 600;
    }

    .add-address-btn {
        background: var(--primary-gradient);
        color: white;
        border: none;
        border-radius: 0.6rem;
        padding: 0.4rem 1.2rem;
        font-size: 0.8rem;
        font-weight: 500;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }
    .add-address-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        color: white;
    }

    @media (max-width: 576px) {
        .address-actions { flex-direction: column; }
        .address-actions .btn-sm { width: 100%; text-align: center; }
    }
</style>

<div class="page-wrapper">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 style="font-weight: 700; font-size: 1.1rem; margin: 0;">
                <i class="fas fa-map-marker-alt" style="color: #667eea;"></i> My Addresses
            </h5>
            <a href="{{ route('customer.addresses.create') }}" class="add-address-btn">
                <i class="fas fa-plus me-1"></i> Add Address
            </a>
        </div>

        @if(isset($addresses) && $addresses->count() > 0)
            @foreach($addresses as $address)
            <div class="address-card {{ $address->is_default ? 'default' : '' }}">
                @if($address->is_default)
                    <span class="default-badge">Default</span>
                @endif
                <div class="address-name">{{ $address->name }}</div>
                <div class="address-phone"><i class="fas fa-phone me-1"></i> {{ $address->phone }}</div>
                <div class="address-text">{{ $address->full_address }}</div>
                <div class="address-actions">
                    <a href="{{ route('customer.addresses.edit', $address->id) }}" class="btn-sm btn-edit">
                        <i class="fas fa-edit me-1"></i> Edit
                    </a>
                    @if(!$address->is_default)
                        <form method="POST" action="{{ route('customer.addresses.default', $address->id) }}" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn-sm btn-default">
                                <i class="fas fa-check me-1"></i> Set Default
                            </button>
                        </form>
                    @endif
                    <form method="POST" action="{{ route('customer.addresses.destroy', $address->id) }}" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-sm btn-delete" onclick="return confirm('Are you sure you want to delete this address?')">
                            <i class="fas fa-trash me-1"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        @else
            <div class="text-center py-4" style="background: white; border-radius: var(--radius); box-shadow: var(--shadow-sm);">
                <div style="width: 50px; height: 50px; background: #f3f4f6; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 0.6rem;">
                    <i class="fas fa-map-marker-alt fa-2x" style="color: #9ca3af;"></i>
                </div>
                <h6 style="color: #4b5563; font-weight: 600; font-size: 0.9rem;">No addresses saved</h6>
                <p style="color: #6b7280; font-size: 0.8rem;">Add your first address for faster checkout</p>
                <a href="{{ route('customer.addresses.create') }}" class="add-address-btn">
                    <i class="fas fa-plus me-1"></i> Add Address
                </a>
            </div>
        @endif
    </div>
</div>
@endsection