@extends('layouts.admin')

@section('title', 'Vendor Details - EktaMart Admin')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">
            <i class="fas fa-store text-primary me-2"></i>Vendor Details
        </h4>
        <div>
            @if(!$vendor->is_approved)
                <form action="{{ route('admin.vendors.approve', $vendor) }}" method="POST" class="d-inline">
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

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body text-center">
                    <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mx-auto" 
                         style="width: 100px; height: 100px; font-size: 2.5rem; font-weight: bold; color: #8b5cf6;">
                        {{ strtoupper(substr($vendor->name, 0, 2)) }}
                    </div>
                    <h5 class="mt-3 fw-bold">{{ $vendor->name }}</h5>
                    <p class="text-muted">{{ $vendor->email }}</p>
                    <div class="d-flex justify-content-center gap-2">
                        <span class="badge {{ $vendor->is_approved ? 'bg-success' : 'bg-warning' }} rounded-pill px-3 py-2">
                            {{ $vendor->is_approved ? 'Approved' : 'Pending Approval' }}
                        </span>
                        <span class="badge {{ $vendor->status ? 'bg-success' : 'bg-danger' }} rounded-pill px-3 py-2">
                            {{ $vendor->status ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">Vendor Information</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-2">
                                <label class="text-muted small">Full Name</label>
                                <p class="fw-semibold mb-0">{{ $vendor->name }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-2">
                                <label class="text-muted small">Email</label>
                                <p class="fw-semibold mb-0">{{ $vendor->email }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-2">
                                <label class="text-muted small">Phone</label>
                                <p class="fw-semibold mb-0">{{ $vendor->phone ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-2">
                                <label class="text-muted small">Joined</label>
                                <p class="fw-semibold mb-0">{{ $vendor->created_at->format('d M Y, h:i A') }}</p>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-2">
                                <label class="text-muted small">Address</label>
                                <p class="fw-semibold mb-0">{{ $vendor->address ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-2">
                                <label class="text-muted small">Store Description</label>
                                <p class="mb-0">{{ $vendor->store_description ?? 'No description provided' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0 rounded-4 mt-3">
                <div class="card-header bg-transparent border-0 pt-3">
                    <h6 class="fw-bold">
                        <i class="fas fa-box text-primary me-2"></i>Products ({{ $vendor->products_count ?? 0 }})
                    </h6>
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
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($vendor->products ?? [] as $product)
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td>${{ number_format($product->price, 2) }}</td>
                                    <td>{{ $product->stock }}</td>
                                    <td>
                                        <span class="badge {{ $product->status ? 'bg-success' : 'bg-danger' }}">
                                            {{ $product->status ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-3">
                                        No products found.
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