@extends('layouts.admin')

@section('title', $category->name . ' - Category Details')
@section('page-title', 'Category Details')
@section('icon', 'tags')

@section('content')
<div class="container-fluid">
    
    {{-- ============================================================
         BACK BUTTON
    ============================================================ --}}
    <div class="row mb-4">
        <div class="col-12">
            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                <i class="fas fa-arrow-left me-1"></i> Back to Categories
            </a>
        </div>
    </div>

    {{-- ============================================================
         MAIN CARD
    ============================================================ --}}
    <div class="row g-4">
        {{-- Left Column - Image & Basic Info --}}
        <div class="col-xl-4 col-lg-5">
            <div class="detail-card">
                <div class="detail-card-header">
                    <h5><i class="fas fa-image text-primary me-2"></i>Category Image</h5>
                </div>
                <div class="detail-card-body text-center">
                    @php
                        $imagePath = null;
                        $imageFile = $category->icon ?? $category->image ?? null;
                        
                        if($imageFile) {
                            $possiblePaths = [
                                'storage/products/' . $imageFile,
                                'storage/' . $imageFile,
                                'products/' . $imageFile,
                            ];
                            
                            foreach($possiblePaths as $path) {
                                if(file_exists(public_path($path))) {
                                    $imagePath = asset($path);
                                    break;
                                }
                            }
                        }
                    @endphp
                    
                    @if($imagePath)
                        <img src="{{ $imagePath }}"
                             class="detail-image"
                             alt="{{ $category->name }}"
                             onclick="previewImage(this.src, '{{ $category->name }}')"
                             title="Click to enlarge"
                             id="categoryImage">
                        <div class="mt-2">
                            <button class="btn btn-sm btn-outline-primary rounded-pill px-3" onclick="document.getElementById('categoryImage').click()">
                                <i class="fas fa-expand me-1"></i> View Full Size
                            </button>
                        </div>
                    @else
                        <div class="detail-image-placeholder">
                            <i class="fas fa-image"></i>
                            <span>No Image Available</span>
                        </div>
                    @endif
                    
                    <div class="detail-meta mt-3">
                        <div class="row g-2">
                            <div class="col-6">
                                <div class="meta-item">
                                    <span class="meta-label">Category ID</span>
                                    <span class="meta-value">#{{ $category->id }}</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="meta-item">
                                    <span class="meta-label">Status</span>
                                    <span class="meta-value">
                                        @if($category->status)
                                            <span class="badge-status status-active">
                                                <span class="status-dot"></span> Active
                                            </span>
                                        @else
                                            <span class="badge-status status-inactive">
                                                <span class="status-dot"></span> Inactive
                                            </span>
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="detail-card mt-4">
                <div class="detail-card-header">
                    <h5><i class="fas fa-bolt text-warning me-2"></i>Quick Actions</h5>
                </div>
                <div class="detail-card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.categories.edit', $category->id) }}" 
                           class="btn btn-warning btn-sm rounded-pill">
                            <i class="fas fa-edit me-1"></i> Edit Category
                        </a>
                        <a href="{{ route('admin.products.index') }}?category={{ $category->id }}" 
                           class="btn btn-info btn-sm rounded-pill text-white">
                            <i class="fas fa-box me-1"></i> View Products
                        </a>
                        <form action="{{ route('admin.categories.destroy', $category->id) }}" 
                              method="POST" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm rounded-pill w-100">
                                <i class="fas fa-trash-alt me-1"></i> Delete Category
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Column - Details --}}
        <div class="col-xl-8 col-lg-7">
            <div class="detail-card">
                <div class="detail-card-header">
                    <h5><i class="fas fa-info-circle text-primary me-2"></i>Category Information</h5>
                </div>
                <div class="detail-card-body">
                    <div class="detail-info-grid">
                        {{-- Name --}}
                        <div class="detail-info-item">
                            <span class="detail-info-label">
                                <i class="fas fa-tag text-primary"></i> Name
                            </span>
                            <span class="detail-info-value">{{ $category->name }}</span>
                        </div>

                        {{-- Slug --}}
                        <div class="detail-info-item">
                            <span class="detail-info-label">
                                <i class="fas fa-link text-primary"></i> Slug
                            </span>
                            <span class="detail-info-value">
                                <code class="slug-code">{{ $category->slug }}</code>
                            </span>
                        </div>

                        {{-- Parent Category --}}
                        <div class="detail-info-item">
                            <span class="detail-info-label">
                                <i class="fas fa-sitemap text-primary"></i> Parent Category
                            </span>
                            <span class="detail-info-value">
                                @if($category->parent_id)
                                    @php
                                        $parent = \App\Models\Category::find($category->parent_id);
                                    @endphp
                                    @if($parent)
                                        <a href="{{ route('admin.categories.show', $parent->id) }}" class="text-primary">
                                            {{ $parent->name }}
                                        </a>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                @else
                                    <span class="text-muted">No Parent (Top Level)</span>
                                @endif
                            </span>
                        </div>

                        {{-- Order --}}
                        <div class="detail-info-item">
                            <span class="detail-info-label">
                                <i class="fas fa-sort-numeric-up text-primary"></i> Display Order
                            </span>
                            <span class="detail-info-value">
                                <span class="badge bg-secondary">{{ $category->order ?? 0 }}</span>
                            </span>
                        </div>

                        {{-- Products Count --}}
                        <div class="detail-info-item">
                            <span class="detail-info-label">
                                <i class="fas fa-box text-primary"></i> Products
                            </span>
                            <span class="detail-info-value">
                                <span class="badge bg-primary">{{ $category->products_count ?? $category->products()->count() }}</span>
                                <span class="text-muted ms-1">products in this category</span>
                            </span>
                        </div>

                        {{-- Created At --}}
                        <div class="detail-info-item">
                            <span class="detail-info-label">
                                <i class="fas fa-calendar-plus text-primary"></i> Created At
                            </span>
                            <span class="detail-info-value">
                                {{ $category->created_at->format('d M Y, h:i A') }}
                                <span class="text-muted ms-1">({{ $category->created_at->diffForHumans() }})</span>
                            </span>
                        </div>

                        {{-- Updated At --}}
                        <div class="detail-info-item">
                            <span class="detail-info-label">
                                <i class="fas fa-calendar-edit text-primary"></i> Last Updated
                            </span>
                            <span class="detail-info-value">
                                {{ $category->updated_at->format('d M Y, h:i A') }}
                                <span class="text-muted ms-1">({{ $category->updated_at->diffForHumans() }})</span>
                            </span>
                        </div>

                        {{-- Description --}}
                        @if($category->description)
                            <div class="detail-info-item detail-info-full">
                                <span class="detail-info-label">
                                    <i class="fas fa-align-left text-primary"></i> Description
                                </span>
                                <div class="detail-info-value description-text">
                                    {{ $category->description }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Subcategories (if any) --}}
            @php
                $subcategories = \App\Models\Category::where('parent_id', $category->id)->get();
            @endphp
            @if($subcategories->count() > 0)
                <div class="detail-card mt-4">
                    <div class="detail-card-header">
                        <h5><i class="fas fa-sitemap text-primary me-2"></i>Subcategories</h5>
                        <span class="badge bg-primary">{{ $subcategories->count() }}</span>
                    </div>
                    <div class="detail-card-body p-0">
                        <div class="table-responsive">
                            <table class="table detail-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Slug</th>
                                        <th>Products</th>
                                        <th>Status</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($subcategories as $sub)
                                        <tr>
                                            <td>#{{ $sub->id }}</td>
                                            <td>{{ $sub->name }}</td>
                                            <td><code class="slug-code">{{ $sub->slug }}</code></td>
                                            <td>{{ $sub->products_count ?? $sub->products()->count() }}</td>
                                            <td>
                                                @if($sub->status)
                                                    <span class="badge-status status-active">
                                                        <span class="status-dot"></span> Active
                                                    </span>
                                                @else
                                                    <span class="badge-status status-inactive">
                                                        <span class="status-dot"></span> Inactive
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('admin.categories.show', $sub->id) }}" 
                                                   class="action-btn action-view" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.categories.edit', $sub->id) }}" 
                                                   class="action-btn action-edit" title="Edit">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

</div>

{{-- Image Preview Modal --}}
<div class="modal fade" id="imagePreviewModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title fw-bold" id="previewTitle">Image Preview</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="previewImage" src="" alt="Preview" style="max-width:100%;max-height:80vh;border-radius:8px;">
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* ============================================================
   DETAIL CARD
============================================================ */
.detail-card {
    background: var(--bg-card);
    border-radius: 16px;
    border: 1px solid var(--border-color);
    box-shadow: var(--shadow-sm);
    overflow: hidden;
    height: 100%;
}
.detail-card:hover {
    box-shadow: var(--shadow-md);
}

.detail-card-header {
    padding: 16px 20px;
    border-bottom: 1px solid var(--border-color);
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.detail-card-header h5 {
    font-weight: 600;
    font-size: 15px;
    color: var(--text-primary);
    margin: 0;
}

.detail-card-body {
    padding: 20px;
}

/* ============================================================
   DETAIL IMAGE
============================================================ */
.detail-image {
    max-width: 100%;
    max-height: 300px;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.3s ease;
    border: 2px solid var(--border-color);
    object-fit: cover;
}
.detail-image:hover {
    transform: scale(1.02);
    border-color: var(--primary);
    box-shadow: 0 8px 30px rgba(139, 92, 246, 0.15);
}

.detail-image-placeholder {
    width: 100%;
    height: 200px;
    border-radius: 12px;
    background: var(--bg-body);
    border: 2px dashed var(--border-color);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: var(--text-muted);
}
.detail-image-placeholder i {
    font-size: 48px;
    opacity: 0.3;
    margin-bottom: 8px;
}
.detail-image-placeholder span {
    font-size: 14px;
}

/* ============================================================
   META ITEMS
============================================================ */
.detail-meta {
    border-top: 1px solid var(--border-color);
    padding-top: 16px;
    margin-top: 16px;
}

.meta-item {
    background: var(--bg-body);
    border-radius: 10px;
    padding: 10px 14px;
}
.meta-label {
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    color: var(--text-muted);
    display: block;
    letter-spacing: 0.3px;
}
.meta-value {
    font-size: 14px;
    font-weight: 600;
    color: var(--text-primary);
    margin-top: 2px;
    display: block;
}

/* ============================================================
   STATUS BADGE
============================================================ */
.badge-status {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}
.status-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    display: inline-block;
}
.status-active {
    background: #dcfce7;
    color: #16a34a;
}
.status-active .status-dot {
    background: #16a34a;
}
.status-inactive {
    background: #fee2e2;
    color: #dc2626;
}
.status-inactive .status-dot {
    background: #dc2626;
}

