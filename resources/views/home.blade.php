@extends('layouts.app')

@section('title', 'EcoEvents - Home')

@push('styles')
    @vite('resources/css/home.css')
@endpush

@section('content')
<section class="hero-section">
    <div class="hero-container">
        <!-- Flash Messages -->
        @if(session('success'))
            <div style="position: fixed; top: 100px; right: 20px; z-index: 1050; background: linear-gradient(135deg, var(--secondary-green), var(--primary-green)); color: white; padding: 1rem 1.5rem; border-radius: 12px; box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3); max-width: 400px;">
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <i class="fas fa-check-circle" style="font-size: 1.2rem;"></i>
                    <div>
                        <strong>Succès !</strong><br>
                        {{ session('success') }}
                    </div>
                </div>
                <button onclick="this.parentElement.parentElement.style.display='none'" style="background: none; border: none; color: white; font-size: 1.2rem; cursor: pointer; margin-left: auto;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div style="position: fixed; top: 100px; right: 20px; z-index: 1050; background: linear-gradient(135deg, #ef4444, #dc2626); color: white; padding: 1rem 1.5rem; border-radius: 12px; box-shadow: 0 8px 25px rgba(239, 68, 68, 0.3); max-width: 400px;">
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <i class="fas fa-exclamation-circle" style="font-size: 1.2rem;"></i>
                    <div>
                        <strong>Erreur !</strong><br>
                        {{ session('error') }}
                    </div>
                </div>
                <button onclick="this.parentElement.parentElement.style.display='none'" style="background: none; border: none; color: white; font-size: 1.2rem; cursor: pointer; margin-left: auto;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        @if(session('warning'))
            <div style="position: fixed; top: 100px; right: 20px; z-index: 1050; background: linear-gradient(135deg, var(--accent-orange), #ea580c); color: white; padding: 1rem 1.5rem; border-radius: 12px; box-shadow: 0 8px 25px rgba(249, 115, 22, 0.3); max-width: 400px;">
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <i class="fas fa-exclamation-triangle" style="font-size: 1.2rem;"></i>
                    <div>
                        <strong>Attention !</strong><br>
                        {{ session('warning') }}
                    </div>
                </div>
                <button onclick="this.parentElement.parentElement.style.display='none'" style="background: none; border: none; color: white; font-size: 1.2rem; cursor: pointer; margin-left: auto;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        <div class="hero-content animate-fade-in">
            <div class="hero-badge">
                <i class="fas fa-bolt"></i>
                Plateforme Innovante
            </div>
            <h1 class="hero-title">
                Organisez des événements
                <span class="accent">éco-responsables</span>
                qui font la différence
            </h1>
            <p class="hero-subtitle">
                La première plateforme collaborative pour créer, gérer et participer à des événements qui respectent notre planète.
            </p>
            <div class="hero-buttons">
                <a href="{{ route('events.index') }}" class="btn-primary">
                    <i class="fas fa-calendar-plus"></i>
                    Explorer les événements
                </a>
                <a href="{{ route('produits.index') }}" class="btn-secondary">
                    <i class="fas fa-shopping-bag"></i>
                    Visiter la boutique
                </a>
            </div>
            <div class="hero-stats">
                <div class="stat-card">
                    <span class="stat-number">{{ $stats['users'] ?? 0 }}</span>
                    <span class="stat-label">Membres</span>
                </div>
                <div class="stat-card">
                    <span class="stat-number">{{ $stats['published_events'] ?? 0 }}</span>
                    <span class="stat-label">Événements publiés</span>
                </div>
                <div class="stat-card">
                    <span class="stat-number">{{ $stats['registrations'] ?? 0 }}</span>
                    <span class="stat-label">Inscriptions</span>
                </div>
            </div>
        </div>

        <div class="hero-visual animate-fade-in">
            <div class="visual-grid">
                <div class="visual-card main-visual">
                    <i class="fas fa-globe-americas"></i>
                    <h3>Impact Global</h3>
                    <p>Mesurez l'empreinte carbone réduite grâce à vos événements durables</p>
                </div>
                <div class="visual-card">
                    <i class="fas fa-calendar-check"></i>
                    <h3>Gestion Simple</h3>
                    <p>Outils intuitifs pour organiser facilement</p>
                </div>
                <div class="visual-card">
                    <i class="fas fa-users"></i>
                    <h3>Communauté</h3>
                    <p>Réseau engagé de participants actifs</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Events Section -->
<section class="events-section" id="events">
    <div class="events-container">
        <div class="section-header">
            <h2 class="section-title">Événements <span class="accent">Éco-responsables</span></h2>
            <p class="section-subtitle">Découvrez les événements durables qui font la différence dans votre région</p>
        </div>

        @if(isset($upcomingEvents) && $upcomingEvents->count() > 0)
            <div class="events-grid">
                @foreach($upcomingEvents as $event)
                    <div class="event-card">
                        <div class="event-image">
                            @if($event->featured_image)
                                <img src="{{ asset('storage/' . $event->featured_image) }}" alt="{{ $event->title }}">
                            @else
                                <div class="event-placeholder">
                                    <i class="fas fa-calendar-alt"></i>
                                    <div class="placeholder-text">Événement</div>
                                </div>
                            @endif
                        </div>
                        <div class="event-content">
                            <div class="event-date">
                                <div class="date-day">{{ $event->start_date->format('d') }}</div>
                                <div class="date-month">{{ $event->start_date->format('M') }}</div>
                            </div>
                            <div class="event-info">
                                <h3 class="event-title">{{ $event->title }}</h3>
                                <p class="event-description">{{ Str::limit($event->short_description ?? $event->description, 120) }}</p>
                                <div class="event-meta">
                                    <div>
                                        <i class="fas fa-map-marker-alt"></i>
                                        {{ $event->venue->name ?? 'Lieu à définir' }}
                                    </div>
                                    <div>
                                        <i class="fas fa-users"></i>
                                        {{ $event->approved_registrations_count ?? 0 }} participants
                                    </div>
                                    <div>
                                        <i class="fas fa-tag"></i>
                                        {{ $event->category->name ?? 'Général' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="event-actions">
                            <a href="{{ route('events.show', $event) }}" class="btn-details">
                                <i class="fas fa-eye"></i>
                                Voir détails
                            </a>
                            @auth
                                @if($event->registrations()->where('user_id', auth()->id())->exists())
                                    <button class="btn-registered" disabled>
                                        <i class="fas fa-check"></i>
                                        Inscrit
                                    </button>
                                @else
                                    <form action="{{ route('events.register', $event) }}" method="POST" style="flex: 1;">
                                        @csrf
                                        <button type="submit" class="btn-register">
                                            <i class="fas fa-plus"></i>
                                            S'inscrire
                                        </button>
                                    </form>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="btn-register">
                                    <i class="fas fa-sign-in-alt"></i>
                                    Se connecter
                                </a>
                            @endauth
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="no-events">
                <div class="no-events-icon"><i class="fas fa-calendar-times"></i></div>
                <h3>Aucun événement à venir</h3>
                <p>Revenez bientôt pour découvrir de nouveaux événements.</p>
            </div>
        @endif
    </div>
</section>

<!-- Features Section -->
<section class="features-section">
    <div class="features-container">
        <div class="section-header">
            <h2 class="section-title">Fonctionnalités <span class="accent">Avancées</span></h2>
            <p class="section-subtitle">Découvrez les outils puissants qui rendent EcoEvents unique</p>
        </div>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3>Analytics en Temps Réel</h3>
                <p>Suivez les inscriptions, l'engagement et l'impact de vos événements avec des tableaux de bord interactifs et des rapports détaillés.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <h3>Application Mobile Native</h3>
                <p>Gérez vos événements et restez connecté avec votre communauté où que vous soyez grâce à notre application mobile intuitive.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-award"></i>
                </div>
                <h3>Système de Badges & Récompenses</h3>
                <p>Motivez votre communauté avec un système de gamification qui récompense l'engagement environnemental et la participation active.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3>Conformité & Certifications</h3>
                <p>Respectez automatiquement les normes environnementales et obtenez des certifications reconnues pour vos événements durables.</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="cta-container">
        <h2 class="cta-title">Prêt à transformer vos événements ?</h2>
        <p class="cta-subtitle">
            Rejoignez des milliers d'organisateurs qui font déjà la différence.
            Créez des événements mémorables qui respectent notre planète.
        </p>
        @auth
            @if(Auth::check() && Auth::user()->isAdmin())
                <a href="{{ route('admin.users.index') }}" class="cta-button">
                    <i class="fas fa-dashboard"></i>
                    Accéder au tableau de bord
                </a>
            @else
                <a href="#" class="cta-button">
                    <i class="fas fa-plus-circle"></i>
                    Créer mon premier événement
                </a>
            @endif
        @else
            <a href="#" class="cta-button">
                <i class="fas fa-plus-circle"></i>
                Créer mon premier événement
            </a>
        @endauth
    </div>
</section>
@endsection
