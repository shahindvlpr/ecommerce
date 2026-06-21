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
                        <th class="ps-4" style="width: 50px;">
                            <input type="checkbox" class="form-check-input" id="selectAll">
                        </th>
                        <th style="min-width: 150px;">User</th>
                        <th style="min-width: 100px;">Action</th>
                        <th style="min-width: 120px;">Module</th>
                        <th>Description</th>
                        <th style="min-width: 120px;">IP Address</th>
                        <th style="min-width: 150px;">Time</th>
                        <th class="text-center" style="width: 100px;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($activities ?? [] as $activity)
                    <tr class="activity-row" 
                        data-id="{{ $activity->id }}"
                        data-module="{{ $activity->module ?? '' }}"
                        data-action="{{ $activity->action ?? '' }}"
                        data-status="{{ $activity->is_read ? 'read' : 'unread' }}">
                        <td class="ps-4">
                            <input type="checkbox" class="form-check-input row-checkbox" value="{{ $activity->id }}">
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar-sm bg-{{ $activity->color ?? 'primary' }} text-white rounded-circle d-flex align-items-center justify-content-center"
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
                            <span class="badge rounded-pill px-3 py-2 {{ $activity->badge_class ?? 'bg-primary bg-opacity-10 text-primary' }}">
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
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5">
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
{{-- STYLES --}}
{{-- ============================================================ --}}
@push('styles')
<style>
    .activity-row {
        transition: all 0.2s ease;
        cursor: pointer;
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
    .form-check-input {
        cursor: pointer;
    }
</style>
@endpush