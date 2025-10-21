@extends('layouts.admin')

@section('title', 'Create Category')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary-green text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-plus me-2"></i>
                        Create New Category
                    </h5>
                </div>
                <div class="card-body">
                    <nav aria-label="breadcrumb" class="mb-4">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.categories.index') }}">Categories</a>
                            </li>
                            <li class="breadcrumb-item active">Create</li>
                        </ol>
                    </nav>

                    <form action="{{ route('admin.categories.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Category Name *</label>
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
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" 
                                              name="description" 
                                              rows="4"
                                              placeholder="Enter category description...">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="color" class="form-label">Category Color</label>
                                            <input type="color" 
                                                   class="form-control form-control-color @error('color') is-invalid @enderror" 
                                                   id="color" 
                                                   name="color" 
                                                   value="{{ old('color', '#059669') }}" 
                                                   title="Choose category color">
                                            @error('color')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="icon" class="form-label">Icon Class</label>
                                            <input type="text" 
                                                   class="form-control @error('icon') is-invalid @enderror" 
                                                   id="icon" 
                                                   name="icon" 
                                                   value="{{ old('icon') }}" 
                                                   placeholder="fas fa-leaf">
                                            @error('icon')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">Font Awesome class (e.g., fas fa-leaf, fas fa-tree)</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input @error('is_active') is-invalid @enderror" 
                                               type="checkbox" 
                                               role="switch" 
                                               id="is_active" 
                                               name="is_active" 
                                               value="1"
                                               {{ old('is_active', true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            Active Category
                                        </label>
                                        @error('is_active')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">Inactive categories won't be available for new events</div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Information
                                        </h6>
                                        <p class="card-text small text-muted">
                                            Categories help organize events by type. Choose descriptive names that users will easily understand.
                                        </p>
                                        <p class="card-text small">
                                            <strong>Examples:</strong><br>
                                            • Environmental Cleanup<br>
                                            • Tree Planting<br>
                                            • Wildlife Conservation<br>
                                            • Renewable Energy<br>
                                            • Sustainability Workshop
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>
                        
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left me-1"></i>
                                        Back to Categories
                                    </a>
                                    <button type="submit" class="btn btn-primary-green">
                                        <i class="fas fa-save me-1"></i>
                                        Create Category
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