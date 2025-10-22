@extends('layouts.admin')

@section('title', 'Cart Orders Management')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header mb-4">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="mb-2">
                        <i class="fas fa-shopping-cart me-2"></i>
                        Cart Orders Management
                    </h1>
                    <p class="mb-0 opacity-90">Manage all customer orders and cart items</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="stats-card">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="icon-circle bg-success">
                        <i class="fas fa-check-circle text-white"></i>
                    </div>
                    <div class="text-end">
                        <h2 class="mb-0 fw-bold">{{ $stats['total_orders'] }}</h2>
                        <small class="text-muted">Total Orders</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="stats-card warning">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="icon-circle bg-warning">
                        <i class="fas fa-clock text-white"></i>
                    </div>
                    <div class="text-end">
                        <h2 class="mb-0 fw-bold">{{ $stats['pending_carts'] }}</h2>
                        <small class="text-muted">Pending Carts</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="stats-card info">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="icon-circle bg-info">
                        <i class="fas fa-lira-sign text-white"></i>
                    </div>
                    <div class="text-end">
                        <h2 class="mb-0 fw-bold">{{ number_format($stats['total_revenue'], 2) }} TND</h2>
                        <small class="text-muted">Total Revenue</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="stats-card">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="icon-circle bg-primary">
                        <i class="fas fa-boxes text-white"></i>
                    </div>
                    <div class="text-end">
                        <h2 class="mb-0 fw-bold">{{ $stats['total_items'] }}</h2>
                        <small class="text-muted">Total Items</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.panier.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="ordered" {{ request('status') == 'ordered' ? 'selected' : '' }}>Ordered</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">User</label>
                    <input type="text" name="user" class="form-control" placeholder="Search by user name or email" value="{{ request('user') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary-green flex-grow-1">
                            <i class="fas fa-filter me-2"></i>Filter
                        </button>
                        <a href="{{ route('admin.panier.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-redo"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="card">
        <div class="card-header bg-gradient-success text-white">
            <h5 class="mb-0">
                <i class="fas fa-list me-2"></i>All Orders
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-gradient-success text-white">
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Subtotal</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($paniers as $panier)
                            <tr>
                                <td><strong>#{{ $panier->id }}</strong></td>
                                <td>
                                    <div>
                                        <strong>{{ $panier->user->name }}</strong><br>
                                        <small class="text-muted">{{ $panier->user->email }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <strong>{{ $panier->produit->name }}</strong><br>
                                        <small class="text-muted">{{ $panier->produit->category }}</small>
                                    </div>
                                </td>
                                <td><span class="badge bg-info">{{ $panier->quantity }} x</span></td>
                                <td>{{ number_format($panier->price, 2) }} TND</td>
                                <td><strong>{{ number_format($panier->subtotal, 2) }} TND</strong></td>
                                <td>
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
                                </td>
                                <td>
                                    <small>{{ $panier->created_at->format('d/m/Y') }}</small><br>
                                    <small class="text-muted">{{ $panier->created_at->format('H:i') }}</small>
                                </td>
                                <td>
                                    <div class="action-buttons d-flex justify-content-center gap-1">
                                        <a href="{{ route('admin.panier.show', $panier) }}" 
                                           class="btn btn-sm btn-info" 
                                           title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        @if($panier->status === 'pending')
                                            <form action="{{ route('admin.panier.update-status', $panier) }}" 
                                                  method="POST" 
                                                  class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="ordered">
                                                <button type="submit" 
                                                        class="btn btn-sm btn-success" 
                                                        title="Mark as Ordered"
                                                        onclick="return confirm('Mark this as ordered?')">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                        @endif

                                        <form action="{{ route('admin.panier.destroy', $panier) }}" 
                                              method="POST" 
                                              class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-sm btn-danger" 
                                                    title="Delete"
                                                    onclick="return confirm('Are you sure you want to delete this order?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-5">
                                    <div class="empty-state">
                                        <i class="fas fa-shopping-cart"></i>
                                        <h5>No Orders Found</h5>
                                        <p>There are no cart orders in the system yet.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($paniers->hasPages())
            <div class="card-footer bg-light">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted">
                        Showing {{ $paniers->firstItem() }} to {{ $paniers->lastItem() }} of {{ $paniers->total() }} orders
                    </div>
                    {{ $paniers->links() }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
