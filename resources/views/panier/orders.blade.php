@extends('layouts.app')

@section('title', 'Mes Commandes')

@section('content')
<div class="container py-5">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold mb-3">
                    <i class="fas fa-receipt me-3" style="color: var(--primary-green);"></i>
                    Mes Commandes
                </h1>
                <p class="lead text-muted">Historique complet de vos achats et commandes</p>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="rounded-circle bg-success bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3" 
                         style="width: 60px; height: 60px;">
                        <i class="fas fa-check-circle text-success fs-4"></i>
                    </div>
                    <h3 class="fw-bold mb-1">{{ $stats['total_orders'] }}</h3>
                    <p class="text-muted mb-0 small">Commandes Validées</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="rounded-circle bg-danger bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3" 
                         style="width: 60px; height: 60px;">
                        <i class="fas fa-times-circle text-danger fs-4"></i>
                    </div>
                    <h3 class="fw-bold mb-1">{{ $stats['cancelled_orders'] }}</h3>
                    <p class="text-muted mb-0 small">Commandes Annulées</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="rounded-circle bg-primary bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3" 
                         style="width: 60px; height: 60px;">
                        <i class="fas fa-boxes text-primary fs-4"></i>
                    </div>
                    <h3 class="fw-bold mb-1">{{ $stats['total_items'] }}</h3>
                    <p class="text-muted mb-0 small">Articles Achetés</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="rounded-circle bg-warning bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3" 
                         style="width: 60px; height: 60px;">
                        <i class="fas fa-lira-sign text-warning fs-4"></i>
                    </div>
                    <h3 class="fw-bold mb-1">{{ number_format($stats['total_spent'], 2) }}</h3>
                    <p class="text-muted mb-0 small">Total Dépensé (TND)</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders List -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-list-alt me-2 text-primary"></i>
                    Historique des Commandes
                </h5>
                <a href="{{ route('panier.index') }}" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-shopping-cart me-2"></i>Retour au Panier
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            @if($orders->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Produit</th>
                                <th class="text-center">Quantité</th>
                                <th class="text-center">Prix Unitaire</th>
                                <th class="text-center">Sous-total</th>
                                <th class="text-center">Statut</th>
                                <th class="text-center">Date</th>
                                <th class="pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            @if($order->produit->image)
                                                <img src="{{ asset('storage/' . $order->produit->image) }}" 
                                                     alt="{{ $order->produit->name }}" 
                                                     class="rounded me-3 shadow-sm" 
                                                     style="width: 60px; height: 60px; object-fit: cover;">
                                            @else
                                                <div class="bg-gradient-primary text-white d-flex align-items-center justify-content-center me-3 rounded shadow-sm" 
                                                     style="width: 60px; height: 60px;">
                                                    <i class="fas fa-box fa-lg"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <h6 class="mb-1 fw-bold">{{ $order->produit->name }}</h6>
                                                <small class="text-muted">{{ $order->produit->category }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-info px-3 py-2">
                                            <i class="fas fa-times me-1"></i>{{ $order->quantity }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <strong>{{ number_format($order->price, 2) }} TND</strong>
                                    </td>
                                    <td class="text-center">
                                        <strong class="text-success fs-5">{{ number_format($order->subtotal, 2) }} TND</strong>
                                    </td>
                                    <td class="text-center">
                                        @if($order->status === 'ordered')
                                            <span class="badge bg-success px-3 py-2">
                                                <i class="fas fa-check-circle me-1"></i>Commandé
                                            </span>
                                        @elseif($order->status === 'cancelled')
                                            <span class="badge bg-danger px-3 py-2">
                                                <i class="fas fa-times-circle me-1"></i>Annulé
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div>
                                            <small class="d-block fw-bold">{{ $order->updated_at->format('d/m/Y') }}</small>
                                            <small class="text-muted">{{ $order->updated_at->format('H:i') }}</small>
                                        </div>
                                        <small class="text-muted fst-italic">{{ $order->updated_at->diffForHumans() }}</small>
                                    </td>
                                    <td class="pe-4">
                                        <a href="{{ route('produits.show', $order->produit) }}" 
                                           class="btn btn-sm btn-outline-primary" 
                                           title="Voir le produit">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-receipt fa-5x text-muted opacity-50"></i>
                    </div>
                    <h5 class="text-muted mb-3">Aucune commande trouvée</h5>
                    <p class="text-muted mb-4">Vous n'avez pas encore passé de commande.</p>
                    <a href="{{ route('produits.index') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-shopping-bag me-2"></i>Découvrir nos Produits
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Payment Information Card -->
    <div class="row mt-5">
        <div class="col-lg-6 mx-auto">
            <div class="card border-0 shadow-sm bg-light">
                <div class="card-body text-center py-4">
                    <i class="fas fa-info-circle fa-2x text-primary mb-3"></i>
                    <h5 class="fw-bold mb-3">Informations de Paiement</h5>
                    <p class="text-muted mb-0">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        Les paiements sont traités de manière sécurisée
                    </p>
                    <p class="text-muted mb-0">
                        <i class="fas fa-shield-alt text-primary me-2"></i>
                        Vos données sont protégées et cryptées
                    </p>
                    <p class="text-muted mb-3">
                        <i class="fas fa-headset text-info me-2"></i>
                        Support client disponible 24/7
                    </p>
                    <div class="d-flex justify-content-center gap-3 mt-4">
                        <i class="fab fa-cc-visa fa-2x text-primary"></i>
                        <i class="fab fa-cc-mastercard fa-2x text-danger"></i>
                        <i class="fab fa-cc-paypal fa-2x text-info"></i>
                        <i class="fas fa-credit-card fa-2x text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('produits.index') }}" class="btn btn-outline-primary">
                    <i class="fas fa-shopping-bag me-2"></i>Continuer mes Achats
                </a>
                <a href="{{ route('panier.index') }}" class="btn btn-primary">
                    <i class="fas fa-shopping-cart me-2"></i>Voir mon Panier
                </a>
                <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-home me-2"></i>Retour à l'Accueil
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
