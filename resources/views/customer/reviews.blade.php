@extends('layouts.app')

@section('title', 'My Reviews - EktaMart')

@section('content')
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --shadow-sm: 0 2px 12px rgba(0, 0, 0, 0.06);
        --shadow-hover: 0 8px 30px rgba(0, 0, 0, 0.1);
        --radius: 1rem;
    }

    .page-wrapper {
        background: #f5f6fa;
        min-height: 100vh;
        padding: 1.5rem 0;
    }

    .review-card {
        background: white;
        border-radius: var(--radius);
        padding: 1rem 1.2rem;
        box-shadow: var(--shadow-sm);
        border: 1px solid rgba(0,0,0,0.02);
        transition: all 0.3s ease;
        margin-bottom: 0.8rem;
    }
    .review-card:hover {
        box-shadow: var(--shadow-hover);
        transform: translateY(-2px);
    }

    .review-product {
        font-weight: 700;
        font-size: 0.9rem;
    }
    .review-rating {
        color: #f59e0b;
        font-size: 0.8rem;
        letter-spacing: 1px;
    }
    .review-title {
        font-weight: 600;
        font-size: 0.85rem;
        margin: 0.2rem 0;
    }
    .review-comment {
        color: #4b5563;
        font-size: 0.8rem;
        margin-bottom: 0.2rem;
    }
    .review-date {
        color: #6b7280;
        font-size: 0.7rem;
    }

    .review-status {
        padding: 0.15rem 0.6rem;
        border-radius: 2rem;
        font-size: 0.6rem;
        font-weight: 600;
        display: inline-block;
    }
    .review-status.approved { background: #dcfce7; color: #16a34a; }
    .review-status.pending { background: #fef3c7; color: #d97706; }

    .review-actions .btn-sm {
        padding: 0.15rem 0.6rem;
        font-size: 0.65rem;
        border-radius: 0.4rem;
        border: none;
        font-weight: 500;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }
    .review-actions .btn-edit {
        background: #dbeafe;
        color: #2563eb;
    }
    .review-actions .btn-edit:hover {
        background: #2563eb;
        color: white;
    }
    .review-actions .btn-delete {
        background: #fee2e2;
        color: #dc2626;
    }
    .review-actions .btn-delete:hover {
        background: #dc2626;
        color: white;
    }
</style>

<div class="page-wrapper">
    <div class="container">
        <h5 style="font-weight: 700; font-size: 1.1rem; margin-bottom: 1rem;">
            <i class="fas fa-star" style="color: #f59e0b;"></i> My Reviews
        </h5>

        @if(isset($reviews) && $reviews->count() > 0)
            @foreach($reviews as $review)
            <div class="review-card">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-1">
                    <div>
                        <div class="review-product">{{ $review->product->name ?? 'Product' }}</div>
                        <div class="review-rating">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= $review->rating ? '' : 'text-muted' }}"></i>
                            @endfor
                            <span class="text-muted ms-1" style="font-size: 0.7rem;">({{ $review->rating }})</span>
                        </div>
                        @if($review->title)
                            <div class="review-title">{{ $review->title }}</div>
                        @endif
                        <div class="review-comment">{{ $review->comment }}</div>
                        <div class="review-date">
                            <i class="far fa-calendar-alt me-1"></i>
                            {{ $review->created_at->format('M d, Y') }}
                        </div>
                    </div>
                    <div class="text-end">
                        <span class="review-status {{ $review->is_approved ? 'approved' : 'pending' }}">
                            {{ $review->is_approved ? 'Approved' : 'Pending' }}
                        </span>
                        <div class="review-actions mt-1">
                            @if(!$review->is_approved)
                                <span class="text-muted" style="font-size: 0.65rem;">
                                    <i class="fas fa-clock me-1"></i> Awaiting approval
                                </span>
                            @endif
                            <form method="POST" action="{{ route('customer.reviews.destroy', $review->id) }}" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-sm btn-delete" onclick="return confirm('Delete this review?')">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            <div class="mt-3">
                {{ $reviews->links() }}
            </div>
        @else
            <div class="text-center py-4" style="background: white; border-radius: var(--radius); box-shadow: var(--shadow-sm);">
                <div style="width: 50px; height: 50px; background: #f3f4f6; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 0.6rem;">
                    <i class="fas fa-star fa-2x" style="color: #9ca3af;"></i>
                </div>
                <h6 style="color: #4b5563; font-weight: 600; font-size: 0.9rem;">No reviews yet</h6>
                <p style="color: #6b7280; font-size: 0.8rem;">Share your experience with products you've purchased</p>
                <a href="{{ route('shop.index') }}" class="btn" style="background: var(--primary-gradient); color: white; border: none; border-radius: 0.6rem; padding: 0.4rem 1.2rem; font-size: 0.8rem;">
                    <i class="fas fa-shopping-cart me-1"></i> Start Shopping
                </a>
            </div>
        @endif
    </div>
</div>
@endsection