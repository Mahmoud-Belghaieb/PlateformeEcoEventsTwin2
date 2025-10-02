<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Événements - EcoEvents</title>
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
        }

        .card {
            border: none;
            box-shadow: var(--shadow);
            border-radius: 16px;
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
                    <i class="fas fa-calendar me-1"></i>Tous les événements
                </a>
                <a class="nav-link" href="{{ route('home') }}">
                    <i class="fas fa-home me-1"></i>Accueil
                </a>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="display-6 fw-bold mb-3" style="color: var(--dark-text);">
                    <i class="fas fa-user-calendar me-3" style="color: var(--primary-green);"></i>
                    Mes Événements
                </h1>
                <p class="lead text-muted">Retrouvez tous vos événements passés et à venir</p>
            </div>
        </div>

        <!-- Tabs -->
        <ul class="nav nav-tabs mb-4" id="myEventsTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="participant-tab" data-bs-toggle="tab" data-bs-target="#participant" type="button" role="tab">
                    <i class="fas fa-hand-paper me-2"></i>
                    En tant que Participant
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="volunteer-tab" data-bs-toggle="tab" data-bs-target="#volunteer" type="button" role="tab">
                    <i class="fas fa-hands-helping me-2"></i>
                    En tant que Bénévole
                </button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content" id="myEventsTabContent">
            <!-- Participant Events -->
            <div class="tab-pane fade show active" id="participant" role="tabpanel">
                @if($participatedEvents->count() > 0)
                    <div class="row">
                        @foreach($participatedEvents as $event)
                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card">
                                    <div class="card-header bg-primary text-white">
                                        <h6 class="mb-0">{{ $event->title }}</h6>
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text">{{ Str::limit($event->description, 100) }}</p>
                                        <small class="text-muted">
                                            <i class="fas fa-calendar me-1"></i>
                                            {{ $event->start_date }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="card">
                        <div class="card-body text-center py-5">
                            <i class="fas fa-calendar-times" style="font-size: 4rem; color: var(--light-text);"></i>
                            <h4 class="mt-3 text-muted">Aucune participation</h4>
                            <p class="text-muted mb-4">Vous n'avez pas encore participé à d'événements en tant que participant.</p>
                            <a href="{{ route('events.index') }}" class="btn btn-primary">
                                <i class="fas fa-search me-2"></i>
                                Découvrir les événements
                            </a>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Volunteer Events -->
            <div class="tab-pane fade" id="volunteer" role="tabpanel">
                @if($volunteeredEvents->count() > 0)
                    <div class="row">
                        @foreach($volunteeredEvents as $event)
                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card">
                                    <div class="card-header bg-success text-white">
                                        <h6 class="mb-0">{{ $event->title }}</h6>
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text">{{ Str::limit($event->description, 100) }}</p>
                                        <small class="text-muted">
                                            <i class="fas fa-calendar me-1"></i>
                                            {{ $event->start_date }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="card">
                        <div class="card-body text-center py-5">
                            <i class="fas fa-hands-helping" style="font-size: 4rem; color: var(--light-text);"></i>
                            <h4 class="mt-3 text-muted">Aucun bénévolat</h4>
                            <p class="text-muted mb-4">Vous n'avez pas encore participé à d'événements en tant que bénévole.</p>
                            <a href="{{ route('events.index') }}" class="btn btn-success">
                                <i class="fas fa-hands-helping me-2"></i>
                                Devenir bénévole
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

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