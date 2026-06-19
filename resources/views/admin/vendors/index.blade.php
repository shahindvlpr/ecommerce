@extends('layouts.admin')

@section('title', 'Vendors - EktaMart Admin')

@section('content')
<div class="container-fluid px-4">
    <h4 class="fw-bold mb-4">
        <i class="fas fa-store text-primary me-2"></i>Vendors
    </h4>

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
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Products</th>
                            <th>Joined</th>
                            <th class="text-end pe-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($vendors as $vendor)
                        <tr>
                            <td class="ps-3">{{ $loop->iteration }}</td>
                            <td class="fw-semibold">{{ $vendor->name }}</td>
                            <td>{{ $vendor->email }}</td>
                            <td>
                                <span class="badge {{ $vendor->is_approved ? 'bg-success' : 'bg-warning' }}">
                                    {{ $vendor->is_approved ? 'Approved' : 'Pending' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $vendor->products_count ?? 0 }}</span>
                            </td>
                            <td>{{ $vendor->created_at->format('d M Y') }}</td>
                            <td class="text-end pe-3">
                                <a href="{{ route('admin.vendors.show', $vendor) }}" class="btn btn-sm btn-outline-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if(!$vendor->is_approved)
                                    <form action="{{ route('admin.vendors.approve', $vendor) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('POST')
                                        <button type="submit" class="btn btn-sm btn-outline-success" onclick="return confirm('Approve this vendor?')">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="fas fa-inbox fa-2x d-block mb-2"></i>
                                No vendors found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-transparent">
            {{ $vendors->links() }}
        </div>
    </div>
</div>
@endsection