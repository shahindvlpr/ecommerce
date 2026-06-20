@extends('layouts.admin')

@section('title', 'Notifications - EktaMart Admin')

@section('content')
<div class="container-fluid px-4 py-3">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">
                <i class="fas fa-bell text-primary me-2"></i>Notifications
            </h4>
            <p class="text-muted small">Manage your notifications</p>
        </div>
        <div class="d-flex gap-2">
            @if(isset($notifications) && $notifications->count() > 0)
                <form action="{{ route('admin.notifications.read-all') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-success btn-sm">
                        <i class="fas fa-check-double"></i> Mark All as Read
                    </button>
                </form>
                <form action="{{ route('admin.notifications.destroy-all') }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Delete all notifications?')">
                        <i class="fas fa-trash"></i> Delete All
                    </button>
                </form>
            @endif
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-0">
            @if(isset($notifications) && $notifications->count() > 0)
                <div class="list-group list-group-flush">
                    @foreach($notifications as $notification)
                    <div class="list-group-item d-flex gap-3 align-items-start py-3 {{ !$notification->is_read ? 'bg-light' : '' }}" 
                         id="notification-{{ $notification->id }}">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle p-2" style="background: {{ $notification->color ?? '#8b5cf6' }}20; color: {{ $notification->color ?? '#8b5cf6' }};">
                                <i class="{{ $notification->icon_class ?? 'fas fa-bell' }}"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0 fw-bold {{ !$notification->is_read ? 'text-primary' : '' }}">
                                        {{ $notification->title }}
                                    </h6>
                                    <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                </div>
                                <div class="d-flex gap-1">
                                    @if(!$notification->is_read)
                                        <form action="{{ route('admin.notifications.read', $notification->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-success" title="Mark as read">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                    @endif
                                    <form action="{{ route('admin.notifications.destroy', $notification->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Delete this notification?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <p class="mb-0 text-muted">{{ $notification->message }}</p>
                            @if($notification->link)
                                <a href="{{ $notification->link }}" class="btn btn-sm btn-outline-primary mt-2">
                                    View Details <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            @endif
                        </div>
                        @if(!$notification->is_read)
                            <div class="flex-shrink-0">
                                <span class="badge bg-danger rounded-pill">New</span>
                            </div>
                        @endif
                    </div>
                    @endforeach
                </div>
                <div class="card-footer bg-transparent">
                    {{ $notifications->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-bell fa-3x text-muted mb-3 d-block"></i>
                    <h5>No Notifications</h5>
                    <p class="text-muted">You're all caught up!</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection