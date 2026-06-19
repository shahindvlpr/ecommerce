@extends('layouts.admin')

@section('title', 'Products - EktaMart Admin')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">
                <i class="fas fa-box text-primary me-2"></i>Products
            </h4>
            <p class="text-muted small">Manage your product inventory</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.products.export.excel') }}" class="btn btn-success btn-sm">
                <i class="fas fa-file-excel"></i> Export
            </a>
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Product
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-transparent border-0 pt-3 pb-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <span class="text-muted small">Total Products: <strong>{{ $products->total() }}</strong></span>
                    <span class="text-muted small ms-3">
                        <span class="badge bg-success">Active: {{ \App\Models\Product::where('status', true)->count() }}</span>
                        <span class="badge bg-danger ms-1">Inactive: {{ \App\Models\Product::where('status', false)->count() }}</span>
                    </span>
                </div>
                <div class="input-group input-group-sm" style="width: 250px;">
                    <span class="input-group-text bg-transparent border-end-0">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" class="form-control border-start-0" placeholder="Search products..." id="searchInput">
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="productTable">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-3" style="width: 60px;">#</th>
                            <th style="width: 80px;">Image</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th style="width: 100px;">Price</th>
                            <th style="width: 80px;">Stock</th>
                            <th style="width: 100px;">Status</th>
                            <th class="text-end pe-3" style="width: 130px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                        <tr>
                            <td class="ps-3">{{ $loop->iteration }}</td>
                            <td>
                                <img src="{{ $product->thumbnail_url }}" 
                                     alt="{{ $product->name }}" 
                                     style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px; border: 1px solid #e5e7eb;">
                            </td>
                            <td>
                                <span class="fw-semibold">{{ $product->name }}</span>
                                @if($product->featured)
                                    <span class="badge bg-warning text-dark ms-1">Featured</span>
                                @endif
                            </td>
                            <td>{{ $product->category->name ?? 'Uncategorized' }}</td>
                            <td>
                                @if($product->sale_price && $product->sale_price < $product->price)
                                    <span class="text-decoration-line-through text-muted small">${{ number_format($product->price, 2) }}</span>
                                    <br>
                                    <span class="fw-bold text-danger">${{ number_format($product->sale_price, 2) }}</span>
                                @else
                                    <span class="fw-bold">${{ number_format($product->price, 2) }}</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge {{ $product->stock > 10 ? 'bg-success' : ($product->stock > 0 ? 'bg-warning' : 'bg-danger') }}">
                                    {{ $product->stock }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <form action="{{ route('admin.products.toggle-status', $product) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('POST')
                                        <button type="submit" class="btn btn-sm {{ $product->status ? 'btn-success' : 'btn-secondary' }} rounded-pill px-2" title="Toggle Status">
                                            <i class="fas {{ $product->status ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.products.toggle-featured', $product) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('POST')
                                        <button type="submit" class="btn btn-sm {{ $product->featured ? 'btn-warning' : 'btn-outline-secondary' }} rounded-pill px-2" title="Toggle Featured">
                                            <i class="fas fa-star"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                            <td class="text-end pe-3">
                                <div class="d-flex justify-content-end gap-1">
                                    <a href="{{ route('admin.products.show', $product) }}" class="btn btn-sm btn-outline-info" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-danger" title="Delete" onclick="confirmDelete({{ $product->id }}, '{{ $product->name }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-5">
                                <i class="fas fa-box-open fa-3x d-block mb-3" style="color: #d1d5db;"></i>
                                <h5>No Products Found</h5>
                                <p class="text-muted">Start by creating your first product.</p>
                                <a href="{{ route('admin.products.create') }}" class="btn btn-primary mt-2">
                                    <i class="fas fa-plus"></i> Create Product
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($products->hasPages())
            <div class="card-footer bg-transparent">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <span class="text-muted small">
                        Showing {{ $products->firstItem() ?? 0 }} to {{ $products->lastItem() ?? 0 }} of {{ $products->total() }} entries
                    </span>
                    {{ $products->links() }}
                </div>
            </div>
        @endif
    </div>
</div>

{{-- Delete Form (Hidden) --}}
<form id="delete-form" action="" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
    function confirmDelete(id, name) {
        if (confirm(`Are you sure you want to delete product "${name}"? This action cannot be undone.`)) {
            const form = document.getElementById('delete-form');
            form.action = `/admin/products/${id}`;
            form.submit();
        }
    }

    document.getElementById('searchInput')?.addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('#productTable tbody tr');
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? '' : 'none';
        });
    });

    console.log('%c📦 Products Page Loaded', 'color: #8b5cf6; font-size: 13px; font-weight: bold;');
    console.log(`%c📊 Total Products: {{ $products->total() }}`, 'color: #10b981; font-size: 12px;');
</script>
@endsection