/* ============================================================
   DETAIL INFO GRID
============================================================ */
.detail-info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}

.detail-info-item {
    background: var(--bg-body);
    border-radius: 10px;
    padding: 12px 16px;
    transition: all 0.2s ease;
}
.detail-info-item:hover {
    background: rgba(139, 92, 246, 0.04);
}

.detail-info-full {
    grid-column: 1 / -1;
}

.detail-info-label {
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    color: var(--text-muted);
    display: flex;
    align-items: center;
    gap: 6px;
    letter-spacing: 0.3px;
    margin-bottom: 4px;
}
.detail-info-label i {
    font-size: 12px;
}

.detail-info-value {
    font-size: 14px;
    font-weight: 500;
    color: var(--text-primary);
    display: block;
}

.slug-code {
    background: var(--bg-body);
    padding: 2px 10px;
    border-radius: 4px;
    font-size: 13px;
    color: var(--text-muted);
    font-family: monospace;
}

.description-text {
    font-weight: 400;
    line-height: 1.6;
    color: var(--text-secondary);
    padding: 4px 0;
}

/* ============================================================
   DETAIL TABLE
============================================================ */
.detail-table {
    margin: 0;
    font-size: 13px;
}
.detail-table thead th {
    background: var(--bg-body);
    color: var(--text-muted);
    font-weight: 600;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.3px;
    padding: 10px 16px;
    border-bottom: 1px solid var(--border-color);
}
.detail-table tbody td {
    padding: 10px 16px;
    border-bottom: 1px solid var(--border-color);
    color: var(--text-primary);
    vertical-align: middle;
}
.detail-table tbody tr:hover {
    background: rgba(139, 92, 246, 0.02);
}
.detail-table tbody tr:last-child td {
    border-bottom: none;
}

