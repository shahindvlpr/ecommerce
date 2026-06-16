{{-- resources/views/admin/category/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Category List - EktaMart Admin')

@section('content')
<div class="container-fluid px-4 py-4">
    
    <style>
        /* Custom Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        @keyframes shimmer {
            0% { background-position: -1000px 0; }
            100% { background-position: 1000px 0; }
        }
        
        .animate-fade-up {
            animation: fadeInUp 0.6s ease-out forwards;
        }
        
        .animate-slide-right {
            animation: slideInRight 0.5s ease-out forwards;
        }
        
        /* Category Card */
        .category-card {
            border: none;
            border-radius: 1.25rem;
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .category-card:hover {
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            transform: translateY(-2px);
        }
        
        /* Card Header */
        .card-header-premium {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 1.25rem 1.5rem;
            border-bottom: none;
        }
        
        .card-header-premium h4 {
            color: white;
            font-weight: 700;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        /* Table Styles */
        .premium-table {
            border-radius: 1rem;
            overflow: hidden;
        }
        
        .premium-table thead {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
        }
        
        .premium-table thead th {
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            border: none;
            padding: 1rem;
        }
        
        .premium-table tbody tr {
            transition: all 0.3s ease;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .premium-table tbody tr:hover {
            background: linear-gradient(90deg, #f8fafc 0%, #ffffff 100%);
            transform: scale(1.01);
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        
        .premium-table tbody td {
            padding: 1rem;
            vertical-align: middle;
            font-weight: 500;
        }
        
        /* Badge Styles */
        .badge-premium {
            padding: 0.5rem 1rem;
            border-radius: 2rem;
            font-weight: 600;
            font-size: 0.75rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .badge-active {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
        }
        
        .badge-inactive {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
        }
        
        /* Button Styles */
        .btn-premium-sm {
            padding: 0.4rem 1rem;
            border-radius: 0.5rem;
            font-weight: 600;
            font-size: 0.8rem;
            transition: all 0.3s ease;
            margin: 0 0.2rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .btn-premium-sm:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        
        .btn-view {
            background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
            color: white;
            border: none;
        }
        
        .btn-edit {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
            border: none;
        }
        
        .btn-delete {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            border: none;
        }
        
        .btn-add {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border: none;
            padding: 0.6rem 1.5rem;
            border-radius: 0.75rem;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
            color: white;
        }
        
        /* Image Preview */
        .category-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 0.75rem;
            border: 2px solid #e2e8f0;
            transition: all 0.3s ease;
        }
        
        .category-image:hover {
            transform: scale(1.5);
            border-color: #8b5cf6;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            cursor: pointer;
        }
        
        /* Alert Animation */
        .alert-premium {
            border-radius: 1rem;
            border: none;
            background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
            color: #166534;
            font-weight: 500;
            animation: slideInRight 0.5s ease-out;
            padding: 1rem 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
        }
        
        .empty-state i {
            font-size: 4rem;
            color: #cbd5e1;
            margin-bottom: 1rem;
        }
        
        .empty-state h5 {
            color: #64748b;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .empty-state p {
            color: #94a3b8;
        }
        
        /* Pagination Custom */
        .pagination-custom {
            margin-top: 1.5rem;
        }
        
        .pagination-custom .pagination {
            justify-content: flex-end;
        }
        
        .pagination-custom .page-link {
            border-radius: 0.5rem;
            margin: 0 0.2rem;
            border: 1px solid #e2e8f0;
            color: #475569;
            transition: all 0.3s ease;
        }
        
        .pagination-custom .page-link:hover {
            background: linear-gradient(135deg, #8b5cf6 0%, #6366f1 100%);
            color: white;
            border-color: transparent;
            transform: translateY(-2px);
        }
        
        .pagination-custom .active .page-link {
            background: linear-gradient(135deg, #8b5cf6 0%, #6366f1 100%);
            border-color: transparent;
            color: white;
        }
        
        /* Breadcrumb */
        .breadcrumb-custom {
            background: transparent;
            padding: 0;
            margin-bottom: 1.5rem;
        }
        
        .breadcrumb-custom .breadcrumb-item a {
            color: #8b5cf6;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .breadcrumb-custom .breadcrumb-item a:hover {
            color: #6366f1;
        }
        
        .breadcrumb-custom .breadcrumb-item.active {
            color: #64748b;
            font-weight: 500;
        }
        
        /* Search and Filter Section */
        .search-section {
            margin-bottom: 1.5rem;
        }
        
        .search-input {
            border-radius: 0.75rem;
            border: 2px solid #e2e8f0;
            padding: 0.6rem 1rem;
            transition: all 0.3s ease;
        }
        
        .search-input:focus {
            border-color: #8b5cf6;
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
        }
        
        /* Stats Cards */
        .stats-card {
            background: white;
            border-radius: 1rem;
            padding: 1rem;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
            border-left: 4px solid;
        }
        
        .stats-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .premium-table thead th {
                font-size: 0.7rem;
                padding: 0.75rem;
            }
            
            .premium-table tbody td {
                padding: 0.75rem;
                font-size: 0.85rem;
            }
            
            .btn-premium-sm {
                padding: 0.3rem 0.6rem;
                font-size: 0.7rem;
            }
        }
    </style>

    <!-- Breadcrumb -->
    <div class="animate-slide-right">
        <nav aria-label="breadcrumb" class="breadcrumb-custom">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-home me-1"></i> Dashboard
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <i class="fas fa-tags me-1"></i> Categories
                </li>
            </ol>
        </nav>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4 animate-fade-up">
        <div class="col-md-3">
            <div class="stats-card" style="border-left-color: #8b5cf6;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted text-uppercase">Total Categories</small>
                        <h3 class="mb-0 fw-bold mt-1">{{ $categories->total() }}</h3>
                    </div>
                    <div class="rounded-circle bg-purple-100 p-3">
                        <i class="fas fa-layer-group fa-2x text-purple-600"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card" style="border-left-color: #10b981;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted text-uppercase">Active Categories</small>
                        <h3 class="mb-0 fw-bold mt-1">{{ $categories->where('status', 1)->count() }}</h3>
                    </div>
                    <div class="rounded-circle bg-green-100 p-3">
                        <i class="fas fa-check-circle fa-2x text-green-600"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card" style="border-left-color: #ef4444;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted text-uppercase">Inactive Categories</small>
                        <h3 class="mb-0 fw-bold mt-1">{{ $categories->where('status', 0)->count() }}</h3>
                    </div>
                    <div class="rounded-circle bg-red-100 p-3">
                        <i class="fas fa-ban fa-2x text-red-600"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card" style="border-left-color: #f59e0b;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted text-uppercase">With Images</small>
                        <h3 class="mb-0 fw-bold mt-1">{{ $categories->whereNotNull('icon')->count() }}</h3>
                    </div>
                    <div class="rounded-circle bg-orange-100 p-3">
                        <i class="fas fa-image fa-2x text-orange-600"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Card -->
    <div class="card category-card animate-fade-up">
        <div class="card-header-premium d-flex justify-content-between align-items-center flex-wrap gap-3">
            <h4>
                <i class="fas fa-tags me-2"></i>
                Category Management
            </h4>
            <a href="{{ route('categories.create') }}" class="btn-add">
                <i class="fas fa-plus-circle"></i>
                Add New Category
            </a>
        </div>

        <div class="card-body p-4">
            
            <!-- Success Alert -->
            @if(session('success'))
                <div class="alert-premium mb-4" id="successAlert">
                    <i class="fas fa-check-circle fa-lg"></i>
                    <span>{{ session('success') }}</span>
                    <button type="button" class="btn-close ms-auto" onclick="this.parentElement.remove()"></button>
                </div>
            @endif

            <!-- Search Section -->
            <div class="search-section">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0" style="border-radius: 0.75rem 0 0 0.75rem;">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" 
                                   id="searchInput" 
                                   class="form-control search-input border-start-0" 
                                   placeholder="Search categories by name or slug..."
                                   style="border-radius: 0 0.75rem 0.75rem 0;">
                        </div>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <select id="statusFilter" class="form-select search-input d-inline-block w-auto">
                            <option value="all">All Status</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                        <button id="resetFilter" class="btn btn-secondary ms-2" style="border-radius: 0.75rem;">
                            <i class="fas fa-sync-alt"></i> Reset
                        </button>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table premium-table" id="categoryTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Icon/Image</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Status</th>
                            <th width="250">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        @forelse($categories as $category)
                            <tr data-status="{{ $category->status }}" data-name="{{ strtolower($category->name) }}" data-slug="{{ strtolower($category->slug) }}">
                                <td>
                                    <span class="fw-bold text-purple-600">#{{ $category->id }}</span>
                                </td>
                                <td>
                                    @if($category->icon)
                                        <img src="{{ asset('storage/'.$category->icon) }}"
                                             class="category-image"
                                             alt="{{ $category->name }}"
                                             title="Click to preview"
                                             onclick="showImagePreview(this.src)">
                                    @else
                                        <div class="text-center">
                                            <i class="fas fa-image fa-2x text-muted"></i>
                                            <br>
                                            <small class="text-muted">No Image</small>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $category->name }}</strong>
                                </td>
                                <td>
                                    <code class="small">{{ $category->slug }}</code>
                                </td>
                                <td>
                                    @if($category->status)
                                        <span class="badge-premium badge-active">
                                            <i class="fas fa-circle fa-xs"></i>
                                            Active
                                        </span>
                                    @else
                                        <span class="badge-premium badge-inactive">
                                            <i class="fas fa-circle fa-xs"></i>
                                            Inactive
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-1 justify-content-center">
                                        <a href="{{ route('categories.show', $category->id) }}"
                                           class="btn-premium-sm btn-view"
                                           title="View Details">
                                            <i class="fas fa-eye"></i>
                                            <span class="d-none d-md-inline">View</span>
                                        </a>
                                        
                                        <a href="{{ route('categories.edit', $category->id) }}"
                                           class="btn-premium-sm btn-edit"
                                           title="Edit Category">
                                            <i class="fas fa-edit"></i>
                                            <span class="d-none d-md-inline">Edit</span>
                                        </a>
                                        
                                        <form action="{{ route('categories.destroy', $category->id) }}"
                                              method="POST"
                                              class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn-premium-sm btn-delete delete-btn"
                                                    title="Delete Category">
                                                <i class="fas fa-trash-alt"></i>
                                                <span class="d-none d-md-inline">Delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state">
                                        <i class="fas fa-folder-open"></i>
                                        <h5>No Categories Found</h5>
                                        <p>Get started by creating your first category</p>
                                        <a href="{{ route('categories.create') }}" class="btn-add mt-3">
                                            <i class="fas fa-plus-circle"></i> Create Category
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($categories->hasPages())
                <div class="pagination-custom">
                    {{ $categories->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Image Preview Modal -->
<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 1rem;">
            <div class="modal-header border-0">
                <h5 class="modal-title">Category Image Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="Preview" style="max-width: 100%; border-radius: 0.75rem;">
            </div>
        </div>
    </div>
</div>

<script>
    // Image Preview Function
    function showImagePreview(src) {
        document.getElementById('modalImage').src = src;
        var myModal = new bootstrap.Modal(document.getElementById('imageModal'));
        myModal.show();
    }
    
    // Auto-hide success alert after 5 seconds
    const successAlert = document.getElementById('successAlert');
    if (successAlert) {
        setTimeout(() => {
            successAlert.style.opacity = '0';
            setTimeout(() => successAlert.remove(), 300);
        }, 5000);
    }
    
    // Search and Filter Functionality
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const resetFilter = document.getElementById('resetFilter');
    const tableRows = document.querySelectorAll('#tableBody tr');
    
    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();
        const statusValue = statusFilter.value;
        
        tableRows.forEach(row => {
            if (row.querySelector('td[colspan]')) return; // Skip empty state row
            
            const name = row.getAttribute('data-name') || '';
            const slug = row.getAttribute('data-slug') || '';
            const rowStatus = row.getAttribute('data-status');
            
            const matchesSearch = name.includes(searchTerm) || slug.includes(searchTerm);
            const matchesStatus = statusValue === 'all' || rowStatus === statusValue;
            
            if (matchesSearch && matchesStatus) {
                row.style.display = '';
                row.style.animation = 'fadeInUp 0.3s ease-out';
            } else {
                row.style.display = 'none';
            }
        });
    }
    
    searchInput.addEventListener('input', filterTable);
    statusFilter.addEventListener('change', filterTable);
    resetFilter.addEventListener('click', () => {
        searchInput.value = '';
        statusFilter.value = 'all';
        filterTable();
    });
    
    // Delete Confirmation with Sweet Alert Style
    const deleteButtons = document.querySelectorAll('.delete-btn');
    deleteButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('.delete-form');
            
            if (confirm('⚠️ Are you sure you want to delete this category?\n\nThis action cannot be undone and will remove all associated products.')) {
                form.submit();
            }
        });
    });
    
    // Table row hover effect
    const rows = document.querySelectorAll('.premium-table tbody tr');
    rows.forEach(row => {
        row.addEventListener('mouseenter', () => {
            row.style.transition = 'all 0.3s ease';
        });
    });
    
    // Console greeting
    console.log('%c✨ EktaMart Admin | Category Management Page Loaded ✨', 'color: #8b5cf6; font-size: 14px; font-weight: bold;');
    console.log('%c⚡ Features: Real-time search • Status filter • Image preview • Stats cards • Smooth animations', 'color: #6366f1; font-size: 12px;');
    
    // Tooltip initialization (if Bootstrap JS available)
    if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }
</script>

<style>
    /* Additional inline styles */
    .bg-purple-100 { background: #f3e8ff; }
    .bg-green-100 { background: #dcfce7; }
    .bg-red-100 { background: #fee2e2; }
    .bg-orange-100 { background: #ffedd5; }
    .text-purple-600 { color: #8b5cf6; }
    .text-green-600 { color: #10b981; }
    .text-red-600 { color: #ef4444; }
    .text-orange-600 { color: #f59e0b; }
    
    /* Loading animation for images */
    .category-image {
        background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: shimmer 1.5s infinite;
    }
    
    .category-image[src] {
        animation: none;
        background: none;
    }
    
    /* Custom scrollbar */
    .table-responsive::-webkit-scrollbar {
        height: 8px;
    }
    
    .table-responsive::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    .table-responsive::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, #8b5cf6, #6366f1);
        border-radius: 10px;
    }
    
    /* Button group hover effects */
    .btn-premium-sm {
        position: relative;
        overflow: hidden;
    }
    
    .btn-premium-sm::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s ease;
    }
    
    .btn-premium-sm:hover::before {
        left: 100%;
    }
    
    /* Alert close button */
    .alert-premium .btn-close {
        filter: brightness(0.8);
    }
    
    /* Table cell animations */
    .premium-table tbody td {
        position: relative;
    }
</style>
@endsection