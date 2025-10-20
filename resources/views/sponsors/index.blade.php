@extends('layouts.app')

@section('title', 'Nos Sponsors')

@section('content')
<div class="container py-5">
    <!-- Hero Section -->
    <div class="row mb-5">
        <div class="col-12 text-center">
            <h1 class="display-4 mb-3 fw-bold text-primary-green">
                <i class="fas fa-handshake me-3"></i>Nos Sponsors & Partenaires
            </h1>
            <p class="lead text-muted">Découvrez les entreprises qui soutiennent nos initiatives écologiques</p>
        </div>
    </div>

    <!-- Sponsors Grid -->
    <div class="row">
        @forelse($sponsors as $sponsor)
            <div class="col-lg-6 mb-4">
                <div class="card h-100 shadow-sm transform-hover">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 text-center mb-3 mb-md-0">
                                @if($sponsor->logo)
                                    <img src="{{ Storage::url($sponsor->logo) }}" 
                                         alt="{{ $sponsor->name }}" 
                                         class="img-fluid rounded shadow-sm" 
                                         style="max-height: 150px; width: auto;">
                                @else
                                    <div class="bg-gradient-primary text-white d-flex align-items-center justify-content-center rounded shadow-sm" style="height: 150px;">
                                        <i class="fas fa-handshake fa-4x opacity-75"></i>
                                    </div>
                                @endif
                                
                                <div class="mt-3">
                                    @php
                                        $levelColors = [
                                            'platinum' => 'dark',
                                            'gold' => 'warning',
                                            'silver' => 'secondary',
                                            'bronze' => 'light text-dark'
                                        ];
                                        $levelColor = $levelColors[$sponsor->sponsorship_level] ?? 'info';
                                    @endphp
                                    <span class="badge bg-{{ $levelColor }} px-3 py-2 shadow-sm">
                                        <i class="fas fa-award me-1"></i>{{ ucfirst($sponsor->sponsorship_level) }}
                                    </span>
                                </div>
                            </div>
                            
                            <div class="col-md-8">
                                <h3 class="mb-3 fw-bold text-primary-green">{{ $sponsor->name }}</h3>
                                
                                @if($sponsor->description)
                                    <p class="text-muted mb-3">{{ $sponsor->description }}</p>
                                @endif

                                <div class="mb-3">
                                    @if($sponsor->website)
                                        <p class="mb-2">
                                            <i class="fas fa-globe text-primary me-2"></i>
                                            <a href="{{ $sponsor->website }}" target="_blank" class="text-decoration-none fw-semibold">
                                                Visiter le site web <i class="fas fa-external-link-alt small"></i>
                                            </a>
                                        </p>
                                    @endif

                                    @if($sponsor->contact_email)
                                        <p class="mb-2">
                                            <i class="fas fa-envelope text-primary me-2"></i>
                                            <a href="mailto:{{ $sponsor->contact_email }}" class="text-decoration-none">
                                                {{ $sponsor->contact_email }}
                                            </a>
                                        </p>
                                    @endif

                                    @if($sponsor->contact_phone)
                                        <p class="mb-2">
                                            <i class="fas fa-phone text-primary me-2"></i>
                                            <a href="tel:{{ $sponsor->contact_phone }}" class="text-decoration-none">
                                                {{ $sponsor->contact_phone }}
                                            </a>
                                        </p>
                                    @endif
                                </div>

                                @if($sponsor->produits && $sponsor->produits->count() > 0)
                                    <div class="mt-3">
                                        <p class="mb-2 fw-semibold">
                                            <i class="fas fa-box text-info me-2"></i>Produits proposés:
                                        </p>
                                        <div class="d-flex flex-wrap gap-2">
                                            @foreach($sponsor->produits->take(3) as $produit)
                                                <a href="{{ route('produits.show', $produit) }}" class="badge bg-gradient-info text-white text-decoration-none px-3 py-2">
                                                    {{ $produit->name }}
                                                </a>
                                            @endforeach
                                            @if($sponsor->produits->count() > 3)
                                                <span class="badge bg-secondary px-3 py-2">
                                                    +{{ $sponsor->produits->count() - 3 }} autres
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-handshake fa-4x text-muted mb-3"></i>
                        <h4>Aucun sponsor actuellement</h4>
                        <p class="text-muted">Nous travaillons activement à développer nos partenariats.</p>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Call to Action -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card shadow-lg border-0" style="background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));">
                <div class="card-body text-white text-center py-5">
                    <h3 class="mb-3 fw-bold">
                        <i class="fas fa-star me-2"></i>Devenez Sponsor
                    </h3>
                    <p class="lead mb-4">Rejoignez-nous pour soutenir des initiatives écologiques et durables</p>
                    <div class="row justify-content-center mb-4">
                        <div class="col-md-3 mb-3">
                            <div class="bg-white bg-opacity-10 rounded p-3">
                                <i class="fas fa-eye fa-2x mb-2"></i>
                                <h6>Visibilité</h6>
                                <small>Augmentez votre notoriété</small>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="bg-white bg-opacity-10 rounded p-3">
                                <i class="fas fa-leaf fa-2x mb-2"></i>
                                <h6>Impact</h6>
                                <small>Soutenez l'écologie</small>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="bg-white bg-opacity-10 rounded p-3">
                                <i class="fas fa-users fa-2x mb-2"></i>
                                <h6>Communauté</h6>
                                <small>Engagez votre audience</small>
                            </div>
                        </div>
                    </div>
                    <a href="mailto:contact@ecoevents.tn?subject=Demande de partenariat" class="btn btn-light btn-lg shadow">
                        <i class="fas fa-envelope me-2"></i>Nous contacter
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
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
    }
    
    .text-primary-green {
        color: var(--primary-green);
    }
</style>
@endsection
