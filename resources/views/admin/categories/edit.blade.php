@extends('layouts.admin')

@section('title', 'Edit Category')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">
                        <i class="fas fa-edit me-2"></i>
                        Edit Category: {{ $category->name }}
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
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.categories.show', $category) }}">{{ $category->name }}</a>
                            </li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </nav>

                    <form action="{{ route('admin.categories.update', $category) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Category Name *</label>
                                    <input type="text" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name', $category->name) }}" 
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
                                              placeholder="Enter category description...">{{ old('description', $category->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title">
                                            <i class="fas fa-chart-bar me-1"></i>
                                            Category Statistics
                                        </h6>
                                        <div class="row text-center">
                                            <div class="col-6">
                                                <div class="border-end">
                                                    <h4 class="text-primary-green mb-0">{{ $category->events()->count() }}</h4>
                                                    <small class="text-muted">Events</small>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <h4 class="text-accent-orange mb-0">{{ $category->events()->sum('max_participants') }}</h4>
                                                <small class="text-muted">Total Spots</small>
                                            </div>
                                        </div>
                                        <hr>
                                        <p class="small text-muted mb-0">
                                            <strong>Created:</strong> {{ $category->created_at->format('M d, Y H:i') }}
                                        </p>
                                        <p class="small text-muted mb-0">
                                            <strong>Last Updated:</strong> {{ $category->updated_at->format('M d, Y H:i') }}
                                        </p>
                                    </div>
                                </div>

                                @if($category->events()->count() > 0)
                                <div class="card bg-info bg-opacity-10 mt-3">
                                    <div class="card-body">
                                        <h6 class="card-title text-info">
                                            <i class="fas fa-exclamation-triangle me-1"></i>
                                            Notice
                                        </h6>
                                        <p class="card-text small mb-0">
                                            This category has {{ $category->events()->count() }} events associated with it. 
                                            Changes will affect all related events.
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
                                        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary me-2">
                                            <i class="fas fa-arrow-left me-1"></i>
                                            Back to Categories
                                        </a>
                                        <a href="{{ route('admin.categories.show', $category) }}" class="btn btn-outline-info">
                                            <i class="fas fa-eye me-1"></i>
                                            View Category
                                        </a>
                                    </div>
                                    <button type="submit" class="btn btn-warning">
                                        <i class="fas fa-save me-1"></i>
                                        Update Category
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