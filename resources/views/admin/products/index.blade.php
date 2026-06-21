@extends('layouts.admin')

@section('title', 'Products - EktaMart Admin')

@section('content')
<div class="container-fluid px-4">
    {{-- ============================================================ --}}
    {{-- PAGE HEADER --}}
    {{-- ============================================================ --}}
    <div class="d-flex flex-wrap flex-md-nowrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h4 class="fw-bold mb-1 d-flex align-items-center gap-2">
                <span class="bg-primary bg-opacity-10 p-2 rounded-3">
                    <i class="fas fa-box text-primary"></i>
                </span>
                Product Management
            </h4>
            <p class="text-muted small mb-0">Manage your product inventory efficiently</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            {{-- Import Button --}}
            <button type="button" class="btn btn-info btn-sm px-3" data-bs-toggle="modal" data-bs-target="#importModal">
                <i class="fas fa-file-import me-1"></i> Import
            </button>
            <a href="{{ route('admin.products.export.excel') }}" class="btn btn-success btn-sm px-3">
                <i class="fas fa-file-excel me-1"></i> Export
            </a>
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm px-3">
                <i class="fas fa-plus me-1"></i> Add Product
            </a>
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- ALERT MESSAGES --}}
    {{-- ============================================================ --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3" role="alert">
            <div class="d-flex align-items-center gap-2">
                <i class="fas fa-check-circle text-success fs-5"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3" role="alert">
            <div class="d-flex align-items-center gap-2">
                <i class="fas fa-exclamation-circle text-danger fs-5"></i>
                <span>{{ session('error') }}</span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3" role="alert">
            <div class="d-flex align-items-start gap-2">
                <i class="fas fa-times-circle text-danger fs-5 mt-1"></i>
                <div>
                    <strong>Please fix the following errors:</strong>
                    <ul class="mb-0 mt-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- ============================================================ --}}
    {{-- MAIN CARD --}}
    {{-- ============================================================ --}}
    <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
        {{-- Card Header --}}
        <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
            <div class="row g-3 align-items-center">
                <div class="col-md-5 col-lg-6">
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">
                            <i class="fas fa-list me-1"></i> {{ $products->total() }} Products
                        </span>
                        <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">
                            <i class="fas fa-check-circle me-1"></i> {{ \App\Models\Product::where('status', true)->count() }} Active
                        </span>
                        <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill">
                            <i class="fas fa-times-circle me-1"></i> {{ \App\Models\Product::where('status', false)->count() }} Inactive
                        </span>
                    </div>
                </div>
                <div class="col-md-7 col-lg-6">
                    <div class="d-flex flex-wrap align-items-center justify-content-md-end gap-2">
                        {{-- Search --}}
                        <div class="input-group input-group-sm" style="min-width: 200px; flex: 1;">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" 
                                   class="form-control border-start-0 bg-white" 
                                   placeholder="Search products..." 
                                   id="searchInput">
                            <button class="btn btn-outline-secondary border-start-0" type="button" id="clearSearch" style="display:none;">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        
                        {{-- Filter Dropdown --}}
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-filter me-1"></i> Filter
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                <li><a class="dropdown-item active" href="#" data-filter="all">All Products</a></li>
                                <li><a class="dropdown-item" href="#" data-filter="active">✅ Active</a></li>
                                <li><a class="dropdown-item" href="#" data-filter="inactive">❌ Inactive</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#" data-filter="featured">⭐ Featured</a></li>
                                <li><a class="dropdown-item" href="#" data-filter="low-stock">📦 Low Stock (&lt; 10)</a></li>
                                <li><a class="dropdown-item" href="#" data-filter="out-of-stock">🚫 Out of Stock</a></li>
                            </ul>
                        </div>
                        
                        {{-- View Toggle --}}
                        <button class="btn btn-outline-secondary btn-sm" id="toggleView" title="Toggle view">
                            <i class="fas fa-th"></i>
                        </button>
                        
                        {{-- Refresh Button --}}
                        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary btn-sm" title="Refresh">
                            <i class="fas fa-sync-alt"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card Body --}}
        <div class="card-body p-0">
            {{-- GRID VIEW --}}
            <div id="gridView" class="p-3 d-none">
                <div class="row g-3" id="productGrid">
                    @forelse($products as $product)
                        <div class="col-xl-3 col-lg-4 col-md-6 product-item" 
                             data-status="{{ $product->status ? 'active' : 'inactive' }}"
                             data-featured="{{ $product->featured ? 'true' : 'false' }}"
                             data-stock="{{ $product->stock }}">
                            <div class="card h-100 border-0 shadow-sm hover-card transition-all rounded-3 overflow-hidden">
                                {{-- Product Image --}}
                                <div class="position-relative">
                                    <img src="{{ $product->thumbnail_url }}" 
                                         alt="{{ $product->name }}" 
                                         class="card-img-top" 
                                         style="height: 200px; object-fit: cover; background: #f8f9fa;"
                                         loading="lazy"
                                         onerror="this.src='{{ asset('images/placeholder.jpg') }}'">
                                    
                                    {{-- Badges --}}
                                    <div class="position-absolute top-0 end-0 p-2">
                                        @if($product->featured)
                                            <span class="badge bg-warning text-dark rounded-pill px-3 py-2 mb-1 d-block">
                                                <i class="fas fa-star me-1"></i> Featured
                                            </span>
                                        @endif
                                        @if(!$product->status)
                                            <span class="badge bg-danger rounded-pill px-3 py-2 d-block">
                                                <i class="fas fa-times me-1"></i> Inactive
                                            </span>
                                        @endif
                                    </div>
                                    
                                    {{-- Category Badge --}}
                                    <div class="position-absolute bottom-0 start-0 p-2 w-100">
                                        <span class="badge bg-dark bg-opacity-75 rounded-pill px-3 py-2">
                                            <i class="fas fa-tag me-1"></i> {{ $product->category->name ?? 'Uncategorized' }}
                                        </span>
                                    </div>
                                </div>
                                
                                {{-- Card Body --}}
                                <div class="card-body d-flex flex-column p-3">
                                    <h6 class="card-title fw-semibold mb-1 text-truncate" title="{{ $product->name }}">
                                        {{ $product->name }}
                                    </h6>
                                    
                                    {{-- Price & Stock --}}
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        @if($product->sale_price && $product->sale_price < $product->price)
                                            <div>
                                                <span class="text-decoration-line-through text-muted small">${{ number_format($product->price, 2) }}</span>
                                                <span class="fw-bold text-danger d-block">${{ number_format($product->sale_price, 2) }}</span>
                                            </div>
                                        @else
                                            <span class="fw-bold text-primary">${{ number_format($product->price, 2) }}</span>
                                        @endif
                                        <span class="ms-auto">
                                            <span class="badge {{ $product->stock > 10 ? 'bg-success' : ($product->stock > 0 ? 'bg-warning' : 'bg-danger') }} rounded-pill px-3">
                                                <i class="fas fa-box me-1"></i> {{ $product->stock }}
                                            </span>
                                        </span>
                                    </div>
                                    
                                    {{-- Actions --}}
                                    <div class="d-flex gap-1 mt-auto">
                                        <a href="{{ route('admin.products.show', $product) }}" 
                                           class="btn btn-sm btn-outline-primary flex-fill">
                                            <i class="fas fa-eye me-1"></i> View
                                        </a>
                                        <a href="{{ route('admin.products.edit', $product) }}" 
                                           class="btn btn-sm btn-outline-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-danger" 
                                                onclick="confirmDelete({{ $product->id }}, '{{ $product->name }}')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="text-center py-5">
                                <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
                                <h5>No Products Found</h5>
                                <p class="text-muted">Start by creating your first product.</p>
                                <a href="{{ route('admin.products.create') }}" class="btn btn-primary mt-2">
                                    <i class="fas fa-plus"></i> Create Product
                                </a>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- TABLE VIEW --}}
            <div id="tableView">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="productTable">
                        <thead class="bg-light bg-opacity-50">
                            <tr>
                                <th class="ps-4" style="width: 50px;">#</th>
                                <th style="width: 70px;">Image</th>
                                <th>Product</th>
                                <th>Category</th>
                                <th style="width: 120px;">Price</th>
                                <th style="width: 80px;">Stock</th>
                                <th style="width: 120px;">Status</th>
                                <th class="text-end pe-4" style="width: 150px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                            <tr class="product-item" 
                                data-status="{{ $product->status ? 'active' : 'inactive' }}"
                                data-featured="{{ $product->featured ? 'true' : 'false' }}"
                                data-stock="{{ $product->stock }}">
                                <td class="ps-4 text-muted">{{ $loop->iteration }}</td>
                                <td>
                                    <img src="{{ $product->thumbnail_url }}" 
                                         alt="{{ $product->name }}" 
                                         class="rounded-2" 
                                         style="width: 45px; height: 45px; object-fit: cover; border: 1px solid #e5e7eb;"
                                         loading="lazy"
                                         onerror="this.src='{{ asset('images/placeholder.jpg') }}'">
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="fw-semibold">{{ $product->name }}</span>
                                        <div class="d-flex gap-1 mt-1 flex-wrap">
                                            @if($product->featured)
                                                <span class="badge bg-warning text-dark px-2 py-1" style="font-size: 10px;">
                                                    <i class="fas fa-star me-1"></i> Featured
                                                </span>
                                            @endif
                                            @if($product->status)
                                                <span class="badge bg-success px-2 py-1" style="font-size: 10px;">
                                                    <i class="fas fa-check me-1"></i> Active
                                                </span>
                                            @else
                                                <span class="badge bg-secondary px-2 py-1" style="font-size: 10px;">
                                                    <i class="fas fa-times me-1"></i> Inactive
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark px-3 py-2 rounded-pill">
                                        {{ $product->category->name ?? 'Uncategorized' }}
                                    </span>
                                </td>
                                <td>
                                    @if($product->sale_price && $product->sale_price < $product->price)
                                        <div>
                                            <span class="text-decoration-line-through text-muted small">${{ number_format($product->price, 2) }}</span>
                                            <span class="fw-bold text-danger d-block">${{ number_format($product->sale_price, 2) }}</span>
                                        </div>
                                    @else
                                        <span class="fw-bold text-primary">${{ number_format($product->price, 2) }}</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge {{ $product->stock > 10 ? 'bg-success' : ($product->stock > 0 ? 'bg-warning' : 'bg-danger') }} rounded-pill px-3 py-2">
                                        {{ $product->stock }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <form action="{{ route('admin.products.toggle-status', $product) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('POST')
                                            <button type="submit" 
                                                    class="btn btn-sm {{ $product->status ? 'btn-success' : 'btn-secondary' }} rounded-circle p-1" 
                                                    style="width: 32px; height: 32px;"
                                                    title="{{ $product->status ? 'Deactivate' : 'Activate' }}"
                                                    onclick="return confirm('Are you sure you want to {{ $product->status ? 'deactivate' : 'activate' }} "{{ $product->name }}"?')">
                                                <i class="fas {{ $product->status ? 'fa-check' : 'fa-pause' }}"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.products.toggle-featured', $product) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('POST')
                                            <button type="submit" 
                                                    class="btn btn-sm {{ $product->featured ? 'btn-warning' : 'btn-outline-secondary' }} rounded-circle p-1" 
                                                    style="width: 32px; height: 32px;"
                                                    title="{{ $product->featured ? 'Remove Featured' : 'Make Featured' }}"
                                                    onclick="return confirm('{{ $product->featured ? 'Remove' : 'Add' }} featured status for "{{ $product->name }}"?')">
                                                <i class="fas fa-star"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex justify-content-end gap-1">
                                        <a href="{{ route('admin.products.show', $product) }}" 
                                           class="btn btn-sm btn-outline-info rounded-circle p-1" 
                                           style="width: 32px; height: 32px;"
                                           title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.products.edit', $product) }}" 
                                           class="btn btn-sm btn-outline-warning rounded-circle p-1" 
                                           style="width: 32px; height: 32px;"
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-danger rounded-circle p-1" 
                                                style="width: 32px; height: 32px;"
                                                title="Delete" 
                                                onclick="confirmDelete({{ $product->id }}, '{{ $product->name }}')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <div class="py-4">
                                        <i class="fas fa-box-open fa-3x text-muted d-block mb-3"></i>
                                        <h5 class="text-muted">No Products Found</h5>
                                        <p class="text-muted small">Start by creating your first product.</p>
                                        <a href="{{ route('admin.products.create') }}" class="btn btn-primary mt-2">
                                            <i class="fas fa-plus"></i> Create Product
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Card Footer with Pagination --}}
        @if($products->hasPages())
            <div class="card-footer bg-white border-0 py-3 px-4">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                    <span class="text-muted small">
                        Showing <strong>{{ $products->firstItem() ?? 0 }}</strong> to <strong>{{ $products->lastItem() ?? 0 }}</strong> of <strong>{{ $products->total() }}</strong> entries
                    </span>
                    <div>
                        {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

{{-- ============================================================ --}}
{{-- IMPORT MODAL --}}
{{-- ============================================================ --}}
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel">
                    <i class="fas fa-file-import text-info me-2"></i>Import Products
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.products.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="file" class="form-label fw-semibold">Choose Excel/CSV File</label>
                        <input type="file" class="form-control @error('file') is-invalid @enderror" 
                               id="file" name="file" accept=".csv,.xlsx,.xls" required>
                        @error('file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="mt-2">
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Supported formats: .csv, .xlsx, .xls
                            </small>
                        </div>
                    </div>
                    <div class="alert alert-info border-0">
                        <i class="fas fa-download me-2"></i>
                        <a href="#" class="text-decoration-none">Download sample template</a>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-info">
                        <i class="fas fa-upload me-1"></i> Import Products
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ============================================================ --}}
{{-- DELETE FORM --}}
{{-- ============================================================ --}}
<form id="delete-form" action="" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

