@extends('layouts.app')

@section('title', 'Boutique Écologique')

@section('content')
<div class="container py-5">
    <!-- Hero Section -->
    <div class="row mb-5">
        <div class="col-12 text-center">
            <h1 class="display-4 mb-3 fw-bold text-primary-green">
                <i class="fas fa-shopping-bag me-3"></i>Boutique Écologique
            </h1>
            <p class="lead text-muted">Découvrez nos produits écologiques et durables pour un mode de vie responsable</p>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('produits.index') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text bg-white">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" name="search" class="form-control" placeholder="Rechercher un produit..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select name="category" class="form-select">
                            <option value="">Toutes les catégories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                    {{ $category }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="sponsor_id" class="form-select">
                            <option value="">Tous les sponsors</option>
                            @foreach($sponsors as $sponsor)
                                <option value="{{ $sponsor->id }}" {{ request('sponsor_id') == $sponsor->id ? 'selected' : '' }}>
                                    {{ $sponsor->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary-green w-100">
                            <i class="fas fa-filter me-2"></i>Filtrer
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="row">
        @forelse($produits as $produit)
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="card h-100 shadow-sm transform-hover">
                    @if($produit->image)
                        <img src="{{ Storage::url($produit->image) }}" class="card-img-top" alt="{{ $produit->name }}" style="height: 220px; object-fit: cover;">
                    @else
                        <div class="bg-gradient-primary text-white d-flex align-items-center justify-content-center" style="height: 220px;">
                            <i class="fas fa-box fa-4x opacity-75"></i>
                        </div>
                    @endif
                    
                    <div class="card-body d-flex flex-column">
                        <div class="mb-2">
                            <span class="badge bg-gradient-info text-white px-2 py-1">{{ $produit->category }}</span>
                            @if($produit->sponsor)
                                <span class="badge bg-gradient-secondary text-white px-2 py-1">{{ $produit->sponsor->name }}</span>
                            @endif
                        </div>
                        
                        <h5 class="card-title fw-bold mb-2">{{ $produit->name }}</h5>
                        <p class="card-text text-muted small flex-grow-1">{{ Str::limit($produit->description, 80) }}</p>
                        
                        <div class="mt-auto">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4 class="text-primary-green mb-0 fw-bold">{{ $produit->formatted_price }}</h4>
                                <small class="text-muted">
                                    <i class="fas fa-box me-1"></i>{{ $produit->stock }}
                                </small>
                            </div>
                            
                            <div class="d-flex gap-2">
                                <a href="{{ route('produits.show', $produit) }}" class="btn btn-outline-primary btn-sm flex-grow-1">
                                    <i class="fas fa-eye"></i> Voir
                                </a>
                                @auth
                                    @if($produit->stock > 0)
                                        <form action="{{ route('panier.store') }}" method="POST" class="flex-grow-1">
                                            @csrf
                                            <input type="hidden" name="produit_id" value="{{ $produit->id }}">
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="btn btn-success btn-sm w-100">
                                                <i class="fas fa-cart-plus"></i>
                                            </button>
                                        </form>
                                    @else
                                        <button class="btn btn-secondary btn-sm flex-grow-1" disabled>
                                            <i class="fas fa-ban"></i> Épuisé
                                        </button>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-success btn-sm flex-grow-1" title="Connectez-vous pour ajouter au panier">
                                        <i class="fas fa-cart-plus"></i>
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-shopping-bag fa-4x text-muted mb-3"></i>
                        <h4>Aucun produit trouvé</h4>
                        <p class="text-muted">Aucun produit ne correspond à vos critères de recherche.</p>
                        <a href="{{ route('produits.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-redo me-2"></i>Réinitialiser les filtres
                        </a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($produits->hasPages())
        <div class="row mt-4">
            <div class="col-12 d-flex justify-content-center">
                {{ $produits->links() }}
            </div>
        </div>
    @endif

    <!-- Features Section -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card shadow-lg border-0" style="background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));">
                <div class="card-body text-white text-center py-5">
                    <h3 class="mb-4 fw-bold">
                        <i class="fas fa-leaf me-2"></i>Pourquoi choisir nos produits?
                    </h3>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="bg-white bg-opacity-10 rounded p-4">
                                <i class="fas fa-recycle fa-3x mb-3"></i>
                                <h5>Écologiques</h5>
                                <p class="small mb-0">Des produits respectueux de l'environnement</p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="bg-white bg-opacity-10 rounded p-4">
                                <i class="fas fa-award fa-3x mb-3"></i>
                                <h5>Qualité</h5>
                                <p class="small mb-0">Sélection rigoureuse de produits durables</p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="bg-white bg-opacity-10 rounded p-4">
                                <i class="fas fa-heart fa-3x mb-3"></i>
                                <h5>Impact</h5>
                                <p class="small mb-0">Chaque achat soutient des initiatives vertes</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .transform-hover {
        transition: all 0.3s ease;
    }
    
    .transform-hover:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 30px rgba(0,0,0,0.15) !important;
    }
    
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
</style>
@endsection
