@extends('layouts.admin')

@section('title', 'Create New Position')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-plus-circle me-2"></i>
                        Create New Position
                    </h5>
                </div>

                <div class="card-body">
                    <nav aria-label="breadcrumb" class="mb-4">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.positions.index') }}">Positions</a></li>
                            <li class="breadcrumb-item active">Create New Position</li>
                        </ol>
                    </nav>

                    <form action="{{ route('admin.positions.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <!-- Main Form -->
                            <div class="col-md-8">
                                <!-- Title -->
                                <div class="mb-4">
                                    <label for="title" class="form-label fw-bold">Position Title *</label>
                                    <input type="text" 
                                           class="form-control @error('title') is-invalid @enderror" 
                                           id="title" 
                                           name="title" 
                                           value="{{ old('title') }}" 
                                           required
                                           autofocus>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Description -->
                                <div class="mb-4">
                                    <label for="description" class="form-label fw-bold">Description *</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" 
                                              name="description" 
                                              rows="4" 
                                              required>{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Responsibilities (required) -->
                                <div class="mb-4">
                                    <label for="responsibilities" class="form-label fw-bold">Responsibilities *</label>
                                    <textarea class="form-control @error('responsibilities') is-invalid @enderror"
                                              id="responsibilities"
                                              name="responsibilities"
                                              rows="3"
                                              placeholder="Describe the responsibilities for this position"
                                              required>{{ old('responsibilities') }}</textarea>
                                    @error('responsibilities')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Requirements -->
                                <div class="mb-4">
                                    <label for="requirements" class="form-label fw-bold">Requirements</label>
                                    <textarea class="form-control @error('requirements') is-invalid @enderror" 
                                              id="requirements" 
                                              name="requirements" 
                                              rows="3">{{ old('requirements') }}</textarea>
                                    @error('requirements')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Leadership and Time -->
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label for="is_leadership" class="form-label fw-bold">Position Type *</label>
                                        <select class="form-select @error('is_leadership') is-invalid @enderror" 
                                                id="is_leadership" 
                                                name="is_leadership" 
                                                required>
                                            <option value="">Select a type...</option>
                                            <option value="0" {{ old('is_leadership') === "0" ? 'selected' : '' }}>Regular Position</option>
                                            <option value="1" {{ old('is_leadership') === "1" ? 'selected' : '' }}>Leadership Position</option>
                                        </select>
                                        @error('is_leadership')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label for="time_commitment" class="form-label fw-bold">Daily Time Commitment</label>
                                        <div class="input-group">
                                            <input type="number" 
                                                   class="form-control @error('time_commitment') is-invalid @enderror" 
                                                   id="time_commitment" 
                                                   name="time_commitment" 
                                                   value="{{ old('time_commitment') }}"
                                                   min="0.5"
                                                   max="24"
                                                   step="0.5">
                                            <span class="input-group-text">hours/day</span>
                                            @error('time_commitment')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Info Sidebar -->
                            <div class="col-md-4">
                                <div class="card bg-light mb-4">
                                    <div class="card-body">
                                        <h6 class="card-title">
                                            <i class="fas fa-info-circle me-2"></i>
                                            Position Types
                                        </h6>
                                        <hr>
                                        <p class="card-text small">
                                            <strong class="d-block mb-2">Regular Position:</strong>
                                            Basic volunteer role focused on specific tasks and responsibilities.
                                        </p>
                                        <p class="card-text small mb-0">
                                            <strong class="d-block mb-2">Leadership Position:</strong>
                                            Involves team supervision and coordination responsibilities.
                                        </p>
                                    </div>
                                </div>

                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title">
                                            <i class="fas fa-lightbulb me-2"></i>
                                            Tips for Creating Positions
                                        </h6>
                                        <hr>
                                        <ul class="small mb-0">
                                            <li>Be specific about responsibilities</li>
                                            <li>List key requirements clearly</li>
                                            <li>Include necessary skills</li>
                                            <li>Specify time expectations</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="border-top pt-4 mt-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('admin.positions.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>
                                    Back to Positions
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>
                                    Create Position
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection