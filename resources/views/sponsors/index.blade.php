<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos Sponsors - EcoEvents</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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

        /* Page content adjustments */
        .main-content {
            padding-top: 100px;
        }

        .text-primary-green {
            color: var(--primary-green) !important;
        }

        /* Responsive navbar */
        @media (max-width: 968px) {
            .nav-links {
                display: none;
            }
        }

        @media (max-width: 768px) {
            .nav-container {
                padding: 0 1rem;
            }
            .user-menu {
                flex-direction: column;
                gap: 0.5rem;
            }
            .user-info {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <a href="{{ route('home') }}" class="logo">
                <i class="fas fa-leaf"></i>
                EcoEvents
            </a>
            <div class="nav-links">
                <a href="{{ route('home') }}" class="nav-link">Accueil</a>
                <a href="{{ route('events.index') }}" class="nav-link">Événements</a>
                <a href="{{ route('produits.index') }}" class="nav-link">Produits</a>
                <a href="{{ route('sponsors.index') }}" class="nav-link active">Sponsors</a>
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

<div class="main-content">
<div class="container py-5">
    <!-- Hero Section -->
    <div class="row mb-5">
        <div class="col-12 text-center">
            <h1 class="display-4 mb-3 fw-bold text-primary-green">
                <i class="fas fa-handshake me-3"></i>Nos Sponsors & Partenaires
            </h1>
            <p class="lead text-muted">Découvrez les entreprises qui soutiennent nos initiatives écologiques</p>
        </div>
    </div>

    <!-- Sponsors Grid -->
    <div class="row">
        @forelse($sponsors as $sponsor)
            <div class="col-lg-6 mb-4">
                <div class="card h-100 shadow-sm transform-hover">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 text-center mb-3 mb-md-0">
                                @if($sponsor->logo)
                                    <img src="{{ Storage::url($sponsor->logo) }}" 
                                         alt="{{ $sponsor->name }}" 
                                         class="img-fluid rounded shadow-sm" 
                                         style="max-height: 150px; width: auto;">
                                @else
                                    <div class="bg-gradient-primary text-white d-flex align-items-center justify-content-center rounded shadow-sm" style="height: 150px;">
                                        <i class="fas fa-handshake fa-4x opacity-75"></i>
                                    </div>
                                @endif
                                
                                <div class="mt-3">
                                    @php
                                        $levelColors = [
                                            'platinum' => 'dark',
                                            'gold' => 'warning',
                                            'silver' => 'secondary',
                                            'bronze' => 'light text-dark'
                                        ];
                                        $levelColor = $levelColors[$sponsor->sponsorship_level] ?? 'info';
                                    @endphp
                                    <span class="badge bg-{{ $levelColor }} px-3 py-2 shadow-sm">
                                        <i class="fas fa-award me-1"></i>{{ ucfirst($sponsor->sponsorship_level) }}
                                    </span>
                                </div>
                            </div>
                            
                            <div class="col-md-8">
                                <h3 class="mb-3 fw-bold text-primary-green">{{ $sponsor->name }}</h3>
                                
                                @if($sponsor->description)
                                    <p class="text-muted mb-3">{{ $sponsor->description }}</p>
                                @endif

                                <div class="mb-3">
                                    @if($sponsor->website)
                                        <p class="mb-2">
                                            <i class="fas fa-globe text-primary me-2"></i>
                                            <a href="{{ $sponsor->website }}" target="_blank" class="text-decoration-none fw-semibold">
                                                Visiter le site web <i class="fas fa-external-link-alt small"></i>
                                            </a>
                                        </p>
                                    @endif

                                    @if($sponsor->contact_email)
                                        <p class="mb-2">
                                            <i class="fas fa-envelope text-primary me-2"></i>
                                            <a href="mailto:{{ $sponsor->contact_email }}" class="text-decoration-none">
                                                {{ $sponsor->contact_email }}
                                            </a>
                                        </p>
                                    @endif

                                    @if($sponsor->contact_phone)
                                        <p class="mb-2">
                                            <i class="fas fa-phone text-primary me-2"></i>
                                            <a href="tel:{{ $sponsor->contact_phone }}" class="text-decoration-none">
                                                {{ $sponsor->contact_phone }}
                                            </a>
                                        </p>
                                    @endif
                                </div>

                                @if($sponsor->produits && $sponsor->produits->count() > 0)
                                    <div class="mt-3">
                                        <p class="mb-2 fw-semibold">
                                            <i class="fas fa-box text-info me-2"></i>Produits proposés:
                                        </p>
                                        <div class="d-flex flex-wrap gap-2">
                                            @foreach($sponsor->produits->take(3) as $produit)
                                                <a href="{{ route('produits.show', $produit) }}" class="badge bg-gradient-info text-white text-decoration-none px-3 py-2">
                                                    {{ $produit->name }}
                                                </a>
                                            @endforeach
                                            @if($sponsor->produits->count() > 3)
                                                <span class="badge bg-secondary px-3 py-2">
                                                    +{{ $sponsor->produits->count() - 3 }} autres
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-handshake fa-4x text-muted mb-3"></i>
                        <h4>Aucun sponsor actuellement</h4>
                        <p class="text-muted">Nous travaillons activement à développer nos partenariats.</p>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Call to Action -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card shadow-lg border-0" style="background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));">
                <div class="card-body text-white text-center py-5">
                    <h3 class="mb-3 fw-bold">
                        <i class="fas fa-star me-2"></i>Devenez Sponsor
                    </h3>
                    <p class="lead mb-4">Rejoignez-nous pour soutenir des initiatives écologiques et durables</p>
                    <div class="row justify-content-center mb-4">
                        <div class="col-md-3 mb-3">
                            <div class="bg-white bg-opacity-10 rounded p-3">
                                <i class="fas fa-eye fa-2x mb-2"></i>
                                <h6>Visibilité</h6>
                                <small>Augmentez votre notoriété</small>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="bg-white bg-opacity-10 rounded p-3">
                                <i class="fas fa-leaf fa-2x mb-2"></i>
                                <h6>Impact</h6>
                                <small>Soutenez l'écologie</small>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="bg-white bg-opacity-10 rounded p-3">
                                <i class="fas fa-users fa-2x mb-2"></i>
                                <h6>Communauté</h6>
                                <small>Engagez votre audience</small>
                            </div>
                        </div>
                    </div>
                    <a href="mailto:contact@ecoevents.tn?subject=Demande de partenariat" class="btn btn-light btn-lg shadow">
                        <i class="fas fa-envelope me-2"></i>Nous contacter
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .transform-hover {
        transition: all 0.3s ease;
    }
    
    .transform-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
    }
    
    .text-primary-green {
        color: var(--primary-green);
    }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</div>
</body>
</html>
