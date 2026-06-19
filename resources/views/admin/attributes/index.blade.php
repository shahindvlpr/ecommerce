@extends('layouts.admin')

@section('title', 'Attributes - EktaMart Admin')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">
                <i class="fas fa-list-check text-primary me-2"></i>Attributes
            </h4>
            <p class="text-muted small">Manage product attributes like size, color, material</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-secondary btn-sm" onclick="window.location.reload()">
                <i class="fas fa-sync-alt"></i>
            </button>
            <a href="{{ route('admin.attributes.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Attribute
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-transparent border-0 pt-3 pb-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <span class="text-muted small">Total Attributes: <strong>{{ $attributes->total() }}</strong></span>
                </div>
                <div class="input-group input-group-sm" style="width: 250px;">
                    <span class="input-group-text bg-transparent border-end-0">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" class="form-control border-start-0" placeholder="Search attributes..." id="searchInput">
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="attributeTable">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-3" style="width: 60px;">#</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Type</th>
                            <th style="width: 100px;">Values</th>
                            <th style="width: 120px;">Status</th>
                            <th style="width: 120px;">Created</th>
                            <th class="text-end pe-3" style="width: 130px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attributes as $attribute)
                        <tr>
                            <td class="ps-3">{{ $loop->iteration }}</td>
                            <td>
                                <span class="fw-semibold">{{ $attribute->name }}</span>
                            </td>
                            <td><code>{{ $attribute->slug }}</code></td>
                            <td>
                                <span class="badge bg-info">
                                    {{ ucfirst($attribute->type) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-secondary">{{ $attribute->values_count ?? 0 }}</span>
                            </td>
                            <td>
                                <form action="{{ route('admin.attributes.toggle-status', $attribute) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" class="btn btn-sm {{ $attribute->status ? 'btn-success' : 'btn-secondary' }} rounded-pill px-3">
                                        <i class="fas {{ $attribute->status ? 'fa-check-circle' : 'fa-times-circle' }} me-1"></i>
                                        {{ $attribute->status ? 'Active' : 'Inactive' }}
                                    </button>
                                </form>
                            </td>
                            <td>
                                <small>{{ $attribute->created_at->format('d M Y') }}</small>
                            </td>
                            <td class="text-end pe-3">
                                <div class="d-flex justify-content-end gap-1">
                                    <a href="{{ route('admin.attributes.show', $attribute) }}" class="btn btn-sm btn-outline-info" title="View Values">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.attributes.edit', $attribute) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-danger" title="Delete" onclick="confirmDelete({{ $attribute->id }}, '{{ $attribute->name }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-5">
                                <i class="fas fa-list-check fa-3x d-block mb-3" style="color: #d1d5db;"></i>
                                <h5>No Attributes Found</h5>
                                <p class="text-muted">Start by creating your first attribute.</p>
                                <a href="{{ route('admin.attributes.create') }}" class="btn btn-primary mt-2">
                                    <i class="fas fa-plus"></i> Create Attribute
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($attributes->hasPages())
            <div class="card-footer bg-transparent">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <span class="text-muted small">
                        Showing {{ $attributes->firstItem() ?? 0 }} to {{ $attributes->lastItem() ?? 0 }} of {{ $attributes->total() }} entries
                    </span>
                    {{ $attributes->links() }}
                </div>
            </div>
        @endif
    </div>
</div>

{{-- Delete Form (Hidden) --}}
<form id="delete-form" action="" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
    function confirmDelete(id, name) {
        if (confirm(`Are you sure you want to delete attribute "${name}"? This will also delete all its values.`)) {
            const form = document.getElementById('delete-form');
            form.action = `/admin/attributes/${id}`;
            form.submit();
        }
    }

    document.getElementById('searchInput')?.addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('#attributeTable tbody tr');
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? '' : 'none';
        });
    });

    console.log('%c🏷️ Attributes Page Loaded', 'color: #8b5cf6; font-size: 13px; font-weight: bold;');
    console.log(`%c📊 Total Attributes: {{ $attributes->total() }}`, 'color: #10b981; font-size: 12px;');
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
    .input-group .form-control:focus {
        border-color: #8b5cf6;
        box-shadow: 0 0 0 0.2rem rgba(139, 92, 246, 0.1);
    }
</style>
@endsection