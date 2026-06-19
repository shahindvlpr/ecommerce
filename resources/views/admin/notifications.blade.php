@extends('layouts.admin')

@section('title', 'Notifications - EktaMart Admin')

@section('content')
<div class="container-fluid px-4">
    <h4 class="fw-bold mb-4">
        <i class="fas fa-bell text-primary me-2"></i>Notifications
    </h4>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">
            @php
                $notifications = [
                    (object)['id' => 1, 'title' => 'New Order #123', 'message' => 'A new order has been placed', 'time' => '2 minutes ago', 'read' => false],
                    (object)['id' => 2, 'title' => 'Product Low Stock', 'message' => 'iPhone 15 Pro is low on stock', 'time' => '1 hour ago', 'read' => false],
                    (object)['id' => 3, 'title' => 'New Review', 'message' => 'A customer left a new review', 'time' => '3 hours ago', 'read' => true],
                ];
            @endphp

            <div class="list-group list-group-flush">
                @foreach($notifications as $notif)
                <div class="list-group-item d-flex gap-3 align-items-start py-3 {{ !$notif->read ? 'bg-light' : '' }}">
                    <div class="flex-shrink-0">
                        <div class="rounded-circle bg-primary bg-opacity-10 p-2">
                            <i class="fas fa-bell text-primary"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0 fw-bold">{{ $notif->title }}</h6>
                            <small class="text-muted">{{ $notif->time }}</small>
                        </div>
                        <p class="mb-0 text-muted">{{ $notif->message }}</p>
                    </div>
                    @if(!$notif->read)
                        <button class="btn btn-sm btn-outline-primary">Mark as Read</button>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection