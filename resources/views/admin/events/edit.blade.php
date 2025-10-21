@extends('layouts.admin')

@section('title', 'Edit Event')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-edit me-2"></i>
                Edit Event
            </h1>
            <p class="mb-0 text-muted">Update event details</p>
        </div>
        <div>
            <a href="{{ route('admin.events.show', $event) }}" class="btn btn-outline-info me-2">
                <i class="fas fa-eye me-1"></i>
                View Event
            </a>
            <a href="{{ route('admin.events.index') }}" class="btn btn-outline-primary-green">
                <i class="fas fa-arrow-left me-1"></i>
                Back to Events
            </a>
        </div>
    </div>

    <!-- Edit Form -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-edit me-2"></i>
                        Event Details
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.events.update', $event) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <!-- Title -->
                            <div class="col-md-12 mb-3">
                                <label for="title" class="form-label font-weight-bold">
                                    <i class="fas fa-heading me-1"></i>
                                    Event Title *
                                </label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                       id="title" name="title" value="{{ old('title', $event->title) }}" 
                                       placeholder="Enter event title" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="col-md-12 mb-3">
                                <label for="description" class="form-label font-weight-bold">
                                    <i class="fas fa-align-left me-1"></i>
                                    Description *
                                </label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" name="description" rows="4" 
                                          placeholder="Describe the event..." required>{{ old('description', $event->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Start Date -->
                            <div class="col-md-6 mb-3">
                                <label for="start_date" class="form-label font-weight-bold">
                                    <i class="fas fa-calendar me-1"></i>
                                    Start Date & Time *
                                </label>
                                <input type="datetime-local" class="form-control @error('start_date') is-invalid @enderror" 
                                       id="start_date" name="start_date" 
                                       value="{{ old('start_date', $event->start_date ? $event->start_date->format('Y-m-d\TH:i') : '') }}" required>
                                @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Price -->
                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label font-weight-bold">
                                    <i class="fas fa-money-bill me-1"></i>
                                    Price (TND) *
                                </label>
                                <div class="input-group">
                                    <input type="number" class="form-control @error('price') is-invalid @enderror" 
                                           id="price" name="price" value="{{ old('price', $event->price) }}" 
                                           step="0.01" min="0" placeholder="0.00" required>
                                    <span class="input-group-text">TND</span>
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Category -->
                            <div class="col-md-6 mb-3">
                                <label for="category_id" class="form-label font-weight-bold">
                                    <i class="fas fa-tags me-1"></i>
                                    Category *
                                </label>
                                <select class="form-control @error('category_id') is-invalid @enderror" 
                                        id="category_id" name="category_id" required>
                                    <option value="">Select a category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" 
                                                {{ old('category_id', $event->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Venue -->
                            <div class="col-md-6 mb-3">
                                <label for="venue_id" class="form-label font-weight-bold">
                                    <i class="fas fa-map-marker-alt me-1"></i>
                                    Venue *
                                </label>
                                <select class="form-control @error('venue_id') is-invalid @enderror" 
                                        id="venue_id" name="venue_id" required>
                                    <option value="">Select a venue</option>
                                    @foreach($venues as $venue)
                                        <option value="{{ $venue->id }}" 
                                                {{ old('venue_id', $event->venue_id) == $venue->id ? 'selected' : '' }}>
                                            {{ $venue->name }} - {{ $venue->location }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('venue_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Capacity -->
                            <div class="col-md-6 mb-3">
                                <label for="capacity" class="form-label font-weight-bold">
                                    <i class="fas fa-users me-1"></i>
                                    Capacity
                                </label>
                                <input type="number" class="form-control @error('capacity') is-invalid @enderror" 
                                       id="capacity" name="capacity" value="{{ old('capacity', $event->max_participants) }}" 
                                       min="1" placeholder="Maximum attendees">
                                @error('capacity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label font-weight-bold">
                                    <i class="fas fa-toggle-on me-1"></i>
                                    Status *
                                </label>
                                <select class="form-control @error('status') is-invalid @enderror" 
                                        id="status" name="status" required>
                                    <option value="published" {{ old('status', $event->status) == 'published' ? 'selected' : '' }}>Published</option>
                                    <option value="draft" {{ old('status', $event->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="cancelled" {{ old('status', $event->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Current Image -->
                            @if($event->featured_image)
                            <div class="col-md-12 mb-3">
                                <label class="form-label font-weight-bold">
                                    <i class="fas fa-image me-1"></i>
                                    Current Image
                                </label>
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $event->featured_image) }}" 
                                         alt="Event Image" class="img-thumbnail" style="max-height: 150px;">
                                </div>
                            </div>
                            @endif

                            <!-- Image Upload -->
                            <div class="col-md-12 mb-3">
                                <label for="image" class="form-label font-weight-bold">
                                    <i class="fas fa-image me-1"></i>
                                    {{ $event->featured_image ? 'Replace Image' : 'Event Image' }}
                                </label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                       id="image" name="image" accept="image/*">
                                <small class="form-text text-muted">Upload an image for the event (JPG, PNG, GIF)</small>
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                            <a href="{{ route('admin.events.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-1"></i>
                                Cancel
                            </a>
                            <div>
                                <button type="submit" class="btn btn-primary-green">
                                    <i class="fas fa-save me-1"></i>
                                    Update Event
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Positions Selection -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-user-friends me-2"></i>
                        Required Positions
                    </h5>
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-3">Select the positions needed for this event:</p>
                    
                    @if($positions->count() > 0)
                        @foreach($positions as $position)
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" 
                                       name="positions[]" value="{{ $position->id }}" 
                                       id="position_{{ $position->id }}"
                                       {{ in_array($position->id, old('positions', $event->positions->pluck('id')->toArray())) ? 'checked' : '' }}>
                                <label class="form-check-label" for="position_{{ $position->id }}">
                                    <strong>{{ $position->name }}</strong>
                                    @if($position->description)
                                        <br><small class="text-muted">{{ $position->description }}</small>
                                    @endif
                                </label>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-3">
                            <i class="fas fa-user-plus fa-2x text-muted mb-2"></i>
                            <p class="text-muted">No positions available.</p>
                            <a href="{{ route('admin.positions.create') }}" class="btn btn-sm btn-outline-primary-green">
                                <i class="fas fa-plus me-1"></i>
                                Create Position
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Event Stats -->
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-chart-bar me-2"></i>
                        Event Statistics
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <h4 class="mb-0 text-primary">{{ $event->registrations->count() }}</h4>
                                <small class="text-muted">Registrations</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <h4 class="mb-0 text-success">{{ $event->max_participants ?? '∞' }}</h4>
                            <small class="text-muted">Capacity</small>
                        </div>
                    </div>
                    <hr>
                    <div class="text-center">
                        <small class="text-muted">
                            Created: {{ $event->created_at->format('M d, Y') }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .form-label {
        color: #2d3748;
        margin-bottom: 0.5rem;
    }
    
    .form-check-input:checked {
        background-color: var(--primary-green);
        border-color: var(--primary-green);
    }
    
    .form-control:focus {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 0.2rem rgba(5, 150, 105, 0.25);
    }
    
    .input-group-text {
        background-color: #f8f9fa;
        border-color: #e2e8f0;
        color: #6c757d;
        font-weight: 500;
    }
</style>
@endpush