# 🧭 NAVIGATION MENU UPDATE GUIDE

This guide shows how to add the new modules to your navigation menu.

## 📍 Where to Update

Your navigation is likely in one of these files:
- `resources/views/layouts/app.blade.php` (main layout)
- `resources/views/partials/navbar.blade.php` (separate navbar file)
- `resources/views/components/navigation.blade.php` (component)

---

## 🎯 PUBLIC NAVIGATION (For all users)

Add these links to your main navigation menu:

```blade
<!-- Existing links -->
<li class="nav-item">
    <a class="nav-link" href="{{ route('events.index') }}">Événements</a>
</li>

<!-- NEW: Products Link -->
<li class="nav-item">
    <a class="nav-link" href="{{ route('produits.index') }}">
        <i class="fas fa-shopping-bag"></i> Produits
    </a>
</li>

<!-- NEW: Sponsors Link -->
<li class="nav-item">
    <a class="nav-link" href="{{ route('sponsors.index') }}">
        <i class="fas fa-handshake"></i> Sponsors
    </a>
</li>

<!-- NEW: Cart Link (only for authenticated users) -->
@auth
    <li class="nav-item">
        <a class="nav-link" href="{{ route('panier.index') }}">
            <i class="fas fa-shopping-cart"></i> Panier
            @if(Auth::user()->activePaniers->count() > 0)
                <span class="badge bg-danger">{{ Auth::user()->activePaniers->count() }}</span>
            @endif
        </a>
    </li>
@endauth
```

---

## 👨‍💼 ADMIN NAVIGATION (For administrators only)

Add these links to your admin sidebar/menu:

```blade
<!-- Existing admin links -->
<li class="nav-item">
    <a class="nav-link" href="{{ route('admin.events.index') }}">
        <i class="fas fa-calendar"></i> Événements
    </a>
</li>

<!-- NEW: Sponsors Management -->
<li class="nav-item">
    <a class="nav-link" href="{{ route('admin.sponsors.index') }}">
        <i class="fas fa-handshake"></i> Sponsors
    </a>
</li>

<!-- NEW: Products Management -->
<li class="nav-item">
    <a class="nav-link" href="{{ route('admin.produits.index') }}">
        <i class="fas fa-box"></i> Produits
    </a>
</li>

<!-- NEW: Materials Management -->
<li class="nav-item">
    <a class="nav-link" href="{{ route('admin.materiels.index') }}">
        <i class="fas fa-tools"></i> Matériels
    </a>
</li>
```

---

## 🎨 ENHANCED CART BADGE (Optional)

For a dynamic cart counter with real-time updates, add this to your layout's `<head>`:

```blade
@auth
<script>
    // Update cart count (if you implement AJAX cart operations later)
    function updateCartCount() {
        fetch('{{ route("panier.index") }}')
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const count = doc.querySelectorAll('.cart-item').length;
                document.getElementById('cart-count').textContent = count;
            });
    }
</script>
@endauth
```

---

## 📱 MOBILE NAVIGATION (Responsive)

For mobile menu (collapsed navigation):

```blade
<!-- Mobile menu toggle -->
<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
    <span class="navbar-toggler-icon"></span>
</button>

<div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ms-auto">
        <!-- Public links -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('produits.index') }}">
                <i class="fas fa-shopping-bag"></i> Produits
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('sponsors.index') }}">
                <i class="fas fa-handshake"></i> Sponsors
            </a>
        </li>
        
        @auth
            <li class="nav-item">
                <a class="nav-link" href="{{ route('panier.index') }}">
                    <i class="fas fa-shopping-cart"></i> Panier
                    <span class="badge bg-danger">{{ Auth::user()->activePaniers->count() }}</span>
                </a>
            </li>
        @endauth
    </ul>
</div>
```

---

## 🎭 DROPDOWN MENU (Advanced)

If you want a "Shop" dropdown:

```blade
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="shopDropdown" role="button" data-bs-toggle="dropdown">
        <i class="fas fa-store"></i> Boutique
    </a>
    <ul class="dropdown-menu" aria-labelledby="shopDropdown">
        <li>
            <a class="dropdown-item" href="{{ route('produits.index') }}">
                <i class="fas fa-box"></i> Tous les produits
            </a>
        </li>
        <li><hr class="dropdown-divider"></li>
        <li>
            <a class="dropdown-item" href="{{ route('panier.index') }}">
                <i class="fas fa-shopping-cart"></i> Mon panier
            </a>
        </li>
        <li>
            <a class="dropdown-item" href="{{ route('sponsors.index') }}">
                <i class="fas fa-handshake"></i> Nos sponsors
            </a>
        </li>
    </ul>
</li>
```

