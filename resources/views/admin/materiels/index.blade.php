@extends('layouts.admin')

@section('title', 'Materials Management')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header mb-4">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="mb-2">
                        <i class="fas fa-tools me-2"></i>
                        Materials Management
                    </h1>
                    <p class="mb-0 opacity-90">Manage equipment and materials inventory</p>
                </div>
                <a href="{{ route('admin.materiels.create') }}" class="btn btn-primary-green btn-lg shadow">
                    <i class="fas fa-plus me-2"></i>Add New Material
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="stats-card">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="icon-circle bg-primary">
                        <i class="fas fa-tools text-white"></i>
                    </div>
                    <div class="text-end">
                        <h2 class="mb-0 fw-bold">{{ $materiels->total() }}</h2>
                        <small class="text-muted">Total Items</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stats-card">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="icon-circle bg-success">
                        <i class="fas fa-check-circle text-white"></i>
                    </div>
                    <div class="text-end">
                        <h2 class="mb-0 fw-bold">{{ $materiels->where('is_available', true)->count() }}</h2>
                        <small class="text-muted">Available</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stats-card">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="icon-circle bg-info">
                        <i class="fas fa-boxes text-white"></i>
                    </div>
                    <div class="text-end">
                        <h2 class="mb-0 fw-bold">{{ $materiels->sum('quantity') }}</h2>
                        <small class="text-muted">Total Quantity</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stats-card warning">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="icon-circle bg-warning">
                        <i class="fas fa-award text-white"></i>
                    </div>
                    <div class="text-end">
                        <h2 class="mb-0 fw-bold">{{ $materiels->where('condition', 'excellent')->count() }}</h2>
                        <small class="text-muted">Excellent</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.materiels.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Search</label>
                    <input type="text" name="search" class="form-control" placeholder="Search by name..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Category</label>
                    <select name="category" class="form-select">
                        <option value="">All Categories</option>
                        @foreach($materiels->pluck('category')->unique() as $category)
                            <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>{{ $category }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Condition</label>
                    <select name="condition" class="form-select">
                        <option value="">All Conditions</option>
                        <option value="excellent" {{ request('condition') == 'excellent' ? 'selected' : '' }}>Excellent</option>
                        <option value="good" {{ request('condition') == 'good' ? 'selected' : '' }}>Good</option>
                        <option value="fair" {{ request('condition') == 'fair' ? 'selected' : '' }}>Fair</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary-green flex-grow-1">
                            <i class="fas fa-filter me-2"></i>Filter
                        </button>
                        <a href="{{ route('admin.materiels.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-redo"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Materials Table -->
    <div class="card shadow-sm">
        <div class="card-header bg-gradient-success text-white">
            <h5 class="mb-0">
                <i class="fas fa-list me-2"></i>All Materials
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-gradient-success text-white">
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Quantity</th>
                            <th>Condition</th>
                            <th>Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($materiels as $materiel)
                            <tr>
                                <td>
                                    @if($materiel->image)
                                        <img src="{{ Storage::url($materiel->image) }}" alt="{{ $materiel->name }}" class="rounded shadow-sm" style="height: 60px; width: 60px; object-fit: cover;">
                                    @else
                                        <div class="bg-gradient-primary text-white d-flex align-items-center justify-content-center rounded shadow-sm" style="width: 60px; height: 60px;">
                                            <i class="fas fa-tools fa-2x"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $materiel->name }}</strong><br>
                                    @if($materiel->description)
                                        <small class="text-muted">{{ Str::limit($materiel->description, 40) }}</small>
                                    @endif
                                </td>
                                <td><span class="badge bg-gradient-info text-white px-3 py-2">{{ $materiel->category }}</span></td>
                                <td>
                                    <span class="badge bg-primary px-3 py-2">
                                        <i class="fas fa-boxes me-1"></i>{{ $materiel->quantity }} units
                                    </span>
                                </td>
                                <td>
                                    @if($materiel->condition == 'excellent')
                                        <span class="badge bg-success px-3 py-2">
                                            <i class="fas fa-star me-1"></i>Excellent
                                        </span>
                                    @elseif($materiel->condition == 'good')
                                        <span class="badge bg-info px-3 py-2">
                                            <i class="fas fa-thumbs-up me-1"></i>Good
                                        </span>
                                    @else
                                        <span class="badge bg-warning px-3 py-2">
                                            <i class="fas fa-exclamation-triangle me-1"></i>Fair
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($materiel->is_available)
                                        <span class="badge bg-success px-3 py-2">
                                            <i class="fas fa-check-circle me-1"></i>Available
                                        </span>
                                    @else
                                        <span class="badge bg-danger px-3 py-2">
                                            <i class="fas fa-ban me-1"></i>Unavailable
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="action-buttons d-flex justify-content-center gap-1">
                                        <a href="{{ route('admin.materiels.show', $materiel) }}" class="btn btn-sm btn-info" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.materiels.edit', $materiel) }}" class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.materiels.destroy', $materiel) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this material?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="empty-state">
                                        <i class="fas fa-tools"></i>
                                        <h5>No Materials Found</h5>
                                        <p>There are no materials in the system yet.</p>
                                        <a href="{{ route('admin.materiels.create') }}" class="btn btn-primary-green">
                                            <i class="fas fa-plus me-2"></i>Add First Material
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($materiels->hasPages())
            <div class="card-footer bg-light">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted">
                        Showing {{ $materiels->firstItem() }} to {{ $materiels->lastItem() }} of {{ $materiels->total() }} materials
                    </div>
                    {{ $materiels->links() }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
