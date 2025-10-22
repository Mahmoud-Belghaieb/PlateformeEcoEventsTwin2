@extends('layouts.admin')

@section('title', 'Registration Details')

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
                        <a href="{{ route('admin.registrations.index') }}">Registrations</a>
                    </li>
                    <li class="breadcrumb-item active">Registration #{{ $registration->id }}</li>
                </ol>
            </nav>

            <div class="row">
                <div class="col-md-8">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary-green text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-clipboard-check me-2"></i>
                                Registration Details #{{ $registration->id }}
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>User Information</h6>
                                    <table class="table table-sm">
                                        <tr>
                                            <td><strong>Name:</strong></td>
                                            <td>{{ $registration->user->name }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Email:</strong></td>
                                            <td>
                                                <a href="mailto:{{ $registration->user->email }}" class="text-decoration-none">
                                                    {{ $registration->user->email }}
                                                </a>
                                            </td>
                                        </tr>
                                        @if($registration->user->phone)
                                        <tr>
                                            <td><strong>Phone:</strong></td>
                                            <td>
                                                <a href="tel:{{ $registration->user->phone }}" class="text-decoration-none">
                                                    {{ $registration->user->phone }}
                                                </a>
                                            </td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <td><strong>User Since:</strong></td>
                                            <td>{{ $registration->user->created_at->format('M d, Y') }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <h6>Event Information</h6>
                                    <table class="table table-sm">
                                        <tr>
                                            <td><strong>Event:</strong></td>
                                            <td>
                                                <a href="{{ route('admin.events.show', $registration->event) }}" 
                                                   class="text-primary-green text-decoration-none">
                                                    {{ $registration->event->title }}
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Date & Time:</strong></td>
                                            <td>
                                                {{ $registration->event->start_date->format('M d, Y') }} at 
                                                {{ $registration->event->start_date->format('H:i') }}
                                            </td>
                                        </tr>
                                        @if($registration->event->venue)
                                        <tr>
                                            <td><strong>Venue:</strong></td>
                                            <td>{{ $registration->event->venue->name }}, {{ $registration->event->venue->city }}</td>
                                        </tr>
                                        @endif
                                        @if($registration->event->category)
                                        <tr>
                                            <td><strong>Category:</strong></td>
                                            <td>
                                                <span class="badge bg-secondary">{{ $registration->event->category->name }}</span>
                                            </td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <td><strong>Price:</strong></td>
                                            <td><strong class="text-success">{{ number_format($registration->event->price, 2) }} TND</strong></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Registration Information</h6>
                                    <table class="table table-sm">
                                        <tr>
                                            <td><strong>Registration Date:</strong></td>
                                            <td>{{ $registration->created_at->format('M d, Y H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Last Updated:</strong></td>
                                            <td>{{ $registration->updated_at->format('M d, Y H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Status:</strong></td>
                                            <td>
                                                @switch($registration->status)
                                                    @case('pending')
                                                        <span class="badge bg-warning text-dark">
                                                            <i class="fas fa-clock me-1"></i>Pending
                                                        </span>
                                                        @break
                                                    @case('confirmed')
                                                        <span class="badge bg-success">
                                                            <i class="fas fa-check me-1"></i>Confirmed
                                                        </span>
                                                        @break
                                                    @case('cancelled')
                                                        <span class="badge bg-danger">
                                                            <i class="fas fa-times me-1"></i>Cancelled
                                                        </span>
                                                        @break
                                                    @default
                                                        <span class="badge bg-secondary">Unknown</span>
                                                @endswitch
                                            </td>
                                        </tr>
                                        @if($registration->position)
                                        <tr>
                                            <td><strong>Position:</strong></td>
                                            <td>
                                                <span class="badge bg-{{ $registration->position->is_leadership ? 'warning' : 'secondary' }}">
                                                    {{ $registration->position->name }}
                                                    @if($registration->position->is_leadership)
                                                        <i class="fas fa-crown ms-1"></i>
                                                    @endif
                                                </span>
                                            </td>
                                        </tr>
                                        @endif
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    @if($registration->position)
                                    <h6>Position Details</h6>
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <h6 class="card-title">{{ $registration->position->name }}</h6>
                                            <p class="card-text small">{{ $registration->position->description }}</p>
                                            @if($registration->position->requirements)
                                                <p class="card-text small">
                                                    <strong>Requirements:</strong><br>
                                                    {{ $registration->position->requirements }}
                                                </p>
                                            @endif
                                            @if($registration->position->time_commitment)
                                                <p class="card-text small mb-0">
                                                    <strong>Time Commitment:</strong> {{ $registration->position->time_commitment }} hours
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('admin.registrations.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-1"></i>
                                    Back to Registrations
                                </a>
                                
                                <div class="btn-group" role="group">
                                    @if($registration->status === 'pending')
                                        <form action="{{ route('admin.registrations.update', $registration) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="confirmed">
                                            <button type="submit" class="btn btn-success">
                                                <i class="fas fa-check me-1"></i>
                                                Confirm Registration
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.registrations.update', $registration) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="cancelled">
                                            <button type="submit" class="btn btn-outline-danger">
                                                <i class="fas fa-times me-1"></i>
                                                Cancel Registration
                                            </button>
                                        </form>
                                    @elseif($registration->status === 'confirmed')
                                        <form action="{{ route('admin.registrations.update', $registration) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="cancelled">
                                            <button type="submit" class="btn btn-outline-danger">
                                                <i class="fas fa-times me-1"></i>
                                                Cancel Registration
                                            </button>
                                        </form>
                                    @elseif($registration->status === 'cancelled')
                                        <form action="{{ route('admin.registrations.update', $registration) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="confirmed">
                                            <button type="submit" class="btn btn-success">
                                                <i class="fas fa-undo me-1"></i>
                                                Restore Registration
                                            </button>
                                        </form>
                                    @endif
                                    
                                    <form action="{{ route('admin.registrations.destroy', $registration) }}" 
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete this registration? This action cannot be undone.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-trash me-1"></i>
                                            Delete Registration
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
                                <i class="fas fa-info-circle me-2"></i>
                                Registration Timeline
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="timeline">
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-primary"></div>
                                    <div class="timeline-content">
                                        <h6 class="timeline-title">Registration Created</h6>
                                        <p class="timeline-description">
                                            {{ $registration->created_at->format('M d, Y H:i') }}
                                        </p>
                                    </div>
                                </div>
                                @if($registration->updated_at != $registration->created_at)
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-warning"></div>
                                    <div class="timeline-content">
                                        <h6 class="timeline-title">Last Updated</h6>
                                        <p class="timeline-description">
                                            {{ $registration->updated_at->format('M d, Y H:i') }}
                                        </p>
                                    </div>
                                </div>
                                @endif
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-{{ $registration->event->start_date >= now() ? 'success' : 'secondary' }}"></div>
                                    <div class="timeline-content">
                                        <h6 class="timeline-title">Event Date</h6>
                                        <p class="timeline-description">
                                            {{ $registration->event->start_date->format('M d, Y') }} at {{ $registration->event->start_date->format('H:i') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($registration->user->registrations()->count() > 1)
                    <div class="card shadow-sm mt-3">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">
                                <i class="fas fa-user me-2"></i>
                                User's Other Registrations
                            </h6>
                        </div>
                        <div class="card-body p-0">
                            <div class="list-group list-group-flush">
                                @foreach($registration->user->registrations()->where('id', '!=', $registration->id)->latest()->take(3)->get() as $otherReg)
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="ms-2 me-auto">
                                            <div class="fw-bold">{{ Str::limit($otherReg->event->title, 20) }}</div>
                                            <small class="text-muted">{{ $otherReg->event->start_date->format('M d, Y') }}</small>
                                        </div>
                                        <span class="badge bg-{{ $otherReg->status === 'confirmed' ? 'success' : ($otherReg->status === 'pending' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($otherReg->status) }}
                                        </span>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    padding-bottom: 20px;
}

.timeline-item:not(:last-child)::before {
    content: '';
    position: absolute;
    left: -22px;
    top: 20px;
    height: calc(100% - 10px);
    width: 2px;
    background: #e9ecef;
}

.timeline-marker {
    position: absolute;
    left: -26px;
    top: 0;
    width: 8px;
    height: 8px;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 0 0 2px #e9ecef;
}

.timeline-title {
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 5px;
}

.timeline-description {
    font-size: 13px;
    color: #6c757d;
    margin-bottom: 0;
}
</style>
@endsection