@extends('layouts.admin')

@section('title', 'Categories - EktaMart Admin')
@section('page-title', 'Categories')
@section('icon', 'tags')

@section('content')
<div class="container-fluid">
    
    {{-- ============================================================
         MODERN STATS CARDS - GLASSMORPHISM
    ============================================================ --}}
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="glass-card glass-card-purple">
                <div class="glass-card-content">
                    <div class="glass-icon">
                        <i class="fas fa-layer-group"></i>
                    </div>
                    <div class="glass-info">
                        <span class="glass-label">Total Categories</span>
                        <h3 class="glass-value">{{ $categories->total() }}</h3>
                    </div>
                </div>
                <div class="glass-footer">
                    <span><i class="far fa-calendar-alt me-1"></i> All Categories</span>
                    <span class="glass-trend up">+{{ $categories->total() > 0 ? round(($categories->where('status', 1)->count() / $categories->total()) * 100) : 0 }}%</span>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="glass-card glass-card-green">
                <div class="glass-card-content">
                    <div class="glass-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="glass-info">
                        <span class="glass-label">Active</span>
                        <h3 class="glass-value">{{ $categories->where('status', 1)->count() }}</h3>
                    </div>
                </div>
                <div class="glass-footer">
                    <span><i class="fas fa-circle text-success me-1"></i> Active</span>
                    <span class="glass-trend up">{{ $categories->total() > 0 ? round(($categories->where('status', 1)->count() / $categories->total()) * 100) : 0 }}%</span>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="glass-card glass-card-red">
                <div class="glass-card-content">
                    <div class="glass-icon">
                        <i class="fas fa-ban"></i>
                    </div>
                    <div class="glass-info">
                        <span class="glass-label">Inactive</span>
                        <h3 class="glass-value">{{ $categories->where('status', 0)->count() }}</h3>
                    </div>
                </div>
                <div class="glass-footer">
                    <span><i class="fas fa-circle text-danger me-1"></i> Inactive</span>
                    <span class="glass-trend down">-{{ $categories->total() > 0 ? round(($categories->where('status', 0)->count() / $categories->total()) * 100) : 0 }}%</span>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="glass-card glass-card-orange">
                <div class="glass-card-content">
                    <div class="glass-icon">
                        <i class="fas fa-image"></i>
                    </div>
                    <div class="glass-info">
                        <span class="glass-label">With Images</span>
                        <h3 class="glass-value">{{ $categories->whereNotNull('icon')->count() }}</h3>
                    </div>
                </div>
                <div class="glass-footer">
                    <span><i class="fas fa-image me-1"></i> With Icons</span>
                    <span class="glass-trend up">{{ $categories->total() > 0 ? round(($categories->whereNotNull('icon')->count() / $categories->total()) * 100) : 0 }}%</span>
                </div>
            </div>
        </div>
    </div>

    {{-- ============================================================
         MAIN CARD - MODERN
    ============================================================ --}}
    <div class="modern-card">
        <div class="modern-card-header">
            <div class="modern-card-title">
                <i class="fas fa-tags"></i>
                <span>Category Management</span>
                <span class="modern-badge">{{ $categories->total() }} Total</span>
            </div>
            <a href="{{ route('admin.categories.create') }}" class="modern-btn-primary">
                <i class="fas fa-plus"></i> Add Category
            </a>
        </div>

        <div class="modern-card-body">
            
            {{-- Success Alert --}}
            @if(session('success'))
                <div class="modern-alert modern-alert-success">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ session('success') }}</span>
                    <button type="button" class="modern-alert-close" onclick="this.parentElement.remove()">&times;</button>
                </div>
            @endif

            {{-- Search & Filter --}}
            <div class="modern-toolbar">
                <div class="modern-search">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" placeholder="Search categories..." class="modern-search-input">
                </div>
                <div class="modern-filters">
                    <select id="statusFilter" class="modern-select">
                        <option value="all">All Status</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                    <button id="resetFilter" class="modern-btn-outline">
                        <i class="fas fa-sync-alt"></i> Reset
                    </button>
                </div>
            </div>

            {{-- Table --}}
            <div class="modern-table-wrapper">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        @forelse($categories as $category)
                            <tr data-status="{{ $category->status }}" 
                                data-name="{{ strtolower($category->name) }}" 
                                data-slug="{{ strtolower($category->slug) }}">
                                <td><span class="modern-id">#{{ $category->id }}</span></td>
                                <td>
    @if($category->icon && file_exists(public_path('storage/products/' . $category->icon)))
        <img src="{{ asset('storage/products/' . $category->icon) }}"
             class="modern-avatar"
             alt="{{ $category->name }}"
             onclick="previewImage(this.src, '{{ $category->name }}')"
             title="Click to preview"
             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
        <div class="modern-avatar-placeholder" style="display:none;">
            <i class="fas fa-image"></i>
        </div>
    @else
        <div class="modern-avatar-placeholder">
            <i class="fas fa-image"></i>
        </div>
    @endif
