@extends('layouts.admin')

@section('title', 'Position Details')

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
                        <a href="{{ route('admin.positions.index') }}">Positions</a>
                    </li>
                    <li class="breadcrumb-item active">{{ $position->title }}</li>
                </ol>
            </nav>

            <div class="row">
                <div class="col-md-8">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary-green text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-user-cog me-2"></i>
                                {{ $position->title }}
                                    @if($position->is_leadership)
                                    <span class="badge bg-warning text-dark ms-2">Leadership</span>
                                @else
                                    <span class="badge bg-light text-dark ms-2">Volunteer</span>
                                @endif
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <h6>Description</h6>
                                    <p class="card-text">{{ $position->description }}</p>
                                </div>
                            </div>

                            @if($position->requirements)
                            <hr>
                            <div class="row">
                                <div class="col-12">
                                    <h6>Requirements</h6>
                                    <p class="card-text">{{ $position->requirements }}</p>
                                </div>
                            </div>
                            @endif

                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Position Information</h6>
                                    <table class="table table-sm">
                                        <tr>
                                            <td><strong>Position Type:</strong></td>
                                            <td>
                                                @if($position->is_leadership)
                                                    <span class="badge bg-warning text-dark">Leadership Position</span>
                                                @else
                                                    <span class="badge bg-light text-dark">Volunteer Position</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @if($position->time_commitment)
                                        <tr>
                                            <td><strong>Time Commitment:</strong></td>
                                            <td>
                                                <span class="badge bg-info">{{ $position->time_commitment }} hours</span>
                                            </td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <td><strong>Created:</strong></td>
                                            <td>{{ $position->created_at->format('M d, Y H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Last Updated:</strong></td>
                                            <td>{{ $position->updated_at->format('M d, Y H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Total Events:</strong></td>
                                            <td>
                                                <span class="badge bg-primary">{{ $position->events()->distinct('events.id')->count('events.id') }}</span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.positions.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-1"></i>
                                    Back to Positions
                                </a>
                                <div>
                                    <a href="{{ route('admin.positions.edit', $position) }}" class="btn btn-warning me-2">
                                        <i class="fas fa-edit me-1"></i>
                                        Edit Position
                                    </a>
                                    <form action="{{ route('admin.positions.destroy', $position) }}" 
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete this position? This action cannot be undone.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-trash me-1"></i>
                                            Delete Position
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
                                    <h3 class="text-primary-green mb-0">{{ $position->events()->count() }}</h3>
                                    <small class="text-muted">Total Events</small>
                                </div>
                                <div class="col-6">
                                    <h4 class="text-success mb-0">{{ $position->events()->where('start_date', '>=', now())->count() }}</h4>
                                    <small class="text-muted">Upcoming</small>
                                </div>
                                <div class="col-6">
                                    <h4 class="text-secondary mb-0">{{ $position->events()->where('start_date', '<', now())->count() }}</h4>
                                    <small class="text-muted">Past</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($position->events()->count() > 0)
                    <div class="card shadow-sm mt-3">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">
                                <i class="fas fa-calendar-alt me-2"></i>
                                Recent Events
                            </h6>
                        </div>
                        <div class="card-body p-0">
                            <div class="list-group list-group-flush">
                                @foreach($position->events()->latest()->take(5)->get() as $event)
                                <div class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">{{ Str::limit($event->title, 25) }}</div>
                                        <small class="text-muted">{{ $event->start_date->format('M d, Y') }}</small>
                                        @if($event->venue)
                                            <br><small class="text-info">{{ $event->venue->name }}</small>
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
                            <a href="{{ route('admin.events.index') }}?position={{ $position->id }}" class="btn btn-sm btn-outline-primary">
                                View All Events
                            </a>
                        </div>
                    </div>
                    @endif

                    @if($position->is_leadership)
                    <div class="card bg-warning bg-opacity-10 mt-3">
                        <div class="card-body">
                            <h6 class="card-title text-warning">
                                <i class="fas fa-crown me-1"></i>
                                Leadership Position
                            </h6>
                            <p class="card-text small mb-0">
                                This is a leadership position that requires supervision or coordination responsibilities.
                            </p>
                        </div>
                    </div>
                    @endif

                    @if($position->time_commitment)
                    <div class="card bg-info bg-opacity-10 mt-3">
                        <div class="card-body">
                            <h6 class="card-title text-info">
                                <i class="fas fa-clock me-1"></i>
                                Time Commitment
                            </h6>
                            <p class="card-text mb-0">
                                This position requires approximately <strong>{{ $position->time_commitment }} hours</strong> of time commitment.
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