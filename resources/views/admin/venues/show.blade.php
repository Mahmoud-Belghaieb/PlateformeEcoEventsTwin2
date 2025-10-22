@extends('layouts.admin')

@section('title', 'Venue Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.venues.index') }}">Venues</a>
                    </li>
                    <li class="breadcrumb-item active">{{ $venue->name }}</li>
                </ol>
            </nav>

            <div class="row">
                <div class="col-md-8">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary-green text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-map-marker-alt me-2"></i>
                                {{ $venue->name }}
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Location Information</h6>
                                    <table class="table table-sm">
                                        <tr>
                                            <td><strong>City:</strong></td>
                                            <td>{{ $venue->city }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Address:</strong></td>
                                            <td>{{ $venue->address }}</td>
                                        </tr>
                                        @if($venue->capacity)
                                        <tr>
                                            <td><strong>Capacity:</strong></td>
                                            <td>
                                                <span class="badge bg-info">{{ number_format($venue->capacity) }} people</span>
                                            </td>
                                        </tr>
                                        @endif
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <h6>Contact Information</h6>
                                    <table class="table table-sm">
                                        @if($venue->phone)
                                        <tr>
                                            <td><strong>Phone:</strong></td>
                                            <td>
                                                <a href="tel:{{ $venue->phone }}" class="text-decoration-none">
                                                    <i class="fas fa-phone text-muted"></i>
                                                    {{ $venue->phone }}
                                                </a>
                                            </td>
                                        </tr>
                                        @endif
                                        @if($venue->email)
                                        <tr>
                                            <td><strong>Email:</strong></td>
                                            <td>
                                                <a href="mailto:{{ $venue->email }}" class="text-decoration-none">
                                                    <i class="fas fa-envelope text-muted"></i>
                                                    {{ $venue->email }}
                                                </a>
                                            </td>
                                        </tr>
                                        @endif
                                        @if($venue->website)
                                        <tr>
                                            <td><strong>Website:</strong></td>
                                            <td>
                                                <a href="{{ $venue->website }}" target="_blank" class="text-decoration-none">
                                                    <i class="fas fa-globe text-muted"></i>
                                                    {{ $venue->website }}
                                                    <i class="fas fa-external-link-alt ms-1"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @endif
                                    </table>
                                </div>
                            </div>

                            @if($venue->description)
                            <hr>
                            <h6>Description</h6>
                            <p class="card-text">{{ $venue->description }}</p>
                            @endif

                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Venue Information</h6>
                                    <table class="table table-sm">
                                        <tr>
                                            <td><strong>Created:</strong></td>
                                            <td>{{ $venue->created_at->format('M d, Y H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Last Updated:</strong></td>
                                            <td>{{ $venue->updated_at->format('M d, Y H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Total Events:</strong></td>
                                            <td>
                                                <span class="badge bg-primary">{{ $venue->events()->count() }}</span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.venues.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-1"></i>
                                    Back to Venues
                                </a>
                                <div>
                                    <a href="{{ route('admin.venues.edit', $venue) }}" class="btn btn-warning me-2">
                                        <i class="fas fa-edit me-1"></i>
                                        Edit Venue
                                    </a>
                                    <form action="{{ route('admin.venues.destroy', $venue) }}" 
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete this venue? This action cannot be undone.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-trash me-1"></i>
                                            Delete Venue
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">
                                <i class="fas fa-chart-pie me-2"></i>
                                Statistics
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-12 mb-3">
                                    <h3 class="text-primary-green mb-0">{{ $venue->events()->count() }}</h3>
                                    <small class="text-muted">Total Events</small>
                                </div>
                                <div class="col-6">
                                    <h4 class="text-success mb-0">{{ $venue->events()->where('start_date', '>=', now())->count() }}</h4>
                                    <small class="text-muted">Upcoming</small>
                                </div>
                                <div class="col-6">
                                    <h4 class="text-secondary mb-0">{{ $venue->events()->where('start_date', '<', now())->count() }}</h4>
                                    <small class="text-muted">Past</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($venue->events()->count() > 0)
                    <div class="card shadow-sm mt-3">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">
                                <i class="fas fa-calendar-alt me-2"></i>
                                Recent Events
                            </h6>
                        </div>
                        <div class="card-body p-0">
                            <div class="list-group list-group-flush">
                                @foreach($venue->events()->latest()->take(5)->get() as $event)
                                <div class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">{{ Str::limit($event->title, 25) }}</div>
                                        <small class="text-muted">{{ $event->start_date->format('M d, Y') }}</small>
                                        @if($event->category)
                                            <br><small class="badge bg-secondary">{{ $event->category->name }}</small>
                                        @endif
                                    </div>
                                    <span class="badge bg-{{ $event->start_date >= now() ? 'success' : 'secondary' }} rounded-pill">
                                        {{ $event->start_date >= now() ? 'Upcoming' : 'Past' }}
                                    </span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <a href="{{ route('admin.events.index') }}?venue={{ $venue->id }}" class="btn btn-sm btn-outline-primary">
                                View All Events
                            </a>
                        </div>
                    </div>
                    @endif

                    @if($venue->capacity)
                    <div class="card bg-info bg-opacity-10 mt-3">
                        <div class="card-body">
                            <h6 class="card-title text-info">
                                <i class="fas fa-users me-1"></i>
                                Capacity Information
                            </h6>
                            <p class="card-text mb-0">
                                This venue can accommodate up to <strong>{{ number_format($venue->capacity) }}</strong> participants.
                            </p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection