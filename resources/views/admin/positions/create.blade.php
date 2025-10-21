@extends('layouts.admin')

@section('title', 'Create Position')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary-green text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-plus me-2"></i>
                        Create New Position
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
                            <li class="breadcrumb-item active">Create</li>
                        </ol>
                    </nav>

                    <form action="{{ route('admin.positions.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Position Title *</label>
                                    <input type="text" 
                                           class="form-control @error('title') is-invalid @enderror" 
                                           id="title" 
                                           name="title" 
                                           value="{{ old('title') }}" 
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
                                              required>{{ old('description') }}</textarea>
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
                                              required>{{ old('responsibilities') }}</textarea>
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
                                              placeholder="List any skills, experience, or qualifications needed for this position...">{{ old('requirements') }}</textarea>
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
                                                <option value="volunteer" {{ old('type') == 'volunteer' ? 'selected' : '' }}>
                                                    Volunteer
                                                </option>
                                                <option value="staff" {{ old('type') == 'staff' ? 'selected' : '' }}>
                                                    Staff
                                                </option>
                                                <option value="coordinator" {{ old('type') == 'coordinator' ? 'selected' : '' }}>
                                                    Coordinator
                                                </option>
                                                <option value="manager" {{ old('type') == 'manager' ? 'selected' : '' }}>
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
                                                   value="{{ old('required_count', 1) }}"
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
                                                   value="{{ old('hourly_rate') }}"
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
                                                <input class="form-check-input" type="checkbox" name="requires_training" value="1" id="requires_training">
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
                                        <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" checked>
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
                                            <i class="fas fa-info-circle me-1"></i>
                                            Position Information
                                        </h6>
                                        <p class="card-text small text-muted">
                                            Positions define roles that volunteers can fill during events. Be clear about responsibilities and expectations.
                                        </p>
                                        <p class="card-text small">
                                            <strong>Examples:</strong><br>
                                            • Event Coordinator<br>
                                            • Registration Assistant<br>
                                            • Setup Crew<br>
                                            • Photography Assistant<br>
                                            • Cleanup Team Leader
                                        </p>
                                    </div>
                                </div>

                                <div class="card bg-info bg-opacity-10 mt-3">
                                    <div class="card-body">
                                        <h6 class="card-title text-info">
                                            <i class="fas fa-lightbulb me-1"></i>
                                            Position Types
                                        </h6>
                                        <p class="card-text small mb-2">
                                            <strong>Volunteer Position:</strong><br>
                                            Regular volunteer roles with specific tasks.
                                        </p>
                                        <p class="card-text small mb-0">
                                            <strong>Leadership Position:</strong><br>
                                            Roles that require supervision or coordination responsibilities.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>
                        
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('admin.positions.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left me-1"></i>
                                        Back to Positions
                                    </a>
                                    <button type="submit" class="btn btn-primary-green">
                                        <i class="fas fa-save me-1"></i>
                                        Create Position
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