@extends('layouts.admin')

@section('title', 'Détails du commentaire')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-comment me-2"></i>
                        Détails du commentaire #{{ $commentaire->id }}
                    </h5>
                </div>
                <div class="card-body">
                    <nav aria-label="breadcrumb" class="mb-4">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.commentaires.index') }}">Commentaires</a>
                            </li>
                            <li class="breadcrumb-item active">Détails #{{ $commentaire->id }}</li>
                        </ol>
                    </nav>

                    <div class="row">
                        <div class="col-md-8">
                            <!-- Commentaire principal -->
                            <div class="card mb-4">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-user-circle fa-2x text-primary me-2"></i>
                                        <div>
                                            <strong>{{ $commentaire->user->name }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $commentaire->user->email }}</small>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        @if($commentaire->is_approved)
                                            <span class="badge bg-success">
                                                <i class="fas fa-check me-1"></i>Approuvé
                                            </span>
                                        @else
                                            <span class="badge bg-warning">
                                                <i class="fas fa-clock me-1"></i>En attente
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <p class="mb-0">{{ $commentaire->content }}</p>
                                    </div>
                                    
                                    <div class="row text-muted small">
                                        <div class="col-md-6">
                                            <i class="fas fa-calendar me-1"></i>
                                            Créé le {{ $commentaire->created_at->format('d/m/Y à H:i') }}
                                        </div>
                                        <div class="col-md-6">
                                            @if($commentaire->updated_at != $commentaire->created_at)
                                                <i class="fas fa-edit me-1"></i>
                                                Modifié le {{ $commentaire->updated_at->format('d/m/Y à H:i') }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Avis lié -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h6 class="mb-0">
                                        <i class="fas fa-star me-2"></i>
                                        Avis lié
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6>{{ $commentaire->avis->title ?? 'Sans titre' }}</h6>
                                            <p class="text-muted mb-2">
                                                Par {{ $commentaire->avis->user->name }} 
                                                • {{ $commentaire->avis->rating }}/5 ⭐
                                            </p>
                                            <p class="mb-0">{{ Str::limit($commentaire->avis->content, 200) }}</p>
                                        </div>
                                        <a href="{{ route('avis.index', $commentaire->avis->event_id) }}" 
                                           class="btn btn-outline-primary btn-sm" target="_blank">
                                            <i class="fas fa-external-link-alt me-1"></i>Voir l'avis
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Événement lié -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h6 class="mb-0">
                                        <i class="fas fa-calendar-alt me-2"></i>
                                        Événement lié
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6>{{ $commentaire->avis->event->title }}</h6>
                                            <p class="text-muted mb-2">
                                                <i class="fas fa-calendar me-1"></i>
                                                {{ $commentaire->avis->event->start_date->format('d/m/Y à H:i') }}
                                            </p>
                                            @if($commentaire->avis->event->venue)
                                                <p class="text-muted mb-0">
                                                    <i class="fas fa-map-marker-alt me-1"></i>
                                                    {{ $commentaire->avis->event->venue->name }}
                                                </p>
                                            @endif
                                        </div>
                                        <a href="{{ route('events.show', $commentaire->avis->event->slug) }}" 
                                           class="btn btn-outline-primary btn-sm" target="_blank">
                                            <i class="fas fa-external-link-alt me-1"></i>Voir l'événement
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Commentaire parent (si c'est une réponse) -->
                            @if($commentaire->parent)
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h6 class="mb-0">
                                        <i class="fas fa-reply me-2"></i>
                                        En réponse à
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex align-items-start">
                                        <i class="fas fa-user-circle fa-2x text-secondary me-3"></i>
                                        <div class="flex-grow-1">
                                            <strong>{{ $commentaire->parent->user->name }}</strong>
                                            <small class="text-muted ms-2">
                                                {{ $commentaire->parent->created_at->format('d/m/Y à H:i') }}
                                            </small>
                                            <p class="mt-2 mb-0">{{ $commentaire->parent->content }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Réponses -->
                            @if($commentaire->reponses && $commentaire->reponses->count() > 0)
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h6 class="mb-0">
                                        <i class="fas fa-comments me-2"></i>
                                        Réponses ({{ $commentaire->reponses->count() }})
                                    </h6>
                                </div>
                                <div class="card-body">
                                    @foreach($commentaire->reponses as $reponse)
                                    <div class="d-flex align-items-start mb-3 pb-3 @if(!$loop->last) border-bottom @endif">
                                        <i class="fas fa-user-circle fa-lg text-secondary me-3"></i>
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <strong>{{ $reponse->user->name }}</strong>
                                                <div>
                                                    @if($reponse->is_approved)
                                                        <span class="badge bg-success me-2">Approuvé</span>
                                                    @else
                                                        <span class="badge bg-warning me-2">En attente</span>
                                                    @endif
                                                    <small class="text-muted">{{ $reponse->created_at->format('d/m/Y à H:i') }}</small>
                                                </div>
                                            </div>
                                            <p class="mb-0">{{ $reponse->content }}</p>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>

                        <div class="col-md-4">
                            <!-- Actions -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h6 class="mb-0">
                                        <i class="fas fa-cogs me-2"></i>
                                        Actions
                                    </h6>
                                </div>
                                <div class="card-body">
                                    @if(!$commentaire->is_approved)
                                        <form action="{{ route('admin.commentaires.approve', $commentaire->id) }}" method="POST" class="mb-2">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-success w-100">
                                                <i class="fas fa-check me-1"></i>Approuver
                                            </button>
                                        </form>
                                        
                                        <form action="{{ route('admin.commentaires.reject', $commentaire->id) }}" method="POST" class="mb-2">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-warning w-100" 
                                                    onclick="return confirm('Êtes-vous sûr de vouloir rejeter ce commentaire ?')">
                                                <i class="fas fa-times me-1"></i>Rejeter
                                            </button>
                                        </form>
                                    @endif
                                    
                                    <form action="{{ route('admin.commentaires.destroy', $commentaire->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger w-100" 
                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer définitivement ce commentaire ?')">
                                            <i class="fas fa-trash me-1"></i>Supprimer
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <!-- Informations d'approbation -->
                            @if($commentaire->is_approved && $commentaire->approvedBy)
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h6 class="mb-0">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Informations d'approbation
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <p class="mb-2">
                                        <strong>Approuvé par :</strong><br>
                                        {{ $commentaire->approvedBy->name }}
                                    </p>
                                    <p class="mb-0">
                                        <strong>Date d'approbation :</strong><br>
                                        {{ $commentaire->approved_at->format('d/m/Y à H:i') }}
                                    </p>
                                </div>
                            </div>
                            @endif

                            <!-- Statistiques -->
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">
                                        <i class="fas fa-chart-bar me-2"></i>
                                        Statistiques
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Longueur :</span>
                                        <span>{{ strlen($commentaire->content) }} caractères</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Réponses :</span>
                                        <span>{{ $commentaire->reponses ? $commentaire->reponses->count() : 0 }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span>Type :</span>
                                        <span>{{ $commentaire->parent ? 'Réponse' : 'Commentaire principal' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection