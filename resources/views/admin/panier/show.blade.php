@extends('layouts.admin')

@section('title', 'Order Details')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header mb-4">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="mb-2">
                        <i class="fas fa-shopping-cart me-2"></i>
                        Order #{{ $panier->id }}
                    </h1>
                    <p class="mb-0 opacity-90">View order details and manage status</p>
                </div>
                <a href="{{ route('admin.panier.index') }}" class="btn btn-outline-light">
                    <i class="fas fa-arrow-left me-2"></i>Back to Orders
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Order Information -->
        <div class="col-lg-8 mb-4">
            <div class="card mb-4">
                <div class="card-header bg-gradient-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-box me-2"></i>Product Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Product Name</label>
                            <h5>{{ $panier->produit->name }}</h5>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Category</label>
                            <h5><span class="badge bg-info">{{ $panier->produit->category }}</span></h5>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="text-muted small">Unit Price</label>
                            <h5 class="text-success">{{ number_format($panier->price, 2) }} TND</h5>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="text-muted small">Quantity</label>
                            <h5><span class="badge bg-primary fs-5">{{ $panier->quantity }} x</span></h5>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="text-muted small">Subtotal</label>
                            <h5 class="text-primary fw-bold">{{ number_format($panier->subtotal, 2) }} TND</h5>
                        </div>
                    </div>

                    @if($panier->produit->description)
                        <hr>
                        <div class="mb-3">
                            <label class="text-muted small">Product Description</label>
                            <p class="mb-0">{{ $panier->produit->description }}</p>
                        </div>
                    @endif

                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="text-muted small">Current Stock</label>
                            <h6>
                                @if($panier->produit->stock > 10)
                                    <span class="badge bg-success">{{ $panier->produit->stock }} units</span>
                                @elseif($panier->produit->stock > 0)
                                    <span class="badge bg-warning">{{ $panier->produit->stock }} units (Low Stock)</span>
                                @else
                                    <span class="badge bg-danger">Out of Stock</span>
                                @endif
                            </h6>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">Product Status</label>
                            <h6>
                                @if($panier->produit->is_available)
                                    <span class="badge bg-success">
                                        <i class="fas fa-check-circle me-1"></i>Available
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        <i class="fas fa-ban me-1"></i>Unavailable
                                    </span>
                                @endif
                            </h6>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer Information -->
            <div class="card">
                <div class="card-header bg-gradient-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-user me-2"></i>Customer Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Customer Name</label>
                            <h5>{{ $panier->user->name }}</h5>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Email</label>
                            <h5><a href="mailto:{{ $panier->user->email }}">{{ $panier->user->email }}</a></h5>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">User Role</label>
                            <h6><span class="badge bg-info">{{ ucfirst($panier->user->role) }}</span></h6>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Account Status</label>
                            <h6>
                                @if($panier->user->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Status & Actions -->
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header bg-gradient-warning text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>Order Status
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted small">Current Status</label>
                        <h4>
                            @if($panier->status === 'pending')
                                <span class="badge bg-warning">
                                    <i class="fas fa-clock me-1"></i>Pending
                                </span>
                            @elseif($panier->status === 'ordered')
                                <span class="badge bg-success">
                                    <i class="fas fa-check-circle me-1"></i>Ordered
                                </span>
                            @else
                                <span class="badge bg-danger">
                                    <i class="fas fa-times-circle me-1"></i>Cancelled
                                </span>
                            @endif
                        </h4>
                    </div>

                    <div class="mb-3">
                        <label class="text-muted small">Order Date</label>
                        <p class="mb-0">{{ $panier->created_at->format('F d, Y \a\t H:i') }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="text-muted small">Last Updated</label>
                        <p class="mb-0">{{ $panier->updated_at->diffForHumans() }}</p>
                    </div>

                    <hr>

                    <!-- Status Change Form -->
                    <form action="{{ route('admin.panier.update-status', $panier) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Change Status</label>
                            <select name="status" class="form-select" required>
                                <option value="pending" {{ $panier->status === 'pending' ? 'selected' : '' }}>
                                    Pending
                                </option>
                                <option value="ordered" {{ $panier->status === 'ordered' ? 'selected' : '' }}>
                                    Ordered
                                </option>
                                <option value="cancelled" {{ $panier->status === 'cancelled' ? 'selected' : '' }}>
                                    Cancelled
                                </option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary-green btn-block w-100 mb-2">
                            <i class="fas fa-save me-2"></i>Update Status
                        </button>
                    </form>

                    @if($panier->status === 'ordered')
                        <hr>
                        
                        <!-- Generate Invoice PDF -->
                        <a href="{{ route('admin.panier.invoice-pdf', $panier) }}" 
                           class="btn btn-info btn-block w-100 mb-2"
                           target="_blank">
                            <i class="fas fa-file-pdf me-2"></i>Télécharger Facture PDF
                        </a>
                    @endif

                    <hr>

                    <!-- Delete Form -->
                    <form action="{{ route('admin.panier.destroy', $panier) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="btn btn-danger btn-block w-100"
                                onclick="return confirm('Are you sure you want to delete this order? This action cannot be undone.')">
                            <i class="fas fa-trash me-2"></i>Delete Order
                        </button>
                    </form>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="card">
                <div class="card-header bg-gradient-info text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-link me-2"></i>Quick Links
                    </h6>
                </div>
                <div class="card-body">
                    <a href="{{ route('admin.produits.show', $panier->produit) }}" class="btn btn-outline-info btn-sm w-100 mb-2">
                        <i class="fas fa-box me-2"></i>View Product Details
                    </a>
                    <a href="{{ route('admin.users.show', $panier->user) }}" class="btn btn-outline-primary btn-sm w-100 mb-2">
                        <i class="fas fa-user me-2"></i>View Customer Profile
                    </a>
                    <a href="{{ route('admin.panier.index') }}" class="btn btn-outline-secondary btn-sm w-100">
                        <i class="fas fa-list me-2"></i>All Orders
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
