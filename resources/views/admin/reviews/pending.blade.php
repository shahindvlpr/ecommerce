@extends('layouts.admin')

@section('title', 'Pending Reviews - EktaMart Admin')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">
                <i class="fas fa-clock text-warning me-2"></i>Pending Reviews
            </h4>
            <p class="text-muted small">Reviews waiting for approval</p>
        </div>
        <a href="{{ route('admin.reviews.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Back to All Reviews
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-3">#</th>
                            <th>Rating</th>
                            <th>Product</th>
                            <th>Customer</th>
                            <th>Review</th>
                            <th>Date</th>
                            <th class="text-end pe-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reviews as $review)
                        <tr>
                            <td class="ps-3">{{ $loop->iteration }}</td>
                            <td>
                                <div class="text-warning" style="font-size: 0.85rem;">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $review->rating ? '' : 'empty' }}" 
                                           style="color: {{ $i <= $review->rating ? '#f59e0b' : '#d1d5db' }};"></i>
                                    @endfor
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="{{ $review->product->thumbnail_url ?? asset('images/default-product.png') }}" 
                                         alt="{{ $review->product->name ?? 'Product' }}" 
                                         style="width: 35px; height: 35px; object-fit: cover; border-radius: 8px;">
                                    <span>{{ Str::limit($review->product->name ?? 'N/A', 25) }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle bg-primary bg-opacity-10 p-1" style="width: 28px; height: 28px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-user text-primary fa-xs"></i>
                                    </div>
                                    {{ $review->user->name ?? 'Anonymous' }}
                                </div>
                            </td>
                            <td>
                                <div>
                                    <div class="fw-semibold">{{ Str::limit($review->title ?? '', 20) }}</div>
                                    <small class="text-muted">{{ Str::limit($review->comment, 30) }}</small>
                                </div>
                            </td>
                            <td>
                                <small>{{ $review->created_at->format('d M Y') }}</small>
                            </td>
                            <td class="text-end pe-3">
                                <div class="d-flex justify-content-end gap-1">
                                    <form action="{{ route('admin.reviews.approve', $review) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('POST')
                                        <button type="submit" class="btn btn-sm btn-outline-success" title="Approve" onclick="return confirm('Approve this review?')">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.reviews.reject', $review) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('POST')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Reject" onclick="return confirm('Reject this review?')">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-5">
                                <i class="fas fa-check-circle fa-3x text-success d-block mb-3"></i>
                                <h5>No Pending Reviews</h5>
                                <p class="text-muted">All reviews have been approved.</p>
                                <a href="{{ route('admin.reviews.index') }}" class="btn btn-primary mt-2">
                                    <i class="fas fa-arrow-left"></i> View All Reviews
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-transparent">
            {{ $reviews->links() }}
        </div>
    </div>
</div>

<script>
    console.log('%c⏳ Pending Reviews Page Loaded', 'color: #f59e0b; font-size: 13px; font-weight: bold;');
</script>

<style>
    .table > :not(caption) > * > * {
        padding: 0.6rem 0.6rem;
        vertical-align: middle;
    }
    .table tbody tr {
        transition: all 0.2s ease;
    }
    .table tbody tr:hover {
        background-color: #f8fafc;
    }
</style>
@endsection