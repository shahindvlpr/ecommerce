@extends('layouts.admin')

@section('title', 'Brands - EktaMart Admin')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">
                <i class="fas fa-tag text-primary me-2"></i>Brands
            </h4>
            <p class="text-muted small">Manage your product brands</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-secondary btn-sm" onclick="window.location.reload()">
                <i class="fas fa-sync-alt"></i>
            </button>
            <a href="{{ route('admin.brands.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Brand
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-transparent border-0 pt-3 pb-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <span class="text-muted small">Total Brands: <strong>{{ $brands->total() }}</strong></span>
                </div>
                <div class="d-flex gap-2">
                    <div class="input-group input-group-sm" style="width: 250px;">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" placeholder="Search brands..." id="searchInput">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="brandTable">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-3" style="width: 60px;">#</th>
                            <th style="width: 80px;">Logo</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th style="width: 100px;">Products</th>
                            <th style="width: 120px;">Status</th>
                            <th style="width: 120px;">Created</th>
                            <th class="text-end pe-3" style="width: 130px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($brands as $brand)
                        <tr>
                            <td class="ps-3">{{ $loop->iteration }}</td>
                            <td>
                                @if($brand->logo)
                                    <img src="{{ asset('storage/' . $brand->logo) }}" 
                                         alt="{{ $brand->name }}" 
                                         style="width: 40px; height: 40px; object-fit: contain; border-radius: 8px; border: 1px solid #e5e7eb;">
                                @else
                                    <span class="badge bg-light text-muted border p-2" style="width: 40px; height: 40px; display: inline-flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-tag"></i>
                                    </span>
                                @endif
                            </td>
                            <td>
                                <span class="fw-semibold">{{ $brand->name }}</span>
                            </td>
                            <td><code>{{ $brand->slug }}</code></td>
                            <td>
                                <span class="badge bg-info">{{ $brand->products_count ?? 0 }}</span>
                            </td>
                            <td>
                                <form action="{{ route('admin.brands.toggle-status', $brand) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" class="btn btn-sm {{ $brand->status ? 'btn-success' : 'btn-secondary' }} rounded-pill px-3">
                                        <i class="fas {{ $brand->status ? 'fa-check-circle' : 'fa-times-circle' }} me-1"></i>
                                        {{ $brand->status ? 'Active' : 'Inactive' }}
                                    </button>
                                </form>
                            </td>
                            <td>
                                <small>{{ $brand->created_at->format('d M Y') }}</small>
                            </td>
                            <td class="text-end pe-3">
                                <div class="d-flex justify-content-end gap-1">
                                    <a href="{{ route('admin.brands.edit', $brand) }}" 
                                       class="btn btn-sm btn-outline-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-sm btn-outline-danger" 
                                            title="Delete"
                                            onclick="confirmDelete({{ $brand->id }}, '{{ $brand->name }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-5">
                                <i class="fas fa-tag fa-3x d-block mb-3" style="color: #d1d5db;"></i>
                                <h5>No Brands Found</h5>
                                <p class="text-muted">Start by creating your first brand.</p>
                                <a href="{{ route('admin.brands.create') }}" class="btn btn-primary mt-2">
                                    <i class="fas fa-plus"></i> Create Brand
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($brands->hasPages())
            <div class="card-footer bg-transparent">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <span class="text-muted small">
                        Showing {{ $brands->firstItem() ?? 0 }} to {{ $brands->lastItem() ?? 0 }} of {{ $brands->total() }} entries
                    </span>
                    {{ $brands->links() }}
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
    // ============================================================
    // 1. CONFIRM DELETE
    // ============================================================
    function confirmDelete(id, name) {
        if (confirm(`Are you sure you want to delete brand "${name}"? This action cannot be undone.`)) {
            const form = document.getElementById('delete-form');
            form.action = `/admin/brands/${id}`;
            form.submit();
        }
    }

    // ============================================================
    // 2. SEARCH FUNCTIONALITY
    // ============================================================
    document.getElementById('searchInput')?.addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('#brandTable tbody tr');
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? '' : 'none';
        });
    });

    // ============================================================
    // 3. CONSOLE GREETING
    // ============================================================
    console.log('%c🏷️ Brands Page Loaded', 'color: #8b5cf6; font-size: 13px; font-weight: bold;');
    console.log(`%c📊 Total Brands: {{ $brands->total() }}`, 'color: #10b981; font-size: 12px;');
</script>

<style>
    .table > :not(caption) > * > * {
        padding: 0.6rem 0.6rem;
        vertical-align: middle;
    }
    
    .table tbody tr {
        transition: all 0.2s ease;
    }
    
    .table tbody tr:hover {
        background-color: #f8fafc;
    }
    
    .btn-success, .btn-secondary {
        transition: all 0.2s ease;
    }
    
    .input-group .form-control:focus {
        border-color: #8b5cf6;
        box-shadow: 0 0 0 0.2rem rgba(139, 92, 246, 0.1);
    }
</style>
@endsection