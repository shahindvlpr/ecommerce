{{-- resources/views/admin/category/show.blade.php --}}
@extends('layouts.admin')

@section('title', 'Category Details - ' . $category->name . ' | EktaMart Admin')

@section('content')
<div class="container-fluid px-4 py-5">
    
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
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        
        /* Card Header */
        .card-header-premium {
            background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
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
        
        /* Detail Table */
        .details-table {
            border-radius: 1rem;
            overflow: hidden;
        }
        
        .details-table tr {
            transition: all 0.3s ease;
        }
        
        .details-table tr:hover {
            background: #f8fafc;
        }
        
        .details-table th {
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            width: 200px;
            font-weight: 700;
            color: #1e293b;
            border: 1px solid #e2e8f0;
            padding: 1rem;
        }
        
        .details-table td {
            border: 1px solid #e2e8f0;
            padding: 1rem;
            font-weight: 500;
            color: #334155;
        }
        
        /* Badge Styles */
        .badge-premium {
            padding: 0.5rem 1rem;
            border-radius: 2rem;
            font-weight: 600;
            font-size: 0.8rem;
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
        
        /* Image Styles */
        .category-image {
            max-width: 200px;
            max-height: 200px;
            border-radius: 1rem;
            border: 3px solid white;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .category-image:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        }
        
        /* Button Styles */
        .btn-premium {
            background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
            border: none;
            border-radius: 0.75rem;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            color: white;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .btn-premium:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(14, 165, 233, 0.3);
            background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
            color: white;
        }
        
        .btn-edit {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        }
        
        .btn-edit:hover {
            background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
            box-shadow: 0 10px 20px rgba(245, 158, 11, 0.3);
        }
        
        /* Stats Cards */
        .stats-card {
            background: white;
            border-radius: 1rem;
            padding: 1.25rem;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
            border-left: 4px solid;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        
        .stats-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        
        /* Breadcrumb */
        .breadcrumb-custom {
            background: transparent;
            padding: 0;
            margin-bottom: 1.5rem;
        }
        
        .breadcrumb-custom .breadcrumb-item a {
            color: #0ea5e9;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .breadcrumb-custom .breadcrumb-item a:hover {
            color: #0284c7;
        }
        
        .breadcrumb-custom .breadcrumb-item.active {
            color: #64748b;
            font-weight: 500;
        }
        
        /* Info Cards */
        .info-card {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-radius: 1rem;
            padding: 1rem;
            height: 100%;
        }
        
        .info-card i {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }
        
        .info-card .label {
            font-size: 0.75rem;
            text-transform: uppercase;
            color: #64748b;
            font-weight: 600;
        }
        
        .info-card .value {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1e293b;
        }
        
        /* Code styling */
        code {
            background: #f1f5f9;
            padding: 0.25rem 0.5rem;
            border-radius: 0.5rem;
            color: #0ea5e9;
            font-weight: 600;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .card-header-premium {
                flex-direction: column;
                text-align: center;
            }
            
            .action-buttons {
                flex-direction: column;
                gap: 1rem;
            }
            
            .action-buttons a {
                width: 100%;
                text-align: center;
                justify-content: center;
            }
            
            .details-table th {
                width: auto;
            }
            
            .stats-card {
                margin-bottom: 1rem;
            }
        }
        
        /* Loading animation for image */
        .category-image {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
        }
        
        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
        
        .category-image[src] {
            animation: none;
            background: none;
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
                <li class="breadcrumb-item">
                    <a href="{{ route('categories.index') }}">
                        <i class="fas fa-tags me-1"></i> Categories
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <i class="fas fa-info-circle me-1"></i> {{ $category->name }}
                </li>
            </ol>
        </nav>
    </div>

    <!-- Stats Overview Row -->
    <div class="row mb-4 animate-fade-up">
        <div class="col-md-3">
            <div class="stats-card" style="border-left-color: #0ea5e9;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted text-uppercase">Category ID</small>
                        <h3 class="mb-0 fw-bold mt-1">#{{ $category->id }}</h3>
                    </div>
                    <div class="rounded-circle bg-sky-100 p-3">
                        <i class="fas fa-hashtag fa-2x text-sky-600"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card" style="border-left-color: #10b981;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted text-uppercase">Current Status</small>
                        <h3 class="mb-0 fw-bold mt-1">
                            @if($category->status)
                                <span class="text-success">Active</span>
                            @else
                                <span class="text-danger">Inactive</span>
                            @endif
                        </h3>
                    </div>
                    <div class="rounded-circle bg-green-100 p-3">
                        <i class="fas {{ $category->status ? 'fa-check-circle' : 'fa-ban' }} fa-2x {{ $category->status ? 'text-green-600' : 'text-red-600' }}"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card" style="border-left-color: #8b5cf6;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted text-uppercase">Created</small>
                        <h6 class="mb-0 fw-bold mt-1">{{ $category->created_at ? $category->created_at->format('M d, Y') : 'N/A' }}</h6>
                        <small class="text-muted">{{ $category->created_at ? $category->created_at->diffForHumans() : '' }}</small>
                    </div>
                    <div class="rounded-circle bg-purple-100 p-3">
                        <i class="fas fa-calendar-plus fa-2x text-purple-600"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card" style="border-left-color: #f59e0b;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted text-uppercase">Last Updated</small>
                        <h6 class="mb-0 fw-bold mt-1">{{ $category->updated_at ? $category->updated_at->format('M d, Y') : 'N/A' }}</h6>
                        <small class="text-muted">{{ $category->updated_at ? $category->updated_at->diffForHumans() : '' }}</small>
                    </div>
                    <div class="rounded-circle bg-orange-100 p-3">
                        <i class="fas fa-edit fa-2x text-orange-600"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Card -->
    <div class="row animate-fade-up">
        <div class="col-lg-8 mx-auto">
            <div class="card category-card shadow-sm">
                <div class="card-header-premium">
                    <h4>
                        <i class="fas fa-info-circle me-2"></i>
                        Category Details
                    </h4>
                    <div class="ms-auto">
                        @if($category->status)
                            <span class="badge-premium badge-active">
                                <i class="fas fa-circle fa-xs"></i>
                                Active Category
                            </span>
                        @else
                            <span class="badge-premium badge-inactive">
                                <i class="fas fa-circle fa-xs"></i>
                                Inactive Category
                            </span>
                        @endif
                    </div>
                </div>

                <div class="card-body p-4">
                    
                    <!-- Category Icon Section -->
                    <div class="text-center mb-4">
                        @if($category->icon)
                            <img src="{{ asset('storage/'.$category->icon) }}"
                                 class="category-image"
                                 alt="{{ $category->name }}"
                                 onclick="showImagePreview(this.src)"
                                 title="Click to preview">
                            <div class="mt-2">
                                <small class="text-muted">
                                    <i class="fas fa-info-circle"></i> Click image to preview
                                </small>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <div class="rounded-circle bg-gray-100 d-inline-flex p-4">
                                    <i class="fas fa-image fa-4x text-muted"></i>
                                </div>
                                <p class="text-muted mt-2 mb-0">No icon uploaded</p>
                            </div>
                        @endif
                    </div>

                    <!-- Details Table -->
                    <div class="table-responsive">
                        <table class="table details-table">
                            <tr>
                                <th style="width: 200px;">
                                    <i class="fas fa-hashtag text-sky-600 me-2"></i>
                                    Category ID
                                </th>
                                <td>
                                    <code>#{{ $category->id }}</code>
                                </td>
                            </tr>
                            
                            <tr>
                                <th>
                                    <i class="fas fa-tag text-sky-600 me-2"></i>
                                    Category Name
                                </th>
                                <td>
                                    <strong class="text-dark">{{ $category->name }}</strong>
                                </td>
                            </tr>
                            
                            <tr>
                                <th>
                                    <i class="fas fa-link text-sky-600 me-2"></i>
                                    Slug
                                </th>
                                <td>
                                    <code>{{ $category->slug }}</code>
                                    <br>
                                    <small class="text-muted">URL-friendly version of the category name</small>
                                </td>
                            </tr>
                            
                            <tr>
                                <th>
                                    <i class="fas fa-toggle-on text-sky-600 me-2"></i>
                                    Status
                                </th>
                                <td>
                                    @if($category->status)
                                        <span class="badge-premium badge-active">
                                            <i class="fas fa-check-circle"></i>
                                            Active
                                        </span>
                                        <small class="text-muted ms-2">Visible in store</small>
                                    @else
                                        <span class="badge-premium badge-inactive">
                                            <i class="fas fa-ban"></i>
                                            Inactive
                                        </span>
                                        <small class="text-muted ms-2">Hidden from store</small>
                                    @endif
                                </td>
                            </tr>
                            
                            <tr>
                                <th>
                                    <i class="fas fa-calendar-alt text-sky-600 me-2"></i>
                                    Created At
                                </th>
                                <td>
                                    <div>
                                        <i class="far fa-calendar-alt text-muted me-1"></i>
                                        {{ $category->created_at ? $category->created_at->format('l, F d, Y') : 'N/A' }}
                                    </div>
                                    <small class="text-muted">
                                        <i class="far fa-clock me-1"></i>
                                        {{ $category->created_at ? $category->created_at->format('h:i A') : '' }}
                                        ({{ $category->created_at ? $category->created_at->diffForHumans() : '' }})
                                    </small>
                                </td>
                            </tr>
                            
                            <tr>
                                <th>
                                    <i class="fas fa-clock text-sky-600 me-2"></i>
                                    Last Updated
                                </th>
                                <td>
                                    <div>
                                        <i class="far fa-calendar-alt text-muted me-1"></i>
                                        {{ $category->updated_at ? $category->updated_at->format('l, F d, Y') : 'N/A' }}
                                    </div>
                                    <small class="text-muted">
                                        <i class="far fa-clock me-1"></i>
                                        {{ $category->updated_at ? $category->updated_at->format('h:i A') : '' }}
                                        ({{ $category->updated_at ? $category->updated_at->diffForHumans() : '' }})
                                    </small>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <!-- Additional Info Cards -->
                    <div class="row mt-4">
                        <div class="col-md-6 mb-3">
                            <div class="info-card text-center">
                                <i class="fas fa-chart-line text-sky-600"></i>
                                <div class="label">Products Count</div>
                                <div class="value">{{ $category->products_count ?? 0 }} Products</div>
                                <small class="text-muted">Products under this category</small>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="info-card text-center">
                                <i class="fas fa-store text-sky-600"></i>
                                <div class="label">Store Visibility</div>
                                <div class="value">
                                    @if($category->status)
                                        <span class="text-success">Public</span>
                                    @else
                                        <span class="text-danger">Hidden</span>
                                    @endif
                                </div>
                                <small class="text-muted">Customer visibility status</small>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex gap-3 mt-4 pt-3 action-buttons">
                        <a href="{{ route('categories.edit', $category->id) }}" class="btn-premium btn-edit flex-grow-1 text-center">
                            <i class="fas fa-edit me-2"></i>
                            Edit Category
                        </a>
                        
                        <a href="{{ route('categories.index') }}" class="btn-premium flex-grow-1 text-center">
                            <i class="fas fa-arrow-left me-2"></i>
                            Back to Categories
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Help Section -->
            <div class="text-center mt-4">
                <small class="text-muted">
                    <i class="fas fa-shield-alt me-1"></i> 
                    Secure Category Information | 
                    <i class="fas fa-info-circle ms-2 me-1"></i>
                    Last updated: {{ $category->updated_at ? $category->updated_at->diffForHumans() : 'N/A' }}
                </small>
            </div>
        </div>
    </div>
</div>

<!-- Image Preview Modal -->
<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border-radius: 1rem;">
            <div class="modal-header border-0">
                <h5 class="modal-title">
                    <i class="fas fa-image text-sky-600 me-2"></i>
                    Category Icon Preview
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="Preview" style="max-width: 100%; max-height: 70vh; border-radius: 0.75rem;">
            </div>
            <div class="modal-footer border-0">
                <div class="text-muted small me-auto">
                    <i class="fas fa-info-circle"></i> Category: {{ $category->name }}
                </div>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
    
    // Add ripple effect to buttons
    const buttons = document.querySelectorAll('.btn-premium');
    buttons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            const rect = this.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            const ripple = document.createElement('span');
            ripple.style.position = 'absolute';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            ripple.style.width = '0px';
            ripple.style.height = '0px';
            ripple.style.borderRadius = '50%';
            ripple.style.backgroundColor = 'rgba(255,255,255,0.3)';
            ripple.style.transform = 'translate(-50%, -50%)';
            ripple.style.transition = 'width 0.4s, height 0.4s, opacity 0.4s';
            ripple.style.pointerEvents = 'none';
            this.style.position = 'relative';
            this.style.overflow = 'hidden';
            this.appendChild(ripple);
            setTimeout(() => {
                ripple.style.width = '200px';
                ripple.style.height = '200px';
                ripple.style.opacity = '0';
            }, 10);
            setTimeout(() => ripple.remove(), 500);
        });
    });
    
    // Animate stats cards on scroll
    const statsCards = document.querySelectorAll('.stats-card');
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    statsCards.forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'all 0.5s ease';
        observer.observe(card);
    });
    
    // Console greeting
    console.log('%c✨ EktaMart Admin | Category Details Page Loaded ✨', 'color: #0ea5e9; font-size: 14px; font-weight: bold;');
    console.log('%c📊 Category: ' + '{{ $category->name }}' + ' (ID: {{ $category->id }})', 'color: #0284c7; font-size: 12px;');
    console.log('%c⚡ Features: Image preview • Animated stats • Ripple effects • Responsive design', 'color: #0ea5e9; font-size: 12px;');
    
    // Tooltip initialization (if Bootstrap JS available)
    if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }
</script>

<style>
    /* Additional styles */
    .bg-sky-100 { background: #e0f2fe; }
    .bg-green-100 { background: #dcfce7; }
    .bg-purple-100 { background: #f3e8ff; }
    .bg-orange-100 { background: #ffedd5; }
    .bg-gray-100 { background: #f1f5f9; }
    
    .text-sky-600 { color: #0ea5e9; }
    .text-green-600 { color: #10b981; }
    .text-purple-600 { color: #8b5cf6; }
    .text-orange-600 { color: #f59e0b; }
    .text-red-600 { color: #ef4444; }
    
    /* Table hover effect */
    .details-table tr {
        transition: all 0.2s ease;
    }
    
    /* Responsive font sizes */
    @media (max-width: 768px) {
        .details-table th,
        .details-table td {
            font-size: 0.85rem;
            padding: 0.75rem;
        }
        
        .stats-card h3 {
            font-size: 1.25rem;
        }
        
        .stats-card h6 {
            font-size: 0.85rem;
        }
    }
    
    /* Print styles */
    @media print {
        .btn-premium,
        .action-buttons,
        .breadcrumb-custom,
        .stats-card {
            display: none;
        }
        
        .category-card {
            box-shadow: none;
            border: 1px solid #ddd;
        }
        
        .details-table th,
        .details-table td {
            border: 1px solid #ddd;
        }
    }
</style>
@endsection