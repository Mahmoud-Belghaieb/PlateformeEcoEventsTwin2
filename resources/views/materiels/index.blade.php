@extends('layouts.app')

@section('title', 'Matériel Disponible')

@section('content')
<div class="container py-5">
    <!-- Hero Section -->
    <div class="row mb-5">
        <div class="col-12 text-center">
            <h1 class="display-4 mb-3 fw-bold text-primary-green">
                <i class="fas fa-tools me-3"></i>Matériel Écologique
            </h1>
            <p class="lead text-muted">Découvrez notre équipement et matériel pour vos événements durables</p>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('materiels.index') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-text bg-white">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" name="search" class="form-control" placeholder="Rechercher du matériel..." value="{{ request('search') }}">
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
                    <div class="col-md-2">
                        <select name="is_available" class="form-select">
                            <option value="">Toutes</option>
                            <option value="1" {{ request('is_available') == '1' ? 'selected' : '' }}>Disponible</option>
                            <option value="0" {{ request('is_available') == '0' ? 'selected' : '' }}>Indisponible</option>
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

    <!-- Materials Grid -->
    <div class="row">
        @forelse($materiels as $materiel)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 shadow-sm transform-hover">
                    @if($materiel->image)
                        <img src="{{ Storage::url($materiel->image) }}" class="card-img-top" alt="{{ $materiel->name }}" style="height: 220px; object-fit: cover;">
                    @else
                        <div class="bg-gradient-primary text-white d-flex align-items-center justify-content-center" style="height: 220px;">
                            <i class="fas fa-tools fa-4x opacity-75"></i>
                        </div>
                    @endif
                    
                    <div class="card-body d-flex flex-column">
                        <div class="mb-3">
                            <span class="badge bg-gradient-info text-white px-3 py-2">
                                <i class="fas fa-tag me-1"></i>{{ $materiel->category }}
                            </span>
                            @if($materiel->is_available)
                                <span class="badge bg-gradient-success text-white px-3 py-2">
                                    <i class="fas fa-check-circle me-1"></i>Disponible
                                </span>
                            @else
                                <span class="badge bg-gradient-secondary text-white px-3 py-2">
                                    <i class="fas fa-ban me-1"></i>Indisponible
                                </span>
                            @endif
                        </div>
                        
                        <h4 class="card-title mb-3 fw-bold">{{ $materiel->name }}</h4>
                        
                        @if($materiel->description)
                            <p class="card-text text-muted flex-grow-1">
                                {{ Str::limit($materiel->description, 120) }}
                            </p>
                        @endif

                        <div class="mt-auto">
                            <hr>
                            <div class="row g-2 text-center mb-3">
                                <div class="col-6">
                                    <small class="text-muted d-block">Quantité</small>
                                    <strong class="text-primary fs-5">{{ $materiel->quantity }}</strong>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted d-block">État</small>
                                    <span class="badge bg-{{ $materiel->condition == 'excellent' ? 'success' : ($materiel->condition == 'good' ? 'info' : 'warning') }}">
                                        {{ ucfirst($materiel->condition) }}
                                    </span>
                                </div>
                            </div>

                            @auth
                                @if($materiel->is_available)
                                    <a href="mailto:contact@ecoevents.tn?subject=Demande de location - {{ $materiel->name }}" 
                                       class="btn btn-primary-green w-100">
                                        <i class="fas fa-envelope me-2"></i>Demander une location
                                    </a>
                                @else
                                    <button class="btn btn-secondary w-100" disabled>
                                        <i class="fas fa-ban me-2"></i>Actuellement indisponible
                                    </button>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="btn btn-primary-green w-100">
                                    <i class="fas fa-sign-in-alt me-2"></i>Connectez-vous pour louer
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-tools fa-4x text-muted mb-3"></i>
                        <h4>Aucun matériel trouvé</h4>
                        <p class="text-muted">Aucun équipement ne correspond à vos critères de recherche.</p>
                        <a href="{{ route('materiels.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-redo me-2"></i>Réinitialiser les filtres
                        </a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($materiels->hasPages())
        <div class="row mt-4">
            <div class="col-12 d-flex justify-content-center">
                {{ $materiels->links() }}
            </div>
        </div>
    @endif

    <!-- Info Section -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card shadow border-0" style="background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));">
                <div class="card-body text-white text-center py-5">
                    <h3 class="mb-3 fw-bold">
                        <i class="fas fa-info-circle me-2"></i>Comment ça marche?
                    </h3>
                    <p class="lead mb-4">Notre matériel écologique est disponible à la location pour vos événements</p>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="bg-white bg-opacity-10 rounded p-4">
                                <i class="fas fa-search fa-3x mb-3"></i>
                                <h5>1. Parcourez</h5>
                                <p class="small mb-0">Découvrez notre catalogue de matériel disponible</p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="bg-white bg-opacity-10 rounded p-4">
                                <i class="fas fa-envelope fa-3x mb-3"></i>
                                <h5>2. Demandez</h5>
                                <p class="small mb-0">Contactez-nous pour réserver le matériel souhaité</p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="bg-white bg-opacity-10 rounded p-4">
                                <i class="fas fa-check-circle fa-3x mb-3"></i>
                                <h5>3. Utilisez</h5>
                                <p class="small mb-0">Profitez du matériel pour votre événement écologique</p>
                            </div>
                        </div>
                    </div>
                    <a href="mailto:contact@ecoevents.tn" class="btn btn-light btn-lg mt-3">
                        <i class="fas fa-paper-plane me-2"></i>Nous contacter
                    </a>
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
</style>
@endsection
