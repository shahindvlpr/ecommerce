@extends('layouts.admin')

@section('title', 'Banners - EktaMart Admin')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">
            <i class="fas fa-image text-primary me-2"></i>Banners
        </h4>
        <a href="{{ route('admin.banners.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Banner
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        @forelse($banners as $banner)
        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                <img src="{{ asset('storage/' . $banner->image) }}" alt="{{ $banner->title }}" 
                     class="card-img-top" style="height: 200px; object-fit: cover;">
                <div class="card-body">
                    <h6 class="fw-bold">{{ $banner->title }}</h6>
                    <p class="text-muted small">{{ Str::limit($banner->description ?? '', 50) }}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge {{ $banner->status ? 'bg-success' : 'bg-secondary' }}">
                            {{ $banner->status ? 'Active' : 'Inactive' }}
                        </span>
                        <div>
                            <a href="{{ route('admin.banners.edit', $banner) }}" class="btn btn-sm btn-outline-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="text-center text-muted py-4">
                <i class="fas fa-inbox fa-2x d-block mb-2"></i>
                No banners found.
            </div>
        </div>
        @endforelse
    </div>
    <div class="mt-4">
        {{ $banners->links() }}
    </div>
</div>
@endsection