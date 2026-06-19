@extends('layouts.admin')

@section('title', 'Reviews - EktaMart Admin')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">
                <i class="fas fa-star text-primary me-2"></i>Reviews
            </h4>
            <p class="text-muted small">Manage all product reviews</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-secondary btn-sm" onclick="window.location.reload()">
                <i class="fas fa-sync-alt"></i>
            </button>
            <a href="{{ route('admin.reviews.pending') }}" class="btn btn-warning">
                <i class="fas fa-clock"></i> Pending Reviews
                @php $pendingCount = \App\Models\Review::where('is_approved', 0)->count(); @endphp
                @if($pendingCount > 0)
                    <span class="badge bg-danger ms-1">{{ $pendingCount }}</span>
                @endif
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Stats Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body text-center">
                    <h6 class="text-muted small">Total Reviews</h6>
                    <h5 class="fw-bold">{{ \App\Models\Review::count() }}</h5>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body text-center">
                    <h6 class="text-muted small">Approved</h6>
                    <h5 class="fw-bold text-success">{{ \App\Models\Review::where('is_approved', 1)->count() }}</h5>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body text-center">
                    <h6 class="text-muted small">Pending</h6>
                    <h5 class="fw-bold text-warning">{{ \App\Models\Review::where('is_approved', 0)->count() }}</h5>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body text-center">
                    <h6 class="text-muted small">Average Rating</h6>
                    <h5 class="fw-bold text-primary">
                        @php
                            $avgRating = \App\Models\Review::where('is_approved', 1)->avg('rating') ?? 0;
                        @endphp
                        {{ number_format($avgRating, 1) }} ⭐
                    </h5>
                </div>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <ul class="nav nav-pills mb-4 gap-2 flex-wrap">
        <li class="nav-item">
            <a href="{{ route('admin.reviews.index') }}" 
               class="nav-link {{ !request()->routeIs('admin.reviews.pending') ? 'active' : '' }}">
                All Reviews
                <span class="badge bg-light text-dark ms-1">{{ \App\Models\Review::count() }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.reviews.pending') }}" 
               class="nav-link {{ request()->routeIs('admin.reviews.pending') ? 'active' : '' }}">
                Pending
                <span class="badge bg-warning text-dark ms-1">{{ \App\Models\Review::where('is_approved', 0)->count() }}</span>
            </a>
        </li>
    </ul>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="reviewTable">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-3" style="width: 60px;">#</th>
                            <th style="width: 80px;">Rating</th>
                            <th>Product</th>
                            <th>Customer</th>
                            <th>Review</th>
                            <th style="width: 120px;">Status</th>
                            <th style="width: 120px;">Date</th>
                            <th class="text-end pe-3" style="width: 150px;">Actions</th>
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
                                @if($review->is_approved)
                                    <span class="badge bg-success">Approved</span>
                                @else
                                    <span class="badge bg-warning">Pending</span>
                                @endif
                                @if($review->is_verified)
                                    <span class="badge bg-info" title="Verified Purchase">✓ Verified</span>
                                @endif
                            </td>
                            <td>
                                <small>{{ $review->created_at->format('d M Y') }}</small>
                            </td>
                            <td class="text-end pe-3">
                                <div class="d-flex justify-content-end gap-1">
                                    @if(!$review->is_approved)
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
                                    @endif
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
                            <td colspan="8" class="text-center text-muted py-5">
                                <i class="fas fa-star fa-3x d-block mb-3" style="color: #d1d5db;"></i>
                                <h5>No Reviews Found</h5>
                                <p class="text-muted">Reviews will appear here once customers submit them.</p>
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
    // Search functionality
    document.getElementById('searchInput')?.addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('#reviewTable tbody tr');
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? '' : 'none';
        });
    });

    console.log('%c⭐ Reviews Page Loaded', 'color: #8b5cf6; font-size: 13px; font-weight: bold;');
    console.log(`%c📊 Total Reviews: {{ $reviews->total() }}`, 'color: #10b981; font-size: 12px;');
</script>

<style>
    .nav-pills .nav-link {
        border-radius: 2rem;
        padding: 0.4rem 1rem;
        font-size: 0.8rem;
        font-weight: 500;
        color: #6b7280;
        background: #f3f4f6;
        transition: all 0.2s ease;
    }
    .nav-pills .nav-link:hover {
        background: #e5e7eb;
        color: #374151;
    }
    .nav-pills .nav-link.active {
        background: linear-gradient(135deg, #8b5cf6, #6366f1);
        color: white;
    }
    .nav-pills .nav-link .badge {
        font-size: 0.6rem;
        padding: 0.15rem 0.4rem;
    }
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