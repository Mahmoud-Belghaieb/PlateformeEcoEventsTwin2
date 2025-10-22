<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Paniers - EcoEvents</title>
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
                <a href="{{ route('sponsors.index') }}" class="nav-link">Sponsors</a>
                @auth
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('admin.users.index') }}" class="nav-link">Administration</a>
                    @endif
                    <a href="{{ route('panier.index') }}" class="nav-link active">Mes Paniers</a>
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
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="display-5 mb-3 fw-bold text-primary-green">
                <i class="fas fa-shopping-cart me-3"></i>Mon Panier
            </h1>
            <p class="text-muted">Gérez vos articles et finalisez votre commande</p>
        </div>
    </div>

    @if($paniers->count() > 0)
        <div class="row">
            <!-- Cart Items -->
            <div class="col-lg-8 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-gradient-success text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-list me-2"></i>Articles ({{ $paniers->count() }})
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Produit</th>
                                        <th class="text-center">Prix</th>
                                        <th class="text-center">Quantité</th>
                                        <th class="text-center">Sous-total</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($paniers as $item)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($item->produit->image)
                                                        <img src="{{ Storage::url($item->produit->image) }}" 
                                                             alt="{{ $item->produit->name }}" 
                                                             style="width: 70px; height: 70px; object-fit: cover;" 
                                                             class="me-3 rounded shadow-sm">
                                                    @else
                                                        <div class="bg-gradient-primary text-white d-flex align-items-center justify-content-center me-3 rounded shadow-sm" style="width: 70px; height: 70px;">
                                                            <i class="fas fa-box fa-2x"></i>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <strong class="d-block">{{ $item->produit->name }}</strong>
                                                        <small class="text-muted">
                                                            <i class="fas fa-tag me-1"></i>{{ $item->produit->category }}
                                                        </small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-middle text-center">
                                                <strong>{{ number_format($item->price, 2) }} TND</strong>
                                            </td>
                                            <td class="align-middle">
                                                <form action="{{ route('panier.update', $item) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="input-group input-group-sm mx-auto" style="width: 140px;">
                                                        <input type="number" 
                                                               name="quantity" 
                                                               class="form-control text-center" 
                                                               value="{{ $item->quantity }}" 
                                                               min="1" 
                                                               max="{{ $item->produit->stock }}">
                                                        <button type="submit" class="btn btn-outline-primary" title="Mettre à jour">
                                                            <i class="fas fa-sync-alt"></i>
                                                        </button>
                                                    </div>
                                                </form>
                                            </td>
                                            <td class="align-middle text-center">
                                                <strong class="text-primary-green fs-5">{{ $item->formatted_subtotal }}</strong>
                                            </td>
                                            <td class="align-middle text-center">
                                                <form action="{{ route('panier.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('Retirer ce produit du panier?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Supprimer">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer bg-light">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <a href="{{ route('produits.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Continuer mes achats
                            </a>
                            <form action="{{ route('panier.clear') }}" method="POST" class="d-inline" onsubmit="return confirm('Vider tout le panier?')">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger">
                                    <i class="fas fa-trash-alt me-2"></i>Vider le panier
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="card shadow-sm sticky-top" style="top: 20px;">
                    <div class="card-header bg-gradient-warning text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-receipt me-2"></i>Résumé de la commande
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3 pb-3 border-bottom">
                            <span class="text-muted">Sous-total:</span>
                            <strong>{{ number_format($total, 2) }} TND</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-3 pb-3 border-bottom">
                            <span class="text-muted">Livraison:</span>
                            <strong class="text-success">Gratuite</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-4">
                            <h5 class="mb-0">Total:</h5>
                            <h4 class="mb-0 text-primary-green fw-bold">{{ number_format($total, 2) }} TND</h4>
                        </div>
                        
                        <form action="{{ route('panier.checkout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success btn-lg w-100 shadow">
                                <i class="fas fa-check-circle me-2"></i>Valider la commande
                            </button>
                        </form>

                        <div class="alert alert-info mt-3 mb-0 small">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Paiement sécurisé</strong><br>
                            Vos données sont protégées
                        </div>
                    </div>
                </div>

                <!-- Security Features -->
                <div class="card shadow-sm mt-3">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3">
                            <i class="fas fa-shield-alt text-success me-2"></i>Achat sécurisé
                        </h6>
                        <ul class="list-unstyled small mb-0">
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>Paiement sécurisé
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>Livraison gratuite
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>Support client 24/7
                            </li>
                            <li>
                                <i class="fas fa-check text-success me-2"></i>Produits écologiques
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Empty Cart -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm text-center py-5">
                    <div class="card-body">
                        <div class="mb-4">
                            <i class="fas fa-shopping-cart fa-5x text-muted"></i>
                        </div>
                        <h3 class="mb-3">Votre panier est vide</h3>
                        <p class="text-muted mb-4">Ajoutez des produits écologiques pour commencer vos achats!</p>
                        <a href="{{ route('produits.index') }}" class="btn btn-primary-green btn-lg shadow">
                            <i class="fas fa-shopping-bag me-2"></i>Découvrir nos produits
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<style>
    .text-primary-green {
        color: var(--primary-green);
    }
    
    .btn-primary-green {
        background-color: var(--primary-green);
        border-color: var(--primary-green);
        color: white;
    }
    
    .btn-primary-green:hover {
        background-color: #047857;
        border-color: #047857;
        color: white;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(5, 150, 105, 0.05);
    }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</div>
</body>
</html>
