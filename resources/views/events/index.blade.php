<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Événements - EcoEvents</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
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

        .page-header {
            padding: 8rem 0 4rem;
            background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 50%, #f0f9ff 100%);
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><defs><radialGradient id="c" cx="50%" r="20%"><stop offset="0%" stop-color="%2310b981" stop-opacity="0.1"/><stop offset="100%" stop-color="%2310b981" stop-opacity="0"/></radialGradient></defs><rect fill="url(%23c)" width="100%" height="100%"/></svg>');
            opacity: 0.6;
        }

        .page-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
            position: relative;
            z-index: 1;
            text-align: center;
        }

        .page-title {
            font-size: 3.5rem;
            font-weight: 900;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            color: var(--dark-text);
        }

        .page-title .accent {
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .page-subtitle {
            font-size: 1.2rem;
            line-height: 1.7;
            color: var(--light-text);
            margin-bottom: 2rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .stats-row {
            display: flex;
            gap: 2rem;
            justify-content: center;
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

        .events-section {
            padding: 6rem 0;
            background: var(--background);
        }

        .events-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .filter-section {
            background: white;
            padding: 2rem;
            border-radius: 24px;
            box-shadow: var(--shadow);
            border: 1px solid rgba(16, 185, 129, 0.1);
            margin-bottom: 3rem;
        }

        .filter-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--dark-text);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .filter-controls {
            display: flex;
            gap: 1.5rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .filter-select {
            flex: 1;
            min-width: 200px;
            padding: 1rem 1.5rem;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 1rem;
            background: white;
            transition: all 0.3s ease;
        }

        .filter-select:focus {
            outline: none;
            border-color: var(--primary-green);
            box-shadow: 0 0 0 0.2rem rgba(5, 150, 105, 0.25);
        }

        .filter-btn {
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            color: white;
            padding: 1rem 2rem;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .filter-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(5, 150, 105, 0.3);
        }

        .events-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(380px, 1fr));
            gap: 2.5rem;
        }

        .event-card {
            background: white;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(16, 185, 129, 0.1);
            transition: all 0.3s ease;
            position: relative;
        }

        .event-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        }

        .event-image {
            position: relative;
            height: 220px;
            overflow: hidden;
        }

        .event-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
            background: #f3f4f6;
        }

        .event-card:hover .event-image img {
            transform: scale(1.05);
        }

        .event-placeholder {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2.5rem;
            gap: 0.5rem;
        }

        .event-placeholder .placeholder-text {
            font-size: 0.9rem;
            font-weight: 600;
            opacity: 0.9;
        }

        .featured-badge {
            position: absolute;
            top: 1rem;
            left: 1rem;
            background: linear-gradient(135deg, var(--accent-orange), #ea580c);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 4px 15px rgba(249, 115, 22, 0.3);
        }

        .category-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: var(--primary-green);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .event-content {
            padding: 2rem;
            display: flex;
            gap: 1.5rem;
        }

        .event-date {
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            color: white;
            border-radius: 16px;
            padding: 1rem;
            text-align: center;
            min-width: 70px;
            height: fit-content;
        }

        .date-day {
            font-size: 1.8rem;
            font-weight: 900;
            line-height: 1;
        }

        .date-month {
            font-size: 0.9rem;
            font-weight: 600;
            text-transform: uppercase;
            margin-top: 0.25rem;
        }

        .event-info {
            flex: 1;
        }

        .event-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--dark-text);
            margin-bottom: 0.75rem;
            line-height: 1.3;
        }

        .event-description {
            color: var(--light-text);
            line-height: 1.6;
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
        }

        .event-meta {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .event-meta > div {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.9rem;
            color: var(--light-text);
        }

        .event-meta i {
            color: var(--primary-green);
            width: 16px;
        }

        .event-price.free {
            color: var(--secondary-green);
            font-weight: 600;
        }

        .event-actions {
            padding: 0 2rem 2rem;
            display: flex;
            gap: 1rem;
        }

        .btn-register, .btn-details {
            flex: 1;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.95rem;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            text-align: center;
        }

        .btn-register {
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            color: white;
            border: none;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(5, 150, 105, 0.3);
        }

        .btn-details {
            background: white;
            color: var(--primary-green);
            border: 2px solid var(--primary-green);
        }

        .btn-details:hover {
            background: var(--primary-green);
            color: white;
        }

        .btn-registered {
            flex: 1;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            background: rgba(16, 185, 129, 0.1);
            color: var(--primary-green);
            border: 2px solid rgba(16, 185, 129, 0.3);
            cursor: not-allowed;
        }

        .no-events {
            text-align: center;
            padding: 6rem 2rem;
            background: white;
            border-radius: 24px;
            box-shadow: var(--shadow);
            border: 1px solid rgba(16, 185, 129, 0.1);
        }

        .no-events-icon {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            font-size: 2.5rem;
            color: white;
        }

        .no-events h3 {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--dark-text);
            margin-bottom: 1rem;
        }

        .no-events p {
            color: var(--light-text);
            font-size: 1.1rem;
            margin-bottom: 2rem;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }

        .btn-back-home {
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            color: white;
            padding: 1rem 2rem;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }

        .btn-back-home:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(5, 150, 105, 0.3);
        }

        @media (max-width: 1200px) {
            .events-grid {
                grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
                gap: 2rem;
            }
        }

        @media (max-width: 968px) {
            .nav-links {
                display: none;
            }

            .page-title {
                font-size: 2.5rem;
            }

            .stats-row {
                flex-direction: column;
                align-items: center;
                gap: 1rem;
            }

            .filter-controls {
                flex-direction: column;
                align-items: stretch;
            }

            .filter-select {
                min-width: auto;
            }
        }

        @media (max-width: 768px) {
            .nav-container {
                padding: 0 1rem;
            }

            .page-header {
                padding: 6rem 0 3rem;
            }

            .page-container {
                padding: 0 1rem;
            }

            .page-title {
                font-size: 2rem;
            }

            .events-container {
                padding: 0 1rem;
            }

            .events-grid {
                grid-template-columns: 1fr;
            }

            .event-card {
                margin: 0 auto;
                max-width: 400px;
            }

            .event-content {
                flex-direction: column;
                gap: 1rem;
            }

            .event-date {
                align-self: flex-start;
                min-width: 60px;
            }

            .event-actions {
                flex-direction: column;
                gap: 0.75rem;
            }

            .events-section {
                padding: 4rem 0;
            }

            .no-events {
                padding: 4rem 1rem;
            }

            .filter-section {
                padding: 1.5rem;
            }

            .filter-controls {
                gap: 1rem;
            }
        }

        @media (max-width: 480px) {
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
<body>
    <nav class="navbar">
        <div class="nav-container">
            <a href="{{ route('home') }}" class="logo">
                <i class="fas fa-leaf"></i>
                EcoEvents
            </a>
            <div class="nav-links">
                <a href="{{ route('home') }}#features" class="nav-link">Fonctionnalités</a>
                <a href="{{ route('events.index') }}" class="nav-link active">Événements</a>
                <a href="#" class="nav-link">Communauté</a>
                @auth
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('admin.users.index') }}" class="nav-link">Administration</a>
                    @endif
                    <a href="#" class="nav-link">Dashboard</a>
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

    <section class="page-header">
        <div class="page-container">
            <!-- Flash Messages -->
            @if(session('success'))
                <div style="position: fixed; top: 100px; right: 20px; z-index: 1050; background: linear-gradient(135deg, var(--secondary-green), var(--primary-green)); color: white; padding: 1rem 1.5rem; border-radius: 12px; box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3); max-width: 400px;">
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <i class="fas fa-check-circle" style="font-size: 1.2rem;"></i>
                        <div>
                            <strong>Succès !</strong><br>
                            {{ session('success') }}
                        </div>
                        <button onclick="this.parentElement.parentElement.style.display='none'" style="background: none; border: none; color: white; font-size: 1.2rem; cursor: pointer; margin-left: auto;">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
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
                        <button onclick="this.parentElement.parentElement.style.display='none'" style="background: none; border: none; color: white; font-size: 1.2rem; cursor: pointer; margin-left: auto;">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
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
                        <button onclick="this.parentElement.parentElement.style.display='none'" style="background: none; border: none; color: white; font-size: 1.2rem; cursor: pointer; margin-left: auto;">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            @endif

            <h1 class="page-title">
                Événements <span class="accent">Éco-responsables</span>
            </h1>
            <p class="page-subtitle">
                Découvrez tous nos événements durables et rejoignez notre communauté engagée pour l'environnement
            </p>
            
            <div class="stats-row">
                <div class="stat-card">
                    <span class="stat-number">{{ $events->count() }}</span>
                    <span class="stat-label">Événements</span>
                </div>
                <div class="stat-card">
                    <span class="stat-number">{{ $categories->count() }}</span>
                    <span class="stat-label">Catégories</span>
                </div>
                <div class="stat-card">
                    <span class="stat-number">{{ $events->where('price', 0)->count() }}</span>
                    <span class="stat-label">Gratuits</span>
                </div>
            </div>
        </div>
    </section>

    <section class="events-section">
        <div class="events-container">
            <!-- Filter Section -->
            <div class="filter-section">
                <h3 class="filter-title">
                    <i class="fas fa-filter"></i>
                    Filtrer les événements
                </h3>
                <div class="filter-controls">
                    <select class="filter-select" id="categoryFilter">
                        <option value="">Toutes les catégories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->slug }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <select class="filter-select" id="priceFilter">
                        <option value="">Tous les prix</option>
                        <option value="free">Gratuit</option>
                        <option value="paid">Payant</option>
                    </select>
                    <button class="filter-btn" onclick="applyFilters()">
                        <i class="fas fa-search"></i>
                        Filtrer
                    </button>
                    <button class="filter-btn" onclick="clearFilters()" style="background: linear-gradient(135deg, #6b7280, #4b5563);">
                        <i class="fas fa-times"></i>
                        Effacer
                    </button>
                </div>
            </div>

            <!-- Events Grid -->
            @if($events->count() > 0)
                <div class="events-grid">
                    @foreach($events as $event)
                        <div class="event-card" data-category="{{ $event->category->slug ?? '' }}" data-price="{{ $event->price > 0 ? 'paid' : 'free' }}">
                            <div class="event-image">
                                @if($event->featured_image)
                                    <img src="{{ asset('storage/' . $event->featured_image) }}" alt="{{ $event->title }}">
                                @else
                                    <div class="event-placeholder">
                                        <i class="fas fa-calendar-alt"></i>
                                        <div class="placeholder-text">Événement</div>
                                    </div>
                                @endif
                                @if($event->is_featured)
                                    <div class="featured-badge">
                                        <i class="fas fa-star"></i>
                                        Événement vedette
                                    </div>
                                @endif
                                <div class="category-badge" style="background: {{ $event->category->color ?? '#059669' }}">
                                    @if($event->category->icon)
                                        <i class="fas {{ $event->category->icon }}"></i>
                                    @endif
                                    {{ $event->category->name ?? 'Événement' }}
                                </div>
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
                                        <div class="event-location">
                                            <i class="fas fa-map-marker-alt"></i>
                                            {{ $event->venue->city ?? 'Lieu à définir' }}
                                        </div>
                                        <div class="event-participants">
                                            <i class="fas fa-users"></i>
                                            {{ $event->registrations()->where('status', 'approved')->count() }}/{{ $event->max_participants ?? '∞' }}
                                        </div>
                                        @if($event->price > 0)
                                            <div class="event-price">
                                                <i class="fas fa-lira-sign"></i>
                                                {{ number_format($event->price, 2) }} TND
                                            </div>
                                        @else
                                            <div class="event-price free">
                                                <i class="fas fa-gift"></i>
                                                Gratuit
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <div class="event-actions">
                                @auth
                                    @if($event->isUserRegistered(Auth::id()))
                                        <button class="btn-registered" disabled>
                                            <i class="fas fa-check"></i>
                                            Inscrit
                                        </button>
                                    @else
                                        <form method="POST" action="{{ route('events.register', $event->id) }}" style="flex: 1;">
                                            @csrf
                                            <input type="hidden" name="type" value="participant">
                                            <button type="submit" class="btn-register" style="width: 100%;">
                                                <i class="fas fa-calendar-plus"></i>
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
                                <a href="{{ route('events.show', $event->slug) }}" class="btn-details">
                                    <i class="fas fa-info-circle"></i>
                                    Détails
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="no-events">
                    <div class="no-events-icon">
                        <i class="fas fa-calendar-times"></i>
                    </div>
                    <h3>Aucun événement disponible</h3>
                    <p>Il n'y a pas encore d'événements publiés. Revenez bientôt pour découvrir nos prochaines activités éco-responsables !</p>
                    <a href="{{ route('home') }}" class="btn-back-home">
                        <i class="fas fa-home"></i>
                        Retour à l'accueil
                    </a>
                </div>
            @endif
        </div>
    </section>

    <script>
        function applyFilters() {
            const categoryFilter = document.getElementById('categoryFilter').value;
            const priceFilter = document.getElementById('priceFilter').value;
            const eventCards = document.querySelectorAll('.event-card');

            eventCards.forEach(card => {
                let showCard = true;

                // Category filter
                if (categoryFilter && card.dataset.category !== categoryFilter) {
                    showCard = false;
                }

                // Price filter
                if (priceFilter && card.dataset.price !== priceFilter) {
                    showCard = false;
                }

                card.style.display = showCard ? 'block' : 'none';
            });
        }

        // Clear filters
        function clearFilters() {
            document.getElementById('categoryFilter').value = '';
            document.getElementById('priceFilter').value = '';
            const eventCards = document.querySelectorAll('.event-card');
            eventCards.forEach(card => {
                card.style.display = 'block';
            });
        }

        // Auto-hide flash messages after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const flashMessages = document.querySelectorAll('[style*="position: fixed"]');
            flashMessages.forEach(function(message) {
                setTimeout(function() {
                    message.style.opacity = '0';
                    message.style.transform = 'translateX(100%)';
                    message.style.transition = 'all 0.3s ease';
                    setTimeout(function() {
                        message.style.display = 'none';
                    }, 300);
                }, 5000);
            });
        });
    </script>
</body>
</html>