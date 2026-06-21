@extends('layouts.admin')

@section('title', 'Banner Details - EktaMart Admin')
@section('page-title', 'Banner Details')
@section('icon', 'images')

@section('content')
<div class="container-fluid">
    
    {{-- Back Button --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <a href="{{ route('admin.banners.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                        <i class="fas fa-arrow-left me-1"></i> Back to Banners
                    </a>
                </div>
                <div>
                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2">
                        <i class="fas fa-images me-1"></i> Banner Details
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- Left Column - Banner Info --}}
        <div class="col-xl-4 col-lg-5">
            <div class="detail-card">
                <div class="detail-card-header">
                    <h5><i class="fas fa-info-circle text-primary me-2"></i>Banner Information</h5>
                </div>
                <div class="detail-card-body">
                    <div class="detail-info-item">
                        <span class="detail-info-label">ID</span>
                        <span class="detail-info-value fw-bold text-primary">#{{ $banner->id }}</span>
                    </div>
                    <div class="detail-info-item">
                        <span class="detail-info-label">Title</span>
                        <span class="detail-info-value">{{ $banner->title }}</span>
                    </div>
                    <div class="detail-info-item">
                        <span class="detail-info-label">Subtitle</span>
                        <span class="detail-info-value">{{ $banner->subtitle ?? 'N/A' }}</span>
                    </div>
                    <div class="detail-info-item">
                        <span class="detail-info-label">Status</span>
                        <span class="detail-info-value">
                            @if($banner->is_active)
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
                    <div class="detail-info-item">
                        <span class="detail-info-label">Position</span>
                        <span class="detail-info-value">{{ $banner->position ?? 'Home' }}</span>
                    </div>
                    <div class="detail-info-item">
                        <span class="detail-info-label">Type</span>
                        <span class="detail-info-value">{{ $banner->type ?? 'Banner' }}</span>
                    </div>
                    <div class="detail-info-item">
                        <span class="detail-info-label">Display Order</span>
                        <span class="detail-info-value">{{ $banner->order ?? 0 }}</span>
                    </div>
                    <div class="detail-info-item">
                        <span class="detail-info-label">URL</span>
                        <span class="detail-info-value">
                            @if($banner->url)
                                <a href="{{ $banner->url }}" target="_blank" class="text-primary">
                                    {{ Str::limit($banner->url, 30) }}
                                    <i class="fas fa-external-link-alt ms-1"></i>
                                </a>
                            @else
                                <span class="text-muted">No URL</span>
                            @endif
                        </span>
                    </div>
                    <div class="detail-info-item">
                        <span class="detail-info-label">Button Text</span>
                        <span class="detail-info-value">{{ $banner->button_text ?? 'N/A' }}</span>
                    </div>
                    @if($banner->button_url)
                    <div class="detail-info-item">
                        <span class="detail-info-label">Button URL</span>
                        <span class="detail-info-value">
                            <a href="{{ $banner->button_url }}" target="_blank" class="text-primary">
                                {{ Str::limit($banner->button_url, 30) }}
                                <i class="fas fa-external-link-alt ms-1"></i>
                            </a>
                        </span>
                    </div>
                    @endif
                    <div class="detail-info-item">
                        <span class="detail-info-label">Valid From</span>
                        <span class="detail-info-value">
                            @if($banner->start_date)
                                {{ $banner->start_date->format('d M Y') }}
                            @else
                                <span class="text-muted">Immediate</span>
                            @endif
                        </span>
                    </div>
                    <div class="detail-info-item">
                        <span class="detail-info-label">Valid Until</span>
                        <span class="detail-info-value">
                            @if($banner->end_date)
                                <span class="{{ $banner->end_date->isPast() ? 'text-danger' : '' }}">
                                    {{ $banner->end_date->format('d M Y') }}
                                    @if($banner->end_date->isPast())
                                        <span class="badge bg-danger ms-1">Expired</span>
                                    @endif
                                </span>
                            @else
                                <span class="text-muted">Never</span>
                            @endif
                        </span>
                    </div>
                    <div class="detail-info-item">
                        <span class="detail-info-label">Created</span>
                        <span class="detail-info-value">{{ $banner->created_at->format('d M Y, h:i A') }}</span>
                    </div>
                    <div class="detail-info-item">
                        <span class="detail-info-label">Last Updated</span>
                        <span class="detail-info-value">{{ $banner->updated_at->diffForHumans() }}</span>
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
                        <a href="{{ route('admin.banners.edit', $banner) }}" 
                           class="btn btn-warning btn-sm rounded-pill">
                            <i class="fas fa-edit me-1"></i> Edit Banner
                        </a>
                        <form action="{{ route('admin.banners.toggle-status', $banner) }}" method="POST">
                            @csrf
                            @method('POST')
                            <button type="submit" class="btn {{ $banner->status ? 'btn-danger' : 'btn-success' }} btn-sm rounded-pill w-100">
                                <i class="fas {{ $banner->status ? 'fa-pause' : 'fa-play' }} me-1"></i>
                                {{ $banner->status ? 'Deactivate' : 'Activate' }}
                            </button>
                        </form>
                        <form action="{{ route('admin.banners.duplicate', $banner) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-info btn-sm rounded-pill w-100 text-white">
                                <i class="fas fa-copy me-1"></i> Duplicate Banner
                            </button>
                        </form>
                        <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm rounded-pill w-100">
                                <i class="fas fa-trash-alt me-1"></i> Delete Banner
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Column - Images Preview --}}
        <div class="col-xl-8 col-lg-7">
            {{-- Desktop Image --}}
            <div class="detail-card">
                <div class="detail-card-header">
                    <h5><i class="fas fa-desktop text-primary me-2"></i>Desktop Image</h5>
                    <span class="badge bg-secondary">{{ $banner->image ? 'Has Image' : 'No Image' }}</span>
                </div>
                <div class="detail-card-body text-center">
                    @if($banner->image)
                        <img src="{{ asset('storage/' . $banner->image) }}" 
                             alt="{{ $banner->title }}" 
                             class="banner-preview-image"
                             onclick="previewImage(this.src, '{{ $banner->title }} - Desktop')"
                             title="Click to preview">
                    @else
                        <div class="no-image-placeholder">
                            <i class="fas fa-image"></i>
                            <span>No desktop image available</span>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Mobile Image --}}
            <div class="detail-card mt-4">
                <div class="detail-card-header">
                    <h5><i class="fas fa-mobile-alt text-primary me-2"></i>Mobile Image</h5>
                    <span class="badge bg-secondary">{{ $banner->mobile_image ? 'Has Image' : 'No Image' }}</span>
                </div>
                <div class="detail-card-body text-center">
                    @if($banner->mobile_image)
                        <img src="{{ asset('storage/' . $banner->mobile_image) }}" 
                             alt="{{ $banner->title }}" 
                             class="banner-preview-image"
                             onclick="previewImage(this.src, '{{ $banner->title }} - Mobile')"
                             title="Click to preview">
                    @else
                        <div class="no-image-placeholder">
                            <i class="fas fa-image"></i>
                            <span>No mobile image available</span>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Banner Preview --}}
            <div class="detail-card mt-4">
                <div class="detail-card-header">
                    <h5><i class="fas fa-eye text-primary me-2"></i>Live Preview</h5>
                    <span class="badge bg-info text-white">Preview</span>
                </div>
                <div class="detail-card-body">
                    <div class="banner-preview-box">
                        @if($banner->image)
                            <img src="{{ asset('storage/' . $banner->image) }}" 
                                 alt="{{ $banner->title }}" 
                                 class="banner-preview-box-image">
                            <div class="banner-preview-overlay">
                                <h3>{{ $banner->title }}</h3>
                                @if($banner->subtitle)
                                    <p>{{ $banner->subtitle }}</p>
                                @endif
                                @if($banner->button_text)
                                    <span class="btn btn-primary btn-sm">{{ $banner->button_text }}</span>
                                @endif
                            </div>
                        @else
                            <div class="text-center py-5 text-muted">
                                <i class="fas fa-image fa-3x mb-3 d-block opacity-25"></i>
                                <p>Upload an image to see preview</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
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
.detail-card {
    background: var(--bg-card);
    border-radius: 12px;
    border: 1px solid var(--border-color);
    box-shadow: var(--shadow-sm);
    overflow: hidden;
    height: 100%;
}
.detail-card:hover {
    box-shadow: var(--shadow-md);
}
.detail-card-header {
    padding: 14px 20px;
    border-bottom: 1px solid var(--border-color);
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.detail-card-header h5 {
    font-weight: 600;
    font-size: 14px;
    color: var(--text-primary);
    margin: 0;
}
.detail-card-body {
    padding: 20px;
}

.detail-info-item {
    padding: 8px 0;
    border-bottom: 1px solid var(--border-color);
}
.detail-info-item:last-child {
    border-bottom: none;
}
.detail-info-label {
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    color: var(--text-muted);
    display: block;
    letter-spacing: 0.3px;
}
.detail-info-value {
    font-size: 14px;
    font-weight: 500;
    color: var(--text-primary);
    display: block;
    margin-top: 2px;
}

.badge-status {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 14px;
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

.banner-preview-image {
    max-width: 100%;
    max-height: 300px;
    border-radius: 8px;
    border: 1px solid var(--border-color);
    cursor: pointer;
    transition: all 0.3s ease;
}
.banner-preview-image:hover {
    transform: scale(1.02);
    border-color: var(--primary);
    box-shadow: 0 8px 30px rgba(139,92,246,0.15);
}

.no-image-placeholder {
    padding: 40px 20px;
    color: var(--text-muted);
}
.no-image-placeholder i {
    font-size: 48px;
    opacity: 0.2;
    display: block;
    margin-bottom: 8px;
}

.banner-preview-box {
    position: relative;
    border-radius: 8px;
    overflow: hidden;
    background: var(--bg-body);
    border: 1px solid var(--border-color);
}
.banner-preview-box-image {
    width: 100%;
    max-height: 300px;
    object-fit: cover;
}
.banner-preview-overlay {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
    color: #fff;
    text-shadow: 0 2px 10px rgba(0,0,0,0.3);
    pointer-events: none;
}
.banner-preview-overlay h3 {
    font-weight: 700;
    font-size: 28px;
    margin: 0;
}
.banner-preview-overlay p {
    font-size: 16px;
    opacity: 0.9;
    margin: 4px 0 0 0;
}
.banner-preview-overlay .btn {
    pointer-events: none;
    margin-top: 8px;
}

@media (max-width: 768px) {
    .banner-preview-overlay h3 {
        font-size: 18px;
    }
    .banner-preview-overlay p {
        font-size: 13px;
    }
    .banner-preview-image {
        max-height: 200px;
    }
}

/* Dark Mode */
[data-theme="dark"] .banner-preview-overlay {
    text-shadow: 0 2px 10px rgba(0,0,0,0.5);
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
            if (confirm('⚠️ Are you sure you want to delete this banner?\n\nThis action cannot be undone.')) {
                this.submit();
            }
        });
    });

    console.log('%c🖼️ Banner Details Page Loaded', 'color: #8B5CF6; font-size: 13px; font-weight: bold;');
});
</script>
@endpush