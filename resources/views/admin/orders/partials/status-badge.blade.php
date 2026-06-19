@php
    $statusClass = match($status ?? 'pending') {
        'delivered' => 'badge-delivered',
        'paid' => 'badge-paid',
        'pending' => 'badge-pending',
        'shipped' => 'badge-shipped',
        'cancelled' => 'badge-cancelled',
        'processing' => 'badge-processing',
        default => 'badge-pending',
    };
@endphp

<span class="badge-status {{ $statusClass }}">
    {{ ucfirst($status ?? 'Pending') }}
</span>