{{-- ============================================================ --}}
{{-- JAVASCRIPT --}}
{{-- ============================================================ --}}
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ============================================================
        // SEARCH WITH DEBOUNCE
        // ============================================================
        const searchInput = document.getElementById('searchInput');
        const clearSearch = document.getElementById('clearSearch');
        let searchTimeout;

        function filterProducts() {
            const searchTerm = searchInput.value.toLowerCase().trim();
            const filterType = document.querySelector('.dropdown-item.active')?.dataset.filter || 'all';
            
            document.querySelectorAll('.product-item').forEach(item => {
                const text = item.textContent.toLowerCase();
                const status = item.dataset.status;
                const featured = item.dataset.featured === 'true';
                const stock = parseInt(item.dataset.stock) || 0;

                let matchesSearch = !searchTerm || text.includes(searchTerm);
                let matchesFilter = true;

                switch(filterType) {
                    case 'active':
                        matchesFilter = status === 'active';
                        break;
                    case 'inactive':
                        matchesFilter = status === 'inactive';
                        break;
                    case 'featured':
                        matchesFilter = featured;
                        break;
                    case 'low-stock':
                        matchesFilter = stock > 0 && stock < 10;
                        break;
                    case 'out-of-stock':
                        matchesFilter = stock === 0;
                        break;
                    default:
                        matchesFilter = true;
                }

                item.style.display = (matchesSearch && matchesFilter) ? '' : 'none';
            });

            clearSearch.style.display = searchTerm ? 'block' : 'none';
            updateEmptyState();
        }

        function updateEmptyState() {
            const visibleItems = document.querySelectorAll('.product-item[style*="display: none"]');
            // Find the grid or table and show/hide empty message
            // This is handled by the existing empty state in the blade
        }

        // Debounced search
        searchInput?.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(filterProducts, 300);
        });

        // Clear search
        clearSearch?.addEventListener('click', function() {
            searchInput.value = '';
            filterProducts();
            searchInput.focus();
        });

        // ============================================================
        // FILTER DROPDOWN
        // ============================================================
        document.querySelectorAll('.dropdown-item[data-filter]').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelectorAll('.dropdown-item[data-filter]').forEach(i => i.classList.remove('active'));
                this.classList.add('active');
                filterProducts();
            });
        });

        // ============================================================
        // TOGGLE VIEW (TABLE/GRID)
        // ============================================================
        const toggleBtn = document.getElementById('toggleView');
        const tableView = document.getElementById('tableView');
        const gridView = document.getElementById('gridView');
        let isGridView = false;

        // Check localStorage for saved preference
        const savedView = localStorage.getItem('productView');
        if (savedView === 'grid') {
            isGridView = true;
            tableView.classList.add('d-none');
            gridView.classList.remove('d-none');
            toggleBtn.innerHTML = '<i class="fas fa-table"></i>';
            toggleBtn.title = 'Switch to Table View';
        }

        toggleBtn?.addEventListener('click', function() {
            isGridView = !isGridView;
            tableView.classList.toggle('d-none', isGridView);
            gridView.classList.toggle('d-none', !isGridView);
            this.innerHTML = isGridView ? '<i class="fas fa-table"></i>' : '<i class="fas fa-th"></i>';
            this.title = isGridView ? 'Switch to Table View' : 'Switch to Grid View';
            
            // Save preference
            localStorage.setItem('productView', isGridView ? 'grid' : 'table');
        });

        // ============================================================
        // KEYBOARD SHORTCUTS
        // ============================================================
        document.addEventListener('keydown', function(e) {
            // Ctrl + / to focus search
            if ((e.ctrlKey || e.metaKey) && e.key === '/') {
                e.preventDefault();
                searchInput?.focus();
                searchInput?.select();
            }
            // Escape to clear search
            if (e.key === 'Escape' && document.activeElement === searchInput) {
                searchInput.value = '';
                filterProducts();
                searchInput.blur();
            }
        });

        // ============================================================
        // TOOLTIP INIT (if Bootstrap 5)
        // ============================================================
        if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
            document.querySelectorAll('[title]').forEach(el => {
                new bootstrap.Tooltip(el);
            });
        }

        // ============================================================
        // CONSOLE DEBUG
        // ============================================================
        console.log('%c📦 Products Management', 'color: #8b5cf6; font-size: 14px; font-weight: bold;');
        console.log(`%c📊 Total: {{ $products->total() }} | Active: {{ \App\Models\Product::where('status', true)->count() }} | Inactive: {{ \App\Models\Product::where('status', false)->count() }}`, 'color: #10b981; font-size: 12px;');
        console.log('💡 Tip: Use Ctrl+/ to search, Esc to clear');
    });

    // ============================================================
    // DELETE CONFIRMATION
    // ============================================================
    function confirmDelete(id, name) {
        if (confirm(`⚠️ Are you sure you want to delete "${name}"?\n\nThis action cannot be undone.`)) {
            const form = document.getElementById('delete-form');
            form.action = `/admin/products/${id}`;
            form.submit();
        }
    }
</script>
@endpush

{{-- ============================================================ --}}
{{-- ADDITIONAL STYLES --}}
{{-- ============================================================ --}}
@push('styles')
<style>
    .hover-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .hover-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 40px rgba(0,0,0,0.08) !important;
    }
    .transition-all {
        transition: all 0.3s ease;
    }
    .btn-sm.rounded-circle {
        transition: all 0.2s ease;
    }
    .btn-sm.rounded-circle:hover {
        transform: scale(1.15);
    }
    .table > :not(caption) > * > * {
        padding: 0.75rem 0.5rem;
    }
    .badge {
        font-weight: 500;
    }
    .card-img-top {
        background: #f8f9fa;
    }
    .product-item {
        transition: all 0.3s ease;
    }
    .product-item.hidden {
        display: none !important;
    }
    .dropdown-item.active {
        background: #f3e8ff;
        color: #7c3aed;
    }
    .pagination {
        margin-bottom: 0;
    }
    .pagination .page-link {
        border: none;
        color: #4b5563;
        border-radius: 8px;
        padding: 0.375rem 0.75rem;
        margin: 0 2px;
        transition: all 0.2s ease;
    }
    .pagination .page-link:hover {
        background: #f3f4f6;
        color: #111827;
    }
    .pagination .page-item.active .page-link {
        background: #7c3aed;
        color: white;
        box-shadow: 0 2px 8px rgba(124, 58, 237, 0.3);
    }
    .pagination .page-item.disabled .page-link {
        color: #d1d5db;
        background: transparent;
    }
    #searchInput:focus {
        box-shadow: none;
        border-color: #7c3aed;
    }
    .modal-content {
        border: none;
        border-radius: 16px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.15);
    }
    .modal-header {
        border-bottom: 1px solid #f3f4f6;
        padding: 1.25rem 1.5rem;
    }
    .modal-footer {
        border-top: 1px solid #f3f4f6;
        padding: 1rem 1.5rem;
    }
    .alert {
        border-radius: 12px;
    }
</style>
@endpush
@endsection