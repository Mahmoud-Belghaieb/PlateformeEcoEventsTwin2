<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'EcoEvents')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/css/home.css', 'resources/js/app.js'])
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

        .navbar-brand {
            color: var(--primary-green) !important;
            font-weight: bold;
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

        .card {
            border: none;
            box-shadow: var(--shadow);
            border-radius: 16px;
            overflow: hidden;
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

        .stars .fas.fa-star {
            color: var(--accent-orange);
        }

        .stars .far.fa-star {
            color: #ddd;
        }

        /* Enhanced Navbar Dropdown Styles */
        .navbar .dropdown-menu {
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            border-radius: 12px;
            padding: 0.5rem 0;
            margin-top: 0.5rem;
            min-width: 250px;
        }

        .navbar .dropdown-item {
            padding: 0.75rem 1.5rem;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }

        .navbar .dropdown-item:hover {
            background: linear-gradient(90deg, rgba(5, 150, 105, 0.1), transparent);
            border-left-color: var(--primary-green);
            transform: translateX(5px);
        }

        .navbar .dropdown-item i {
            width: 20px;
            text-align: center;
        }

        .navbar .dropdown-divider {
            margin: 0.5rem 1rem;
            opacity: 0.1;
        }

        /* Cart Badge Animation */
        .navbar .badge {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        /* Nav Link Hover Effect */
        .navbar .nav-link {
            position: relative;
            transition: color 0.3s ease;
        }

        .navbar .nav-link:hover {
            color: var(--primary-green) !important;
        }

        .navbar .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 2px;
            background: var(--primary-green);
            transition: width 0.3s ease;
        }

        .navbar .nav-link:hover::after {
            width: 80%;
        }

        @yield('styles')
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-rocket rocket-icon me-2"></i>
                EcoEvents
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="navbar-nav me-auto">
                    <a class="nav-link" href="{{ route('events.index') }}">
                        <i class="fas fa-calendar me-1"></i>Événements
                    </a>
                    <a class="nav-link" href="{{ route('sponsors.index') }}">
                        <i class="fas fa-handshake me-1"></i>Sponsors
                    </a>
                    
                    <!-- Shop Dropdown -->
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-store me-1"></i>Boutique
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="{{ route('produits.index') }}">
                                    <i class="fas fa-shopping-bag me-2 text-primary"></i>Produits Écologiques
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('materiels.index') }}">
                                    <i class="fas fa-tools me-2 text-success"></i>Matériel à Louer
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            @auth
                                <li>
                                    <a class="dropdown-item" href="{{ route('panier.index') }}">
                                        <i class="fas fa-shopping-cart me-2 text-warning"></i>Mon Panier
                                        @php
                                            $cartCount = \App\Models\Panier::where('user_id', Auth::id())
                                                ->where('status', 'pending')
                                                ->count();
                                        @endphp
                                        @if($cartCount > 0)
                                            <span class="badge bg-danger ms-1">{{ $cartCount }}</span>
                                        @endif
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('panier.orders') }}">
                                        <i class="fas fa-receipt me-2 text-info"></i>Mes Commandes
                                    </a>
                                </li>
                            @else
                                <li>
                                    <a class="dropdown-item" href="{{ route('login') }}">
                                        <i class="fas fa-sign-in-alt me-2 text-secondary"></i>Connexion pour commander
                                    </a>
                                </li>
                            @endauth
                        </ul>
                    </div>
                    
                    <a class="nav-link" href="{{ route('avis.index.all') }}">
                        <i class="fas fa-star me-1"></i>Avis
                    </a>
                </div>
                
                <div class="navbar-nav ms-auto">
                    @auth
                        <!-- Cart Icon with Badge (Quick Access) -->
                        <a class="nav-link position-relative" href="{{ route('panier.index') }}" title="Mon Panier">
                            <i class="fas fa-shopping-cart fs-5"></i>
                            @php
                                $cartCount = \App\Models\Panier::where('user_id', Auth::id())
                                    ->where('status', 'pending')
                                    ->count();
                            @endphp
                            @if($cartCount > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.65rem;">
                                    {{ $cartCount }}
                                    <span class="visually-hidden">items dans le panier</span>
                                </span>
                            @endif
                        </a>
                        
                        <div class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user me-1"></i>{{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li class="dropdown-header">
                                    <i class="fas fa-user-circle me-2"></i>Mon Compte
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('home') }}">
                                        <i class="fas fa-home me-2 text-primary"></i>Accueil
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('my-events') }}">
                                        <i class="fas fa-calendar-check me-2 text-success"></i>Mes Événements
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('panier.index') }}">
                                        <i class="fas fa-shopping-cart me-2 text-warning"></i>Mon Panier
                                        @php
                                            $userCartCount = \App\Models\Panier::where('user_id', Auth::id())
                                                ->where('status', 'pending')
                                                ->count();
                                        @endphp
                                        @if($userCartCount > 0)
                                            <span class="badge bg-danger ms-1">{{ $userCartCount }}</span>
                                        @endif
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('panier.orders') }}">
                                        <i class="fas fa-receipt me-2 text-info"></i>Mes Commandes
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                @if(Auth::user()->isAdmin())
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                            <i class="fas fa-cogs me-2 text-danger"></i>Administration
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                @endif
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-sign-out-alt me-2"></i>Déconnexion
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt me-1"></i>Connexion
                        </a>
                        <a class="nav-link" href="{{ route('register') }}">
                            <i class="fas fa-user-plus me-1"></i>Inscription
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Messages d'alerte -->
    @if(session('success'))
        <div class="container mt-3">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="container mt-3">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    @if(session('warning'))
        <div class="container mt-3">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                {{ session('warning') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    <!-- Contenu principal -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-4 mt-5">
        <div class="container">
            <p class="mb-0">
                <i class="fas fa-rocket me-2" style="color: var(--accent-orange);"></i>
                © 2025 EcoEvents - Ensemble pour un avenir plus vert ! 🌱
            </p>
        </div>
    </footer>

    <!-- Scripts Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Scripts personnalisés -->
    <script>
        // Auto-dismiss alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert:not(.alert-permanent)');
            alerts.forEach(function(alert) {
                if (alert.querySelector('.btn-close')) {
                    alert.querySelector('.btn-close').click();
                }
            });
        }, 5000);
    </script>
    
    @stack('scripts')
</body>
</html>