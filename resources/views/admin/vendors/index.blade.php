@extends('layouts.admin')

@section('title', 'Vendors - EktaMart Admin')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">
                <i class="fas fa-store text-primary me-2"></i>Vendors
            </h4>
            <p class="text-muted small">Manage all vendors</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Vendor
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

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-transparent border-0 pt-3 pb-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <span class="text-muted small">Total Vendors: <strong>{{ $vendors->total() }}</strong></span>
                    <span class="text-muted small ms-3">
                        <span class="badge bg-success">Approved: {{ \App\Models\User::where('role', 'vendor')->where('is_approved', true)->count() }}</span>
                        <span class="badge bg-warning ms-1">Pending: {{ \App\Models\User::where('role', 'vendor')->where('is_approved', false)->count() }}</span>
                    </span>
                </div>
                <div class="input-group input-group-sm" style="width: 250px;">
                    <span class="input-group-text bg-transparent border-end-0">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" class="form-control border-start-0" placeholder="Search vendors..." id="searchInput">
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="vendorTable">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-3" style="width: 60px;">#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th>Approval</th>
                            <th>Joined</th>
                            <th class="text-end pe-3" style="width: 150px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($vendors as $vendor)
                        <tr>
                            <td class="ps-3">{{ $loop->iteration }}</td>
                            <td class="fw-semibold">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle bg-primary bg-opacity-10 p-2" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-user text-primary fa-sm"></i>
                                    </div>
                                    {{ $vendor->name }}
                                </div>
                            </td>
                            <td>{{ $vendor->email }}</td>
                            <td>{{ $vendor->phone ?? 'N/A' }}</td>
                            <td>
                                <form action="{{ route('admin.users.toggle-status', $vendor) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" class="btn btn-sm {{ $vendor->status ? 'btn-success' : 'btn-secondary' }} rounded-pill px-3">
                                        <i class="fas {{ $vendor->status ? 'fa-check-circle' : 'fa-times-circle' }} me-1"></i>
                                        {{ $vendor->status ? 'Active' : 'Inactive' }}
                                    </button>
                                </form>
                            </td>
                            <td>
                                @if($vendor->is_approved)
                                    <span class="badge bg-success">Approved</span>
                                @else
                                    <span class="badge bg-warning">Pending</span>
                                @endif
                            </td>
                            <td>{{ $vendor->created_at->format('d M Y') }}</td>
                            <td class="text-end pe-3">
                                <div class="d-flex justify-content-end gap-1">
                                    <a href="{{ route('admin.vendors.show', $vendor) }}" class="btn btn-sm btn-outline-info" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.users.edit', $vendor) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if(!$vendor->is_approved)
                                        <form action="{{ route('admin.vendors.approve', $vendor) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('POST')
                                            <button type="submit" class="btn btn-sm btn-outline-success" title="Approve" onclick="return confirm('Approve this vendor?')">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                    @endif
                                    <form action="{{ route('admin.users.destroy', $vendor) }}" method="POST" class="d-inline">
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
                                <i class="fas fa-store fa-3x d-block mb-3" style="color: #d1d5db;"></i>
                                <h5>No Vendors Found</h5>
                                <p class="text-muted">Start by creating your first vendor.</p>
                                <a href="{{ route('admin.users.create') }}" class="btn btn-primary mt-2">
                                    <i class="fas fa-plus"></i> Create Vendor
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($vendors->hasPages())
            <div class="card-footer bg-transparent">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <span class="text-muted small">
                        Showing {{ $vendors->firstItem() ?? 0 }} to {{ $vendors->lastItem() ?? 0 }} of {{ $vendors->total() }} entries
                    </span>
                    {{ $vendors->links() }}
                </div>
            </div>
        @endif
    </div>
</div>

<script>
    document.getElementById('searchInput')?.addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('#vendorTable tbody tr');
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? '' : 'none';
        });
    });

    console.log('%c🏪 Vendors Page Loaded', 'color: #8b5cf6; font-size: 13px; font-weight: bold;');
    console.log(`%c📊 Total Vendors: {{ $vendors->total() }}`, 'color: #10b981; font-size: 12px;');
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
    .btn-success, .btn-secondary {
        transition: all 0.2s ease;
    }
    .input-group .form-control:focus {
        border-color: #8b5cf6;
        box-shadow: 0 0 0 0.2rem rgba(139, 92, 246, 0.1);
    }
</style>
@endsection