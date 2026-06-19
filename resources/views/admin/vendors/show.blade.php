@extends('layouts.admin')

@section('title', 'Vendor Details - EktaMart Admin')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">
                <i class="fas fa-store text-primary me-2"></i>Vendor Details
            </h4>
            <p class="text-muted small">View vendor information and products</p>
        </div>
        <div class="d-flex gap-2">
            @if(!$user->is_approved)
                <form action="{{ route('admin.vendors.approve', $user) }}" method="POST" class="d-inline">
                    @csrf
                    @method('POST')
                    <button type="submit" class="btn btn-success" onclick="return confirm('Approve this vendor?')">
                        <i class="fas fa-check"></i> Approve Vendor
                    </button>
                </form>
            @endif
            <a href="{{ route('admin.vendors.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        {{-- Vendor Info --}}
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body text-center">
                    <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mx-auto" 
                         style="width: 100px; height: 100px; font-size: 2.5rem; font-weight: bold; color: #8b5cf6;">
                        {{ strtoupper(substr($user->name, 0, 2)) }}
                    </div>
                    <h5 class="mt-3 fw-bold">{{ $user->name }}</h5>
                    <p class="text-muted">{{ $user->email }}</p>
                    <div class="d-flex justify-content-center gap-2 flex-wrap">
                        <span class="badge {{ $user->is_approved ? 'bg-success' : 'bg-warning' }} rounded-pill px-3 py-2">
                            {{ $user->is_approved ? '✓ Approved' : '⏳ Pending Approval' }}
                        </span>
                        <span class="badge {{ $user->status ? 'bg-success' : 'bg-danger' }} rounded-pill px-3 py-2">
                            {{ $user->status ? 'Active' : 'Inactive' }}
                        </span>
                        <span class="badge bg-info rounded-pill px-3 py-2">
                            <i class="fas fa-store"></i> Vendor
                        </span>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0 rounded-4 mt-3">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">Quick Stats</h6>
                    <div class="row g-2">
                        <div class="col-6">
                            <div class="p-2 bg-light rounded-3 text-center">
                                <small class="text-muted">Products</small>
                                <h6 class="fw-bold mb-0">{{ $user->products_count ?? 0 }}</h6>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-2 bg-light rounded-3 text-center">
                                <small class="text-muted">Orders</small>
                                <h6 class="fw-bold mb-0">{{ $user->orders_count ?? 0 }}</h6>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-2 bg-light rounded-3 text-center">
                                <small class="text-muted">Joined</small>
                                <h6 class="fw-bold mb-0">{{ $user->created_at->format('d M Y') }}</h6>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-2 bg-light rounded-3 text-center">
                                <small class="text-muted">Status</small>
                                <h6 class="fw-bold mb-0">
                                    <span class="badge {{ $user->status ? 'bg-success' : 'bg-danger' }}">
                                        {{ $user->status ? 'Active' : 'Inactive' }}
                                    </span>
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="card shadow-sm border-0 rounded-4 mt-3">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">Quick Actions</h6>
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit Vendor
                        </a>
                        @if(!$user->is_approved)
                            <form action="{{ route('admin.vendors.approve', $user) }}" method="POST">
                                @csrf
                                @method('POST')
                                <button type="submit" class="btn btn-success w-100" onclick="return confirm('Approve this vendor?')">
                                    <i class="fas fa-check"></i> Approve Vendor
                                </button>
                            </form>
                        @endif
                        <a href="{{ route('admin.vendors.products', $user) }}" class="btn btn-info text-white">
                            <i class="fas fa-box"></i> View Products
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Vendor Information --}}
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">Vendor Information</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-2">
                                <label class="text-muted small">Full Name</label>
                                <p class="fw-semibold mb-0">{{ $user->name }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-2">
                                <label class="text-muted small">Email</label>
                                <p class="fw-semibold mb-0">{{ $user->email }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-2">
                                <label class="text-muted small">Phone</label>
                                <p class="fw-semibold mb-0">{{ $user->phone ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-2">
                                <label class="text-muted small">Role</label>
                                <p class="fw-semibold mb-0">
                                    <span class="badge bg-warning">Vendor</span>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-2">
                                <label class="text-muted small">Status</label>
                                <p class="fw-semibold mb-0">
                                    <span class="badge {{ $user->status ? 'bg-success' : 'bg-danger' }}">
                                        {{ $user->status ? 'Active' : 'Inactive' }}
                                    </span>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-2">
                                <label class="text-muted small">Approval Status</label>
                                <p class="fw-semibold mb-0">
                                    <span class="badge {{ $user->is_approved ? 'bg-success' : 'bg-warning' }}">
                                        {{ $user->is_approved ? 'Approved' : 'Pending' }}
                                    </span>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-2">
                                <label class="text-muted small">Address</label>
                                <p class="fw-semibold mb-0">{{ $user->address ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-2">
                                <label class="text-muted small">Store Description</label>
                                <p class="mb-0">{{ $user->store_description ?? 'No description provided' }}</p>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-2">
                                <label class="text-muted small">Joined Date</label>
                                <p class="fw-semibold mb-0">{{ $user->created_at->format('d M Y, h:i A') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Vendor Products --}}
            <div class="card shadow-sm border-0 rounded-4 mt-3">
                <div class="card-header bg-transparent border-0 pt-3 d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold">
                        <i class="fas fa-box text-primary me-2"></i>Products
                        <span class="badge bg-secondary">{{ $user->products_count ?? 0 }}</span>
                    </h6>
                    <a href="{{ route('admin.vendors.products', $user) }}" class="btn btn-sm btn-outline-primary">
                        View All <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Status</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse(($user->products ?? [])->take(5) as $product)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <img src="{{ $product->thumbnail_url ?? asset('images/default-product.png') }}" 
                                                 alt="{{ $product->name }}" 
                                                 style="width: 40px; height: 40px; object-fit: cover; border-radius: 8px;">
                                            <span>{{ $product->name }}</span>
                                        </div>
                                    </td>
                                    <td>${{ number_format($product->price, 2) }}</td>
                                    <td>
                                        <span class="badge {{ $product->stock > 10 ? 'bg-success' : ($product->stock > 0 ? 'bg-warning' : 'bg-danger') }}">
                                            {{ $product->stock }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge {{ $product->status ? 'bg-success' : 'bg-danger' }}">
                                            {{ $product->status ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.products.show', $product) }}" class="btn btn-sm btn-outline-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-3">
                                        <i class="fas fa-box-open fa-2x d-block mb-2"></i>
                                        No products found for this vendor.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection