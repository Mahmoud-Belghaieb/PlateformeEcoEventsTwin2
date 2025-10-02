<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $event->title }} - EcoEvents</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
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

                <!-- Contact Info -->
                <div class="info-item">
                    <h6 class="mb-3">
                        <i class="fas fa-envelope me-2" style="color: var(--accent-orange);"></i>
                        Contact organisateur
                    </h6>
                    <p class="mb-1"><strong>Email :</strong> contact@ecoevents.com</p>
                    <p class="mb-1"><strong>Téléphone :</strong> +216 71 123 456</p>
                    <p class="mb-0"><strong>Site web :</strong> www.ecoevents.com</p>
                </div>
            </div>
        </div>
    </div>

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
</body>
</html>