---

## 🔍 QUICK SEARCH BAR (Optional)

Add a search bar in your navbar:

```blade
<form class="d-flex me-3" action="{{ route('produits.index') }}" method="GET">
    <input class="form-control form-control-sm me-2" type="search" name="search" placeholder="Rechercher un produit..." style="width: 250px;">
    <button class="btn btn-sm btn-outline-success" type="submit">
        <i class="fas fa-search"></i>
    </button>
</form>
```

---

## 📊 COMPLETE EXAMPLE

Here's a complete navbar example with all new features:

```blade
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ url('/') }}">
            <strong>EcoEvents</strong>
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('events.index') }}">Événements</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('produits.index') }}">Produits</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('sponsors.index') }}">Sponsors</a>
                </li>
            </ul>
            
            <!-- Search bar -->
            <form class="d-flex me-3" action="{{ route('produits.index') }}" method="GET">
                <input class="form-control form-control-sm me-2" type="search" name="search" placeholder="Rechercher...">
                <button class="btn btn-sm btn-outline-primary" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </form>
            
            <ul class="navbar-nav">
                @auth
                    <!-- Cart -->
                    <li class="nav-item">
                        <a class="nav-link position-relative" href="{{ route('panier.index') }}">
                            <i class="fas fa-shopping-cart fa-lg"></i>
                            @php
                                $cartCount = Auth::user()->activePaniers->count();
                            @endphp
                            @if($cartCount > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        </a>
                    </li>
                    
                    <!-- User dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user"></i> {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('home') }}">Dashboard</a></li>
                            <li><a class="dropdown-item" href="{{ route('my-events') }}">Mes événements</a></li>
                            <li><a class="dropdown-item" href="{{ route('panier.index') }}">Mon panier</a></li>
                            @if(Auth::user()->role === 'admin')
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Admin Panel</a></li>
                            @endif
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt"></i> Déconnexion
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Connexion</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Inscription</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
```

---

## 🎯 ADMIN SIDEBAR EXAMPLE

For your admin panel sidebar:

```blade
<div class="admin-sidebar bg-dark text-white" style="min-height: 100vh;">
    <div class="p-3">
        <h5>Administration</h5>
    </div>
    
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('admin.users.index') }}">
                <i class="fas fa-users"></i> Utilisateurs
            </a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('admin.events.index') }}">
                <i class="fas fa-calendar"></i> Événements
            </a>
        </li>
        
        <!-- NEW MODULES -->
        <li class="nav-item mt-3">
            <h6 class="px-3 text-muted small">BOUTIQUE</h6>
        </li>
        
        <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('admin.sponsors.index') }}">
                <i class="fas fa-handshake"></i> Sponsors
            </a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('admin.produits.index') }}">
                <i class="fas fa-box"></i> Produits
            </a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('admin.materiels.index') }}">
                <i class="fas fa-tools"></i> Matériels
            </a>
        </li>
        
        <!-- End NEW MODULES -->
        
        <li class="nav-item mt-3">
            <h6 class="px-3 text-muted small">CONTENU</h6>
        </li>
        
        <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('admin.avis.index') }}">
                <i class="fas fa-star"></i> Avis
            </a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('admin.commentaires.index') }}">
                <i class="fas fa-comments"></i> Commentaires
            </a>
        </li>
    </ul>
</div>
```

---

## ✅ CHECKLIST

After updating your navigation:

- [ ] Public navbar shows "Produits" and "Sponsors" links
- [ ] Cart icon appears for authenticated users
- [ ] Cart badge shows item count
- [ ] Admin sidebar shows new management links
- [ ] Links are properly styled
- [ ] Mobile menu works correctly
- [ ] Active page is highlighted
- [ ] Icons display correctly (FontAwesome)

---

## 🎨 STYLING TIPS

Make the cart badge more prominent:

```css
/* Add to your CSS file */
.cart-badge {
    position: absolute;
    top: -5px;
    right: -10px;
    padding: 3px 6px;
    border-radius: 50%;
    background: #dc3545;
    color: white;
    font-size: 10px;
    font-weight: bold;
}

.nav-link:hover .cart-badge {
    background: #c82333;
}
```

---

*Generated: October 10, 2025*
*Project: EcoEvents Navigation Updates*
