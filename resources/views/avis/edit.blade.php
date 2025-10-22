@extends('layouts.app')

@section('title', 'Modifier votre avis')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Header -->
            <div class="mb-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('events.index') }}">Événements</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('events.show', $avis->event->slug) }}">{{ $avis->event->title }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('avis.index', $avis->event->id) }}">Avis</a></li>
                        <li class="breadcrumb-item active">Modifier</li>
                    </ol>
                </nav>
                
                <h1 class="h2 mb-2">Modifier votre avis</h1>
                <p class="text-muted">Mettez à jour votre expérience</p>
            </div>

            <!-- Event Info Card -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        @if($avis->event->featured_image)
                        <img src="{{ asset('storage/' . $avis->event->featured_image) }}" 
                             alt="{{ $avis->event->title }}" 
                             class="rounded me-3" 
                             style="width: 80px; height: 80px; object-fit: cover;">
                        @else
                        <div class="bg-primary rounded me-3 d-flex align-items-center justify-content-center text-white" 
                             style="width: 80px; height: 80px;">
                            <i class="fas fa-calendar-alt fa-2x"></i>
                        </div>
                        @endif
                        
                        <div>
                            <h5 class="mb-1">{{ $avis->event->title }}</h5>
                            <p class="text-muted mb-1">
                                <i class="fas fa-calendar me-1"></i>
                                {{ $avis->event->start_date->format('d/m/Y à H:i') }}
                            </p>
                            @if($avis->event->venue)
                            <p class="text-muted mb-0">
                                <i class="fas fa-map-marker-alt me-1"></i>
                                {{ $avis->event->venue->name }}
                            </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Form -->
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">
                        <i class="fas fa-edit me-2"></i>Modifier votre avis
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('avis.update', $avis->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <!-- Rating -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                Note générale <span class="text-danger">*</span>
                            </label>
                            <div class="rating-input d-flex align-items-center">
                                <div class="star-rating me-3">
                                    @for($i = 1; $i <= 5; $i++)
                                    <input type="radio" name="rating" value="{{ $i }}" id="star{{ $i }}" 
                                           class="d-none" required 
                                           {{ (old('rating', $avis->rating) == $i) ? 'checked' : '' }}>
                                    <label for="star{{ $i }}" class="star-label">
                                        <i class="fas fa-star"></i>
                                    </label>
                                    @endfor
                                </div>
                                <span class="rating-text text-muted">Cliquez sur les étoiles</span>
                            </div>
                            @error('rating')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Title -->
                        <div class="mb-3">
                            <label for="title" class="form-label fw-bold">
                                Titre de votre avis <span class="text-muted">(optionnel)</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('title') is-invalid @enderror" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title', $avis->title) }}"
                                   maxlength="255"
                                   placeholder="Ex: Une expérience formidable !">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Content -->
                        <div class="mb-4">
                            <label for="content" class="form-label fw-bold">
                                Votre commentaire <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('content') is-invalid @enderror" 
                                      id="content" 
                                      name="content" 
                                      rows="6" 
                                      minlength="10"
                                      maxlength="1000"
                                      placeholder="Décrivez votre expérience, ce qui vous a plu, ce qui pourrait être amélioré..."
                                      required>{{ old('content', $avis->content) }}</textarea>
                            <div class="form-text">
                                <span id="char-count">0</span>/1000 caractères (minimum 10)
                            </div>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Warning about re-moderation -->
                        <div class="alert alert-warning">
                            <h6><i class="fas fa-exclamation-triangle me-2"></i>Important</h6>
                            <p class="mb-0 small">
                                Après modification, votre avis devra être à nouveau modéré avant d'être publié.
                                Cela peut prendre quelques heures.
                            </p>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('avis.index', $avis->event->id) }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Annuler
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save me-2"></i>Mettre à jour
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Current Review Info -->
            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="mb-0">Informations sur votre avis</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Créé le :</strong> {{ $avis->created_at->format('d/m/Y à H:i') }}</p>
                            <p class="mb-1"><strong>Dernière modification :</strong> {{ $avis->updated_at->format('d/m/Y à H:i') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1">
                                <strong>Statut :</strong> 
                                @if($avis->is_approved)
                                    <span class="badge bg-success">Publié</span>
                                @else
                                    <span class="badge bg-warning">En attente de modération</span>
                                @endif
                            </p>
                            @if($avis->is_approved && $avis->approved_by)
                            <p class="mb-0">
                                <strong>Approuvé le :</strong> {{ $avis->approved_at->format('d/m/Y à H:i') }}
                            </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.star-rating {
    display: flex;
    direction: rtl;
}

.star-label {
    color: #ddd;
    font-size: 1.8rem;
    padding: 0 2px;
    cursor: pointer;
    transition: color 0.2s ease;
}

.star-label:hover,
.star-label:hover ~ .star-label {
    color: #ffc107;
}

.star-rating input:checked ~ .star-label {
    color: #ffc107;
}

.rating-input {
    border: 2px solid transparent;
    border-radius: 0.5rem;
    padding: 0.5rem;
    transition: border-color 0.3s ease;
}

.rating-input:focus-within {
    border-color: #ffc107;
    background-color: #fff3cd;
}

.form-control:focus {
    border-color: #ffc107;
    box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25);
}

.card {
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const contentTextarea = document.getElementById('content');
    const charCount = document.getElementById('char-count');
    const ratingText = document.querySelector('.rating-text');
    const starInputs = document.querySelectorAll('input[name="rating"]');
    
    // Character count
    function updateCharCount() {
        const count = contentTextarea.value.length;
        charCount.textContent = count;
        
        if (count < 10) {
            charCount.parentElement.classList.add('text-danger');
            charCount.parentElement.classList.remove('text-success');
        } else {
            charCount.parentElement.classList.remove('text-danger');
            charCount.parentElement.classList.add('text-success');
        }
    }
    
    contentTextarea.addEventListener('input', updateCharCount);
    updateCharCount(); // Initial call
    
    // Rating text update
    const ratingTexts = {
        1: 'Très décevant',
        2: 'Décevant',
        3: 'Correct',
        4: 'Bien',
        5: 'Excellent'
    };
    
    starInputs.forEach(input => {
        input.addEventListener('change', function() {
            if (this.checked) {
                ratingText.textContent = ratingTexts[this.value];
                ratingText.classList.remove('text-muted');
                ratingText.classList.add('text-warning', 'fw-bold');
            }
        });
    });
    
    // Initialize rating text if there's a pre-selected value
    const checkedRating = document.querySelector('input[name="rating"]:checked');
    if (checkedRating) {
        ratingText.textContent = ratingTexts[checkedRating.value];
        ratingText.classList.remove('text-muted');
        ratingText.classList.add('text-warning', 'fw-bold');
    }
    
    // Form validation feedback
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const rating = document.querySelector('input[name="rating"]:checked');
        const content = contentTextarea.value.trim();
        
        if (!rating) {
            e.preventDefault();
            alert('Veuillez sélectionner une note.');
            return;
        }
        
        if (content.length < 10) {
            e.preventDefault();
            alert('Votre commentaire doit contenir au moins 10 caractères.');
            contentTextarea.focus();
            return;
        }
    });
});
</script>
@endpush