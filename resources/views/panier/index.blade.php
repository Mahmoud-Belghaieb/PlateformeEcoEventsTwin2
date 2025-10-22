@extends('layouts.app')

@section('title', 'Mon Panier')

@section('content')
<div class="container py-5">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="display-5 mb-3 fw-bold text-primary-green">
                <i class="fas fa-shopping-cart me-3"></i>Mon Panier
            </h1>
            <p class="text-muted">Gérez vos articles et finalisez votre commande</p>
        </div>
    </div>

    @if($paniers->count() > 0)
        <div class="row">
            <!-- Cart Items -->
            <div class="col-lg-8 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-gradient-success text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-list me-2"></i>Articles ({{ $paniers->count() }})
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Produit</th>
                                        <th class="text-center">Prix</th>
                                        <th class="text-center">Quantité</th>
                                        <th class="text-center">Sous-total</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($paniers as $item)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($item->produit->image)
                                                        <img src="{{ Storage::url($item->produit->image) }}" 
                                                             alt="{{ $item->produit->name }}" 
                                                             style="width: 70px; height: 70px; object-fit: cover;" 
                                                             class="me-3 rounded shadow-sm">
                                                    @else
                                                        <div class="bg-gradient-primary text-white d-flex align-items-center justify-content-center me-3 rounded shadow-sm" style="width: 70px; height: 70px;">
                                                            <i class="fas fa-box fa-2x"></i>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <strong class="d-block">{{ $item->produit->name }}</strong>
                                                        <small class="text-muted">
                                                            <i class="fas fa-tag me-1"></i>{{ $item->produit->category }}
                                                        </small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-middle text-center">
                                                <strong>{{ number_format($item->price, 2) }} TND</strong>
                                            </td>
                                            <td class="align-middle">
                                                <form action="{{ route('panier.update', $item) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="input-group input-group-sm mx-auto" style="width: 140px;">
                                                        <input type="number" 
                                                               name="quantity" 
                                                               class="form-control text-center" 
                                                               value="{{ $item->quantity }}" 
                                                               min="1" 
                                                               max="{{ $item->produit->stock }}">
                                                        <button type="submit" class="btn btn-outline-primary" title="Mettre à jour">
                                                            <i class="fas fa-sync-alt"></i>
                                                        </button>
                                                    </div>
                                                </form>
                                            </td>
                                            <td class="align-middle text-center">
                                                <strong class="text-primary-green fs-5">{{ $item->formatted_subtotal }}</strong>
                                            </td>
                                            <td class="align-middle text-center">
                                                <form action="{{ route('panier.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('Retirer ce produit du panier?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Supprimer">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer bg-light">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <a href="{{ route('produits.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Continuer mes achats
                            </a>
                            <form action="{{ route('panier.clear') }}" method="POST" class="d-inline" onsubmit="return confirm('Vider tout le panier?')">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger">
                                    <i class="fas fa-trash-alt me-2"></i>Vider le panier
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="card shadow-sm sticky-top" style="top: 20px;">
                    <div class="card-header bg-gradient-warning text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-receipt me-2"></i>Résumé de la commande
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3 pb-3 border-bottom">
                            <span class="text-muted">Sous-total:</span>
                            <strong>{{ number_format($total, 2) }} TND</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-3 pb-3 border-bottom">
                            <span class="text-muted">Livraison:</span>
                            <strong class="text-success">Gratuite</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-4">
                            <h5 class="mb-0">Total:</h5>
                            <h4 class="mb-0 text-primary-green fw-bold">{{ number_format($total, 2) }} TND</h4>
                        </div>
                        
                        <form action="{{ route('panier.checkout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success btn-lg w-100 shadow">
                                <i class="fas fa-check-circle me-2"></i>Valider la commande
                            </button>
                        </form>

                        <div class="alert alert-info mt-3 mb-0 small">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Paiement sécurisé</strong><br>
                            Vos données sont protégées
                        </div>
                    </div>
                </div>

                <!-- Security Features -->
                <div class="card shadow-sm mt-3">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3">
                            <i class="fas fa-shield-alt text-success me-2"></i>Achat sécurisé
                        </h6>
                        <ul class="list-unstyled small mb-0">
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>Paiement sécurisé
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>Livraison gratuite
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>Support client 24/7
                            </li>
                            <li>
                                <i class="fas fa-check text-success me-2"></i>Produits écologiques
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Empty Cart -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm text-center py-5">
                    <div class="card-body">
                        <div class="mb-4">
                            <i class="fas fa-shopping-cart fa-5x text-muted"></i>
                        </div>
                        <h3 class="mb-3">Votre panier est vide</h3>
                        <p class="text-muted mb-4">Ajoutez des produits écologiques pour commencer vos achats!</p>
                        <a href="{{ route('produits.index') }}" class="btn btn-primary-green btn-lg shadow">
                            <i class="fas fa-shopping-bag me-2"></i>Découvrir nos produits
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<style>
    .text-primary-green {
        color: var(--primary-green);
    }
    
    .btn-primary-green {
        background-color: var(--primary-green);
        border-color: var(--primary-green);
        color: white;
    }
    
    .btn-primary-green:hover {
        background-color: #047857;
        border-color: #047857;
        color: white;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(5, 150, 105, 0.05);
    }
</style>
@endsection
