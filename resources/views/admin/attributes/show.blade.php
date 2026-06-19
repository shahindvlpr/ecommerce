@extends('layouts.admin')

@section('title', 'Attribute Values - EktaMart Admin')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">
                <i class="fas fa-list-check text-primary me-2"></i>Attribute Values
            </h4>
            <p class="text-muted small">Manage values for: <strong>{{ $attribute->name }}</strong></p>
        </div>
        <div>
            <a href="{{ route('admin.attributes.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="bg-light">
                        <tr>
                            <th>#</th>
                            <th>Value</th>
                            <th>Slug</th>
                            <th>Color</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attribute->values as $value)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $value->value }}</td>
                            <td><code>{{ $value->slug }}</code></td>
                            <td>
                                @if($value->color_code)
                                    <span class="badge" style="background: {{ $value->color_code }}; width: 30px; height: 30px; display: inline-block;"></span>
                                    {{ $value->color_code }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>
                                <span class="badge {{ $value->status ? 'bg-success' : 'bg-danger' }}">
                                    {{ $value->status ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="text-end">
                                <a href="#" class="btn btn-sm btn-outline-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                No values found for this attribute.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection