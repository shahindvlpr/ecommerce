@extends('layouts.admin')

@section('title', 'Activity Details - EktaMart Admin')

@section('content')
<div class="container-fluid px-4">
    {{-- ============================================================ --}}
    {{-- PAGE HEADER --}}
    {{-- ============================================================ --}}
    <div class="d-flex flex-wrap flex-md-nowrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h4 class="fw-bold mb-1 d-flex align-items-center gap-2">
                <span class="bg-indigo bg-opacity-10 p-2 rounded-3">
                    <i class="fas fa-info-circle text-indigo"></i>
                </span>
                Activity Details
            </h4>
            <p class="text-muted small mb-0">View detailed information about this activity</p>
        </div>
        <div>
            <a href="{{ route('admin.activity.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Back to List
            </a>
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- ACTIVITY DETAILS --}}
    {{-- ============================================================ --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <div class="row g-4">
                {{-- Left Column --}}
                <div class="col-md-6">
                    <h6 class="fw-semibold mb-3">
                        <i class="fas fa-user text-indigo me-2"></i>User Information
                    </h6>
                    <div class="d-flex align-items-center gap-3 p-3 bg-light rounded-3">
                        @if($activity->user->avatar)
                            <img src="{{ asset('storage/avatars/' . $activity->user->avatar) }}" 
                                 alt="{{ $activity->user->name }}" 
                                 style="width: 60px; height: 60px; object-fit: cover; border-radius: 50%;">
                        @else
                            <div class="bg-gradient-indigo text-white d-flex align-items-center justify-content-center rounded-circle" 
                                 style="width: 60px; height: 60px; font-size: 24px; font-weight: 600;">
                                {{ strtoupper(substr($activity->user->name ?? 'U', 0, 2)) }}
                            </div>
                        @endif
                        <div>
                            <h6 class="fw-bold mb-0">{{ $activity->user->name ?? 'Unknown' }}</h6>
                            <p class="text-muted small mb-0">{{ $activity->user->email ?? 'No email' }}</p>
                            <span class="badge bg-indigo bg-opacity-10 text-indigo px-3 py-1 rounded-pill">
                                <i class="fas fa-user-shield me-1"></i> {{ ucfirst($activity->user->role ?? 'User') }}
                            </span>
                        </div>
                    </div>

                    <hr>

                    <h6 class="fw-semibold mb-3">
                        <i class="fas fa-info text-indigo me-2"></i>Activity Information
                    </h6>
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tr>
                                <td class="fw-semibold" style="width: 120px;">Action</td>
                                <td>
                                    <span class="badge rounded-pill px-3 py-2 
                                        @if($activity->action == 'login') bg-emerald bg-opacity-10 text-emerald
                                        @elseif($activity->action == 'logout') bg-rose bg-opacity-10 text-rose
                                        @elseif($activity->action == 'create') bg-indigo bg-opacity-10 text-indigo
                                        @elseif($activity->action == 'update') bg-amber bg-opacity-10 text-amber
                                        @elseif($activity->action == 'delete') bg-rose bg-opacity-10 text-rose
                                        @elseif($activity->action == 'view') bg-sky bg-opacity-10 text-sky
                                        @else bg-gray bg-opacity-10 text-gray
                                        @endif">
                                        <i class="fas {{ $activity->icon ?? 'fa-circle' }} me-1"></i>
                                        {{ ucfirst($activity->action) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Module</td>
                                <td>
                                    @if($activity->module)
                                        <span class="badge bg-gray bg-opacity-10 text-gray rounded-pill px-3 py-2">
                                            <i class="fas fa-folder me-1"></i>
                                            {{ ucfirst($activity->module) }}
                                        </span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Description</td>
                                <td>{{ $activity->description ?? '—' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">IP Address</td>
                                <td><code>{{ $activity->ip_address ?? '—' }}</code></td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Status</td>
                                <td>
                                    @if($activity->is_read)
                                        <span class="badge bg-emerald bg-opacity-10 text-emerald rounded-pill px-3 py-2">
                                            <i class="fas fa-check-circle me-1"></i> Read
                                        </span>
                                    @else
                                        <span class="badge bg-rose bg-opacity-10 text-rose rounded-pill px-3 py-2">
                                            <i class="fas fa-circle me-1" style="font-size: 6px;"></i> Unread
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Date & Time</td>
                                <td>
                                    <div>
                                        <span class="fw-semibold">{{ $activity->created_at->format('F d, Y') }}</span>
                                        <br>
                                        <small class="text-muted">{{ $activity->created_at->format('h:i:s A') }}</small>
                                        <br>
                                        <small class="text-muted">({{ $activity->created_at->diffForHumans() }})</small>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                {{-- Right Column --}}
                <div class="col-md-6">
                    <h6 class="fw-semibold mb-3">
                        <i class="fas fa-database text-indigo me-2"></i>Additional Data
                    </h6>
                    <div class="p-3 bg-light rounded-3" style="min-height: 200px;">
                        @if($activity->data)
                            <pre class="mb-0" style="font-size: 12px; white-space: pre-wrap; word-break: break-all;">
                                {{ json_encode($activity->data, JSON_PRETTY_PRINT) }}
                            </pre>
                        @else
                            <p class="text-muted text-center py-4">
                                <i class="fas fa-database fa-2x d-block mb-2"></i>
                                No additional data available
                            </p>
                        @endif
                    </div>

                    <hr>

                    <h6 class="fw-semibold mb-3">
                        <i class="fas fa-timeline text-indigo me-2"></i>Timeline
                    </h6>
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker 
                                @if($activity->action == 'login') bg-emerald
                                @elseif($activity->action == 'logout') bg-rose
                                @elseif($activity->action == 'create') bg-indigo
                                @elseif($activity->action == 'update') bg-amber
                                @elseif($activity->action == 'delete') bg-rose
                                @elseif($activity->action == 'view') bg-sky
                                @else bg-gray
                                @endif">
                            </div>
                            <div class="timeline-content">
                                <p class="mb-0 fw-semibold">{{ ucfirst($activity->action) }} action performed</p>
                                <small class="text-muted">{{ $activity->created_at->format('F d, Y h:i A') }}</small>
                            </div>
                        </div>
                        @if($activity->is_read)
                            <div class="timeline-item">
                                <div class="timeline-marker bg-emerald"></div>
                                <div class="timeline-content">
                                    <p class="mb-0 fw-semibold">Marked as read</p>
                                    <small class="text-muted">{{ $activity->updated_at ?? $activity->created_at }}</small>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="d-flex gap-2 pt-3 mt-3 border-top">
                @if(!$activity->is_read)
                    <button class="btn btn-indigo btn-sm" onclick="markAsRead({{ $activity->id }})">
                        <i class="fas fa-check-circle me-1"></i> Mark as Read
                    </button>
                @endif
                <a href="{{ route('admin.activity.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-arrow-left me-1"></i> Back
                </a>
                <button class="btn btn-outline-rose btn-sm ms-auto" onclick="deleteActivity({{ $activity->id }})">
                    <i class="fas fa-trash me-1"></i> Delete
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ============================================================ --}}
{{-- STYLES --}}
{{-- ============================================================ --}}
@push('styles')
<style>
    .timeline {
        position: relative;
        padding-left: 30px;
    }
    .timeline::before {
        content: '';
        position: absolute;
        left: 8px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e5e7eb;
    }
    .timeline-item {
        position: relative;
        margin-bottom: 20px;
    }
    .timeline-item:last-child {
        margin-bottom: 0;
    }
    .timeline-marker {
        position: absolute;
        left: -26px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        border: 2px solid white;
        box-shadow: 0 0 0 3px #e5e7eb;
    }
    .timeline-content {
        padding: 0 0 0 10px;
    }
    pre {
        background: #f8fafc;
        border-radius: 8px;
        padding: 12px;
        margin: 0;
        max-height: 300px;
        overflow-y: auto;
    }
    .btn-outline-rose {
        color: #f43f5e;
        border-color: #f43f5e;
    }
    .btn-outline-rose:hover {
        background: #f43f5e;
        color: white;
    }
</style>
@endpush

{{-- ============================================================ --}}
{{-- SCRIPTS --}}
{{-- ============================================================ --}}
@push('scripts')
<script>
    function markAsRead(id) {
        fetch('{{ route("admin.activity.mark-read", "") }}/' + id, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to mark as read.');
        });
    }

    function deleteActivity(id) {
        if (!confirm('Are you sure you want to delete this activity?')) return;
        
        fetch('{{ route("admin.activity.destroy", "") }}/' + id, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = '{{ route("admin.activity.index") }}';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to delete activity.');
        });
    }

    console.log('%c📊 Activity Details Loaded', 'color: #4f46e5; font-size: 14px; font-weight: bold;');
</script>
@endpush
@endsection