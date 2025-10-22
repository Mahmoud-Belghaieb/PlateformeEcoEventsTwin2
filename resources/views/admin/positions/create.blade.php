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
                                    <label for="name" class="form-label">Position Name *</label>
                                    <input type="text" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name') }}" 
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
                                              required>{{ old('description') }}</textarea>
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
                                              placeholder="List any skills, experience, or qualifications needed for this position...">{{ old('requirements') }}</textarea>
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
                                                <option value="0" {{ old('is_leadership') == '0' ? 'selected' : '' }}>
                                                    Volunteer Position
                                                </option>
                                                <option value="1" {{ old('is_leadership') == '1' ? 'selected' : '' }}>
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
                                                   value="{{ old('time_commitment') }}"
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