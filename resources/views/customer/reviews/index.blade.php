@extends('layouts.app')

@section('title', 'My Reviews - EktaMart')

@section('content')
<style>
    .review-card {
        background: white;
        border-radius: 1rem;
        padding: 1.2rem;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        transition: all 0.3s ease;
        border: 1px solid rgba(0,0,0,0.02);
    }
    .review-card:hover {
        box-shadow: 0 8px 30px rgba(0,0,0,0.1);
        transform: translateY(-2px);
    }
    .review-stars {
        color: #f59e0b;
        font-size: 0.9rem;
    }
    .review-stars .empty {
        color: #d1d5db;
    }
    .review-product-img {
        width: 60px;
        height: 60px;
        border-radius: 0.5rem;
        object-fit: cover;
        background: #f3f4f6;
    }
    .review-status-pending {
        color: #d97706;
        background: #fef3c7;
        padding: 0.15rem 0.6rem;
        border-radius: 2rem;
        font-size: 0.65rem;
        font-weight: 600;
    }
    .review-status-approved {
        color: #16a34a;
        background: #dcfce7;
        padding: 0.15rem 0.6rem;
        border-radius: 2rem;
        font-size: 0.65rem;
        font-weight: 600;
    }
</style>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">My Reviews</h2>
        <a href="{{ route('shop.index') }}" class="btn btn-outline-primary">
            <i class="fas fa-store"></i> Shop More
        </a>
    </div>

    @if(isset($reviews) && $reviews->count() > 0)
        <div class="row g-4">
            @foreach($reviews as $review)
            <div class="col-md-6 col-lg-4">
                <div class="review-card">
                    <div class="d-flex gap-3">
                        <div class="flex-shrink-0">
                            @if($review->product->thumbnail)
                                <img src="{{ asset('storage/products/' . $review->product->thumbnail) }}" 
                                     alt="{{ $review->product->name }}"
                                     class="review-product-img"
                                     onerror="this.src='https://placehold.co/60x60/8b5cf6/FFFFFF?text=Product'">
                            @else
                                <img src="https://placehold.co/60x60/8b5cf6/FFFFFF?text=P" 
                                     class="review-product-img">
                            @endif
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="fw-bold mb-0">{{ $review->product->name }}</h6>
                            <div class="review-stars">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= $review->rating ? '' : 'empty' }}"></i>
                                @endfor
                            </div>
                            <small class="text-muted">{{ $review->formatted_date }}</small>
                        </div>
                        <div>
                            @if($review->is_approved)
                                <span class="review-status-approved">✓ Approved</span>
                            @else
                                <span class="review-status-pending">⏳ Pending</span>
                            @endif
                        </div>
                    </div>

                    @if($review->title)
                        <h6 class="mt-2 mb-1">{{ $review->title }}</h6>
                    @endif
                    <p class="text-muted small mb-2">{{ Str::limit($review->comment, 100) }}</p>

                    @if($review->images && count($review->images) > 0)
                        <div class="d-flex gap-1 mb-2">
                            @foreach(array_slice($review->images, 0, 3) as $image)
                                <img src="{{ asset('storage/' . $image) }}" 
                                     style="width: 40px; height: 40px; object-fit: cover; border-radius: 0.3rem;">
                            @endforeach
                            @if(count($review->images) > 3)
                                <span class="badge bg-light text-muted">+{{ count($review->images) - 3 }}</span>
                            @endif
                        </div>
                    @endif

                    <div class="d-flex gap-2 mt-2">
                        @if($review->is_approved)
                            <a href="{{ route('product.show', $review->product->slug) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-eye"></i> View
                            </a>
                        @endif
                        <button onclick="editReview({{ $review->id }})" class="btn btn-sm btn-outline-warning">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button onclick="deleteReview({{ $review->id }})" class="btn btn-sm btn-outline-danger">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-4 d-flex justify-content-center">
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
            } else {
                alert(data.message || 'Failed to delete');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Something went wrong!');
        });
    }
</script>

<style>
    .btn-primary-premium {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
        padding: 0.6rem 1.8rem;
        border-radius: 0.75rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .btn-primary-premium:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        color: white;
    }
</style>
@endsection