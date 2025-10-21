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
                        Edit Position: {{ $position->title }}
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
                                <a href="{{ route('admin.positions.show', $position) }}">{{ $position->title }}</a>
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
                                    <label for="title" class="form-label">Position Title *</label>
                                    <input type="text" 
                                           class="form-control @error('title') is-invalid @enderror" 
                                           id="title" 
                                           name="title" 
                                           value="{{ old('title', $position->title) }}" 
                                           required>
                                    @error('title')
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
                                    <label for="responsibilities" class="form-label">Responsibilities *</label>
                                    <textarea class="form-control @error('responsibilities') is-invalid @enderror" 
                                              id="responsibilities" 
                                              name="responsibilities" 
                                              rows="4"
                                              placeholder="Describe the main tasks and responsibilities for this position..."
                                              required>{{ old('responsibilities', $position->responsibilities) }}</textarea>
                                    @error('responsibilities')
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
                                            <label for="type" class="form-label">Position Type *</label>
                                            <select class="form-select @error('type') is-invalid @enderror" 
                                                    id="type" 
                                                    name="type"
                                                    required>
                                                <option value="">Select position type...</option>
                                                <option value="volunteer" {{ old('type', $position->type) == 'volunteer' ? 'selected' : '' }}>
                                                    Volunteer
                                                </option>
                                                <option value="staff" {{ old('type', $position->type) == 'staff' ? 'selected' : '' }}>
                                                    Staff
                                                </option>
                                                <option value="coordinator" {{ old('type', $position->type) == 'coordinator' ? 'selected' : '' }}>
                                                    Coordinator
                                                </option>
                                                <option value="manager" {{ old('type', $position->type) == 'manager' ? 'selected' : '' }}>
                                                    Manager
                                                </option>
                                            </select>
                                            @error('type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="required_count" class="form-label">Required Count *</label>
                                            <input type="number" 
                                                   class="form-control @error('required_count') is-invalid @enderror" 
                                                   id="required_count" 
                                                   name="required_count" 
                                                   value="{{ old('required_count', $position->required_count) }}"
                                                   min="1"
                                                   required
                                                   placeholder="e.g., 4">
                                            @error('required_count')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="hourly_rate" class="form-label">Hourly Rate (TND)</label>
                                            <input type="number" 
                                                   class="form-control @error('hourly_rate') is-invalid @enderror" 
                                                   id="hourly_rate" 
                                                   name="hourly_rate" 
                                                   value="{{ old('hourly_rate', $position->hourly_rate) }}"
                                                   min="0"
                                                   step="0.01"
                                                   placeholder="0.00">
                                            <small class="form-text text-muted">Leave empty for volunteer positions</small>
                                            @error('hourly_rate')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="requires_training" value="1" id="requires_training"
                                                       {{ old('requires_training', $position->requires_training) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="requires_training">
                                                    <i class="fas fa-graduation-cap me-1"></i>
                                                    Requires Training
                                                </label>
                                            </div>
                                            <small class="form-text text-muted">Check if this position requires special training</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active"
                                               {{ old('is_active', $position->is_active) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            <i class="fas fa-check-circle me-1"></i>
                                            Position is Active
                                        </label>
                                    </div>
                                    <small class="form-text text-muted">Uncheck to make this position unavailable for applications</small>
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
                                                    <h4 class="text-primary-green mb-0">{{ $position->registrations()->count() }}</h4>
                                                    <small class="text-muted">Applications</small>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <h4 class="text-accent-orange mb-0">{{ ucfirst($position->type) }}</h4>
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

                                @if($position->registrations()->count() > 0)
                                <div class="card bg-info bg-opacity-10 mt-3">
                                    <div class="card-body">
                                        <h6 class="card-title text-info">
                                            <i class="fas fa-exclamation-triangle me-1"></i>
                                            Notice
                                        </h6>
                                        <p class="card-text small mb-0">
                                            This position has {{ $position->registrations()->count() }} applications. 
                                            Changes may affect existing applications.
                                        </p>
                                    </div>
                                </div>
                                @endif

                                @if($position->hourly_rate && $position->hourly_rate > 0)
                                <div class="card bg-success bg-opacity-10 mt-3">
                                    <div class="card-body">
                                        <h6 class="card-title text-success">
                                            <i class="fas fa-money-bill me-1"></i>
                                            Compensation
                                        </h6>
                                        <p class="card-text small mb-0">
                                            <strong>{{ number_format($position->hourly_rate, 2) }} TND per hour</strong> for this position.
                                        </p>
                                    </div>
                                </div>
                                @endif

                                @if($position->requires_training)
                                <div class="card bg-warning bg-opacity-10 mt-3">
                                    <div class="card-body">
                                        <h6 class="card-title text-warning">
                                            <i class="fas fa-graduation-cap me-1"></i>
                                            Training Required
                                        </h6>
                                        <p class="card-text small mb-0">
                                            This position requires special training before starting.
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