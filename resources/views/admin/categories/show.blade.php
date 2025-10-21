@extends('layouts.admin')

@section('title', 'Category Details')

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
                        <a href="{{ route('admin.categories.index') }}">Categories</a>
                    </li>
                    <li class="breadcrumb-item active">{{ $category->name }}</li>
                </ol>
            </nav>

            <div class="row">
                <div class="col-md-8">
                    <div class="card shadow-sm">
                        <div class="card-header text-white" style="background-color: {{ $category->color }};">
                            <h5 class="mb-0">
                                @if($category->icon)
                                    <i class="{{ $category->icon }} me-2"></i>
                                @else
                                    <i class="fas fa-tag me-2"></i>
                                @endif
                                {{ $category->name }}
                                @if(!$category->is_active)
                                    <span class="badge bg-secondary ms-2">Inactive</span>
                                @endif
                            </h5>
                        </div>
                        <div class="card-body">
                            @if($category->description)
                                <p class="card-text">{{ $category->description }}</p>
                            @else
                                <p class="text-muted font-italic">No description provided.</p>
                            @endif

                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <h6>Category Information</h6>
                                    <table class="table table-sm">
                                        <tr>
                                            <td><strong>Slug:</strong></td>
                                            <td><code>{{ $category->slug }}</code></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Color:</strong></td>
                                            <td>
                                                <span class="badge text-white" style="background-color: {{ $category->color }};">
                                                    {{ $category->color }}
                                                </span>
                                            </td>
                                        </tr>
                                        @if($category->icon)
                                        <tr>
                                            <td><strong>Icon:</strong></td>
                                            <td>
                                                <i class="{{ $category->icon }}"></i> 
                                                <code>{{ $category->icon }}</code>
                                            </td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <td><strong>Status:</strong></td>
                                            <td>
                                                @if($category->is_active)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-secondary">Inactive</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Created:</strong></td>
                                            <td>{{ $category->created_at->format('M d, Y H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Last Updated:</strong></td>
                                            <td>{{ $category->updated_at->format('M d, Y H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Total Events:</strong></td>
                                            <td>
                                                <span class="badge bg-primary">{{ $category->events()->count() }}</span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-1"></i>
                                    Back to Categories
                                </a>
                                <div>
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-warning me-2">
                                        <i class="fas fa-edit me-1"></i>
                                        Edit Category
                                    </a>
                                    <form action="{{ route('admin.categories.destroy', $category) }}" 
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete this category? This action cannot be undone.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-trash me-1"></i>
                                            Delete Category
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
                                <i class="fas fa-chart-pie me-2"></i>
                                Statistics
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-12 mb-3">
                                    <h3 class="text-primary-green mb-0">{{ $category->events()->count() }}</h3>
                                    <small class="text-muted">Total Events</small>
                                </div>
                                <div class="col-6">
                                    <h4 class="text-success mb-0">{{ $category->events()->where('start_date', '>=', now())->count() }}</h4>
                                    <small class="text-muted">Upcoming</small>
                                </div>
                                <div class="col-6">
                                    <h4 class="text-secondary mb-0">{{ $category->events()->where('start_date', '<', now())->count() }}</h4>
                                    <small class="text-muted">Past</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($category->events()->count() > 0)
                    <div class="card shadow-sm mt-3">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">
                                <i class="fas fa-calendar-alt me-2"></i>
                                Recent Events
                            </h6>
                        </div>
                        <div class="card-body p-0">
                            <div class="list-group list-group-flush">
                                @foreach($category->events()->latest()->take(5)->get() as $event)
                                <div class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">{{ Str::limit($event->title, 25) }}</div>
                                        <small class="text-muted">{{ $event->start_date->format('M d, Y') }}</small>
                                    </div>
                                    <span class="badge bg-{{ $event->start_date >= now() ? 'success' : 'secondary' }} rounded-pill">
                                        {{ $event->start_date >= now() ? 'Upcoming' : 'Past' }}
                                    </span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <a href="{{ route('admin.events.index') }}?category={{ $category->id }}" class="btn btn-sm btn-outline-primary">
                                View All Events
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection