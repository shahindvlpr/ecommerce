@extends('layouts.admin')

@section('title', 'Attribute Values - EktaMart Admin')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">
                <i class="fas fa-list text-primary me-2"></i>Attribute Values
            </h4>
            <p class="text-muted small">Manage attribute values</p>
        </div>
        <a href="{{ route('admin.attribute-values.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Value
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
                            <th>Value</th>
                            <th>Attribute</th>
                            <th>Color</th>
                            <th>Position</th>
                            <th>Status</th>
                            <th class="text-end pe-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($values as $value)
                        <tr>
                            <td class="ps-3">{{ $loop->iteration }}</td>
                            <td class="fw-semibold">{{ $value->value }}</td>
                            <td>{{ $value->attribute->name ?? 'N/A' }}</td>
                            <td>
                                @if($value->color_code)
                                    <span class="badge" style="background: {{ $value->color_code }}; width: 30px; height: 30px; display: inline-block; border-radius: 4px;"></span>
                                    <small>{{ $value->color_code }}</small>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>{{ $value->position ?? 0 }}</td>
                            <td>
                                <span class="badge {{ $value->status ? 'bg-success' : 'bg-danger' }}">
                                    {{ $value->status ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="text-end pe-3">
                                <a href="{{ route('admin.attribute-values.edit', $value) }}" class="btn btn-sm btn-outline-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.attribute-values.destroy', $value) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="fas fa-inbox fa-2x d-block mb-2"></i>
                                No attribute values found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-transparent">
            {{ $values->links() }}
        </div>
    </div>
</div>
@endsection