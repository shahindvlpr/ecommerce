@extends('layouts.admin')

@section('title', 'Banners - EktaMart Admin')
@section('page-title', 'Banners')
@section('icon', 'images')

@section('content')
<div class="container-fluid">
    
    {{-- Stats Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="stats-card stats-card-purple">
                <div class="stats-card-inner">
                    <div class="stats-icon"><i class="fas fa-images"></i></div>
                    <div class="stats-content">
                        <span class="stats-label">Total Banners</span>
                        <h3 class="stats-value">{{ \App\Models\Banner::count() }}</h3>
                    </div>
                </div>
                <div class="stats-footer">
                    <span><i class="far fa-calendar-alt me-1"></i> All Banners</span>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="stats-card stats-card-green">
                <div class="stats-card-inner">
                    <div class="stats-icon"><i class="fas fa-check-circle"></i></div>
                    <div class="stats-content">
                        <span class="stats-label">Active</span>
                        <h3 class="stats-value">{{ \App\Models\Banner::active()->count() }}</h3>
                    </div>
                </div>
                <div class="stats-footer">
                    <span><i class="fas fa-check-circle me-1"></i> Active</span>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="stats-card stats-card-red">
                <div class="stats-card-inner">
                    <div class="stats-icon"><i class="fas fa-clock"></i></div>
                    <div class="stats-content">
                        <span class="stats-label">Inactive</span>
                        <h3 class="stats-value">{{ \App\Models\Banner::where('status', false)->count() }}</h3>
                    </div>
                </div>
                <div class="stats-footer">
                    <span><i class="fas fa-clock me-1"></i> Inactive</span>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="stats-card stats-card-orange">
                <div class="stats-card-inner">
                    <div class="stats-icon"><i class="fas fa-calendar-alt"></i></div>
                    <div class="stats-content">
                        <span class="stats-label">Scheduled</span>
                        <h3 class="stats-value">{{ \App\Models\Banner::where('start_date', '>', now())->count() }}</h3>
                    </div>
                </div>
                <div class="stats-footer">
                    <span><i class="fas fa-calendar-alt me-1"></i> Upcoming</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Card --}}
    <div class="card premium-card">
        <div class="card-header-custom">
            <h5><i class="fas fa-images text-primary me-2"></i>Banners List</h5>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.banners.create') }}" class="btn btn-primary btn-sm rounded-pill px-3">
                    <i class="fas fa-plus me-1"></i> Add Banner
                </a>
            </div>
        </div>
        <div class="card-body-custom">
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table premium-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Position</th>
                            <th>Status</th>
                            <th>Valid</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($banners as $banner)
                            <tr>
                                <td>#{{ $banner->id }}</td>
                                <td>
                                    @if($banner->image)
                                        <img src="{{ asset('storage/' . $banner->image) }}" 
                                             class="banner-thumb" 
                                             alt="{{ $banner->title }}"
                                             onclick="previewImage(this.src, '{{ $banner->title }}')"
                                             title="Click to preview">
                                    @else
                                        <div class="banner-thumb-placeholder">
                                            <i class="fas fa-image"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-semibold">{{ $banner->title }}</div>
                                    @if($banner->subtitle)
                                        <small class="text-muted">{{ Str::limit($banner->subtitle, 30) }}</small>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ $banner->position ?? 'Home' }}</span>
                                </td>
                                <td>
                                    @if($banner->is_active)
                                        <span class="badge-status status-active">
                                            <span class="status-dot"></span> Active
                                        </span>
                                    @else
                                        <span class="badge-status status-inactive">
                                            <span class="status-dot"></span> Inactive
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($banner->start_date && $banner->end_date)
                                        <span class="small">
                                            {{ $banner->start_date->format('d M') }} - 
                                            {{ $banner->end_date->format('d M Y') }}
                                        </span>
                                    @elseif($banner->end_date)
                                        <span class="small">Until {{ $banner->end_date->format('d M Y') }}</span>
                                    @else
                                        <span class="text-muted">Always</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="action-group">
                                        <a href="{{ route('admin.banners.show', $banner) }}" 
                                           class="action-btn action-view" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.banners.edit', $banner) }}" 
                                           class="action-btn action-edit" title="Edit">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <form action="{{ route('admin.banners.toggle-status', $banner) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('POST')
                                            <button type="submit" class="action-btn action-status" title="Toggle Status">
                                                <i class="fas {{ $banner->status ? 'fa-pause' : 'fa-play' }}"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.banners.destroy', $banner) }}" 
                                              method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn action-delete" title="Delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">
                                    <div class="empty-state">
                                        <div class="empty-icon"><i class="fas fa-images"></i></div>
                                        <h6>No Banners Found</h6>
                                        <p class="text-muted">Start by creating your first banner.</p>
                                        <a href="{{ route('admin.banners.create') }}" class="btn btn-primary btn-sm rounded-pill px-3 mt-2">
                                            <i class="fas fa-plus me-1"></i> Add Banner
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($banners->hasPages())
                <div class="pagination-wrapper">
                    {{ $banners->links() }}
                </div>
            @endif
        </div>
    </div>

</div>

{{-- Image Preview Modal --}}
<div class="modal fade" id="imagePreviewModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title fw-bold" id="previewTitle">Image Preview</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="previewImage" src="" alt="Preview" style="max-width:100%;max-height:70vh;border-radius:8px;">
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Stats Cards */
.stats-card {
    background: var(--bg-card);
    border-radius: 12px;
    border: 1px solid var(--border-color);
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: var(--shadow-sm);
    height: 100%;
}
.stats-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-md);
}
.stats-card-inner {
    padding: 16px 20px 12px 20px;
    display: flex;
    align-items: flex-start;
    gap: 14px;
}
.stats-icon {
    width: 44px;
    height: 44px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    flex-shrink: 0;
}
.stats-content {
    flex: 1;
}
.stats-label {
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: var(--text-muted);
    display: block;
}
.stats-value {
    font-size: 22px;
    font-weight: 700;
    color: var(--text-primary);
    margin: 2px 0 4px 0;
    line-height: 1.2;
}
.stats-footer {
    padding: 8px 20px 14px 20px;
    border-top: 1px solid var(--border-color);
    font-size: 12px;
    color: var(--text-muted);
}
.stats-card-purple .stats-icon { background: rgba(139,92,246,0.12); color: #8B5CF6; }
.stats-card-green .stats-icon { background: rgba(16,185,129,0.12); color: #10B981; }
.stats-card-red .stats-icon { background: rgba(239,68,68,0.12); color: #EF4444; }
.stats-card-orange .stats-icon { background: rgba(245,158,11,0.12); color: #F59E0B; }

/* Premium Card */
.premium-card {
    background: var(--bg-card);
    border-radius: 12px;
    border: 1px solid var(--border-color);
    box-shadow: var(--shadow-sm);
    overflow: hidden;
}
.card-header-custom {
    padding: 14px 20px;
    border-bottom: 1px solid var(--border-color);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 8px;
}
.card-header-custom h5 {
    font-weight: 600;
    font-size: 14px;
    color: var(--text-primary);
    margin: 0;
}
.card-body-custom {
    padding: 20px;
}

/* Banner Thumb */
.banner-thumb {
    width: 60px;
    height: 45px;
    border-radius: 6px;
    object-fit: cover;
    cursor: pointer;
    transition: all 0.3s ease;
    border: 1px solid var(--border-color);
}
.banner-thumb:hover {
    transform: scale(1.1);
    border-color: var(--primary);
    box-shadow: 0 4px 15px rgba(139,92,246,0.2);
}
.banner-thumb-placeholder {
    width: 60px;
    height: 45px;
    border-radius: 6px;
    background: var(--bg-body);
    border: 1px solid var(--border-color);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-muted);
    font-size: 18px;
}

/* Status Badge */
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

/* Action Buttons */
.action-group {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 4px;
}
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
    background: rgba(59,130,246,0.1);
    color: #3B82F6;
}
.action-view:hover {
    background: #3B82F6;
    color: #fff;
}
.action-edit {
    background: rgba(245,158,11,0.1);
    color: #F59E0B;
}
.action-edit:hover {
    background: #F59E0B;
    color: #fff;
}
.action-delete {
    background: rgba(239,68,68,0.1);
    color: #EF4444;
}
.action-delete:hover {
    background: #EF4444;
    color: #fff;
}
.action-status {
    background: rgba(16,185,129,0.1);
    color: #10B981;
}
.action-status:hover {
    background: #10B981;
    color: #fff;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 50px 20px;
}
.empty-icon {
    font-size: 56px;
    color: var(--text-muted);
    opacity: 0.2;
    margin-bottom: 16px;
}
.empty-state h6 {
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 4px;
}
.empty-state p {
    color: var(--text-muted);
}

/* Pagination */
.pagination-wrapper {
    margin-top: 16px;
}
.pagination-wrapper .pagination {
    justify-content: flex-end;
    margin: 0;
}

/* Responsive */
@media (max-width: 768px) {
    .card-body-custom {
        padding: 12px;
    }
    .banner-thumb {
        width: 45px;
        height: 35px;
    }
    .banner-thumb-placeholder {
        width: 45px;
        height: 35px;
    }
}

/* Dark Mode */
[data-theme="dark"] .stats-card {
    background: #1A1A3E;
    border-color: rgba(255,255,255,0.06);
}
[data-theme="dark"] .stats-card .stats-value {
    color: #f1f5f9;
}
[data-theme="dark"] .premium-card {
    background: #1A1A3E;
    border-color: rgba(255,255,255,0.06);
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Image Preview
    window.previewImage = function(src, name) {
        const modal = new bootstrap.Modal(document.getElementById('imagePreviewModal'));
        document.getElementById('previewImage').src = src;
        document.getElementById('previewTitle').textContent = 'Preview: ' + name;
        modal.show();
    };

    // Delete confirmation
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            if (confirm('⚠️ Are you sure you want to delete this banner?\n\nThis action cannot be undone.')) {
                this.submit();
            }
        });
    });

    // Auto dismiss alert
    const alert = document.querySelector('.alert-success');
    if (alert) {
        setTimeout(() => {
            alert.style.transition = 'all 0.5s ease';
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(() => alert.remove(), 500);
        }, 5000);
    }

    console.log('%c🖼️ Banner Module Loaded', 'color: #8B5CF6; font-size: 13px; font-weight: bold;');
});
</script>
@endpush