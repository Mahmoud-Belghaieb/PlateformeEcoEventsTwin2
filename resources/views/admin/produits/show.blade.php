@extends('layouts.admin')

@section('title', 'Product Details')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="mb-2">
                    <i class="fas fa-box me-2"></i>
                    Product Details
                </h1>
                <p class="mb-0 opacity-90">View complete information about this product</p>
            </div>
            <div>
                <a href="{{ route('admin.produits.edit', $produit) }}" class="btn btn-warning me-2">
                    <i class="fas fa-edit me-2"></i>Edit Product
                </a>
                <a href="{{ route('admin.produits.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Products
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Product Image -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-gradient-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-image me-2"></i>Product Image</h5>
                </div>
                <div class="card-body text-center">
                    @if($produit->image)
                        <img src="{{ asset('storage/' . $produit->image) }}" 
                             alt="{{ $produit->name }}" 
                             class="img-fluid rounded shadow-sm"
                             style="max-height: 400px; object-fit: cover;">
                    @else
                        <div class="bg-gradient-primary text-white d-flex align-items-center justify-content-center rounded" 
                             style="height: 300px;">
                            <i class="fas fa-box fa-5x opacity-50"></i>
                        </div>
                        <p class="text-muted mt-3">No image available</p>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card shadow-sm mt-3">
                <div class="card-header bg-gradient-secondary text-white">
                    <h5 class="mb-0"><i class="fas fa-bolt me-2"></i>Quick Actions</h5>
                </div>
                <div class="card-body">
                    <a href="{{ route('admin.produits.edit', $produit) }}" class="btn btn-warning w-100 mb-2">
                        <i class="fas fa-edit me-2"></i>Edit Product
                    </a>
                    <a href="{{ route('produits.show', $produit) }}" target="_blank" class="btn btn-info w-100 mb-2">
                        <i class="fas fa-eye me-2"></i>View on Website
                    </a>
                    <form action="{{ route('admin.produits.destroy', $produit) }}" method="POST" 
                          onsubmit="return confirm('Are you sure you want to delete this product?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="fas fa-trash me-2"></i>Delete Product
                        </button>
                    </form>
                </div>
            </div>

            <!-- Sponsor Information -->
            @if($produit->sponsor)
            <div class="card shadow-sm mt-3">
                <div class="card-header bg-gradient-info text-white">
                    <h5 class="mb-0"><i class="fas fa-handshake me-2"></i>Sponsored By</h5>
                </div>
                <div class="card-body text-center">
                    @if($produit->sponsor->logo)
                        <img src="{{ asset('storage/' . $produit->sponsor->logo) }}" 
                             alt="{{ $produit->sponsor->name }}" 
                             class="img-fluid rounded mb-2"
                             style="max-height: 80px;">
                    @endif
                    <h6 class="mb-1">{{ $produit->sponsor->name }}</h6>
                    <a href="{{ route('admin.sponsors.show', $produit->sponsor) }}" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-eye me-1"></i>View Sponsor
                    </a>
                </div>
            </div>
            @endif
        </div>

        <!-- Product Information -->
        <div class="col-md-8">
            <!-- Basic Information -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-gradient-success text-white">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Basic Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label class="text-muted small">Product Name</label>
                            <h5 class="mb-0">{{ $produit->name }}</h5>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="text-muted small">Category</label>
                            <h5><span class="badge bg-gradient-info text-white px-3 py-2">{{ $produit->category }}</span></h5>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="text-muted small">Description</label>
                            <p class="mb-0">{{ $produit->description ?? 'No description provided' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pricing & Stock -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-gradient-warning text-white">
                    <h5 class="mb-0"><i class="fas fa-dollar-sign me-2"></i>Pricing & Stock Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="text-muted small">Price</label>
                            <h3 class="text-success mb-0">
                                {{ $produit->formatted_price }}
                            </h3>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="text-muted small">Stock Quantity</label>
                            <h5>
                                @if($produit->stock > 10)
                                    <span class="badge bg-success px-3 py-2 fs-6">
                                        <i class="fas fa-boxes me-1"></i>{{ $produit->stock }} units
                                    </span>
                                @elseif($produit->stock > 0)
                                    <span class="badge bg-warning px-3 py-2 fs-6">
                                        <i class="fas fa-exclamation-triangle me-1"></i>{{ $produit->stock }} units
                                    </span>
                                @else
                                    <span class="badge bg-danger px-3 py-2 fs-6">
                                        <i class="fas fa-times-circle me-1"></i>Out of Stock
                                    </span>
                                @endif
                            </h5>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="text-muted small">Availability</label>
                            <h5>
                                @if($produit->is_available)
                                    <span class="badge bg-success px-3 py-2">
                                        <i class="fas fa-check-circle me-1"></i>Available
                                    </span>
                                @else
                                    <span class="badge bg-danger px-3 py-2">
                                        <i class="fas fa-times-circle me-1"></i>Unavailable
                                    </span>
                                @endif
                            </h5>
                        </div>
                    </div>

                    @if($produit->stock <= 10 && $produit->stock > 0)
                    <div class="alert alert-warning mb-0 mt-3">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Low Stock Alert:</strong> This product has only {{ $produit->stock }} units remaining. Consider restocking soon.
                    </div>
                    @elseif($produit->stock == 0)
                    <div class="alert alert-danger mb-0 mt-3">
                        <i class="fas fa-times-circle me-2"></i>
                        <strong>Out of Stock:</strong> This product is currently unavailable. Please restock immediately.
                    </div>
                    @endif
                </div>
            </div>

            <!-- Sales Statistics -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-gradient-info text-white">
                    <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i>Sales Statistics</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-4 mb-3">
                            <div class="border rounded p-3">
                                <i class="fas fa-shopping-cart fa-2x text-primary mb-2"></i>
                                <h4 class="mb-1">{{ $produit->paniers->count() }}</h4>
                                <small class="text-muted">Total Orders</small>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="border rounded p-3">
                                <i class="fas fa-boxes fa-2x text-success mb-2"></i>
                                <h4 class="mb-1">{{ $produit->paniers->sum('quantity') }}</h4>
                                <small class="text-muted">Units Sold</small>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="border rounded p-3">
                                <i class="fas fa-dollar-sign fa-2x text-warning mb-2"></i>
                                <h4 class="mb-1">{{ number_format($produit->paniers->sum('subtotal'), 2) }} TND</h4>
                                <small class="text-muted">Total Revenue</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Metadata -->
            <div class="card shadow-sm">
                <div class="card-header bg-gradient-dark text-white">
                    <h5 class="mb-0"><i class="fas fa-clock me-2"></i>Metadata</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="text-muted small">Created At</label>
                            <p class="mb-0">
                                <i class="fas fa-calendar-plus me-2 text-primary"></i>
                                {{ $produit->created_at->format('M d, Y - h:i A') }}
                            </p>
                            <small class="text-muted">{{ $produit->created_at->diffForHumans() }}</small>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">Last Updated</label>
                            <p class="mb-0">
                                <i class="fas fa-calendar-edit me-2 text-success"></i>
                                {{ $produit->updated_at->format('M d, Y - h:i A') }}
                            </p>
                            <small class="text-muted">{{ $produit->updated_at->diffForHumans() }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
