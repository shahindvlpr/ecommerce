{{-- ============================================================ --}}
{{-- FILTERS SECTION --}}
{{-- ============================================================ --}}
<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body p-3">
        <form method="GET" id="filterForm" class="row g-3 align-items-end">
            {{-- Module Filter --}}
            <div class="col-md-2">
                <label class="form-label small fw-semibold text-muted">
                    <i class="fas fa-folder me-1"></i> Module
                </label>
                <select name="module" class="form-select form-select-sm border-0 bg-light rounded-3">
                    <option value="all">All Modules</option>
                    @foreach($modules ?? [] as $module)
                        <option value="{{ $module }}" {{ request('module') == $module ? 'selected' : '' }}>
                            {{ ucfirst($module) }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Action Filter --}}
            <div class="col-md-2">
                <label class="form-label small fw-semibold text-muted">
                    <i class="fas fa-bolt me-1"></i> Action
                </label>
                <select name="action" class="form-select form-select-sm border-0 bg-light rounded-3">
                    <option value="all">All Actions</option>
                    @foreach($actions ?? [] as $action)
                        <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                            {{ ucfirst($action) }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Date From --}}
            <div class="col-md-2">
                <label class="form-label small fw-semibold text-muted">
                    <i class="fas fa-calendar-alt me-1"></i> From
                </label>
                <input type="date" 
                       name="date_from" 
                       class="form-control form-control-sm border-0 bg-light rounded-3"
                       value="{{ request('date_from') }}">
            </div>

            {{-- Date To --}}
            <div class="col-md-2">
                <label class="form-label small fw-semibold text-muted">
                    <i class="fas fa-calendar-alt me-1"></i> To
                </label>
                <input type="date" 
                       name="date_to" 
                       class="form-control form-control-sm border-0 bg-light rounded-3"
                       value="{{ request('date_to') }}">
            </div>

            {{-- Status Filter --}}
            <div class="col-md-2">
                <label class="form-label small fw-semibold text-muted">
                    <i class="fas fa-circle me-1"></i> Status
                </label>
                <select name="status" class="form-select form-select-sm border-0 bg-light rounded-3">
                    <option value="all">All Status</option>
                    <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>Read</option>
                    <option value="unread" {{ request('status') == 'unread' ? 'selected' : '' }}>Unread</option>
                </select>
            </div>

            {{-- Action Buttons --}}
            <div class="col-md-2">
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary btn-sm w-100">
                        <i class="fas fa-filter me-1"></i> Filter
                    </button>
                    <a href="{{ route('admin.activity.index') }}" class="btn btn-outline-secondary btn-sm" title="Reset Filters">
                        <i class="fas fa-undo"></i>
                    </a>
                </div>
            </div>
        </form>

        {{-- Active Filters --}}
        @if(request()->has('module') || request()->has('action') || request()->has('date_from') || request()->has('date_to') || request()->has('status'))
            <div class="mt-2 pt-2 border-top d-flex flex-wrap gap-2">
                <small class="text-muted d-flex align-items-center">
                    <i class="fas fa-filter me-1"></i> Active Filters:
                </small>
                @if(request('module') && request('module') != 'all')
                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2">
                        <i class="fas fa-folder me-1"></i> {{ ucfirst(request('module')) }}
                        <a href="{{ route('admin.activity.index', array_merge(request()->except(['module']))) }}" 
                           class="text-decoration-none ms-1">
                            <i class="fas fa-times"></i>
                        </a>
                    </span>
                @endif
                @if(request('action') && request('action') != 'all')
                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2">
                        <i class="fas fa-bolt me-1"></i> {{ ucfirst(request('action')) }}
                        <a href="{{ route('admin.activity.index', array_merge(request()->except(['action']))) }}" 
                           class="text-decoration-none ms-1">
                            <i class="fas fa-times"></i>
                        </a>
                    </span>
                @endif
                @if(request('date_from'))
                    <span class="badge bg-info bg-opacity-10 text-info rounded-pill px-3 py-2">
                        <i class="fas fa-calendar-alt me-1"></i> From: {{ request('date_from') }}
                        <a href="{{ route('admin.activity.index', array_merge(request()->except(['date_from']))) }}" 
                           class="text-decoration-none ms-1">
                            <i class="fas fa-times"></i>
                        </a>
                    </span>
                @endif
                @if(request('date_to'))
                    <span class="badge bg-info bg-opacity-10 text-info rounded-pill px-3 py-2">
                        <i class="fas fa-calendar-alt me-1"></i> To: {{ request('date_to') }}
                        <a href="{{ route('admin.activity.index', array_merge(request()->except(['date_to']))) }}" 
                           class="text-decoration-none ms-1">
                            <i class="fas fa-times"></i>
                        </a>
                    </span>
                @endif
                @if(request('status') && request('status') != 'all')
                    <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3 py-2">
                        <i class="fas fa-circle me-1"></i> {{ ucfirst(request('status')) }}
                        <a href="{{ route('admin.activity.index', array_merge(request()->except(['status']))) }}" 
                           class="text-decoration-none ms-1">
                            <i class="fas fa-times"></i>
                        </a>
                    </span>
                @endif
            </div>
        @endif
    </div>
</div>

{{-- ============================================================ --}}
{{-- STYLES --}}
{{-- ============================================================ --}}
@push('styles')
<style>
    .form-select, .form-control {
        transition: all 0.2s ease;
    }
    .form-select:focus, .form-control:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        background: white;
    }
    .badge a {
        color: inherit;
        opacity: 0.6;
        transition: all 0.2s ease;
    }
    .badge a:hover {
        opacity: 1;
    }
</style>
@endpush