</td>
                                <td><span class="modern-name">{{ $category->name }}</span></td>
                                <td><span class="modern-slug">{{ $category->slug }}</span></td>
                                <td>
                                    @if($category->status)
                                        <span class="modern-status modern-status-active">
                                            <span class="modern-status-dot"></span> Active
                                        </span>
                                    @else
                                        <span class="modern-status modern-status-inactive">
                                            <span class="modern-status-dot"></span> Inactive
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="modern-actions">
                                        <a href="{{ route('admin.categories.show', $category->id) }}" 
                                           class="modern-action modern-action-view" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.categories.edit', $category->id) }}" 
                                           class="modern-action modern-action-edit" title="Edit">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <form action="{{ route('admin.categories.destroy', $category->id) }}" 
                                              method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="modern-action modern-action-delete" title="Delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="modern-empty">
                                        <div class="modern-empty-icon">
                                            <i class="fas fa-folder-open"></i>
                                        </div>
                                        <h5>No Categories Found</h5>
                                        <p>Start by creating your first category</p>
                                        <a href="{{ route('categories.create') }}" class="modern-btn-primary mt-3">
                                            <i class="fas fa-plus"></i> Create Category
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($categories->hasPages())
                <div class="modern-pagination">
                    {{ $categories->links() }}
                </div>
            @endif
        </div>
    </div>

</div>

{{-- Image Preview Modal --}}
<div class="modern-modal" id="imagePreviewModal">
    <div class="modern-modal-overlay" onclick="closeModal()"></div>
    <div class="modern-modal-content">
        <div class="modern-modal-header">
            <h6 id="previewTitle">Image Preview</h6>
            <button type="button" class="modern-modal-close" onclick="closeModal()">&times;</button>
        </div>
        <div class="modern-modal-body">
            <img id="previewImage" src="" alt="Preview" class="modern-preview-image">
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* ============================================================
   GLASS CARDS
============================================================ */
.glass-card {
    background: var(--bg-card);
    border-radius: 16px;
    border: 1px solid var(--border-color);
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: var(--shadow-sm);
    height: 100%;
    backdrop-filter: blur(10px);
}
.glass-card:hover {
    transform: translateY(-6px);
    box-shadow: var(--shadow-lg);
}

.glass-card-content {
    padding: 18px 20px 12px 20px;
    display: flex;
    align-items: flex-start;
    gap: 14px;
}

.glass-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
}

.glass-info {
    flex: 1;
}
.glass-label {
    font-size: 12px;
    font-weight: 500;
    color: var(--text-muted);
    display: block;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.glass-value {
    font-size: 24px;
    font-weight: 700;
    color: var(--text-primary);
    margin: 2px 0 0 0;
    line-height: 1.2;
}

.glass-footer {
    padding: 10px 20px 14px 20px;
    border-top: 1px solid var(--border-color);
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 12px;
    color: var(--text-muted);
}

.glass-trend {
    padding: 2px 10px;
    border-radius: 20px;
    font-weight: 600;
    font-size: 11px;
}
.glass-trend.up {
    background: #dcfce7;
    color: #16a34a;
}
.glass-trend.down {
    background: #fee2e2;
    color: #dc2626;
}

/* Glass Card Colors */
.glass-card-purple .glass-icon {
    background: rgba(139, 92, 246, 0.12);
    color: #8B5CF6;
}
.glass-card-purple .glass-footer {
    color: #8B5CF6;
}

.glass-card-green .glass-icon {
    background: rgba(16, 185, 129, 0.12);
    color: #10B981;
}
.glass-card-green .glass-footer {
    color: #10B981;
}

.glass-card-red .glass-icon {
    background: rgba(239, 68, 68, 0.12);
    color: #EF4444;
}
.glass-card-red .glass-footer {
    color: #EF4444;
}

.glass-card-orange .glass-icon {
    background: rgba(245, 158, 11, 0.12);
    color: #F59E0B;
}
.glass-card-orange .glass-footer {
    color: #F59E0B;
}

/* ============================================================
   MODERN CARD
============================================================ */
.modern-card {
    background: var(--bg-card);
    border-radius: 16px;
    border: 1px solid var(--border-color);
    box-shadow: var(--shadow-sm);
    overflow: hidden;
}
.modern-card:hover {
    box-shadow: var(--shadow-md);
}

.modern-card-header {
    padding: 16px 24px;
    border-bottom: 1px solid var(--border-color);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
}

.modern-card-title {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 16px;
    font-weight: 600;
    color: var(--text-primary);
}
.modern-card-title i {
    color: var(--primary);
}

.modern-badge {
    background: rgba(139, 92, 246, 0.1);
    color: var(--primary);
    padding: 2px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.modern-card-body {
    padding: 20px 24px;
}

/* ============================================================
   BUTTONS
============================================================ */
.modern-btn-primary {
    background: linear-gradient(135deg, #8B5CF6, #6366F1);
    color: #fff;
    border: none;
    padding: 8px 20px;
    border-radius: 10px;
    font-weight: 600;
    font-size: 13px;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
    transition: all 0.3s ease;
}
.modern-btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(139, 92, 246, 0.3);
    color: #fff;
}

.modern-btn-outline {
    background: transparent;
    color: var(--text-secondary);
    border: 1px solid var(--border-color);
    padding: 8px 16px;
    border-radius: 10px;
    font-weight: 500;
    font-size: 13px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    cursor: pointer;
    transition: all 0.3s ease;
}
.modern-btn-outline:hover {
    background: var(--bg-body);
    border-color: var(--primary);
    color: var(--primary);
}

/* ============================================================
   TOOLBAR
============================================================ */
.modern-toolbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
    margin-bottom: 16px;
}

.modern-search {
    position: relative;
    flex: 1;
    max-width: 320px;
}
.modern-search i {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-muted);
}
.modern-search-input {
    width: 100%;
    padding: 10px 14px 10px 42px;
    border: 2px solid var(--border-color);
    border-radius: 12px;
    background: var(--bg-body);
    color: var(--text-primary);
    font-size: 14px;
    transition: all 0.3s ease;
}
.modern-search-input:focus {
    outline: none;
    border-color: #8B5CF6;
    box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.08);
}
.modern-search-input::placeholder {
    color: var(--text-muted);
}

.modern-filters {
    display: flex;
    align-items: center;
    gap: 8px;
}

.modern-select {
    padding: 10px 16px;
    border: 2px solid var(--border-color);
    border-radius: 12px;
    background: var(--bg-body);
    color: var(--text-primary);
    font-size: 14px;
    cursor: pointer;
    transition: all 0.3s ease;
    appearance: none;
}
.modern-select:focus {
    outline: none;
    border-color: #8B5CF6;
}

