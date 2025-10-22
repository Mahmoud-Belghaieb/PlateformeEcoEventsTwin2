@extends('layouts.app')

@section('title', 'Avis pour ' . $event->title)

@section('content')
<div class="container my-5">
    <!-- Event Header -->
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('events.index') }}">Événements</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('events.show', $event->slug) }}">{{ $event->title }}</a></li>
                    <li class="breadcrumb-item active">Avis</li>
                </ol>
            </nav>
            
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h1 class="h2 mb-2">Avis pour {{ $event->title }}</h1>
                    <p class="text-muted mb-0">Découvrez l'expérience des participants</p>
                </div>
                
                @if($hasParticipated && !$userAvis)
                <a href="{{ route('avis.create', $event->id) }}" class="btn btn-primary">
                    <i class="fas fa-star me-2"></i>Donner mon avis
                </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Reviews Summary -->
    <div class="row mb-5">
        <div class="col-md-4">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <div class="mb-3">
                        <h2 class="display-4 fw-bold text-primary mb-0">{{ number_format($noteMoyenne, 1) }}</h2>
                        <div class="rating-stars mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= round($noteMoyenne))
                                    <i class="fas fa-star text-warning"></i>
                                @else
                                    <i class="far fa-star text-muted"></i>
                                @endif
                            @endfor
                        </div>
                        <p class="text-muted mb-0">sur 5 étoiles</p>
                        <small class="text-muted">{{ $nombreAvis }} avis</small>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title mb-3">Répartition des notes</h5>
                    @if(!empty($repartitionNotes))
                        @for($i = 5; $i >= 1; $i--)
                        <div class="d-flex align-items-center mb-2">
                            <span class="me-2 fw-medium">{{ $i }}</span>
                            <i class="fas fa-star text-warning me-2"></i>
                            <div class="progress flex-fill me-3" style="height: 8px;">
                                <div class="progress-bar bg-warning" 
                                     style="width: {{ $repartitionNotes[$i]['percentage'] }}%"></div>
                            </div>
                            <small class="text-muted">
                                {{ $repartitionNotes[$i]['count'] }} ({{ $repartitionNotes[$i]['percentage'] }}%)
                            </small>
                        </div>
                        @endfor
                    @else
                        <p class="text-muted">Aucune donnée disponible</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- User's Own Review -->
    @if($userAvis)
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-primary">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-user me-2"></i>Votre avis</h5>
                        <div class="dropdown">
                            <button class="btn btn-light btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-cog"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('avis.edit', $userAvis->id) }}">
                                    <i class="fas fa-edit me-2"></i>Modifier</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('avis.destroy', $userAvis->id) }}" method="POST" 
                                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer votre avis ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-trash me-2"></i>Supprimer
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <div class="rating-stars mb-1">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $userAvis->rating)
                                        <i class="fas fa-star text-warning"></i>
                                    @else
                                        <i class="far fa-star text-muted"></i>
                                    @endif
                                @endfor
                            </div>
                            @if($userAvis->title)
                                <h6 class="fw-bold">{{ $userAvis->title }}</h6>
                            @endif
                        </div>
                        <small class="text-muted">{{ $userAvis->created_at->format('d/m/Y') }}</small>
                    </div>
                    <p class="mb-0">{{ $userAvis->content }}</p>
                    
                    @if(!$userAvis->is_approved)
                        <div class="alert alert-warning mt-3 mb-0">
                            <i class="fas fa-clock me-2"></i>
                            Votre avis est en attente de modération et sera publié sous peu.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- All Reviews -->
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3>Tous les avis ({{ $nombreAvis }})</h3>
                
                <!-- Filter dropdown -->
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-filter me-2"></i>Filtrer
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('avis.index', $event->id) }}">Tous les avis</a></li>
                        <li><hr class="dropdown-divider"></li>
                        @for($i = 5; $i >= 1; $i--)
                        <li><a class="dropdown-item" href="{{ route('avis.index', $event->id) }}?rating={{ $i }}">
                            {{ $i }} étoiles
                        </a></li>
                        @endfor
                    </ul>
                </div>
            </div>

            @forelse($avis as $avi)
            <div class="card mb-4 review-card">
                <div class="card-body">
                    <!-- Review Header -->
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar-circle bg-primary me-3">
                                {{ strtoupper(substr($avi->user->name, 0, 1)) }}
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold">{{ $avi->user->name }}</h6>
                                <div class="rating-stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $avi->rating)
                                            <i class="fas fa-star text-warning"></i>
                                        @else
                                            <i class="far fa-star text-muted"></i>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                        </div>
                        <small class="text-muted">{{ $avi->created_at->diffForHumans() }}</small>
                    </div>

                    <!-- Review Content -->
                    @if($avi->title)
                        <h6 class="fw-bold mb-2">{{ $avi->title }}</h6>
                    @endif
                    <p class="mb-3">{{ $avi->content }}</p>

                    <!-- Comments Section -->
                    @if($avi->commentairesApprouves->count() > 0)
                    <div class="comments-section">
                        <h6 class="text-muted mb-3">
                            <i class="fas fa-comments me-2"></i>
                            Commentaires ({{ $avi->commentairesApprouves->count() }})
                        </h6>
                        
                        @foreach($avi->commentairesApprouves as $commentaire)
                        <div class="comment mb-3 {{ $commentaire->estReponse() ? 'ms-4' : '' }}">
                            <div class="d-flex align-items-start">
                                <div class="avatar-circle bg-secondary me-2" style="width: 32px; height: 32px; font-size: 0.8rem;">
                                    {{ strtoupper(substr($commentaire->user->name, 0, 1)) }}
                                </div>
                                <div class="flex-fill">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <small class="fw-bold">{{ $commentaire->user->name }}</small>
                                        <small class="text-muted">{{ $commentaire->created_at->diffForHumans() }}</small>
                                    </div>
                                    <p class="mb-2" style="font-size: 0.9rem;">{{ $commentaire->content }}</p>
                                    
                                    @auth
                                    @if(!$commentaire->estReponse())
                                    <button class="btn btn-link btn-sm p-0 text-primary reply-btn" 
                                            data-commentaire-id="{{ $commentaire->id }}">
                                        <i class="fas fa-reply me-1"></i>Répondre
                                    </button>
                                    @endif
                                    @endauth
                                </div>
                            </div>
                            
                            <!-- Réponses -->
                            @foreach($commentaire->reponsesApprouvees as $reponse)
                            <div class="comment ms-4 mt-2">
                                <div class="d-flex align-items-start">
                                    <div class="avatar-circle bg-info me-2" style="width: 28px; height: 28px; font-size: 0.75rem;">
                                        {{ strtoupper(substr($reponse->user->name, 0, 1)) }}
                                    </div>
                                    <div class="flex-fill">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <small class="fw-bold">{{ $reponse->user->name }}</small>
                                            <small class="text-muted">{{ $reponse->created_at->diffForHumans() }}</small>
                                        </div>
                                        <p class="mb-0" style="font-size: 0.85rem;">{{ $reponse->content }}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            
                            <!-- Reply Form (Hidden by default) -->
                            @auth
                            @if(!$commentaire->estReponse())
                            <div class="reply-form ms-4 mt-2" id="reply-form-{{ $commentaire->id }}" style="display: none;">
                                <form action="{{ route('commentaires.reply', $commentaire->id) }}" method="POST">
                                    @csrf
                                    <div class="input-group input-group-sm">
                                        <input type="text" class="form-control" name="content" 
                                               placeholder="Votre réponse..." required maxlength="500">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-paper-plane"></i>
                                        </button>
                                        <button type="button" class="btn btn-secondary cancel-reply">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                            @endif
                            @endauth
                        </div>
                        @endforeach
                    </div>
                    @endif

                    <!-- Comment Form -->
                    @auth
                    <div class="comment-form mt-3">
                        <form action="{{ route('commentaires.store', $avi->id) }}" method="POST">
                            @csrf
                            <div class="input-group">
                                <input type="text" class="form-control" name="content" 
                                       placeholder="Ajouter un commentaire..." required maxlength="500">
                                <button type="submit" class="btn btn-outline-primary">
                                    <i class="fas fa-paper-plane me-1"></i>Commenter
                                </button>
                            </div>
                        </form>
                    </div>
                    @else
                    <div class="text-center mt-3">
                        <a href="{{ route('login') }}" class="btn btn-outline-primary">
                            Connectez-vous pour commenter
                        </a>
                    </div>
                    @endauth
                </div>
            </div>
            @empty
            <div class="text-center py-5">
                <i class="fas fa-star fa-3x text-muted mb-3"></i>
                <h4>Aucun avis pour le moment</h4>
                <p class="text-muted">Soyez le premier à partager votre expérience !</p>
                
                @if($hasParticipated && !$userAvis)
                <a href="{{ route('avis.create', $event->id) }}" class="btn btn-primary">
                    <i class="fas fa-star me-2"></i>Donner mon avis
                </a>
                @endif
            </div>
            @endforelse

            <!-- Pagination -->
            @if($avis->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $avis->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.avatar-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: bold;
}

.rating-stars {
    font-size: 1.1em;
}

.review-card {
    transition: all 0.3s ease;
}

.review-card:hover {
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.comment {
    background: #f8f9fa;
    border-radius: 0.5rem;
    padding: 0.75rem;
}

.comment-form .input-group {
    border-radius: 1.5rem;
}

.comment-form .form-control {
    border-radius: 1.5rem 0 0 1.5rem;
    border: 1px solid #e0e0e0;
}

.comment-form .btn {
    border-radius: 0 1.5rem 1.5rem 0;
}

.reply-form .input-group-sm .form-control {
    border-radius: 1rem 0 0 1rem;
}

.reply-form .input-group-sm .btn {
    border-radius: 0 1rem 1rem 0;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle reply buttons
    document.querySelectorAll('.reply-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const commentaireId = this.dataset.commentaireId;
            const replyForm = document.getElementById(`reply-form-${commentaireId}`);
            
            // Hide all other reply forms
            document.querySelectorAll('.reply-form').forEach(form => {
                if (form.id !== `reply-form-${commentaireId}`) {
                    form.style.display = 'none';
                }
            });
            
            // Toggle current reply form
            replyForm.style.display = replyForm.style.display === 'none' ? 'block' : 'none';
            
            if (replyForm.style.display === 'block') {
                replyForm.querySelector('input[name="content"]').focus();
            }
        });
    });
    
    // Handle cancel reply buttons
    document.querySelectorAll('.cancel-reply').forEach(btn => {
        btn.addEventListener('click', function() {
            this.closest('.reply-form').style.display = 'none';
        });
    });
});
</script>
@endpush