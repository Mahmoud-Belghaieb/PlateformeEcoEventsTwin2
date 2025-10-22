@extends('layouts.admin')

@section('title', 'Material Details')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="mb-2">
                    <i class="fas fa-tools me-2"></i>
                    Material Details
                </h1>
                <p class="mb-0 opacity-90">View complete information about this material</p>
            </div>
            <div>
                <a href="{{ route('admin.materiels.edit', $materiel) }}" class="btn btn-warning me-2">
                    <i class="fas fa-edit me-2"></i>Edit Material
                </a>
                <a href="{{ route('admin.materiels.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Materials
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Material Image -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-gradient-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-image me-2"></i>Material Image</h5>
                </div>
                <div class="card-body text-center">
                    @if($materiel->image)
                        <img src="{{ asset('storage/' . $materiel->image) }}" 
                             alt="{{ $materiel->name }}" 
                             class="img-fluid rounded shadow-sm"
                             style="max-height: 400px; object-fit: cover;">
                    @else
                        <div class="bg-gradient-primary text-white d-flex align-items-center justify-content-center rounded" 
                             style="height: 300px;">
                            <i class="fas fa-tools fa-5x opacity-50"></i>
                        </div>
                        <p class="text-muted mt-3">No image available</p>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card shadow-sm mt-3">
                <div class="card-header bg-gradient-secondary text-white">
                    <h5 class="mb-0"><i class="fas fa-bolt me-2"></i>Quick Actions</h5>
                </div>
                <div class="card-body">
                    <a href="{{ route('admin.materiels.edit', $materiel) }}" class="btn btn-warning w-100 mb-2">
                        <i class="fas fa-edit me-2"></i>Edit Material
                    </a>
                    <form action="{{ route('admin.materiels.destroy', $materiel) }}" method="POST" 
                          onsubmit="return confirm('Are you sure you want to delete this material?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="fas fa-trash me-2"></i>Delete Material
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Material Information -->
        <div class="col-md-8">
            <!-- Basic Information -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-gradient-success text-white">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Basic Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Material Name</label>
                            <h5 class="mb-0">{{ $materiel->name }}</h5>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Type/Category</label>
                            <h5><span class="badge bg-gradient-info text-white px-3 py-2">{{ $materiel->type }}</span></h5>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="text-muted small">Description</label>
                            <p class="mb-0">{{ $materiel->description ?? 'No description provided' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Inventory Details -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-gradient-info text-white">
                    <h5 class="mb-0"><i class="fas fa-boxes me-2"></i>Inventory Details</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="text-muted small">Quantity</label>
                            <h5><span class="badge bg-primary px-3 py-2 fs-6">
                                <i class="fas fa-boxes me-1"></i>{{ $materiel->quantity }} units
                            </span></h5>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="text-muted small">Condition</label>
                            <h5>
                                @php
                                    $conditionColors = [
                                        'excellent' => 'success',
                                        'good' => 'info',
                                        'fair' => 'warning'
                                    ];
                                    $conditionIcons = [
                                        'excellent' => 'fa-star',
                                        'good' => 'fa-thumbs-up',
                                        'fair' => 'fa-exclamation-triangle'
                                    ];
                                    $color = $conditionColors[$materiel->condition] ?? 'secondary';
                                    $icon = $conditionIcons[$materiel->condition] ?? 'fa-question';
                                @endphp
                                <span class="badge bg-{{ $color }} px-3 py-2">
                                    <i class="fas {{ $icon }} me-1"></i>{{ ucfirst($materiel->condition) }}
                                </span>
                            </h5>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="text-muted small">Value</label>
                            <h5 class="text-success">{{ number_format($materiel->value, 2) }} TND</h5>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="text-muted small">Availability</label>
                            <h5>
                                @if($materiel->is_available)
                                    <span class="badge bg-success px-3 py-2">
                                        <i class="fas fa-check-circle me-1"></i>Available
                                    </span>
                                @else
                                    <span class="badge bg-danger px-3 py-2">
                                        <i class="fas fa-times-circle me-1"></i>Unavailable
                                    </span>
                                @endif
                            </h5>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Event Association -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-gradient-warning text-white">
                    <h5 class="mb-0"><i class="fas fa-calendar-alt me-2"></i>Event Association</h5>
                </div>
                <div class="card-body">
                    @if($materiel->event)
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="fas fa-calendar-check fa-3x text-primary"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">{{ $materiel->event->title }}</h5>
                                <p class="text-muted mb-1">
                                    <i class="fas fa-map-marker-alt me-1"></i>{{ $materiel->event->location }}
                                </p>
                                <p class="text-muted mb-0">
                                    <i class="fas fa-clock me-1"></i>
                                    {{ \Carbon\Carbon::parse($materiel->event->start_date)->format('M d, Y') }}
                                </p>
                                <a href="{{ route('admin.events.show', $materiel->event) }}" class="btn btn-sm btn-outline-primary mt-2">
                                    <i class="fas fa-eye me-1"></i>View Event
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                            <p class="text-muted mb-0">Not associated with any event</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Metadata -->
            <div class="card shadow-sm">
                <div class="card-header bg-gradient-dark text-white">
                    <h5 class="mb-0"><i class="fas fa-clock me-2"></i>Metadata</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="text-muted small">Created At</label>
                            <p class="mb-0">
                                <i class="fas fa-calendar-plus me-2 text-primary"></i>
                                {{ $materiel->created_at->format('M d, Y - h:i A') }}
                            </p>
                            <small class="text-muted">{{ $materiel->created_at->diffForHumans() }}</small>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">Last Updated</label>
                            <p class="mb-0">
                                <i class="fas fa-calendar-edit me-2 text-success"></i>
                                {{ $materiel->updated_at->format('M d, Y - h:i A') }}
                            </p>
                            <small class="text-muted">{{ $materiel->updated_at->diffForHumans() }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
