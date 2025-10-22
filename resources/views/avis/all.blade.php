@extends('layouts.app')

@section('title', 'Tous les avis')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-md-12">
            <!-- Header -->
            <div class="mb-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('events.index') }}">Événements</a></li>
                        <li class="breadcrumb-item active">Tous les avis</li>
                    </ol>
                </nav>
                
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h2 mb-2">Tous les avis</h1>
                        <p class="text-muted">Découvrez les avis de nos participants sur les différents événements</p>
                    </div>
                </div>
            </div>

            @if($avis->count() > 0)
                <div class="row">
                    @foreach($avis as $avisItem)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <!-- En-tête de l'avis -->
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div class="flex-grow-1">
                                            <h6 class="card-title mb-1">{{ $avisItem->title }}</h6>
                                            <div class="stars mb-2">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $avisItem->rating)
                                                        <i class="fas fa-star text-warning"></i>
                                                    @else
                                                        <i class="far fa-star text-muted"></i>
                                                    @endif
                                                @endfor
                                                <span class="ms-1 text-muted">({{ $avisItem->rating }}/5)</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Événement -->
                                    <div class="mb-2">
                                        <small class="text-muted">
                                            <i class="fas fa-calendar me-1"></i>
                                            <a href="{{ route('events.show', $avisItem->event->slug) }}" class="text-decoration-none">
                                                {{ $avisItem->event->title }}
                                            </a>
                                        </small>
                                    </div>

                                    <!-- Contenu de l'avis -->
                                    <p class="card-text">
                                        {{ Str::limit($avisItem->content, 100) }}
                                    </p>

                                    <!-- Métadonnées -->
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            <i class="fas fa-user me-1"></i>
                                            {{ $avisItem->user->name }}
                                        </small>
                                        <small class="text-muted">
                                            {{ $avisItem->created_at->diffForHumans() }}
                                        </small>
                                    </div>
                                </div>
                                
                                <div class="card-footer bg-white border-0">
                                    <a href="{{ route('events.show', $avisItem->event->slug) }}#avis-{{ $avisItem->id }}" 
                                       class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-eye me-1"></i>
                                        Voir l'événement
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($avis->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $avis->links() }}
                    </div>
                @endif
            @else
                <!-- État vide -->
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-star fa-4x text-muted"></i>
                    </div>
                    <h4 class="mb-3">Aucun avis disponible</h4>
                    <p class="text-muted mb-4">
                        Il n'y a pas encore d'avis publiés. <br>
                        Participez à nos événements et partagez votre expérience !
                    </p>
                    <a href="{{ route('events.index') }}" class="btn btn-primary">
                        <i class="fas fa-calendar me-2"></i>
                        Découvrir nos événements
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Ajouter des effets hover sur les cartes
    const cards = document.querySelectorAll('.card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
            this.style.transition = 'transform 0.3s ease';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
});
</script>
@endpush