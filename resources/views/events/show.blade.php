<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $event->title }} - EcoEvents</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <style>
        :root {
            --primary-green: #059669;
            --secondary-green: #10b981;
            --accent-orange: #f97316;
            --dark-text: #1f2937;
            --light-text: #6b7280;
            --background: #f9fafb;
            --white: #ffffff;
            --shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background: var(--background);
            line-height: 1.6;
        }

        .hero-banner {
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--secondary-green) 100%);
            color: white;
            padding: 3rem 0;
        }

        .card {
            border: none;
            box-shadow: var(--shadow);
            border-radius: 16px;
            overflow: hidden;
        }

        .btn-success {
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            border: none;
            border-radius: 12px;
            font-weight: 600;
            padding: 12px 30px;
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(5, 150, 105, 0.4);
        }

        .info-item {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            box-shadow: var(--shadow);
        }

        .rocket-icon {
            color: var(--accent-orange);
            font-size: 1.5rem;
        }

        /* Rating System Styles */
        .rating-input {
            display: flex;
            flex-direction: row-reverse;
            justify-content: flex-end;
        }

        .rating-input input[type="radio"] {
            display: none;
        }

        .rating-input .star-label {
            cursor: pointer;
            font-size: 1.5rem;
            color: #ddd;
            transition: color 0.2s;
            margin-right: 0.2rem;
        }

        .rating-input input[type="radio"]:checked ~ .star-label,
        .rating-input .star-label:hover,
        .rating-input .star-label:hover ~ .star-label {
            color: var(--accent-orange);
        }

        .avis-item {
            transition: all 0.3s ease;
        }

        .avis-item:hover {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 1rem;
            margin: -1rem;
            margin-bottom: 1rem;
        }

        .commentaire-item {
            border-left: 3px solid var(--primary-green);
        }

        .reponse-item {
            border-left: 2px solid var(--accent-orange);
        }

        /* Social Media Sharing Styles */
        .social-share-btn {
            transition: all 0.3s ease;
            border-radius: 8px;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 40px;
            height: 40px;
        }

        .social-share-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .api-share-form {
            margin: 0;
        }

        .api-share-form button {
            transition: all 0.3s ease;
            border-radius: 8px;
            font-weight: 500;
            border: none;
            width: 100%;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.875rem;
        }

        .api-share-form button:hover {
            transform: translateY(-1px);
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.2);
        }

        .api-share-form button:active {
            transform: translateY(0);
        }

        .btn-facebook {
            background: linear-gradient(135deg, #1877f2, #42a5f5);
            color: white;
        }

        .btn-facebook:hover {
            background: linear-gradient(135deg, #166fe5, #1976d2);
            color: white;
        }

        .btn-instagram {
            background: linear-gradient(135deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
            color: white;
        }

        .btn-instagram:hover {
            background: linear-gradient(135deg, #d6822f 0%, #c85a35 25%, #c0243a 50%, #b0225f 75%, #a11881 100%);
            color: white;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}" style="color: var(--primary-green);">
                <i class="fas fa-rocket rocket-icon me-2"></i>
                EcoEvents
            </a>
            
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="{{ route('events.index') }}">
                    <i class="fas fa-arrow-left me-1"></i>Retour aux événements
                </a>
                @auth
                    <a class="nav-link" href="{{ route('home') }}">
                        <i class="fas fa-home me-1"></i>Accueil
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero Banner -->
    <section class="hero-banner">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <h1 class="display-5 fw-bold mb-3">{{ $event->title }}</h1>
                    <p class="lead">{{ $event->description }}</p>
                    
                    <div class="d-flex flex-wrap gap-3 mt-4">
                        <span class="badge bg-warning fs-6 px-3 py-2">{{ $event->category->name ?? 'Général' }}</span>
                        <span class="badge bg-light text-dark fs-6 px-3 py-2">
                            <i class="fas fa-calendar me-1"></i>
                            {{ \Carbon\Carbon::parse($event->start_date)->format('d/m/Y à H:i') }}
                        </span>
                        <span class="badge bg-light text-dark fs-6 px-3 py-2">
                            <i class="fas fa-users me-1"></i>
                            {{ $event->max_participants }} participants max
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="container my-5">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header bg-white">
                        <h3 class="mb-0">
                            <i class="fas fa-info-circle me-2" style="color: var(--primary-green);"></i>
                            Détails de l'événement
                        </h3>
                    </div>
                    <div class="card-body">
                        <p class="fs-5">{{ $event->description }}</p>
                        
                        <hr>
                        
                        <h5>
                            <i class="fas fa-bullseye me-2" style="color: var(--accent-orange);"></i>
                            Objectifs de l'événement
                        </h5>
                        <ul>
                            <li>Nettoyer et préserver l'environnement marin</li>
                            <li>Sensibiliser le public à la pollution plastique</li>
                            <li>Créer une communauté engagée pour l'écologie</li>
                            <li>Collecter et trier les déchets de manière responsable</li>
                        </ul>
                    </div>
                </div>

                <!-- What to bring -->
                <div class="card">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">
                            <i class="fas fa-backpack me-2" style="color: var(--primary-green);"></i>
                            À apporter
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <ul class="list-unstyled">
                                    <li><i class="fas fa-check-circle text-success me-2"></i>Vêtements confortables</li>
                                    <li><i class="fas fa-check-circle text-success me-2"></i>Chaussures fermées</li>
                                    <li><i class="fas fa-check-circle text-success me-2"></i>Bouteille d'eau</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="list-unstyled">
                                    <li><i class="fas fa-gift text-warning me-2"></i>Gants fournis</li>
                                    <li><i class="fas fa-gift text-warning me-2"></i>Sacs de collecte fournis</li>
                                    <li><i class="fas fa-gift text-warning me-2"></i>Collation prévue</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Avis et Commentaires Section -->
                <div class="card mt-4">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="fas fa-star me-2" style="color: var(--accent-orange);"></i>
                            Avis des participants
                        </h4>
                        
                        @if($avisStats['total'] > 0)
                            <div class="d-flex align-items-center">
                                <div class="text-center me-3">
                                    <div class="fs-2 fw-bold" style="color: var(--accent-orange);">{{ $avisStats['moyenne'] }}</div>
                                    <div class="text-muted small">sur 5</div>
                                </div>
                                <div>
                                    <div class="stars mb-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $avisStats['moyenne'])
                                                <i class="fas fa-star" style="color: var(--accent-orange);"></i>
                                            @else
                                                <i class="far fa-star text-muted"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <div class="text-muted small">{{ $avisStats['total'] }} avis</div>
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    <div class="card-body">
                        @auth
                            {{-- Temporairement, on permet à tous les utilisateurs connectés d'ajouter un avis pour les tests --}}
                            @if(true)
                                <!-- Formulaire pour donner un avis -->
                                <div class="alert alert-light border-0 mb-4" style="background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);">
                                    <h6 class="mb-3">
                                        <i class="fas fa-pencil-alt me-2" style="color: var(--primary-green);"></i>
                                        Donnez votre avis sur cet événement
                                    </h6>
                                    
                                    <form method="POST" action="{{ route('avis.store', $event) }}">
                                        @csrf
                                        <input type="hidden" name="event_id" value="{{ $event->id }}">
                                        
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="rating" class="form-label">Note <span class="text-danger">*</span></label>
                                                <div class="rating-input">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <input type="radio" name="rating" value="{{ $i }}" id="star{{ $i }}" required>
                                                        <label for="star{{ $i }}" class="star-label">
                                                            <i class="fas fa-star"></i>
                                                        </label>
                                                    @endfor
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="title" class="form-label">Titre de l'avis <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="title" name="title" required maxlength="255" placeholder="Résumez votre expérience en quelques mots">
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="content" class="form-label">Votre avis <span class="text-danger">*</span></label>
                                            <textarea class="form-control" id="content" name="content" rows="4" required maxlength="1000" placeholder="Partagez votre expérience, ce que vous avez aimé ou moins aimé..."></textarea>
                                        </div>
                                        
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-paper-plane me-2"></i>
                                            Publier mon avis
                                        </button>
                                    </form>
                                </div>
                            @else
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Vous devez être inscrit à cet événement pour donner votre avis.
                                </div>
                            @endif
                        @else
                            <div class="alert alert-warning">
                                <i class="fas fa-sign-in-alt me-2"></i>
                                <a href="{{ route('login') }}" class="text-decoration-none">Connectez-vous</a> pour donner votre avis sur cet événement.
                            </div>
                        @endauth
                        
                        <!-- Liste des avis -->
                        @if($avis->count() > 0)
                            <div class="avis-list">
                                @foreach($avis as $avisItem)
                                    <div class="avis-item border-bottom pb-4 mb-4">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <h6 class="mb-1">{{ $avisItem->title }}</h6>
                                                <div class="d-flex align-items-center mb-2">
                                                    <div class="stars me-2">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            @if($i <= $avisItem->rating)
                                                                <i class="fas fa-star" style="color: var(--accent-orange);"></i>
                                                            @else
                                                                <i class="far fa-star text-muted"></i>
                                                            @endif
                                                        @endfor
                                                    </div>
                                                    <small class="text-muted">
                                                        par {{ $avisItem->user->name }} • {{ $avisItem->created_at->diffForHumans() }}
                                                    </small>
                                                </div>
                                            </div>
                                            
                                            @auth
                                                @if($avisItem->user_id === Auth::id())
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                            <i class="fas fa-ellipsis-h"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item" href="{{ route('avis.edit', $avisItem->id) }}">
                                                                <i class="fas fa-edit me-2"></i>Modifier
                                                            </a></li>
                                                            <li><hr class="dropdown-divider"></li>
                                                            <li>
                                                                <form method="POST" action="{{ route('avis.destroy', $avisItem->id) }}" class="d-inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet avis ?')">
                                                                        <i class="fas fa-trash me-2"></i>Supprimer
                                                                    </button>
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                @endif
                                            @endauth
                                        </div>
                                        
                                        <p class="mb-3">{{ $avisItem->content }}</p>
                                        
                                        <!-- Commentaires -->
                                        @if($avisItem->commentaires->count() > 0)
                                            <div class="commentaires-section mt-3">
                                                <h6 class="mb-3">
                                                    <i class="fas fa-comments me-2" style="color: var(--primary-green);"></i>
                                                    Commentaires ({{ $avisItem->commentaires->count() }})
                                                </h6>
                                                
                                                @foreach($avisItem->commentaires->where('parent_id', null) as $commentaire)
                                                    <div class="commentaire-item bg-light rounded p-3 mb-2">
                                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                                            <small class="text-muted">
                                                                <strong>{{ $commentaire->user->name }}</strong> • {{ $commentaire->created_at->diffForHumans() }}
                                                            </small>
                                                            
                                                            @auth
                                                                @if($commentaire->user_id === Auth::id())
                                                                    <div class="dropdown">
                                                                        <button class="btn btn-sm btn-link text-muted p-0" type="button" data-bs-toggle="dropdown">
                                                                            <i class="fas fa-ellipsis-h"></i>
                                                                        </button>
                                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                                            <li>
                                                                                <form method="POST" action="{{ route('commentaires.destroy', $commentaire->id) }}" class="d-inline">
                                                                                    @csrf
                                                                                    @method('DELETE')
                                                                                    <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Supprimer ce commentaire ?')">
                                                                                        <i class="fas fa-trash me-2"></i>Supprimer
                                                                                    </button>
                                                                                </form>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                @endif
                                                            @endauth
                                                        </div>
                                                        
                                                        <p class="mb-0">{{ $commentaire->content }}</p>
                                                        
                                                        <!-- Réponses au commentaire -->
                                                        @foreach($avisItem->commentaires->where('parent_id', $commentaire->id) as $reponse)
                                                            <div class="reponse-item bg-white rounded p-2 mt-2 ms-3">
                                                                <small class="text-muted">
                                                                    <strong>{{ $reponse->user->name }}</strong> • {{ $reponse->created_at->diffForHumans() }}
                                                                </small>
                                                                <p class="mb-0 mt-1">{{ $reponse->content }}</p>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                        
                                        <!-- Formulaire d'ajout de commentaire -->
                                        @auth
                                            <div class="add-comment mt-3">
                                                <form method="POST" action="{{ route('commentaires.store', $avisItem) }}" class="row g-2">
                                                    @csrf
                                                    <input type="hidden" name="avis_id" value="{{ $avisItem->id }}">
                                                    <div class="col-md-10">
                                                        <textarea name="content" class="form-control form-control-sm" rows="2" placeholder="Ajouter un commentaire..." required maxlength="500"></textarea>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <button type="submit" class="btn btn-sm btn-outline-primary w-100">
                                                            <i class="fas fa-paper-plane"></i>
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        @endauth
                                    </div>
                                @endforeach
                                
                                <!-- Pagination -->
                                @if($avis->hasPages())
                                    <div class="d-flex justify-content-center">
                                        {{ $avis->links() }}
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-star fa-3x text-muted mb-3"></i>
                                <h6 class="text-muted">Aucun avis pour le moment</h6>
                                <p class="text-muted">Soyez le premier à partager votre expérience !</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Event Info -->
                <div class="info-item">
                    <h5 class="mb-3">
                        <i class="fas fa-calendar-alt me-2" style="color: var(--primary-green);"></i>
                        Informations pratiques
                    </h5>
                    
                    <div class="mb-3">
                        <strong>📅 Date et heure :</strong><br>
                        Du {{ \Carbon\Carbon::parse($event->start_date)->format('d/m/Y à H:i') }}<br>
                        au {{ \Carbon\Carbon::parse($event->end_date)->format('d/m/Y à H:i') }}
                    </div>
                    
                    <div class="mb-3">
                        <strong>📍 Lieu :</strong><br>
                        {{ $event->venue->name ?? 'Lieu à confirmer' }}
                        @if($event->venue && $event->venue->full_address)
                            <br><small class="text-muted">{{ $event->venue->full_address }}</small>
                        @endif
                    </div>
                    
                    <div class="mb-3">
                        <strong>👥 Participants :</strong><br>
                        Maximum {{ $event->max_participants }} personnes
                    </div>
                    
                    <div class="mb-3">
                        <strong>💰 Prix :</strong><br>
                        @if($event->price > 0)
                            {{ number_format($event->price, 2) }} TND
                        @else
                            <span class="text-success fw-bold">Gratuit</span>
                        @endif
                    </div>
                </div>

                <!-- Registration -->
                <div class="info-item text-center">
                    @auth
                        @if($isRegistered)
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle me-2"></i>
                                Vous êtes déjà inscrit à cet événement !
                            </div>
                        @else
                            <h5 class="mb-3">Rejoignez-nous !</h5>
                            <form method="POST" action="{{ route('events.register', $event->id) }}">
                                @csrf
                                <input type="hidden" name="type" value="participant">
                                <button type="submit" class="btn btn-success btn-lg w-100">
                                    <i class="fas fa-hand-paper me-2"></i>
                                    S'inscrire maintenant
                                </button>
                            </form>
                            <small class="text-muted mt-2 d-block">
                                Inscription gratuite et sans engagement
                            </small>
                        @endif
                    @else
                        <h5 class="mb-3">Rejoignez-nous !</h5>
                        <p class="text-muted mb-3">Connectez-vous pour vous inscrire à cet événement</p>
                        <a href="{{ route('login') }}" class="btn btn-success btn-lg w-100">
                            <i class="fas fa-sign-in-alt me-2"></i>
                            Se connecter
                        </a>
                        <div class="mt-2">
                            <small class="text-muted">
                                Pas encore de compte ? 
                                <a href="{{ route('register') }}" class="text-decoration-none">Créer un compte</a>
                            </small>
                        </div>
                    @endauth
                </div>

                <!-- Social Sharing -->
                <div class="info-item">
                    <h6 class="mb-3">
                        <i class="fas fa-share-alt me-2" style="color: var(--primary-green);"></i>
                        Partager cet événement
                    </h6>

                    <!-- API-based Social Media Posting (for authenticated users) -->
                    @auth
                        <div class="mb-3">
                            <small class="text-muted d-block mb-2">Publier directement sur les réseaux sociaux :</small>
                            <div class="d-flex gap-2 mb-2">
                                <form action="{{ route('events.share.social', [$event, 'facebook']) }}" method="POST" class="flex-fill api-share-form">
                                    @csrf
                                    <button type="submit" class="btn btn-facebook" title="Publier sur Facebook">
                                        <i class="fab fa-facebook-f me-1"></i>Facebook
                                    </button>
                                </form>
                                <form action="{{ route('events.share.social', [$event, 'instagram']) }}" method="POST" class="flex-fill api-share-form">
                                    @csrf
                                    <button type="submit" class="btn btn-instagram" title="Publier sur Instagram">
                                        <i class="fab fa-instagram me-1"></i>Instagram
                                    </button>
                                </form>
                            </div>
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Publication directe sur votre page/compte professionnel
                            </small>
                        </div>
                        <hr class="my-3">
                    @endauth

                    <!-- URL-based Social Sharing Links -->
                    <div class="mb-2">
                        <small class="text-muted d-block mb-2">Partager le lien sur les réseaux sociaux :</small>
                        <div class="d-flex flex-wrap gap-2">
                            <!-- Facebook Share -->
                            <a href="{{ route('events.share.facebook', $event->slug) }}"
                               target="_blank"
                               class="social-share-btn btn-outline-primary"
                               title="Partager sur Facebook"
                               onclick="trackShare('facebook')">
                                <i class="fab fa-facebook-f"></i>
                            </a>

                            <!-- Instagram Share -->
                            <a href="#"
                               class="social-share-btn btn-outline-danger"
                               title="Partager sur Instagram"
                               onclick="shareToInstagram(); return false;">
                                <i class="fab fa-instagram"></i>
                            </a>

                            <!-- Twitter Share -->
                            <a href="{{ route('events.share.twitter', $event->slug) }}"
                               target="_blank"
                               class="social-share-btn btn-outline-info"
                               title="Partager sur Twitter"
                               onclick="trackShare('twitter')">
                                <i class="fab fa-twitter"></i>
                            </a>

                            <!-- LinkedIn Share -->
                            <a href="{{ route('events.share.linkedin', $event->slug) }}"
                               target="_blank"
                               class="social-share-btn btn-outline-primary"
                               title="Partager sur LinkedIn"
                               onclick="trackShare('linkedin')">
                                <i class="fab fa-linkedin-in"></i>
                            </a>

                            <!-- WhatsApp Share -->
                            <a href="{{ route('events.share.whatsapp', $event->slug) }}"
                               target="_blank"
                               class="social-share-btn btn-outline-success"
                               title="Partager sur WhatsApp"
                               onclick="trackShare('whatsapp')">
                                <i class="fab fa-whatsapp"></i>
                            </a>

                            <!-- Email Share -->
                            <a href="{{ route('events.share.email', $event->slug) }}"
                               class="social-share-btn btn-outline-secondary"
                               title="Partager par email"
                               onclick="trackShare('email')">
                                <i class="fas fa-envelope"></i>
                            </a>

                            <!-- Copy Link -->
                            <button type="button"
                                    class="social-share-btn btn-outline-dark"
                                    title="Copier le lien"
                                    onclick="copyEventLink()">
                                <i class="fas fa-link"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Copy Link Feedback -->
                    <div id="copy-feedback" class="alert alert-success py-2 px-3 mb-0 d-none" role="alert">
                        <small><i class="fas fa-check me-1"></i>Lien copié dans le presse-papiers !</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Venue Location Map -->
    @if($event->venue && $event->venue->latitude && $event->venue->longitude)
    <div class="container mt-4">
        <div class="venue-map-section">
            <h3 class="map-title">
                <i class="fas fa-map-marked-alt me-2"></i>
                Localisation du Lieu
            </h3>
            <p class="map-subtitle">{{ $event->venue->name ?? 'Venue de l\'événement' }} - {{ $event->venue->city ?? '' }}</p>
            <div id="venueMap"></div>
        </div>
    </div>
    @endif

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div class="toast show align-items-center text-white bg-success border-0" role="alert">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div class="toast show align-items-center text-white bg-danger border-0" role="alert">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        {{ session('error') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        </div>
    @endif

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-4 mt-5">
        <div class="container">
            <p class="mb-0">
                <i class="fas fa-rocket me-2" style="color: var(--accent-orange);"></i>
                © 2025 EcoEvents - Ensemble pour un avenir plus vert ! 🌱
            </p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Script pour le système d'étoiles -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Gestion du système d'étoiles
            const starInputs = document.querySelectorAll('.rating-input input[type="radio"]');
            const starLabels = document.querySelectorAll('.rating-input .star-label');
            
            starLabels.forEach((label, index) => {
                label.addEventListener('click', function() {
                    const value = this.getAttribute('for').replace('star', '');
                    console.log('Étoile sélectionnée:', value);
                });
                
                label.addEventListener('mouseover', function() {
                    const value = parseInt(this.getAttribute('for').replace('star', ''));
                    highlightStars(value);
                });
            });
            
            document.querySelector('.rating-input').addEventListener('mouseleave', function() {
                const checked = document.querySelector('.rating-input input[type="radio"]:checked');
                if (checked) {
                    highlightStars(parseInt(checked.value));
                } else {
                    highlightStars(0);
                }
            });
            
            function highlightStars(rating) {
                starLabels.forEach((label, index) => {
                    const starValue = parseInt(label.getAttribute('for').replace('star', ''));
                    if (starValue <= rating) {
                        label.style.color = '#f97316';
                    } else {
                        label.style.color = '#ddd';
                    }
                });
            }
            
            // Gestion de la soumission du formulaire d'avis
            const avisForm = document.querySelector('form[action*="avis"]');
            if (avisForm) {
                avisForm.addEventListener('submit', function(e) {
                    const rating = document.querySelector('.rating-input input[type="radio"]:checked');
                    const title = document.querySelector('#title');
                    const content = document.querySelector('#content');
                    
                    if (!rating) {
                        e.preventDefault();
                        alert('Veuillez sélectionner une note en cliquant sur les étoiles.');
                        return false;
                    }
                    
                    if (!title.value.trim()) {
                        e.preventDefault();
                        alert('Veuillez saisir un titre pour votre avis.');
                        title.focus();
                        return false;
                    }
                    
                    if (!content.value.trim() || content.value.trim().length < 10) {
                        e.preventDefault();
                        alert('Veuillez saisir un avis d\'au moins 10 caractères.');
                        content.focus();
                        return false;
                    }
                    
                    console.log('Formulaire soumis avec succès');
                });
            }
        });

        // Social Sharing Functions
        function trackShare(platform) {
            // Send tracking request to backend
            fetch(`{{ route("events.share.track", $event->slug) }}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    platform: platform
                })
            }).catch(error => {
                console.log('Share tracking failed:', error);
            });
        }

        function copyEventLink() {
            const eventUrl = '{{ url("/events/" . $event->slug) }}';

            if (navigator.clipboard && window.isSecureContext) {
                // Use the Clipboard API when available and in secure context
                navigator.clipboard.writeText(eventUrl).then(() => {
                    showCopyFeedback();
                });
            } else {
                // Fallback for older browsers or non-secure contexts
                const textArea = document.createElement('textarea');
                textArea.value = eventUrl;
                textArea.style.position = 'fixed';
                textArea.style.left = '-999999px';
                textArea.style.top = '-999999px';
                document.body.appendChild(textArea);
                textArea.focus();
                textArea.select();

                try {
                    document.execCommand('copy');
                    showCopyFeedback();
                } catch (err) {
                    console.error('Fallback: Oops, unable to copy', err);
                }

                textArea.remove();
            }

            // Track the copy action
            trackShare('copy_link');
        }

        function shareToInstagram() {
            const eventUrl = '{{ url("/events/" . $event->slug) }}';
            const eventTitle = '{{ $event->title }}';
            const shareText = `Découvrez cet événement: ${eventTitle} ${eventUrl}`;
            
            // Copy the link to clipboard for Instagram sharing
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(shareText).then(() => {
                    showInstagramFeedback();
                });
            } else {
                // Fallback for older browsers
                const textArea = document.createElement('textarea');
                textArea.value = shareText;
                textArea.style.position = 'fixed';
                textArea.style.left = '-999999px';
                textArea.style.top = '-999999px';
                document.body.appendChild(textArea);
                textArea.focus();
                textArea.select();
                
                try {
                    document.execCommand('copy');
                    showInstagramFeedback();
                } catch (err) {
                    console.error('Fallback: Unable to copy', err);
                }
                
                textArea.remove();
            }
            
            // Track the share action
            trackShare('instagram');
        }

        function showInstagramFeedback() {
            const feedback = document.getElementById('copy-feedback');
            const originalContent = feedback.innerHTML;
            
            // Show Instagram-specific message
            feedback.innerHTML = '<small><i class="fab fa-instagram me-1"></i>Lien copié ! Ouvrez Instagram et collez dans votre story/post</small>';
            feedback.classList.remove('d-none');
            feedback.classList.remove('alert-success');
            feedback.classList.add('alert-info');
            
            // Reset after 5 seconds
            setTimeout(() => {
                feedback.innerHTML = originalContent;
                feedback.classList.add('d-none');
                feedback.classList.remove('alert-info');
                feedback.classList.add('alert-success');
            }, 5000);
        }

        function showCopyFeedback() {
            const feedback = document.getElementById('copy-feedback');
            feedback.classList.remove('d-none');

            // Hide after 3 seconds
            setTimeout(() => {
                feedback.classList.add('d-none');
            }, 3000);
        }
    </script>
</body>
</html>