/* ============================================================
   ACTION BUTTONS
============================================================ */
.action-btn {
    width: 32px;
    height: 32px;
    border-radius: 6px;
    border: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
    font-size: 13px;
}
.action-btn:hover {
    transform: translateY(-2px);
}

.action-view {
    background: rgba(59, 130, 246, 0.1);
    color: #3B82F6;
}
.action-view:hover {
    background: #3B82F6;
    color: #fff;
}

.action-edit {
    background: rgba(245, 158, 11, 0.1);
    color: #F59E0B;
}
.action-edit:hover {
    background: #F59E0B;
    color: #fff;
}

/* ============================================================
   RESPONSIVE
============================================================ */
@media (max-width: 768px) {
    .detail-info-grid {
        grid-template-columns: 1fr;
    }
    .detail-info-full {
        grid-column: 1;
    }
    .detail-card-body {
        padding: 16px;
    }
    .detail-image {
        max-height: 200px;
    }
    .detail-image-placeholder {
        height: 150px;
    }
    .meta-item {
        padding: 8px 12px;
    }
}

@media (max-width: 576px) {
    .detail-card-header {
        padding: 12px 16px;
    }
    .detail-card-body {
        padding: 12px;
    }
    .detail-info-item {
        padding: 10px 12px;
    }
    .detail-table {
        font-size: 12px;
    }
    .detail-table thead th,
    .detail-table tbody td {
        padding: 6px 10px;
    }
}

/* ============================================================
   DARK MODE
============================================================ */
[data-theme="dark"] .detail-card {
    background: #1A1A3E;
    border-color: rgba(255, 255, 255, 0.06);
}
[data-theme="dark"] .detail-card-header {
    border-bottom-color: rgba(255, 255, 255, 0.04);
}
[data-theme="dark"] .detail-info-item {
    background: rgba(255, 255, 255, 0.03);
}
[data-theme="dark"] .detail-info-value {
    color: #e2e0f0;
}
[data-theme="dark"] .detail-table thead th {
    background: rgba(255, 255, 255, 0.03);
    color: #7F77DD;
}
[data-theme="dark"] .detail-table tbody td {
    border-color: rgba(255, 255, 255, 0.04);
    color: #e2e0f0;
}
[data-theme="dark"] .meta-item {
    background: rgba(255, 255, 255, 0.03);
}
[data-theme="dark"] .meta-value {
    color: #e2e0f0;
}
[data-theme="dark"] .slug-code {
    background: rgba(255, 255, 255, 0.04);
    color: #7F77DD;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ============================================================
    // IMAGE PREVIEW
    // ============================================================
    window.previewImage = function(src, name) {
        const modal = new bootstrap.Modal(document.getElementById('imagePreviewModal'));
        document.getElementById('previewImage').src = src;
        document.getElementById('previewTitle').textContent = 'Preview: ' + name;
        modal.show();
    };

    // ============================================================
    // DELETE CONFIRMATION
    // ============================================================
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            if (confirm('⚠️ Are you sure you want to delete this category?\n\nThis action cannot be undone and will remove all associated products.')) {
                this.submit();
            }
        });
    });

    // ============================================================
    // CONSOLE
    // ============================================================
    console.log('%c📁 Category Details Page Loaded', 'color: #8B5CF6; font-size: 13px; font-weight: bold;');
});
</script>
@endpush