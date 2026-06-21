@extends('layouts.admin')

@section('title', 'Invoice ' . $invoice->invoice_number)
@section('page-title', 'Invoice Details')
@section('icon', 'file-invoice')

@section('content')
<div class="container-fluid">
    
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <a href="{{ route('admin.invoices.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                        <i class="fas fa-arrow-left me-1"></i> Back to Invoices
                    </a>
                </div>
                <div class="d-flex gap-2">
                    <button onclick="window.print()" class="btn btn-info btn-sm rounded-pill px-3 text-white">
                        <i class="fas fa-print me-1"></i> Print
                    </button>
                    <form action="{{ route('admin.invoices.destroy', $invoice->id) }}" method="POST" class="d-inline delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm rounded-pill px-3">
                            <i class="fas fa-trash-alt me-1"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Invoice Card --}}
    <div class="card premium-card">
        <div class="card-body p-4">
            
            {{-- Header --}}
            <div class="row mb-4">
                <div class="col-6">
                    <h2 class="fw-bold mb-0">INVOICE</h2>
                    <p class="text-muted">#{{ $invoice->invoice_number }}</p>
                </div>
                <div class="col-6 text-end">
                    <div class="fw-bold">EktaMart</div>
                    <div class="text-muted small">123 Business Street</div>
                    <div class="text-muted small">Dhaka, Bangladesh</div>
                    <div class="text-muted small">Phone: +880 1234 567890</div>
                    <div class="text-muted small">Email: info@ektamart.com</div>
                </div>
            </div>

            {{-- Status --}}
            <div class="row mb-4">
                <div class="col-12">
                    <span class="badge bg-{{ $invoice->status_badge }} fs-6 px-3 py-2">
                        Status: {{ $invoice->status_label }}
                    </span>
                    @if($invoice->isOverdue())
                        <span class="badge bg-danger fs-6 px-3 py-2 ms-2">
                            <i class="fas fa-exclamation-triangle me-1"></i> Overdue
                        </span>
                    @endif
                </div>
            </div>

            {{-- Bill To & Ship To --}}
            <div class="row mb-4">
                <div class="col-md-6">
                    <h6 class="fw-bold">Bill To:</h6>
                    <p class="mb-1">{{ $invoice->user->name ?? 'N/A' }}</p>
                    <p class="mb-1">{{ $invoice->user->email ?? 'N/A' }}</p>
                    <p class="mb-0">{{ $invoice->billing_address ?? 'N/A' }}</p>
                </div>
                <div class="col-md-6">
                    <h6 class="fw-bold">Ship To:</h6>
                    <p class="mb-0">{{ $invoice->shipping_address ?? 'N/A' }}</p>
                </div>
            </div>

            {{-- Dates --}}
            <div class="row mb-4">
                <div class="col-md-4">
                    <span class="text-muted small">Invoice Date:</span>
                    <div class="fw-semibold">{{ $invoice->created_at->format('d M Y') }}</div>
                </div>
                <div class="col-md-4">
                    <span class="text-muted small">Due Date:</span>
                    <div class="fw-semibold {{ $invoice->isOverdue() ? 'text-danger' : '' }}">
                        {{ $invoice->due_date ? $invoice->due_date->format('d M Y') : 'N/A' }}
                    </div>
                </div>
                <div class="col-md-4">
                    <span class="text-muted small">Paid Date:</span>
                    <div class="fw-semibold">{{ $invoice->paid_date ? $invoice->paid_date->format('d M Y') : 'Not Paid Yet' }}</div>
                </div>
            </div>

            {{-- Items --}}
            <div class="table-responsive mb-4">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th class="text-end">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $items = $invoice->items ?? []; @endphp
                        @forelse($items as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item['name'] ?? $item['product_name'] ?? 'N/A' }}</td>
                                <td>{{ $item['quantity'] ?? 0 }}</td>
                                <td>${{ number_format($item['price'] ?? 0, 2) }}</td>
                                <td class="text-end">${{ number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 0), 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No items found</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="text-end fw-bold">Subtotal</td>
                            <td class="text-end">${{ number_format($invoice->subtotal, 2) }}</td>
                        </tr>
                        @if($invoice->tax > 0)
                        <tr>
                            <td colspan="4" class="text-end">Tax</td>
                            <td class="text-end">${{ number_format($invoice->tax, 2) }}</td>
                        </tr>
                        @endif
                        @if($invoice->shipping > 0)
                        <tr>
                            <td colspan="4" class="text-end">Shipping</td>
                            <td class="text-end">${{ number_format($invoice->shipping, 2) }}</td>
                        </tr>
                        @endif
                        @if($invoice->discount > 0)
                        <tr>
                            <td colspan="4" class="text-end text-danger">Discount</td>
                            <td class="text-end text-danger">-${{ number_format($invoice->discount, 2) }}</td>
                        </tr>
                        @endif
                        <tr class="table-active">
                            <td colspan="4" class="text-end fw-bold fs-5">Total</td>
                            <td class="text-end fw-bold fs-5 text-success">${{ number_format($invoice->total, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            {{-- Notes --}}
            @if($invoice->notes)
                <div class="row">
                    <div class="col-12">
                        <h6 class="fw-bold">Notes:</h6>
                        <p class="text-muted">{{ $invoice->notes }}</p>
                    </div>
                </div>
            @endif

            {{-- Update Status --}}
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3">Update Status</h6>
                            <form action="{{ route('admin.invoices.update', $invoice->id) }}" method="POST" class="row g-2">
                                @csrf
                                @method('PUT')
                                <div class="col-md-4">
                                    <select name="status" class="form-select">
                                        <option value="unpaid" {{ $invoice->status == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                                        <option value="paid" {{ $invoice->status == 'paid' ? 'selected' : '' }}>Paid</option>
                                        <option value="partial" {{ $invoice->status == 'partial' ? 'selected' : '' }}>Partial</option>
                                        <option value="refunded" {{ $invoice->status == 'refunded' ? 'selected' : '' }}>Refunded</option>
                                        <option value="cancelled" {{ $invoice->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <input type="date" name="due_date" class="form-control" value="{{ $invoice->due_date ? $invoice->due_date->format('Y-m-d') : '' }}">
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fas fa-save me-1"></i> Update Status
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection

@push('styles')
<style>
.premium-card {
    background: var(--bg-card);
    border-radius: 12px;
    border: 1px solid var(--border-color);
    box-shadow: var(--shadow-sm);
}
@media print {
    .btn, .delete-form, .card.bg-light {
        display: none !important;
    }
    .premium-card {
        box-shadow: none !important;
        border: 1px solid #ddd !important;
    }
}
</style>
@endpush