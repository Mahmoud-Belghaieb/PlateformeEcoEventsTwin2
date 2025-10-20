@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Product Image -->
        <div class="col-md-6 mb-4">
            @if($produit->image)
                <img src="{{ Storage::url($produit->image) }}" class="img-fluid rounded shadow" alt="{{ $produit->name }}">
            @else
                <div class="bg-light d-flex align-items-center justify-content-center rounded shadow" style="height: 400px;">
                    <i class="fas fa-box fa-5x text-muted"></i>
                </div>
            @endif
        </div>

        <!-- Product Details -->
        <div class="col-md-6">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('produits.index') }}">Produits</a></li>
                    <li class="breadcrumb-item active">{{ $produit->name }}</li>
                </ol>
            </nav>

            <h1 class="mb-3">{{ $produit->name }}</h1>

            <div class="mb-3">
                <span class="badge bg-info me-2">{{ $produit->category }}</span>
                @if($produit->sponsor)
                    <span class="badge bg-secondary">{{ $produit->sponsor->name }}</span>
                @endif
            </div>

            <h2 class="text-primary mb-4">{{ $produit->formatted_price }}</h2>

            @if($produit->description)
                <div class="mb-4">
                    <h5>Description</h5>
                    <p class="text-muted">{{ $produit->description }}</p>
                </div>
            @endif

            <div class="mb-4">
                <h5>Disponibilité</h5>
                @if($produit->stock > 0)
                    <p class="text-success">
                        <i class="fas fa-check-circle"></i> En stock ({{ $produit->stock }} unités disponibles)
                    </p>
                @else
                    <p class="text-danger">
                        <i class="fas fa-times-circle"></i> Épuisé
                    </p>
                @endif
            </div>

            @if($produit->sponsor && $produit->sponsor->website)
                <div class="mb-4">
                    <h5>Sponsor</h5>
                    <p>
                        <a href="{{ $produit->sponsor->website }}" target="_blank" class="text-decoration-none">
                            {{ $produit->sponsor->name }} <i class="fas fa-external-link-alt small"></i>
                        </a>
                    </p>
                </div>
            @endif

            <!-- Add to Cart Form -->
            @auth
                @if($produit->stock > 0)
                    <form action="{{ route('panier.store') }}" method="POST" class="mb-4">
                        @csrf
                        <input type="hidden" name="produit_id" value="{{ $produit->id }}">
                        
                        <div class="row g-3">
                            <div class="col-auto">
                                <label for="quantity" class="form-label">Quantité</label>
                                <input type="number" name="quantity" id="quantity" class="form-control" value="1" min="1" max="{{ $produit->stock }}" style="width: 100px;">
                            </div>
                            <div class="col-auto align-self-end">
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="fas fa-shopping-cart"></i> Ajouter au panier
                                </button>
                            </div>
                        </div>
                    </form>
                @endif
            @else
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> 
                    Veuillez <a href="{{ route('login') }}">vous connecter</a> pour ajouter ce produit au panier.
                </div>
            @endauth

            <a href="{{ route('produits.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Retour aux produits
            </a>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
        <div class="row mt-5">
            <div class="col-12">
                <h3 class="mb-4">Produits similaires</h3>
            </div>
            @foreach($relatedProducts as $related)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card h-100 shadow-sm">
                        @if($related->image)
                            <img src="{{ Storage::url($related->image) }}" class="card-img-top" alt="{{ $related->name }}" style="height: 150px; object-fit: cover;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center" style="height: 150px;">
                                <i class="fas fa-box fa-2x text-muted"></i>
                            </div>
                        @endif
                        
                        <div class="card-body">
                            <h6 class="card-title">{{ $related->name }}</h6>
                            <p class="text-primary mb-2"><strong>{{ $related->formatted_price }}</strong></p>
                            <a href="{{ route('produits.show', $related) }}" class="btn btn-sm btn-outline-primary w-100">
                                Voir
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

@if(session('success'))
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div class="toast show" role="alert">
            <div class="toast-header bg-success text-white">
                <strong class="me-auto">Succès</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body">
                {{ session('success') }}
            </div>
        </div>
    </div>
@endif
@endsection
