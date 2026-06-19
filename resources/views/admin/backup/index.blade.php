@extends('layouts.admin')

@section('title', 'Backup - EktaMart Admin')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">
            <i class="fas fa-database text-primary me-2"></i>Backup
        </h4>
        <button onclick="createBackup()" class="btn btn-primary">
            <i class="fas fa-plus"></i> Create Backup
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="bg-light">
                        <tr>
                            <th>#</th>
                            <th>File Name</th>
                            <th>Size</th>
                            <th>Date</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($backups ?? [] as $backup)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $backup['name'] }}</td>
                            <td>{{ $backup['size'] }}</td>
                            <td>{{ $backup['date'] }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.backup.download', $backup['name']) }}" class="btn btn-sm btn-outline-success">
                                    <i class="fas fa-download"></i>
                                </a>
                                <form action="{{ route('admin.backup.delete', $backup['name']) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this backup?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <i class="fas fa-inbox fa-2x d-block mb-2"></i>
                                No backups found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function createBackup() {
    if (!confirm('Create a new backup? This may take a few moments.')) return;

    const btn = event.target;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Creating...';
    btn.disabled = true;

    fetch('{{ route("admin.backup.create") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Failed to create backup');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Something went wrong!');
    })
    .finally(() => {
        btn.innerHTML = '<i class="fas fa-plus"></i> Create Backup';
        btn.disabled = false;
    });
}
</script>
@endsection