/* ============================================================
   TABLE
============================================================ */
.modern-table-wrapper {
    overflow-x: auto;
    margin: 0 -4px;
}

.modern-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
}
.modern-table thead th {
    background: var(--bg-body);
    color: var(--text-muted);
    font-weight: 600;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 12px 16px;
    border-bottom: 2px solid var(--border-color);
}
.modern-table tbody td {
    padding: 12px 16px;
    border-bottom: 1px solid var(--border-color);
    color: var(--text-primary);
    vertical-align: middle;
}
.modern-table tbody tr {
    transition: all 0.2s ease;
}
.modern-table tbody tr:hover {
    background: rgba(139, 92, 246, 0.02);
}
.modern-table tbody tr:last-child td {
    border-bottom: none;
}

.modern-id {
    font-weight: 700;
    color: var(--primary);
}

.modern-name {
    font-weight: 500;
}

.modern-slug {
    background: var(--bg-body);
    padding: 2px 10px;
    border-radius: 6px;
    font-size: 12px;
    color: var(--text-muted);
    font-family: monospace;
}

/* ============================================================
   AVATAR
============================================================ */
.modern-avatar {
    width: 42px;
    height: 42px;
    border-radius: 10px;
    object-fit: cover;
    cursor: pointer;
    transition: all 0.3s ease;
    border: 2px solid var(--border-color);
}
.modern-avatar:hover {
    transform: scale(1.15);
    border-color: #8B5CF6;
    box-shadow: 0 4px 15px rgba(139, 92, 246, 0.2);
}

.modern-avatar-placeholder {
    width: 42px;
    height: 42px;
    border-radius: 10px;
    background: var(--bg-body);
    border: 2px solid var(--border-color);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-muted);
}

/* ============================================================
   STATUS
============================================================ */
.modern-status {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 4px 14px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}
.modern-status-dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    display: inline-block;
}
.modern-status-active {
    background: #dcfce7;
    color: #16a34a;
}
.modern-status-active .modern-status-dot {
    background: #16a34a;
}
.modern-status-inactive {
    background: #fee2e2;
    color: #dc2626;
}
.modern-status-inactive .modern-status-dot {
    background: #dc2626;
}

/* ============================================================
   ACTIONS
============================================================ */
.modern-actions {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 4px;
}

.modern-action {
    width: 34px;
    height: 34px;
    border-radius: 8px;
    border: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
    font-size: 14px;
}
.modern-action:hover {
    transform: translateY(-2px) scale(1.05);
}

.modern-action-view {
    background: rgba(59, 130, 246, 0.1);
    color: #3B82F6;
}
.modern-action-view:hover {
    background: #3B82F6;
    color: #fff;
}

.modern-action-edit {
    background: rgba(245, 158, 11, 0.1);
    color: #F59E0B;
}
.modern-action-edit:hover {
    background: #F59E0B;
    color: #fff;
}

.modern-action-delete {
    background: rgba(239, 68, 68, 0.1);
    color: #EF4444;
}
.modern-action-delete:hover {
    background: #EF4444;
    color: #fff;
}

/* ============================================================
   ALERT
============================================================ */
.modern-alert {
    padding: 14px 18px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 16px;
    animation: slideDown 0.3s ease;
}
.modern-alert-success {
    background: #dcfce7;
    color: #16a34a;
    border-left: 4px solid #16a34a;
}
.modern-alert-close {
    margin-left: auto;
    background: none;
    border: none;
    font-size: 20px;
    cursor: pointer;
    opacity: 0.5;
    transition: opacity 0.2s;
    color: inherit;
}
.modern-alert-close:hover {
    opacity: 1;
}

/* ============================================================
   EMPTY STATE
============================================================ */
.modern-empty {
    text-align: center;
    padding: 50px 20px;
}
.modern-empty-icon {
    font-size: 56px;
    color: var(--text-muted);
    opacity: 0.2;
    margin-bottom: 16px;
}
.modern-empty h5 {
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 4px;
}
.modern-empty p {
    color: var(--text-muted);
}

/* ============================================================
   PAGINATION
============================================================ */
.modern-pagination {
    margin-top: 16px;
}
.modern-pagination .pagination {
    justify-content: flex-end;
    margin: 0;
}

/* ============================================================
   MODAL
============================================================ */
.modern-modal {
    display: none;
    position: fixed;
    inset: 0;
    z-index: 9999;
}
.modern-modal.show {
    display: block;
}
.modern-modal-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(8px);
}
.modern-modal-content {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: var(--bg-card);
    border-radius: 16px;
    max-width: 500px;
    width: 90%;
    overflow: hidden;
    animation: modalIn 0.3s ease;
}
@keyframes modalIn {
    from { opacity: 0; transform: translate(-50%, -50%) scale(0.9); }
    to { opacity: 1; transform: translate(-50%, -50%) scale(1); }
}
.modern-modal-header {
    padding: 16px 20px;
    border-bottom: 1px solid var(--border-color);
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.modern-modal-header h6 {
    margin: 0;
    font-weight: 600;
}
.modern-modal-close {
    background: none;
    border: none;
    font-size: 24px;
    cursor: pointer;
    opacity: 0.5;
    transition: opacity 0.2s;
}
.modern-modal-close:hover {
    opacity: 1;
}
.modern-modal-body {
    padding: 20px;
    text-align: center;
}
.modern-preview-image {
    max-width: 100%;
    max-height: 70vh;
    border-radius: 8px;
}

/* ============================================================
   ANIMATIONS
============================================================ */
@keyframes slideDown {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* ============================================================
   RESPONSIVE
============================================================ */
@media (max-width: 768px) {
    .modern-toolbar {
        flex-direction: column;
        align-items: stretch;
    }
    .modern-search {
        max-width: 100%;
    }
    .modern-filters {
        flex-wrap: wrap;
    }
    .modern-filters .modern-select,
    .modern-filters .modern-btn-outline {
        flex: 1;
    }
    .modern-card-header {
        flex-direction: column;
        align-items: stretch;
    }
    .modern-card-header .modern-btn-primary {
        justify-content: center;
    }
    .modern-card-body {
        padding: 12px 16px;
    }
    .glass-card-content {
        padding: 14px 16px 8px 16px;
        gap: 10px;
    }
    .glass-icon {
        width: 40px;
        height: 40px;
        font-size: 16px;
    }
    .glass-value {
        font-size: 20px;
    }
    .glass-footer {
        padding: 8px 16px 10px 16px;
        font-size: 11px;
    }
}

@media (max-width: 576px) {
    .modern-table thead th,
    .modern-table tbody td {
        padding: 6px 8px;
        font-size: 12px;
    }
    .modern-avatar,
    .modern-avatar-placeholder {
        width: 32px;
        height: 32px;
    }
    .modern-action {
        width: 28px;
        height: 28px;
        font-size: 11px;
    }
    .modern-status {
        font-size: 10px;
        padding: 2px 10px;
    }
    .glass-card-content {
        padding: 10px 12px 6px 12px;
        gap: 8px;
    }
    .glass-icon {
        width: 34px;
        height: 34px;
        font-size: 14px;
    }
    .glass-value {
        font-size: 18px;
    }
    .glass-label {
        font-size: 10px;
    }
    .glass-footer {
        padding: 6px 12px 8px 12px;
        font-size: 10px;
    }
}

/* ============================================================
   DARK MODE
============================================================ */
[data-theme="dark"] .glass-card {
    background: #1A1A3E;
    border-color: rgba(255, 255, 255, 0.06);
}
[data-theme="dark"] .glass-card .glass-value {
    color: #f1f5f9;
}
[data-theme="dark"] .modern-card {
    background: #1A1A3E;
    border-color: rgba(255, 255, 255, 0.06);
}
[data-theme="dark"] .modern-table thead th {
    background: rgba(255, 255, 255, 0.03);
    color: #7F77DD;
}
[data-theme="dark"] .modern-table tbody td {
    border-color: rgba(255, 255, 255, 0.04);
    color: #e2e0f0;
}
[data-theme="dark"] .modern-card-title {
    color: #e2e0f0;
}
[data-theme="dark"] .modern-search-input {
    background: rgba(255, 255, 255, 0.04);
    border-color: rgba(255, 255, 255, 0.08);
    color: #e2e0f0;
}
[data-theme="dark"] .modern-select {
    background: rgba(255, 255, 255, 0.04);
    border-color: rgba(255, 255, 255, 0.08);
    color: #e2e0f0;
}
[data-theme="dark"] .modern-slug {
    background: rgba(255, 255, 255, 0.04);
    color: #7F77DD;
}
[data-theme="dark"] .modern-avatar-placeholder {
    background: rgba(255, 255, 255, 0.04);
    border-color: rgba(255, 255, 255, 0.08);
}
[data-theme="dark"] .glass-footer {
    border-top-color: rgba(255, 255, 255, 0.04);
}
[data-theme="dark"] .modern-card-header {
    border-bottom-color: rgba(255, 255, 255, 0.04);
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ============================================================
    // SEARCH & FILTER
    // ============================================================
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const resetFilter = document.getElementById('resetFilter');
    const tableRows = document.querySelectorAll('#tableBody tr');

    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        const statusValue = statusFilter.value;

        tableRows.forEach(row => {
            if (row.querySelector('td[colspan]')) return;

            const name = row.getAttribute('data-name') || '';
            const slug = row.getAttribute('data-slug') || '';
            const rowStatus = row.getAttribute('data-status');

            const matchesSearch = name.includes(searchTerm) || slug.includes(searchTerm);
            const matchesStatus = statusValue === 'all' || rowStatus === statusValue;

            row.style.display = (matchesSearch && matchesStatus) ? '' : 'none';
        });
    }

    searchInput.addEventListener('input', filterTable);
    statusFilter.addEventListener('change', filterTable);

    resetFilter.addEventListener('click', function() {
        searchInput.value = '';
        statusFilter.value = 'all';
        filterTable();
    });

    // ============================================================
    // IMAGE PREVIEW
    // ============================================================
    window.previewImage = function(src, name) {
        const modal = document.getElementById('imagePreviewModal');
        document.getElementById('previewImage').src = src;
        document.getElementById('previewTitle').textContent = 'Preview: ' + name;
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';
    };

    window.closeModal = function() {
        const modal = document.getElementById('imagePreviewModal');
        modal.classList.remove('show');
        document.body.style.overflow = '';
    };

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModal();
        }
    });

    // ============================================================
    // DELETE CONFIRMATION
    // ============================================================
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            if (confirm('⚠️ Are you sure you want to delete this category?\n\nThis action cannot be undone.')) {
                this.submit();
            }
        });
    });

    // ============================================================
    // AUTO HIDE ALERT
    // ============================================================
    const alert = document.querySelector('.modern-alert');
    if (alert) {
        setTimeout(() => {
            alert.style.transition = 'all 0.5s ease';
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(() => alert.remove(), 500);
        }, 5000);
    }

    // ============================================================
    // CONSOLE
    // ============================================================
    console.log('%c📁 Category Management (Modern) Loaded', 'color: #8B5CF6; font-size: 14px; font-weight: bold;');
    console.log('%c✨ Glassmorphism • Modern UI • Fully Responsive', 'color: #6366F1; font-size: 12px;');
});
</script>
@endpush