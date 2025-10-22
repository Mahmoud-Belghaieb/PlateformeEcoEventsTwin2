@extends('layouts.admin')

@section('title', 'Détail de l\'avis')

@section('content')
<div class="page-header">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h3 mb-0 text-white">
                    <i class="fas fa-star me-2"></i>Détail de l'avis
                </h1>
                <p class="text-white-50 mb-0">Modération et détails complets</p>
            </div>
            <a href="{{ route('admin.avis.index') }}" class="btn btn-outline-light">
                <i class="fas fa-arrow-left me-1"></i>Retour à la liste
            </a>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Contenu de l'avis</h5>
                        <div class="rating-display">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $avis->rating)
                                    <i class="fas fa-star text-warning fa-lg"></i>
                                @else
                                    <i class="far fa-star text-muted fa-lg"></i>
                                @endif
                            @endfor
                            <span class="ms-2 h5 mb-0">{{ $avis->rating }}/5</span>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if($avis->title)
                    <h4 class="mb-3">{{ $avis->title }}</h4>
                    @endif
                    
                    <div class="avis-content">
                        <p class="lead">{{ $avis->content }}</p>
                    </div>
                    
                    <!-- Status Actions -->
                    <div class="mt-4 p-3 bg-light rounded">
                        <h6>Actions de modération :</h6>
                        <div class="d-flex gap-2">
                            @if(!$avis->is_approved)
                                <form action="{{ route('admin.avis.approve', $avis->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success" 
                                            onclick="return confirm('Approuver cet avis ?')">
                                        <i class="fas fa-check me-1"></i>Approuver l'avis
                                    </button>
                                </form>
                                <form action="{{ route('admin.avis.reject', $avis->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-warning" 
                                            onclick="return confirm('Rejeter et supprimer cet avis ?')">
                                        <i class="fas fa-times me-1"></i>Rejeter l'avis
                                    </button>
                                </form>
                            @else
                                <div class="alert alert-success mb-0">
                                    <i class="fas fa-check-circle me-2"></i>
                                    Cet avis a été approuvé le {{ $avis->approved_at->format('d/m/Y à H:i') }}
                                    @if($avis->approvedBy)
                                        par {{ $avis->approvedBy->name }}
                                    @endif
                                </div>
                            @endif
                            
                            <form action="{{ route('admin.avis.destroy', $avis->id) }}" method="POST" class="d-inline ms-auto">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" 
                                        onclick="return confirm('Supprimer définitivement cet avis ?')">
                                    <i class="fas fa-trash me-1"></i>Supprimer
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Comments Section -->
            @if($avis->commentaires->count() > 0)
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-comments me-2"></i>
                        Commentaires ({{ $avis->commentaires->count() }})
                    </h5>
                </div>
                <div class="card-body">
                    @foreach($avis->commentaires as $commentaire)
                    <div class="comment-item {{ $commentaire->estReponse() ? 'ms-4' : '' }} mb-3 p-3 border rounded">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div class="d-flex align-items-center">
                                <div class="avatar-circle bg-secondary me-2">
                                    {{ strtoupper(substr($commentaire->user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <strong>{{ $commentaire->user->name }}</strong>
                                    @if($commentaire->estReponse())
                                        <span class="badge bg-info ms-2">Réponse</span>
                                    @endif
                                    <br>
                                    <small class="text-muted">{{ $commentaire->created_at->format('d/m/Y à H:i') }}</small>
                                </div>
                            </div>
                            
                            <div class="comment-actions">
                                @if($commentaire->is_approved)
                                    <span class="badge bg-success">Approuvé</span>
                                @else
                                    <span class="badge bg-warning">En attente</span>
                                    <form action="{{ route('admin.commentaires.approve', $commentaire->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                @endif
                                
                                <form action="{{ route('admin.commentaires.destroy', $commentaire->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" 
                                            onclick="return confirm('Supprimer ce commentaire ?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        
                        <p class="mb-0">{{ $commentaire->content }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
        
        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- User Info -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-user me-2"></i>Auteur de l'avis
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar-circle bg-primary me-3" style="width: 50px; height: 50px;">
                            {{ strtoupper(substr($avis->user->name, 0, 1)) }}
                        </div>
                        <div>
                            <h6 class="mb-0">{{ $avis->user->name }}</h6>
                            <small class="text-muted">{{ $avis->user->email }}</small>
                        </div>
                    </div>
                    
                    <div class="row text-center">
                        <div class="col">
                            <div class="border-end">
                                <div class="h5 mb-0">{{ $avis->user->avis->count() }}</div>
                                <small class="text-muted">Avis donnés</small>
                            </div>
                        </div>
                        <div class="col">
                            <div class="h5 mb-0">{{ $avis->user->registrations->count() }}</div>
                            <small class="text-muted">Événements</small>
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        <a href="{{ route('admin.users.show', $avis->user->id) }}" class="btn btn-outline-primary btn-sm w-100">
                            <i class="fas fa-eye me-1"></i>Voir le profil
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Event Info -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-calendar-alt me-2"></i>Événement concerné
                    </h5>
                </div>
                <div class="card-body">
                    @if($avis->event->featured_image)
                    <img src="{{ asset('storage/' . $avis->event->featured_image) }}" 
                         alt="{{ $avis->event->title }}" 
                         class="img-fluid rounded mb-3">
                    @endif
                    
                    <h6>{{ $avis->event->title }}</h6>
                    <p class="text-muted mb-2">
                        <i class="fas fa-calendar me-1"></i>
                        {{ $avis->event->start_date->format('d/m/Y à H:i') }}
                    </p>
                    
                    @if($avis->event->venue)
                    <p class="text-muted mb-2">
                        <i class="fas fa-map-marker-alt me-1"></i>
                        {{ $avis->event->venue->name }}
                    </p>
                    @endif
                    
                    <div class="row text-center mb-3">
                        <div class="col">
                            <div class="border-end">
                                <div class="h6 mb-0">{{ $avis->event->nombreAvis() }}</div>
                                <small class="text-muted">Avis</small>
                            </div>
                        </div>
                        <div class="col">
                            <div class="h6 mb-0">{{ number_format($avis->event->noteMoyenne(), 1) }}/5</div>
                            <small class="text-muted">Note moy.</small>
                        </div>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.events.show', $avis->event->id) }}" class="btn btn-outline-primary btn-sm flex-fill">
                            <i class="fas fa-eye me-1"></i>Voir
                        </a>
                        <a href="{{ route('avis.index', $avis->event->id) }}" class="btn btn-outline-secondary btn-sm flex-fill" target="_blank">
                            <i class="fas fa-external-link-alt me-1"></i>Public
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Avis Info -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>Informations
                    </h5>
                </div>
                <div class="card-body">
                    <div class="info-item mb-2">
                        <strong>Créé le :</strong><br>
                        <span class="text-muted">{{ $avis->created_at->format('d/m/Y à H:i') }}</span>
                    </div>
                    
                    @if($avis->updated_at != $avis->created_at)
                    <div class="info-item mb-2">
                        <strong>Modifié le :</strong><br>
                        <span class="text-muted">{{ $avis->updated_at->format('d/m/Y à H:i') }}</span>
                    </div>
                    @endif
                    
                    <div class="info-item mb-2">
                        <strong>Statut :</strong><br>
                        @if($avis->is_approved)
                            <span class="badge bg-success">Approuvé</span>
                        @else
                            <span class="badge bg-warning">En attente</span>
                        @endif
                    </div>
                    
                    @if($avis->is_approved && $avis->approved_at)
                    <div class="info-item mb-2">
                        <strong>Approuvé le :</strong><br>
                        <span class="text-muted">{{ $avis->approved_at->format('d/m/Y à H:i') }}</span>
                        @if($avis->approvedBy)
                            <br><small>par {{ $avis->approvedBy->name }}</small>
                        @endif
                    </div>
                    @endif
                    
                    <div class="info-item">
                        <strong>Commentaires :</strong><br>
                        <span class="text-muted">{{ $avis->commentaires->count() }} commentaires</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.avatar-circle {
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: bold;
}

.comment-item {
    transition: all 0.3s ease;
}

.comment-item:hover {
    background-color: #f8f9fa;
}

.rating-display {
    font-size: 1.2rem;
}

.avis-content {
    font-size: 1.1rem;
    line-height: 1.6;
}

.info-item {
    border-bottom: 1px solid #eee;
    padding-bottom: 0.5rem;
}

.info-item:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.card {
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}
</style>
@endpush