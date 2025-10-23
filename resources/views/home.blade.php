<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcoEvents - Home</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/css/home.css', 'resources/js/app.js'])
</head>
<body>

@push('styles')
<style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

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
            color: var(--dark-text);
            line-height: 1.6;
            overflow-x: hidden;
        }

        .navbar {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(16, 185, 129, 0.1);
            padding: 1rem 0;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }



        /* Styles de la navbar simplifiée comme dans events */
        .nav-container {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 2rem;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--primary-green);
            text-decoration: none;
        }

        .logo i {
            color: var(--accent-orange);
        }

        .nav-links {
            display: flex;
            gap: 2.5rem;
            align-items: center;
        }

        .nav-link {
            color: var(--light-text);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            position: relative;
        }

        .nav-link:hover {
            color: var(--primary-green);
            background: rgba(16, 185, 129, 0.1);
        }

        .nav-link.active {
            color: var(--primary-green);
            background: rgba(16, 185, 129, 0.1);
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 1rem;
            background: rgba(16, 185, 129, 0.1);
            border-radius: 12px;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            background: var(--primary-green);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.85rem;
        }

        .user-name {
            color: var(--dark-text);
            font-weight: 600;
            font-size: 0.9rem;
        }

        .user-role {
            font-size: 0.8rem;
            color: var(--light-text);
        }

        .logout-btn {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            border: none;
            padding: 0.6rem 1.2rem;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .logout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(239, 68, 68, 0.3);
        }

.hero-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 2rem;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 6rem;
    align-items: center;
    position: relative;
    z-index: 1;
    min-height: 600px;
}

.hero-content {
    position: relative;
}

.hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: linear-gradient(135deg, var(--accent-orange), #ea580c);
    color: white;
    padding: 0.8rem 1.5rem;
    border-radius: 30px;
    font-size: 0.9rem;
    font-weight: 700;
    margin-bottom: 2rem;
    animation: pulse 2s ease-in-out infinite;
    box-shadow: 0 8px 25px rgba(249, 115, 22, 0.3);
}

.hero-title {
    font-size: 4rem;
    font-weight: 900;
    line-height: 1.1;
    margin-bottom: 2rem;
    color: var(--dark-text);
}

.hero-title .accent {
    background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.hero-subtitle {
    font-size: 1.3rem;
    line-height: 1.7;
    color: var(--light-text);
    margin-bottom: 3rem;
    max-width: 600px;
}

.hero-buttons {
    display: flex;
    gap: 1.5rem;
    margin-bottom: 3rem;
}

.btn-primary {
    background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
    color: white;
    padding: 1.2rem 2.5rem;
    border: none;
    border-radius: 16px;
    font-size: 1.1rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    box-shadow: 0 10px 30px rgba(5, 150, 105, 0.3);
}

.btn-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 40px rgba(5, 150, 105, 0.4);
}

.btn-secondary {
    background: white;
    color: var(--primary-green);
    padding: 1.2rem 2.5rem;
    border: 2px solid var(--primary-green);
    border-radius: 16px;
    font-size: 1.1rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
}

.btn-secondary:hover {
    background: var(--primary-green);
    color: white;
    transform: translateY(-3px);
    box-shadow: 0 15px 40px rgba(5, 150, 105, 0.3);
}

.hero-stats {
    display: flex;
    gap: 2rem;
    margin-top: 2rem;
}

.stat-card {
    background: white;
    padding: 1.5rem 2rem;
    border-radius: 20px;
    box-shadow: var(--shadow);
    border: 1px solid rgba(16, 185, 129, 0.1);
    text-align: center;
    min-width: 120px;
}

.stat-number {
    font-size: 2rem;
    font-weight: 900;
    color: var(--primary-green);
    display: block;
}

.stat-label {
    color: var(--light-text);
    font-size: 0.9rem;
    font-weight: 600;
    margin-top: 0.5rem;
}

.hero-visual {
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
}

.visual-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    grid-template-rows: 1fr 1fr;
    gap: 1.5rem;
    width: 500px;
    height: 500px;
}

.visual-card {
    background: white;
    border-radius: 24px;
    padding: 2rem;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    transition: all 0.3s ease;
    border: 1px solid rgba(16, 185, 129, 0.1);
    position: relative;
    overflow: hidden;
}

        .nav-link:hover {
            color: var(--primary-green);
            background: rgba(16, 185, 129, 0.1);
        }

        .nav-link.active {
            color: var(--primary-green);
            background: rgba(16, 185, 129, 0.1);
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 1rem;
            background: rgba(16, 185, 129, 0.1);
            border-radius: 12px;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            background: var(--primary-green);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.85rem;
        }

        .user-name {
            color: var(--dark-text);
            font-weight: 600;
            font-size: 0.9rem;
        }

        .user-role {
            font-size: 0.8rem;
            color: var(--light-text);
        }

.features-section {
    padding: 8rem 0;
    background: white;
}

.features-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 2rem;
}

.section-header {
    text-align: center;
    margin-bottom: 5rem;
}

.section-title {
    font-size: 3rem;
    font-weight: 900;
    color: var(--dark-text);
    margin-bottom: 1.5rem;
}

.section-subtitle {
    font-size: 1.2rem;
    color: var(--light-text);
    max-width: 600px;
    margin: 0 auto;
}

.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 3rem;
}

.feature-card {
    background: white;
    padding: 3rem;
    border-radius: 24px;
    box-shadow: var(--shadow);
    border: 1px solid rgba(16, 185, 129, 0.1);
    transition: all 0.3s ease;
    text-align: center;
}

.feature-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
}

.feature-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 2rem;
    font-size: 2rem;
    color: white;
}

.feature-card h3 {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--dark-text);
    margin-bottom: 1rem;
}

.feature-card p {
    color: var(--light-text);
    line-height: 1.6;
}

.cta-section {
    padding: 8rem 0;
    background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
    color: white;
    text-align: center;
}

.cta-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 0 2rem;
}

.cta-title {
    font-size: 3rem;
    font-weight: 900;
    margin-bottom: 1.5rem;
}

.cta-subtitle {
    font-size: 1.3rem;
    opacity: 0.9;
    margin-bottom: 3rem;
    line-height: 1.6;
}

.cta-button {
    background: white;
    color: var(--primary-green);
    padding: 1.5rem 3rem;
    border: none;
    border-radius: 16px;
    font-size: 1.2rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 1rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
}

.cta-button:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
}

@keyframes pulse {
    0%, 100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.05);
    }
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in {
    animation: fadeInUp 0.8s ease-out;
}

@media (max-width: 1200px) {
    .hero-container {
        gap: 4rem;
    }

    .features-grid {
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
    }

    .events-grid {
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 2rem;
    }
}

@media (max-width: 968px) {
    .hero-container {
        grid-template-columns: 1fr;
        text-align: center;
        gap: 3rem;
        min-height: auto;
        padding: 2rem 1rem;
    }

    .hero-title {
        font-size: 3rem;
    }

    .hero-buttons {
        justify-content: center;
        flex-wrap: wrap;
    }

    .hero-stats {
        justify-content: center;
        flex-wrap: wrap;
    }

    .visual-grid {
        width: 400px;
        height: 400px;
        margin: 0 auto;
    }

    .section-title {
        font-size: 2.5rem;
    }

    .cta-title {
        font-size: 2.5rem;
    }
}

@media (max-width: 768px) {
    .hero-section {
        padding: 8rem 0 4rem;
    }

    .hero-container {
        padding: 0 1rem;
        gap: 2rem;
    }

    .hero-title {
        font-size: 2.5rem;
        line-height: 1.2;
    }

    .hero-subtitle {
        font-size: 1.1rem;
        margin-bottom: 2rem;
    }

    .hero-buttons {
        flex-direction: column;
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .btn-primary,
    .btn-secondary {
        width: 100%;
        max-width: 300px;
        margin: 0 auto;
    }

    .hero-stats {
        flex-direction: row;
        align-items: center;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
    }

    .stat-card {
        min-width: 80px;
        flex: 1;
        max-width: 120px;
    }

    .visual-grid {
        width: 320px;
        height: 320px;
    }

    .features-container,
    .cta-container,
    .events-container {
        padding: 0 1rem;
    }

    .features-grid,
    .events-grid {
        grid-template-columns: 1fr;
        gap: 2rem;
    }

    .feature-card {
        padding: 2rem;
    }

    .event-card {
        margin: 0 auto;
        max-width: 100%;
    }

    .event-content {
        flex-direction: column;
        gap: 1rem;
        padding: 1.5rem;
    }

    .event-date {
        align-self: flex-start;
        min-width: 60px;
    }

    .event-actions {
        flex-direction: column;
        gap: 0.75rem;
        padding: 0 1.5rem 1.5rem;
    }

    .events-section {
        padding: 6rem 0;
    }

    .no-events {
        padding: 4rem 1rem;
    }

    .section-header {
        margin-bottom: 3rem;
    }

    .section-title {
        font-size: 2rem;
    }
}

@media (max-width: 480px) {
    .hero-section {
        padding: 6rem 0 3rem;
    }

    .hero-container {
        padding: 0 1rem;
        gap: 2rem;
    }

    .hero-title {
        font-size: 2rem;
    }

    .hero-subtitle {
        font-size: 1.1rem;
    }

    .hero-buttons {
        gap: 0.75rem;
    }

    .btn-primary,
    .btn-secondary {
        padding: 1rem 1.5rem;
        font-size: 1rem;
    }

    .hero-stats {
        gap: 0.75rem;
    }

    .stat-card {
        padding: 1rem 1.5rem;
        min-width: 100px;
    }

    .stat-number {
        font-size: 1.5rem;
    }

    .visual-grid {
        width: 280px;
        height: 280px;
        gap: 1rem;
    }

    .visual-card {
        padding: 1.5rem;
    }

    .visual-card i {
        font-size: 2rem;
        margin-bottom: 0.75rem;
    }

    .visual-card h3 {
        font-size: 1rem;
    }

    .visual-card p {
        font-size: 0.8rem;
    }

    .section-title {
        font-size: 2rem;
    }

    .section-subtitle {
        font-size: 1rem;
    }

    .features-grid,
    .events-grid {
        gap: 1.5rem;
    }

    .feature-card {
        padding: 1.5rem;
    }

    .feature-icon {
        width: 60px;
        height: 60px;
        font-size: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .feature-card h3 {
        font-size: 1.3rem;
    }

    .event-card {
        max-width: 100%;
    }

    .event-content {
        padding: 1.5rem;
        gap: 1rem;
    }

    .event-title {
        font-size: 1.2rem;
    }

    .event-description {
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }

    .event-actions {
        padding: 0 1.5rem 1.5rem;
    }

    .btn-register,
    .btn-details,
    .btn-registered {
        padding: 0.75rem 1rem;
        font-size: 0.9rem;
    }

    .cta-section {
        padding: 6rem 0;
    }

    .cta-title {
        font-size: 2.5rem;
    }

    .cta-subtitle {
        font-size: 1.1rem;
    }

    .cta-button {
        padding: 1.2rem 2rem;
        font-size: 1rem;
    }
}
</style>

<!-- Navigation -->
<nav class="navbar">
    <div class="nav-container">
        <a href="{{ route('home') }}" class="logo">
            <i class="fas fa-leaf"></i>
            EcoEvents
        </a>
        <div class="nav-links">
            <a href="{{ route('home') }}" class="nav-link active">Accueil</a>
            <a href="{{ route('events.index') }}" class="nav-link">Événements</a>
            <a href="{{ route('produits.index') }}" class="nav-link">Produits</a>
            <a href="{{ route('sponsors.index') }}" class="nav-link">Sponsors</a>
            @auth
                @if(Auth::user()->isAdmin())
                    <a href="{{ route('admin.users.index') }}" class="nav-link">Administration</a>
                @endif
                <a href="{{ route('panier.index') }}" class="nav-link">Mes Paniers</a>
            @endauth
        </div>
        <div class="user-menu">
            @auth
                <div class="user-info">
                    <div class="user-avatar">{{ substr(Auth::user()->name, 0, 1) }}</div>
                    <div>
                        <div class="user-name">{{ Auth::user()->name }}</div>
                        <div class="user-role">{{ Auth::user()->getRoleDisplayName() }}</div>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i>
                        Déconnexion
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="nav-link">Connexion</a>
                <a href="{{ route('register') }}" class="nav-link">Inscription</a>
            @endauth
        </div>
    </div>
</nav>

<!-- Contenu de la page -->
<section class="hero-section" style="margin-top: 80px;"></section>
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

<!-- Chatbase Integration -->
<script>
    window.embeddedChatbotConfig = {
        chatbotId: "BMbYDI5JT6uWysGBwPeD3",
        domain: "www.chatbase.co"
    }
</script>
<script src="https://www.chatbase.co/embed.min.js"
    id="BMbYDI5JT6uWysGBwPeD3"
    defer>
</script>

</body>
</html>
