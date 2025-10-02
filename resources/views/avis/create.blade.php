@extends('layouts.app')

@section('title', 'Donner un avis pour ' . $event->title)

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Header -->
            <div class="mb-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('events.index') }}">Événements</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('events.show', $event->slug) }}">{{ $event->title }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('avis.index', $event->id) }}">Avis</a></li>
                        <li class="breadcrumb-item active">Nouveau</li>
                    </ol>
                </nav>
                
                <h1 class="h2 mb-2">Donner votre avis</h1>
                <p class="text-muted">Partagez votre expérience sur cet événement</p>
            </div>

            <!-- Event Info Card -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        @if($event->featured_image)
                        <img src="{{ asset('storage/' . $event->featured_image) }}" 
                             alt="{{ $event->title }}" 
                             class="rounded me-3" 
                             style="width: 80px; height: 80px; object-fit: cover;">
                        @else
                        <div class="bg-primary rounded me-3 d-flex align-items-center justify-content-center text-white" 
                             style="width: 80px; height: 80px;">
                            <i class="fas fa-calendar-alt fa-2x"></i>
                        </div>
                        @endif
                        
                        <div>
                            <h5 class="mb-1">{{ $event->title }}</h5>
                            <p class="text-muted mb-1">
                                <i class="fas fa-calendar me-1"></i>
                                {{ $event->start_date->format('d/m/Y à H:i') }}
                            </p>
                            @if($event->venue)
                            <p class="text-muted mb-0">
                                <i class="fas fa-map-marker-alt me-1"></i>
                                {{ $event->venue->name }}
                            </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Review Form -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-star me-2"></i>Votre avis
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('avis.store', $event->id) }}" method="POST">
                        @csrf
                        
                        <!-- Rating -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                Note générale <span class="text-danger">*</span>
                            </label>
                            <div class="rating-input d-flex align-items-center">
                                <div class="star-rating me-3">
                                    @for($i = 1; $i <= 5; $i++)
                                    <input type="radio" name="rating" value="{{ $i }}" id="star{{ $i }}" 
                                           class="d-none" required {{ old('rating') == $i ? 'checked' : '' }}>
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
                                   value="{{ old('title') }}"
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
                                      required>{{ old('content') }}</textarea>
                            <div class="form-text">
                                <span id="char-count">0</span>/1000 caractères (minimum 10)
                            </div>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Guidelines -->
                        <div class="alert alert-info">
                            <h6><i class="fas fa-info-circle me-2"></i>Conseils pour un bon avis</h6>
                            <ul class="mb-0 small">
                                <li>Soyez constructif et respectueux</li>
                                <li>Décrivez les aspects concrets de l'événement</li>
                                <li>Mentionnez ce qui vous a marqué (positif ou négatif)</li>
                                <li>Votre avis sera modéré avant publication</li>
                            </ul>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('avis.index', $event->id) }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Retour
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-2"></i>Publier mon avis
                            </button>
                        </div>
                    </form>
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
    border-color: #0d6efd;
    background-color: #f8f9fa;
}

.form-control:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}

.card {
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.card-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
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
                ratingText.classList.add('text-primary', 'fw-bold');
            }
        });
    });
    
    // Initialize rating text if there's a pre-selected value
    const checkedRating = document.querySelector('input[name="rating"]:checked');
    if (checkedRating) {
        ratingText.textContent = ratingTexts[checkedRating.value];
        ratingText.classList.remove('text-muted');
        ratingText.classList.add('text-primary', 'fw-bold');
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