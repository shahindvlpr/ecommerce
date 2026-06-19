@extends('layouts.admin')

@section('title', 'Users Report - EktaMart Admin')

@section('content')
<div class="container-fluid px-4">
    <h4 class="fw-bold mb-4">
        <i class="fas fa-users text-primary me-2"></i>Users Report
    </h4>

    <div class="row g-3 mb-4">
        <div class="col-md-2">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body text-center">
                    <h6 class="text-muted small">Total</h6>
                    <h5 class="fw-bold">{{ $totalUsers }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body text-center">
                    <h6 class="text-muted small">Active</h6>
                    <h5 class="fw-bold text-success">{{ $activeUsers }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body text-center">
                    <h6 class="text-muted small">Customers</h6>
                    <h5 class="fw-bold text-info">{{ $customers }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body text-center">
                    <h6 class="text-muted small">Vendors</h6>
                    <h5 class="fw-bold text-warning">{{ $vendors }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body text-center">
                    <h6 class="text-muted small">Admins</h6>
                    <h5 class="fw-bold text-danger">{{ $admins }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body text-center">
                    <h6 class="text-muted small">New This Month</h6>
                    <h5 class="fw-bold">{{ $newUsersThisMonth }}</h5>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Orders</th>
                            <th>Total Spent</th>
                            <th>Joined</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge {{ $user->role == 'admin' ? 'bg-danger' : ($user->role == 'vendor' ? 'bg-warning' : 'bg-info') }}">
                                    {{ ucfirst($user->role ?? 'Customer') }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $user->status ? 'bg-success' : 'bg-danger' }}">
                                    {{ $user->status ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>{{ $user->orders_count ?? 0 }}</td>
                            <td>${{ number_format($user->orders_sum_total ?? 0, 2) }}</td>
                            <td>{{ $user->created_at->format('d M Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-3">No users found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-transparent">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection