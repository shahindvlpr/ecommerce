@extends('layouts.admin')

@section('title', 'General Settings - EktaMart Admin')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">
            <i class="fas fa-globe text-primary me-2"></i>General Settings
        </h4>
        <a href="{{ route('admin.settings.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">
            @include('admin.settings.partials.form', ['section' => 'general'])
        </div>
    </div>
</div>
@endsection