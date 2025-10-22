@extends('layouts.admin')

@section('title', 'Event Details')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-calendar-alt me-2"></i>
                Event Details
            </h1>
            <p class="mb-0 text-muted">{{ $event->title }}</p>
        </div>
        <div>
            <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-primary-green me-2">
                <i class="fas fa-edit me-1"></i>
                Edit Event
            </a>
            <a href="{{ route('admin.events.index') }}" class="btn btn-outline-primary-green">
                <i class="fas fa-arrow-left me-1"></i>
                Back to Events
            </a>
        </div>
    </div>

    <!-- Event Details -->
    <div class="row">
        <!-- Main Event Information -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Event Information
                    </h5>
                </div>
                <div class="card-body">
                    @if($event->image)
                        <div class="mb-4">
                            <img src="{{ asset('storage/' . $event->image) }}" 
                                 alt="{{ $event->title }}" 
                                 class="img-fluid rounded" 
                                 style="max-height: 300px; width: 100%; object-fit: cover;">
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <h2 class="text-gray-800 mb-3">{{ $event->title }}</h2>
                            <p class="text-muted">{{ $event->description }}</p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <h6 class="font-weight-bold text-gray-700">
                                <i class="fas fa-calendar me-2"></i>
                                Date & Time
                            </h6>
                            <p class="mb-0">{{ $event->start_date->format('l, F j, Y') }}</p>
                            <p class="text-muted">{{ $event->start_date->format('g:i A') }}</p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <h6 class="font-weight-bold text-gray-700">
                                <i class="fas fa-money-bill me-2"></i>
                                Price
                            </h6>
                            <p class="mb-0">
                                @if($event->price > 0)
                                    <span class="h5 text-success">{{ number_format($event->price, 2) }} TND</span>
                                @else
                                    <span class="h5 text-success">Free</span>
                                @endif
                            </p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <h6 class="font-weight-bold text-gray-700">
                                <i class="fas fa-tags me-2"></i>
                                Category
                            </h6>
                            <span class="badge bg-primary p-2">{{ $event->category->name }}</span>
                        </div>

                        <div class="col-md-6 mb-3">
                            <h6 class="font-weight-bold text-gray-700">
                                <i class="fas fa-map-marker-alt me-2"></i>
                                Venue
                            </h6>
                            <p class="mb-0">{{ $event->venue->name }}</p>
                            <p class="text-muted">{{ $event->venue->location }}</p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <h6 class="font-weight-bold text-gray-700">
                                <i class="fas fa-users me-2"></i>
                                Capacity
                            </h6>
                            <p class="mb-0">
                                @if($event->capacity)
                                    {{ $event->capacity }} participants
                                @else
                                    Unlimited
                                @endif
                            </p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <h6 class="font-weight-bold text-gray-700">
                                <i class="fas fa-toggle-on me-2"></i>
                                Status
                            </h6>
                            <span class="badge 
                                @if($event->status === 'active') bg-success
                                @elseif($event->status === 'draft') bg-warning
                                @else bg-danger
                                @endif p-2">
                                {{ ucfirst($event->status) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Required Positions -->
            @if(method_exists($event, 'positions') && isset($event->positions) && $event->positions->count() > 0)
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-user-friends me-2"></i>
                        Required Positions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($event->positions as $position)
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-center p-3 bg-light rounded">
                                    <div class="icon-circle bg-secondary me-3" style="width: 40px; height: 40px;">
                                        <i class="fas fa-user text-white"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">{{ $position->name }}</h6>
                                        @if($position->description)
                                            <small class="text-muted">{{ $position->description }}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Registrations -->
            @if($event->registrations->count() > 0)
            <div class="card border-0 shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-clipboard-list me-2"></i>
                        Registrations ({{ $event->registrations->count() }})
                    </h5>
                    <a href="{{ route('admin.registrations.index', ['event_id' => $event->id]) }}" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-external-link-alt me-1"></i>
                        View All
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-4">Participant</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Registered</th>
                                    <th class="pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($event->registrations->take(10) as $registration)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <div class="icon-circle bg-primary me-3" style="width: 35px; height: 35px;">
                                                    <i class="fas fa-user text-white"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">{{ $registration->user->name }}</h6>
                                                    <small class="text-muted">{{ $registration->user->phone ?? 'No phone' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $registration->user->email }}</td>
                                        <td>
                                            <span class="badge 
                                                @if($registration->status === 'confirmed') bg-success
                                                @elseif($registration->status === 'pending') bg-warning
                                                @else bg-danger
                                                @endif">
                                                {{ ucfirst($registration->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $registration->created_at->format('M d, Y') }}</td>
                                        <td class="pe-4">
                                            <a href="{{ route('admin.registrations.show', $registration) }}" 
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Event Statistics -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-bar me-2"></i>
                        Statistics
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <div class="border-end">
                                <h3 class="mb-0 text-primary">{{ $event->registrations->count() }}</h3>
                                <small class="text-muted">Total Registrations</small>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <h3 class="mb-0 text-success">{{ $event->registrations->where('status', 'confirmed')->count() }}</h3>
                            <small class="text-muted">Confirmed</small>
                        </div>
                        <div class="col-6">
                            <div class="border-end">
                                <h3 class="mb-0 text-warning">{{ $event->registrations->where('status', 'pending')->count() }}</h3>
                                <small class="text-muted">Pending</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <h3 class="mb-0 text-danger">{{ $event->registrations->where('status', 'cancelled')->count() }}</h3>
                            <small class="text-muted">Cancelled</small>
                        </div>
                    </div>

                    @if($event->capacity)
                        <hr>
                        <div class="text-center">
                            <small class="text-muted">Capacity Usage</small>
                            <div class="progress mt-2" style="height: 10px;">
                                <div class="progress-bar bg-primary" 
                                     style="width: {{ ($event->registrations->count() / $event->capacity) * 100 }}%">
                                </div>
                            </div>
                            <small class="text-muted">
                                {{ $event->registrations->count() }} / {{ $event->capacity }}
                            </small>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Event Meta -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-info me-2"></i>
                        Event Meta
                    </h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <strong>Slug:</strong> <code>{{ $event->slug }}</code>
                        </li>
                        <li class="mb-2">
                            <strong>Created:</strong> {{ $event->created_at->format('M d, Y g:i A') }}
                        </li>
                        <li class="mb-2">
                            <strong>Updated:</strong> {{ $event->updated_at->format('M d, Y g:i A') }}
                        </li>
                        <li class="mb-0">
                            <strong>Revenue:</strong> 
                            <span class="text-success">
                                {{ number_format($event->registrations->where('status', 'confirmed')->count() * $event->price, 2) }} TND
                            </span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card border-0 shadow-sm">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-bolt me-2"></i>
                        Quick Actions
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-primary-green">
                            <i class="fas fa-edit me-1"></i>
                            Edit Event
                        </a>
                        <a href="{{ route('admin.registrations.create', ['event_id' => $event->id]) }}" class="btn btn-outline-success">
                            <i class="fas fa-user-plus me-1"></i>
                            Add Registration
                        </a>
                        <a href="{{ route('admin.events.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-list me-1"></i>
                            All Events
                        </a>
                        <form action="{{ route('admin.events.destroy', $event) }}" method="POST" 
                              onsubmit="return confirm('Are you sure you want to delete this event?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100">
                                <i class="fas fa-trash me-1"></i>
                                Delete Event
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection