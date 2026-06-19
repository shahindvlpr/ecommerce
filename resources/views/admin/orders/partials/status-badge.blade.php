@php
    $statusClass = match($status ?? 'pending') {
        'delivered' => 'bg-success',
        'shipped' => 'bg-info',
        'processing' => 'bg-warning',
        'cancelled' => 'bg-danger',
        default => 'bg-secondary',
    };
@endphp

<span class="badge {{ $statusClass }}">
    {{ ucfirst($status ?? 'Pending') }}
</span>