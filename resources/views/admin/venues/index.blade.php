@extends('layouts.admin')

@section('title', 'Venues Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center bg-primary-green text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-map-marker-alt me-2"></i>
                        Venues Management
                    </h5>
                    <a href="{{ route('admin.venues.create') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-plus me-1"></i>
                        Add New Venue
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
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>Contact</th>
                                    <th>Events Count</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($venues as $venue)
                                <tr>
                                    <td>{{ $venue->id }}</td>
                                    <td>
                                        <strong class="text-primary-green">{{ $venue->name }}</strong>
                                    </td>
                                    <td>
                                        <span class="text-muted">
                                            {{ Str::limit($venue->address, 30) }}
                                            @if($venue->city)
                                                <br><small class="text-info">{{ $venue->city }}</small>
                                            @endif
                                        </span>
                                    </td>
                                    <td>
                                        @if($venue->phone)
                                            <small class="d-block">
                                                <i class="fas fa-phone text-muted"></i>
                                                {{ $venue->phone }}
                                            </small>
                                        @endif
                                        @if($venue->email)
                                            <small class="d-block">
                                                <i class="fas fa-envelope text-muted"></i>
                                                {{ $venue->email }}
                                            </small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">
                                            {{ $venue->events_count ?? 0 }} events
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('admin.venues.show', $venue) }}" 
                                               class="btn btn-outline-info" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.venues.edit', $venue) }}" 
                                               class="btn btn-outline-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.venues.destroy', $venue) }}" 
                                                  method="POST" class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this venue?')">
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
                                            <i class="fas fa-map-marker-alt fa-3x mb-3"></i>
                                            <p>No venues found.</p>
                                            <a href="{{ route('admin.venues.create') }}" class="btn btn-primary-green">
                                                <i class="fas fa-plus me-1"></i>
                                                Create First Venue
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if(method_exists($venues, 'links'))
                        <div class="d-flex justify-content-center mt-4">
                            {{ $venues->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection