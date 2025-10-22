@extends('layouts.admin')

@section('title', 'Positions Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center bg-primary-green text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-users-cog me-2"></i>
                        Positions Management
                    </h5>
                    <a href="{{ route('admin.positions.create') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-plus me-1"></i>
                        Add New Position
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Position Name</th>
                                    <th>Description</th>
                                    <th>Requirements</th>
                                    <th>Events Count</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($positions as $position)
                                <tr>
                                    <td>{{ $position->id }}</td>
                                    <td>
                                        <strong class="text-primary-green">{{ $position->name }}</strong>
                                    </td>
                                    <td>
                                        <span class="text-muted">
                                            {{ Str::limit($position->description, 40) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($position->requirements)
                                            <span class="text-muted">
                                                {{ Str::limit($position->requirements, 30) }}
                                            </span>
                                        @else
                                            <span class="text-muted font-italic">No requirements</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">
                                            {{ $position->events_count ?? 0 }} events
                                        </span>
                                    </td>
                                    <td>{{ $position->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('admin.positions.show', $position) }}" 
                                               class="btn btn-outline-info" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.positions.edit', $position) }}" 
                                               class="btn btn-outline-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.positions.destroy', $position) }}" 
                                                  method="POST" class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this position?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-users-cog fa-3x mb-3"></i>
                                            <p>No positions found.</p>
                                            <a href="{{ route('admin.positions.create') }}" class="btn btn-primary-green">
                                                <i class="fas fa-plus me-1"></i>
                                                Create First Position
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if(method_exists($positions, 'links'))
                        <div class="d-flex justify-content-center mt-4">
                            {{ $positions->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection