@extends('layouts.admin')

@section('title', 'Products Management')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header mb-4">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="mb-2">
                        <i class="fas fa-box me-2"></i>
                        Products Management
                    </h1>
                    <p class="mb-0 opacity-90">Manage eco-friendly products and inventory</p>
                </div>
                <a href="{{ route('admin.produits.create') }}" class="btn btn-primary-green btn-lg shadow">
                    <i class="fas fa-plus me-2"></i>Add New Product
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
                        <i class="fas fa-box text-white"></i>
                    </div>
                    <div class="text-end">
                        <h2 class="mb-0 fw-bold">{{ $produits->total() }}</h2>
                        <small class="text-muted">Total Products</small>
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
                        <h2 class="mb-0 fw-bold">{{ $produits->where('is_available', true)->count() }}</h2>
                        <small class="text-muted">Available</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stats-card warning">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="icon-circle bg-warning">
                        <i class="fas fa-exclamation-triangle text-white"></i>
                    </div>
                    <div class="text-end">
                        <h2 class="mb-0 fw-bold">{{ $produits->where('stock', '<=', 10)->where('stock', '>', 0)->count() }}</h2>
                        <small class="text-muted">Low Stock</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stats-card danger">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="icon-circle bg-danger">
                        <i class="fas fa-times-circle text-white"></i>
                    </div>
                    <div class="text-end">
                        <h2 class="mb-0 fw-bold">{{ $produits->where('stock', 0)->count() }}</h2>
                        <small class="text-muted">Out of Stock</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.produits.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Search</label>
                    <input type="text" name="search" class="form-control" placeholder="Search by name..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Category</label>
                    <select name="category" class="form-select">
                        <option value="">All Categories</option>
                        @foreach($produits->pluck('category')->unique() as $category)
                            <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>{{ $category }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Stock Status</label>
                    <select name="stock_status" class="form-select">
                        <option value="">All</option>
                        <option value="in_stock" {{ request('stock_status') == 'in_stock' ? 'selected' : '' }}>In Stock</option>
                        <option value="low_stock" {{ request('stock_status') == 'low_stock' ? 'selected' : '' }}>Low Stock</option>
                        <option value="out_of_stock" {{ request('stock_status') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary-green flex-grow-1">
                            <i class="fas fa-filter me-2"></i>Filter
                        </button>
                        <a href="{{ route('admin.produits.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-redo"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Products Table -->
    <div class="card shadow-sm">
        <div class="card-header bg-gradient-success text-white">
            <h5 class="mb-0">
                <i class="fas fa-list me-2"></i>All Products
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
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Sponsor</th>
                            <th>Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($produits as $produit)
                            <tr>
                                <td>
                                    @if($produit->image)
                                        <img src="{{ Storage::url($produit->image) }}" alt="{{ $produit->name }}" class="rounded shadow-sm" style="height: 60px; width: 60px; object-fit: cover;">
                                    @else
                                        <div class="bg-gradient-primary text-white d-flex align-items-center justify-content-center rounded shadow-sm" style="width: 60px; height: 60px;">
                                            <i class="fas fa-box fa-2x"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $produit->name }}</strong><br>
                                    @if($produit->description)
                                        <small class="text-muted">{{ Str::limit($produit->description, 40) }}</small>
                                    @endif
                                </td>
                                <td><span class="badge bg-gradient-info text-white px-3 py-2">{{ $produit->category }}</span></td>
                                <td><strong class="text-success fs-5">{{ $produit->formatted_price }}</strong></td>
                                <td>
                                    @if($produit->stock > 10)
                                        <span class="badge bg-success px-3 py-2">
                                            <i class="fas fa-check-circle me-1"></i>{{ $produit->stock }} units
                                        </span>
                                    @elseif($produit->stock > 0)
                                        <span class="badge bg-warning px-3 py-2">
                                            <i class="fas fa-exclamation-triangle me-1"></i>{{ $produit->stock }} units
                                        </span>
                                    @else
                                        <span class="badge bg-danger px-3 py-2">
                                            <i class="fas fa-times-circle me-1"></i>Out of Stock
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($produit->sponsor)
                                        <small class="badge bg-secondary">{{ $produit->sponsor->name }}</small>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($produit->is_available)
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
                                        <a href="{{ route('admin.produits.show', $produit) }}" class="btn btn-sm btn-info" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.produits.edit', $produit) }}" class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.produits.destroy', $produit) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this product?')">
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
                                <td colspan="8" class="text-center py-5">
                                    <div class="empty-state">
                                        <i class="fas fa-box"></i>
                                        <h5>No Products Found</h5>
                                        <p>There are no products in the system yet.</p>
                                        <a href="{{ route('admin.produits.create') }}" class="btn btn-primary-green">
                                            <i class="fas fa-plus me-2"></i>Add First Product
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($produits->hasPages())
            <div class="card-footer bg-light">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted">
                        Showing {{ $produits->firstItem() }} to {{ $produits->lastItem() }} of {{ $produits->total() }} products
                    </div>
                    {{ $produits->links() }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
