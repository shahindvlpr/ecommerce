@extends('vendor.layouts.app')

@section('title', 'Products - Vendor Panel')
@section('page-title', 'Products')

@section('content')
<div class="container-fluid">
    {{-- Header --}}
    <div class="d-flex flex-wrap flex-md-nowrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h5 class="fw-bold mb-1">Manage Products</h5>
            <p class="text-muted small">Manage your product inventory and listings</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('vendor.products.export') }}" class="btn btn-success btn-sm">
                <i class="fas fa-file-excel me-1"></i> Export
            </a>
            <a href="{{ route('vendor.products.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i> Add Product
            </a>
        </div>
    </div>

    {{-- Stats --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-3">
                    <h6 class="text-muted small">Total Products</h6>
                    <h4 class="fw-bold">{{ $products->total() }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-3">
                    <h6 class="text-muted small">Active</h6>
                    <h4 class="fw-bold text-success">{{ $products->where('status', true)->count() }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-3">
                    <h6 class="text-muted small">Inactive</h6>
                    <h4 class="fw-bold text-danger">{{ $products->where('status', false)->count() }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-3">
                    <h6 class="text-muted small">Low Stock</h6>
                    <h4 class="fw-bold text-warning">{{ $products->where('stock', '<', 10)->count() }}</h4>
                </div>
            </div>
        </div>
    </div>

    {{-- Search & Filter --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-3">
            <form method="GET" class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control form-control-sm" 
                           placeholder="Search products..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="category" class="form-select form-select-sm">
                        <option value="">All Categories</option>
                        @foreach($categories ?? [] as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select form-select-sm">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary btn-sm flex-fill">
                            <i class="fas fa-search me-1"></i> Search
                        </button>
                        <a href="{{ route('vendor.products.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-undo"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Products Table --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-3">#</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Status</th>
                            <th class="text-end pe-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                        <tr>
                            <td class="ps-3">{{ $loop->iteration }}</td>
                            <td>
                                <img src="{{ $product->thumbnail_url ?? asset('images/placeholder.jpg') }}" 
                                     alt="{{ $product->name }}" 
                                     style="width: 45px; height: 45px; object-fit: cover; border-radius: 8px;">
                            </td>
                            <td>
                                <span class="fw-semibold">{{ $product->name }}</span>
                            </td>
                            <td>{{ $product->category->name ?? 'Uncategorized' }}</td>
                            <td>
                                @if($product->sale_price)
                                    <span class="text-decoration-line-through text-muted small">${{ number_format($product->price, 2) }}</span>
                                    <br>
                                    <span class="fw-bold text-danger">${{ number_format($product->sale_price, 2) }}</span>
                                @else
                                    <span class="fw-bold">${{ number_format($product->price, 2) }}</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge 
                                    @if($product->stock > 10) bg-success
                                    @elseif($product->stock > 0) bg-warning
                                    @else bg-danger
                                    @endif
                                    rounded-pill px-3 py-2">
                                    {{ $product->stock }}
                                </span>
                            </td>
                            <td>
                                <form action="{{ route('vendor.products.toggle-status', $product->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" class="btn btn-sm {{ $product->status ? 'btn-success' : 'btn-secondary' }} rounded-pill px-3">
                                        {{ $product->status ? 'Active' : 'Inactive' }}
                                    </button>
                                </form>
                            </td>
                            <td class="text-end pe-3">
                                <div class="d-flex gap-1 justify-content-end">
                                    <a href="{{ route('vendor.products.show', $product->id) }}" 
                                       class="btn btn-sm btn-outline-info" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('vendor.products.edit', $product->id) }}" 
                                       class="btn btn-sm btn-outline-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button onclick="deleteProduct({{ $product->id }})" 
                                            class="btn btn-sm btn-outline-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <i class="fas fa-box-open fa-3x text-muted d-block mb-3"></i>
                                <h5 class="text-muted">No Products Found</h5>
                                <a href="{{ route('vendor.products.create') }}" class="btn btn-primary mt-2">
                                    <i class="fas fa-plus me-1"></i> Add Product
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($products->hasPages())
            <div class="card-footer bg-white border-0 py-3">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</div>

{{-- Delete Form --}}
<form id="delete-form" action="" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

@push('scripts')
<script>
function deleteProduct(id) {
    if (confirm('Are you sure you want to delete this product?')) {
        const form = document.getElementById('delete-form');
        form.action = `/vendor/products/${id}`;
        form.submit();
    }
}
</script>
@endpush
@endsection