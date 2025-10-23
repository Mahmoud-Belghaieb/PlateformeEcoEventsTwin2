<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $produit->name }} - EcoEvents</title>
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
                <a href="{{ route('produits.index') }}" class="nav-link active">Produits</a>
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

<div class="main-content">
<div class="container py-5">
    <div class="row">
        <!-- Product Image -->
        <div class="col-md-6 mb-4">
            @if($produit->image)
                <img src="{{ Storage::url($produit->image) }}" class="img-fluid rounded shadow" alt="{{ $produit->name }}">
            @else
                <div class="bg-light d-flex align-items-center justify-content-center rounded shadow" style="height: 400px;">
                    <i class="fas fa-box fa-5x text-muted"></i>
                </div>
            @endif
        </div>

        <!-- Product Details -->
        <div class="col-md-6">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('produits.index') }}">Produits</a></li>
                    <li class="breadcrumb-item active">{{ $produit->name }}</li>
                </ol>
            </nav>

            <h1 class="mb-3">{{ $produit->name }}</h1>

            <div class="mb-3">
                <span class="badge bg-info me-2">{{ $produit->category }}</span>
                @if($produit->sponsor)
                    <span class="badge bg-secondary">{{ $produit->sponsor->name }}</span>
                @endif
            </div>

            <h2 class="text-primary mb-4">{{ $produit->formatted_price }}</h2>

            @if($produit->description)
                <div class="mb-4">
                    <h5>Description</h5>
                    <p class="text-muted">{{ $produit->description }}</p>
                </div>
            @endif

            <div class="mb-4">
                <h5>Disponibilité</h5>
                @if($produit->stock > 0)
                    <p class="text-success">
                        <i class="fas fa-check-circle"></i> En stock ({{ $produit->stock }} unités disponibles)
                    </p>
                @else
                    <p class="text-danger">
                        <i class="fas fa-times-circle"></i> Épuisé
                    </p>
                @endif
            </div>

            @if($produit->sponsor && $produit->sponsor->website)
                <div class="mb-4">
                    <h5>Sponsor</h5>
                    <p>
                        <a href="{{ $produit->sponsor->website }}" target="_blank" class="text-decoration-none">
                            {{ $produit->sponsor->name }} <i class="fas fa-external-link-alt small"></i>
                        </a>
                    </p>
                </div>
            @endif

            <!-- Add to Cart Form -->
            @auth
                @if($produit->stock > 0)
                    <form action="{{ route('panier.store') }}" method="POST" class="mb-4">
                        @csrf
                        <input type="hidden" name="produit_id" value="{{ $produit->id }}">
                        
                        <div class="row g-3">
                            <div class="col-auto">
                                <label for="quantity" class="form-label">Quantité</label>
                                <input type="number" name="quantity" id="quantity" class="form-control" value="1" min="1" max="{{ $produit->stock }}" style="width: 100px;">
                            </div>
                            <div class="col-auto align-self-end">
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="fas fa-shopping-cart"></i> Ajouter au panier
                                </button>
                            </div>
                        </div>
                    </form>
                @endif
            @else
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> 
                    Veuillez <a href="{{ route('login') }}">vous connecter</a> pour ajouter ce produit au panier.
                </div>
            @endauth

            <a href="{{ route('produits.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Retour aux produits
            </a>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
        <div class="row mt-5">
            <div class="col-12">
                <h3 class="mb-4">Produits similaires</h3>
            </div>
            @foreach($relatedProducts as $related)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card h-100 shadow-sm">
                        @if($related->image)
                            <img src="{{ Storage::url($related->image) }}" class="card-img-top" alt="{{ $related->name }}" style="height: 150px; object-fit: cover;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center" style="height: 150px;">
                                <i class="fas fa-box fa-2x text-muted"></i>
                            </div>
                        @endif
                        
                        <div class="card-body">
                            <h6 class="card-title">{{ $related->name }}</h6>
                            <p class="text-primary mb-2"><strong>{{ $related->formatted_price }}</strong></p>
                            <a href="{{ route('produits.show', $related) }}" class="btn btn-sm btn-outline-primary w-100">
                                Voir
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

@if(session('success'))
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div class="toast show" role="alert">
            <div class="toast-header bg-success text-white">
                <strong class="me-auto">Succès</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body">
                {{ session('success') }}
            </div>
        </div>
    </div>
@endif
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
