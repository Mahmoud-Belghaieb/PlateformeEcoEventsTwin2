@extends('layouts.admin')

@section('title', 'Edit Position')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">
                        <i class="fas fa-edit me-2"></i>
                        Edit Position: {{ $position->name }}
                    </h5>
                </div>
                <div class="card-body">
                    <nav aria-label="breadcrumb" class="mb-4">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.positions.index') }}">Positions</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.positions.show', $position) }}">{{ $position->name }}</a>
                            </li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </nav>

                    <form action="{{ route('admin.positions.update', $position) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Position Name *</label>
                                    <input type="text" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name', $position->name) }}" 
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Description *</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" 
                                              name="description" 
                                              rows="4"
                                              placeholder="Describe the responsibilities and tasks for this position..."
                                              required>{{ old('description', $position->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="requirements" class="form-label">Requirements</label>
                                    <textarea class="form-control @error('requirements') is-invalid @enderror" 
                                              id="requirements" 
                                              name="requirements" 
                                              rows="4"
                                              placeholder="List any skills, experience, or qualifications needed for this position...">{{ old('requirements', $position->requirements) }}</textarea>
                                    @error('requirements')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="is_leadership" class="form-label">Position Type</label>
                                            <select class="form-select @error('is_leadership') is-invalid @enderror" 
                                                    id="is_leadership" 
                                                    name="is_leadership">
                                                <option value="0" {{ old('is_leadership', $position->is_leadership) == '0' ? 'selected' : '' }}>
                                                    Volunteer Position
                                                </option>
                                                <option value="1" {{ old('is_leadership', $position->is_leadership) == '1' ? 'selected' : '' }}>
                                                    Leadership Position
                                                </option>
                                            </select>
                                            @error('is_leadership')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="time_commitment" class="form-label">Time Commitment (hours)</label>
                                            <input type="number" 
                                                   class="form-control @error('time_commitment') is-invalid @enderror" 
                                                   id="time_commitment" 
                                                   name="time_commitment" 
                                                   value="{{ old('time_commitment', $position->time_commitment) }}"
                                                   min="1"
                                                   step="0.5"
                                                   placeholder="e.g., 4">
                                            @error('time_commitment')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title">
                                            <i class="fas fa-chart-bar me-1"></i>
                                            Position Statistics
                                        </h6>
                                        <div class="row text-center">
                                            <div class="col-6">
                                                <div class="border-end">
                                                    <h4 class="text-primary-green mb-0">{{ $position->events()->count() }}</h4>
                                                    <small class="text-muted">Events</small>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <h4 class="text-accent-orange mb-0">{{ $position->is_leadership ? 'Leader' : 'Volunteer' }}</h4>
                                                <small class="text-muted">Type</small>
                                            </div>
                                        </div>
                                        <hr>
                                        <p class="small text-muted mb-0">
                                            <strong>Created:</strong> {{ $position->created_at->format('M d, Y') }}
                                        </p>
                                        <p class="small text-muted mb-0">
                                            <strong>Last Updated:</strong> {{ $position->updated_at->format('M d, Y') }}
                                        </p>
                                    </div>
                                </div>

                                @if($position->events()->count() > 0)
                                <div class="card bg-info bg-opacity-10 mt-3">
                                    <div class="card-body">
                                        <h6 class="card-title text-info">
                                            <i class="fas fa-exclamation-triangle me-1"></i>
                                            Notice
                                        </h6>
                                        <p class="card-text small mb-0">
                                            This position is used in {{ $position->events()->count() }} events. 
                                            Changes will affect all related events.
                                        </p>
                                    </div>
                                </div>
                                @endif

                                @if($position->time_commitment)
                                <div class="card bg-success bg-opacity-10 mt-3">
                                    <div class="card-body">
                                        <h6 class="card-title text-success">
                                            <i class="fas fa-clock me-1"></i>
                                            Time Commitment
                                        </h6>
                                        <p class="card-text small mb-0">
                                            <strong>{{ $position->time_commitment }} hours</strong> required for this position.
                                        </p>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        <hr>
                        
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <a href="{{ route('admin.positions.index') }}" class="btn btn-secondary me-2">
                                            <i class="fas fa-arrow-left me-1"></i>
                                            Back to Positions
                                        </a>
                                        <a href="{{ route('admin.positions.show', $position) }}" class="btn btn-outline-info">
                                            <i class="fas fa-eye me-1"></i>
                                            View Position
                                        </a>
                                    </div>
                                    <button type="submit" class="btn btn-warning">
                                        <i class="fas fa-save me-1"></i>
                                        Update Position
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection