@extends('layouts.app')

@section('title', 'My Reviews - EktaMart')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-4">My Reviews</h2>

    @if($reviews->count() > 0)
        <div class="row g-4">
            @foreach($reviews as $review)
            <div class="col-md-6">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="fw-bold">{{ $review->product->name }}</h6>
                                <div class="text-warning">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $review->rating ? '' : 'empty' }}"></i>
                                    @endfor
                                </div>
                            </div>
                            @if($review->is_approved)
                                <span class="badge bg-success">✓ Approved</span>
                            @else
                                <span class="badge bg-warning">⏳ Pending</span>
                            @endif
                        </div>
                        @if($review->title)
                            <h6 class="mt-2">{{ $review->title }}</h6>
                        @endif
                        <p class="text-muted small">{{ $review->comment }}</p>
                        <small class="text-muted">{{ $review->created_at->format('M d, Y') }}</small>
                        <div class="mt-2">
                            <button onclick="editReview({{ $review->id }})" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button onclick="deleteReview({{ $review->id }})" class="btn btn-sm btn-outline-danger">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="mt-4">
            {{ $reviews->links() }}
        </div>
    @else
        <div class="text-center py-5">
            <i class="fas fa-star fa-4x text-muted mb-3 d-block"></i>
            <h5>No Reviews Yet</h5>
            <p class="text-muted">Start shopping and share your experience!</p>
            <a href="{{ route('shop.index') }}" class="btn btn-primary-premium">Start Shopping</a>
        </div>
    @endif
</div>

<style>
    .btn-primary-premium {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 0.75rem;
        color: white;
        transition: all 0.3s ease;
    }
    .btn-primary-premium:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        color: white;
    }
    .text-warning .empty {
        color: #d1d5db;
    }
</style>

<script>
    function editReview(id) {
        // Implement edit modal
        alert('Edit review feature coming soon!');
    }

    function deleteReview(id) {
        if (!confirm('Are you sure you want to delete this review?')) return;
        
        fetch(`/customer/reviews/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }
</script>
@endsection