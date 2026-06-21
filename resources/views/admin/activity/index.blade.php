@extends('layouts.admin')

@section('title', 'Activity Log - EktaMart Admin')

@section('content')
<div class="container-fluid px-4">
    {{-- ============================================================ --}}
    {{-- PAGE HEADER --}}
    {{-- ============================================================ --}}
    <div class="d-flex flex-wrap flex-md-nowrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h4 class="fw-bold mb-1 d-flex align-items-center gap-2">
                <span class="bg-primary bg-opacity-10 p-2 rounded-3">
                    <i class="fas fa-clipboard-list text-primary"></i>
                </span>
                Activity Log
            </h4>
            <p class="text-muted small mb-0">Track all your activities and actions in real-time</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-success btn-sm px-3" onclick="exportActivities()">
                <i class="fas fa-file-export me-1"></i> Export
            </button>
            <button class="btn btn-danger btn-sm px-3" onclick="clearAll()">
                <i class="fas fa-trash me-1"></i> Clear All
            </button>
            <button class="btn btn-outline-secondary btn-sm px-3" onclick="window.location.reload()">
                <i class="fas fa-sync-alt me-1"></i> Refresh
            </button>
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- STATS CARDS --}}
    {{-- ============================================================ --}}
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 hover-card transition-all">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-primary bg-opacity-10 p-3 rounded-3">
                            <i class="fas fa-list text-primary fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted small mb-0">Total Activities</h6>
                            <h3 class="fw-bold mb-0 text-primary">{{ $activities->total() ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 hover-card transition-all">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-success bg-opacity-10 p-3 rounded-3">
                            <i class="fas fa-calendar-day text-success fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted small mb-0">Today</h6>
                            <h3 class="fw-bold mb-0 text-success">{{ $activities->where('created_at', '>=', now()->startOfDay())->count() ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 hover-card transition-all">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-warning bg-opacity-10 p-3 rounded-3">
                            <i class="fas fa-calendar-week text-warning fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted small mb-0">This Week</h6>
                            <h3 class="fw-bold mb-0 text-warning">{{ $activities->where('created_at', '>=', now()->startOfWeek())->count() ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 hover-card transition-all">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-danger bg-opacity-10 p-3 rounded-3">
                            <i class="fas fa-calendar-alt text-danger fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted small mb-0">This Month</h6>
                            <h3 class="fw-bold mb-0 text-danger">{{ $activities->where('created_at', '>=', now()->startOfMonth())->count() ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- FILTERS & SEARCH --}}
    {{-- ============================================================ --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-3">
            <div class="row g-3 align-items-center">
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" 
                               class="form-control border-start-0 bg-white" 
                               placeholder="Search activities..." 
                               id="searchInput">
                    </div>
                </div>
                <div class="col-md-2">
                    <select class="form-select bg-white" id="moduleFilter">
                        <option value="all">All Modules</option>
                        @foreach($modules ?? [] as $module)
                            <option value="{{ $module }}">{{ ucfirst($module) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select bg-white" id="actionFilter">
                        <option value="all">All Actions</option>
                        @foreach($actions ?? [] as $action)
                            <option value="{{ $action }}">{{ ucfirst($action) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select bg-white" id="statusFilter">
                        <option value="all">All Status</option>
                        <option value="read">Read</option>
                        <option value="unread">Unread</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <div class="d-flex gap-2">
                        <button class="btn btn-primary btn-sm flex-fill" onclick="applyFilters()">
                            <i class="fas fa-filter me-1"></i> Filter
                        </button>
                        <button class="btn btn-outline-secondary btn-sm" onclick="resetFilters()">
                            <i class="fas fa-undo"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- ACTIVITY TABLE --}}
    {{-- ============================================================ --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white border-0 py-3 px-4">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0">
                    <i class="fas fa-list-ul text-primary me-2"></i>Activity Logs
                </h6>
                <span class="badge bg-light text-dark px-3 py-2 rounded-pill">
                    <i class="fas fa-clock me-1"></i> {{ $activities->total() ?? 0 }} entries
                </span>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="activityTable">
                    <thead class="bg-light bg-opacity-50">
                        <tr>
                            <th class="ps-4" style="width: 50px;">#</th>
                            <th style="min-width: 150px;">User</th>
                            <th style="min-width: 100px;">Action</th>
                            <th style="min-width: 120px;">Module</th>
                            <th>Description</th>
                            <th style="min-width: 120px;">IP Address</th>
                            <th style="min-width: 150px;">Time</th>
                            <th class="text-center" style="width: 80px;">Status</th>
                            <th class="text-center" style="width: 120px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($activities ?? [] as $activity)
                        <tr class="activity-row {{ !$activity->is_read ? 'unread' : '' }}" 
                            data-id="{{ $activity->id }}"
                            data-module="{{ $activity->module ?? '' }}"
                            data-action="{{ $activity->action ?? '' }}"
                            data-status="{{ $activity->is_read ? 'read' : 'unread' }}">
                            <td class="ps-4 text-muted">{{ $loop->iteration }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                         style="width: 32px; height: 32px; font-size: 12px; font-weight: 600;">
                                        {{ strtoupper(substr($activity->user->name ?? 'U', 0, 2)) }}
                                    </div>
                                    <div>
                                        <span class="fw-semibold small">{{ $activity->user->name ?? 'Unknown' }}</span>
                                        <br>
                                        <small class="text-muted" style="font-size: 9px;">ID: {{ $activity->user_id }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @php
                                    $actionColors = [
                                        'login' => ['bg' => 'bg-success', 'text' => 'text-success'],
                                        'logout' => ['bg' => 'bg-danger', 'text' => 'text-danger'],
                                        'create' => ['bg' => 'bg-primary', 'text' => 'text-primary'],
                                        'update' => ['bg' => 'bg-warning', 'text' => 'text-warning'],
                                        'delete' => ['bg' => 'bg-danger', 'text' => 'text-danger'],
                                        'view' => ['bg' => 'bg-info', 'text' => 'text-info'],
                                        'export' => ['bg' => 'bg-success', 'text' => 'text-success'],
                                        'import' => ['bg' => 'bg-info', 'text' => 'text-info'],
                                        'order' => ['bg' => 'bg-primary', 'text' => 'text-primary'],
                                        'payment' => ['bg' => 'bg-pink', 'text' => 'text-pink'],
                                        'profile' => ['bg' => 'bg-primary', 'text' => 'text-primary'],
                                        'settings' => ['bg' => 'bg-secondary', 'text' => 'text-secondary'],
                                    ];
                                    $color = $actionColors[$activity->action] ?? ['bg' => 'bg-secondary', 'text' => 'text-secondary'];
                                @endphp
                                <span class="badge {{ $color['bg'] }} bg-opacity-10 {{ $color['text'] }} rounded-pill px-3 py-2">
                                    <i class="fas {{ $activity->icon ?? 'fa-circle' }} me-1"></i>
                                    {{ ucfirst($activity->action) }}
                                </span>
                            </td>
                            <td>
                                @if($activity->module)
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-3 py-2">
                                        <i class="fas fa-folder me-1"></i>
                                        {{ ucfirst($activity->module) }}
                                    </span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>
                                <span class="text-truncate d-block" style="max-width: 200px;" 
                                      title="{{ $activity->description ?? 'No description' }}">
                                    {{ $activity->description ?? '—' }}
                                </span>
                            </td>
                            <td>
                                <code class="small bg-light px-2 py-1 rounded-2">
                                    {{ $activity->ip_address ?? '—' }}
                                </code>
                            </td>
                            <td>
                                <div>
                                    <span class="fw-semibold small">{{ $activity->created_at->format('M d, Y') }}</span>
                                    <br>
                                    <small class="text-muted" style="font-size: 10px;">
                                        <i class="far fa-clock me-1"></i>{{ $activity->created_at->format('h:i:s A') }}
                                    </small>
                                    <br>
                                    <span class="text-muted" style="font-size: 9px;">
                                        <i class="far fa-calendar me-1"></i>{{ $activity->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            </td>
                            <td class="text-center">
                                @if($activity->is_read)
                                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2">
                                        <i class="fas fa-check-circle me-1"></i> Read
                                    </span>
                                @else
                                    <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-2">
                                        <i class="fas fa-circle me-1" style="font-size: 6px;"></i> Unread
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('admin.activity.show', $activity->id) }}" 
                                       class="btn btn-sm btn-outline-primary rounded-circle p-1" 
                                       style="width: 30px; height: 30px;"
                                       title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if(!$activity->is_read)
                                        <button onclick="markAsRead({{ $activity->id }})"
                                                class="btn btn-sm btn-outline-success rounded-circle p-1"
                                                style="width: 30px; height: 30px;"
                                                title="Mark as Read">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    @endif
                                    <button onclick="deleteActivity({{ $activity->id }})"
                                            class="btn btn-sm btn-outline-danger rounded-circle p-1"
                                            style="width: 30px; height: 30px;"
                                            title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-5">
                                <div class="py-4">
                                    <i class="fas fa-inbox fa-3x text-muted d-block mb-3"></i>
                                    <h5 class="text-muted">No Activities Found</h5>
                                    <p class="text-muted small">Start performing actions to see activity logs here</p>
                                    <button class="btn btn-primary btn-sm mt-2" onclick="window.location.reload()">
                                        <i class="fas fa-sync me-1"></i> Refresh
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if(isset($activities) && $activities->hasPages())
            <div class="card-footer bg-white border-0 py-3 px-4">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                    <span class="text-muted small">
                        Showing <strong>{{ $activities->firstItem() ?? 0 }}</strong> to <strong>{{ $activities->lastItem() ?? 0 }}</strong> of <strong>{{ $activities->total() }}</strong> entries
                    </span>
                    <div>
                        {{ $activities->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        @endif
    </div>

    {{-- ============================================================ --}}
    {{-- QUICK STATS (Bottom Section) --}}
    {{-- ============================================================ --}}
    <div class="row g-3 mt-3">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-info bg-opacity-10 p-3 rounded-3">
                            <i class="fas fa-user-check text-info fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted small mb-0">Most Active User</h6>
                            @php
                                $mostActive = $activities->groupBy('user_id')->sortByDesc(function($group) {
                                    return $group->count();
                                })->first();
                            @endphp
                            <p class="fw-semibold mb-0 text-info">
                                {{ $mostActive ? ($mostActive->first()->user->name ?? 'Unknown') : 'N/A' }}
                            </p>
                            <small class="text-muted">{{ $mostActive ? $mostActive->count() . ' activities' : 'No data' }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-warning bg-opacity-10 p-3 rounded-3">
                            <i class="fas fa-bolt text-warning fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted small mb-0">Most Common Action</h6>
                            @php
                                $mostAction = $activities->groupBy('action')->sortByDesc(function($group) {
                                    return $group->count();
                                })->first();
                            @endphp
                            <p class="fw-semibold mb-0 text-warning">
                                {{ $mostAction ? ucfirst($mostAction->first()->action) : 'N/A' }}
                            </p>
                            <small class="text-muted">{{ $mostAction ? $mostAction->count() . ' times' : 'No data' }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-secondary bg-opacity-10 p-3 rounded-3">
                            <i class="fas fa-folder text-secondary fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted small mb-0">Top Module</h6>
                            @php
                                $topModule = $activities->groupBy('module')->sortByDesc(function($group) {
                                    return $group->count();
                                })->first();
                            @endphp
                            <p class="fw-semibold mb-0 text-secondary">
                                {{ $topModule ? ucfirst($topModule->first()->module ?? 'N/A') : 'N/A' }}
                            </p>
                            <small class="text-muted">{{ $topModule ? $topModule->count() . ' activities' : 'No data' }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ============================================================ --}}
{{-- STYLES --}}
{{-- ============================================================ --}}
@push('styles')
<style>
    /* ============================================================ */
    /* CARD & TABLE STYLES */
    /* ============================================================ */
    .hover-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .hover-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 40px rgba(0,0,0,0.08) !important;
    }
    .transition-all {
        transition: all 0.3s ease;
    }
    .activity-row {
        transition: all 0.2s ease;
    }
    .activity-row:hover {
        background: #f8fafc !important;
        transform: translateX(2px);
    }
    .activity-row.unread {
        background: #f0f9ff;
    }
    .activity-row.unread:hover {
        background: #e0f2fe !important;
    }
    .activity-row.deleting {
        opacity: 0;
        transform: translateX(-50px);
        transition: all 0.3s ease;
    }

    /* ============================================================ */
    /* PAGINATION */
    /* ============================================================ */
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
        background: #0d6efd;
        color: white;
        box-shadow: 0 2px 8px rgba(13, 110, 253, 0.3);
    }
    .pagination .page-item.disabled .page-link {
        color: #d1d5db;
        background: transparent;
    }

    /* ============================================================ */
    /* FORM & TABLE */
    /* ============================================================ */
    .form-select:focus, .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.1);
    }
    .table > :not(caption) > * > * {
        padding: 0.75rem 0.5rem;
    }
    .badge {
        font-weight: 500;
    }
    .text-truncate {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .avatar-sm {
        font-weight: 600;
        flex-shrink: 0;
    }
    code {
        font-size: 11px;
        background: #f1f5f9;
        padding: 2px 8px;
        border-radius: 4px;
    }
    .btn-sm.rounded-circle {
        transition: all 0.2s ease;
    }
    .btn-sm.rounded-circle:hover {
        transform: scale(1.15);
    }
    .btn-primary {
        background: #0d6efd;
        border: none;
    }
    .btn-primary:hover {
        background: #0b5ed7;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(13, 110, 253, 0.3);
    }
    .btn-success {
        background: #198754;
        border: none;
    }
    .btn-success:hover {
        background: #157347;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(25, 135, 84, 0.3);
    }
    .btn-danger {
        background: #dc3545;
        border: none;
    }
    .btn-danger:hover {
        background: #bb2d3b;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
    }
    .bg-pink {
        background: #d63384 !important;
    }
    .text-pink {
        color: #d63384 !important;
    }
</style>
@endpush

{{-- ============================================================ --}}
{{-- SCRIPTS --}}
{{-- ============================================================ --}}
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ============================================================
        // SEARCH FUNCTIONALITY
        // ============================================================
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('keyup', function() {
                filterTable();
            });
        }

        // ============================================================
        // FILTER FUNCTION
        // ============================================================
        function filterTable() {
            const searchTerm = searchInput?.value.toLowerCase().trim() || '';
            const moduleFilter = document.getElementById('moduleFilter')?.value || 'all';
            const actionFilter = document.getElementById('actionFilter')?.value || 'all';
            const statusFilter = document.getElementById('statusFilter')?.value || 'all';
            
            const rows = document.querySelectorAll('#activityTable tbody tr:not(.empty-row)');
            let visibleCount = 0;
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                const module = row.dataset.module || '';
                const action = row.dataset.action || '';
                const status = row.dataset.status || '';
                
                let matchesSearch = !searchTerm || text.includes(searchTerm);
                let matchesModule = moduleFilter === 'all' || module === moduleFilter;
                let matchesAction = actionFilter === 'all' || action === actionFilter;
                let matchesStatus = statusFilter === 'all' || status === statusFilter;
                
                if (matchesSearch && matchesModule && matchesAction && matchesStatus) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });
            
            // Show/hide empty message
            const emptyRow = document.querySelector('#activityTable tbody tr td[colspan="9"]')?.closest('tr');
            if (emptyRow) {
                emptyRow.style.display = visibleCount === 0 ? '' : 'none';
            }
        }

        // ============================================================
        // APPLY FILTERS
        // ============================================================
        window.applyFilters = function() {
            filterTable();
        }

        // ============================================================
        // RESET FILTERS
        // ============================================================
        window.resetFilters = function() {
            if (searchInput) searchInput.value = '';
            document.getElementById('moduleFilter').value = 'all';
            document.getElementById('actionFilter').value = 'all';
            document.getElementById('statusFilter').value = 'all';
            filterTable();
        }

        // ============================================================
        // EXPORT ACTIVITIES
        // ============================================================
        window.exportActivities = function() {
            const params = new URLSearchParams(window.location.search);
            window.location.href = '{{ route("admin.activity.export") }}?' + params.toString();
        }

        // ============================================================
        // MARK AS READ
        // ============================================================
        window.markAsRead = function(id) {
            if (!id) {
                console.error('Invalid activity ID');
                return;
            }

            const url = `/admin/activity/${id}/mark-read`;
            
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const row = document.querySelector(`.activity-row[data-id="${id}"]`);
                    if (row) {
                        const statusCell = row.querySelector('td:nth-child(8)');
                        if (statusCell) {
                            statusCell.innerHTML = `
                                <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2">
                                    <i class="fas fa-check-circle me-1"></i> Read
                                </span>
                            `;
                        }
                        row.classList.remove('unread');
                        const markBtn = row.querySelector('.btn-outline-success');
                        if (markBtn) markBtn.style.display = 'none';
                        row.dataset.status = 'read';
                        
                        showToast('✅ Activity marked as read!', 'success');
                    }
                } else {
                    showToast('❌ Failed to mark as read.', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('❌ Failed to mark as read.', 'error');
            });
        }

        // ============================================================
        // DELETE ACTIVITY
        // ============================================================
        window.deleteActivity = function(id) {
            if (!id) {
                console.error('Invalid activity ID');
                return;
            }
            
            if (!confirm('Are you sure you want to delete this activity?')) {
                return;
            }
            
            const url = `/admin/activity/${id}`;
            
            fetch(url, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const row = document.querySelector(`.activity-row[data-id="${id}"]`);
                    if (row) {
                        row.classList.add('deleting');
                        setTimeout(() => {
                            row.remove();
                            const tbody = document.querySelector('#activityTable tbody');
                            if (tbody && tbody.querySelectorAll('.activity-row').length === 0) {
                                tbody.innerHTML = `
                                    <tr>
                                        <td colspan="9" class="text-center py-5">
                                            <div class="py-4">
                                                <i class="fas fa-inbox fa-3x text-muted d-block mb-3"></i>
                                                <h5 class="text-muted">No Activities Found</h5>
                                                <p class="text-muted small">Start performing actions to see activity logs here</p>
                                                <button class="btn btn-primary btn-sm mt-2" onclick="window.location.reload()">
                                                    <i class="fas fa-sync me-1"></i> Refresh
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                `;
                            }
                            updateCounters();
                        }, 300);
                    }
                    showToast('🗑️ Activity deleted successfully!', 'success');
                } else {
                    showToast('❌ Failed to delete activity.', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('❌ Failed to delete activity.', 'error');
            });
        }

        // ============================================================
        // CLEAR ALL
        // ============================================================
        window.clearAll = function() {
            if (!confirm('⚠️ Are you sure you want to clear all activity logs? This action cannot be undone.')) {
                return;
            }
            
            fetch('{{ route("admin.activity.clear") }}', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('🗑️ All activities cleared!', 'success');
                    setTimeout(() => {
                        window.location.reload();
                    }, 500);
                } else {
                    showToast('❌ Failed to clear activities.', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('❌ Failed to clear activities.', 'error');
            });
        }

        // ============================================================
        // TOAST NOTIFICATION
        // ============================================================
        function showToast(message, type = 'success') {
            const colors = {
                success: '#198754',
                error: '#dc3545',
                warning: '#ffc107',
                info: '#0dcaf0'
            };
            
            const toast = document.createElement('div');
            toast.style.cssText = `
                position: fixed;
                bottom: 30px;
                right: 30px;
                padding: 14px 24px;
                background: ${colors[type] || '#0d6efd'};
                color: white;
                border-radius: 12px;
                box-shadow: 0 8px 30px rgba(0,0,0,0.2);
                z-index: 99999;
                font-weight: 500;
                font-size: 14px;
                animation: slideIn 0.3s ease;
                max-width: 400px;
                border: none;
            `;
            toast.textContent = message;
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transition = 'opacity 0.3s ease';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        // ============================================================
        // UPDATE COUNTERS
        // ============================================================
        function updateCounters() {
            const rows = document.querySelectorAll('#activityTable tbody .activity-row');
            const total = rows.length;
            const headerBadge = document.querySelector('.card-header .badge');
            if (headerBadge) {
                headerBadge.innerHTML = `<i class="fas fa-clock me-1"></i> ${total} entries`;
            }
        }

        // ============================================================
        // CSS ANIMATION
        // ============================================================
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideIn {
                from {
                    opacity: 0;
                    transform: translateX(100px);
                }
                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }
        `;
        document.head.appendChild(style);

        // ============================================================
        // KEYBOARD SHORTCUTS
        // ============================================================
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === '/') {
                e.preventDefault();
                searchInput?.focus();
                searchInput?.select();
            }
            if (e.key === 'Escape' && document.activeElement === searchInput) {
                searchInput.value = '';
                filterTable();
                searchInput.blur();
            }
        });

        // ============================================================
        // CONSOLE DEBUG
        // ============================================================
        console.log('%c📊 Activity Log Page Loaded', 'color: #0d6efd; font-size: 14px; font-weight: bold;');
        console.log(`%c📝 Total Activities: {{ $activities->total() ?? 0 }}`, 'color: #6b7280; font-size: 12px;');
        console.log('💡 Tip: Press Ctrl+/ to search, Esc to clear');
    });
</script>
@endpush
@endsection