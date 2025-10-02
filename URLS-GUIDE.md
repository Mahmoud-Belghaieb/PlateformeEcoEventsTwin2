# 🚀 EcoEvents - Guide des URLs et Routes

## URLs Principales du Site

### 🏠 **Accueil & Navigation**
- **Accueil**: `http://127.0.0.1:8000/`
- **Tableau de bord admin**: `http://127.0.0.1:8000/admin`

### 📅 **Système d'Événements**

#### **Navigation Publique**
- **Liste des événements**: `http://127.0.0.1:8000/events`
- **Détail d'un événement**: `http://127.0.0.1:8000/events/{slug}`
  - Exemple: `http://127.0.0.1:8000/events/grand-nettoyage-plage-marseille-2025`

#### **Espace Utilisateur (Authentifié)**
- **Mes événements**: `http://127.0.0.1:8000/my-events`
- **Inscription à un événement**: `POST http://127.0.0.1:8000/events/{id}/register`

#### **API & Tests**
- **Test des relations Many-to-Many**: `http://127.0.0.1:8000/test-relations`

### 🔐 **Authentification**
- **Connexion**: `http://127.0.0.1:8000/login`
- **Inscription**: `http://127.0.0.1:8000/register`
- **Déconnexion**: `POST http://127.0.0.1:8000/logout`
- **Mot de passe oublié**: `http://127.0.0.1:8000/password/reset`

### 👤 **Profil Utilisateur**
- **Profil**: `http://127.0.0.1:8000/profile`
- **Modification du profil**: `http://127.0.0.1:8000/profile/edit`

---

## Structure des Routes

### Routes Publiques
```php
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{slug}', [EventController::class, 'show'])->name('events.show');
```

### Routes Authentifiées
```php
Route::middleware('auth')->group(function () {
    Route::get('/my-events', [EventController::class, 'myEvents'])->name('my-events');
    Route::post('/events/{id}/register', [EventController::class, 'register'])->name('events.register');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
```

### Routes de Test
```php
Route::get('/test-relations', [EventController::class, 'testRelations']);
```

---

## 🎨 Design System

### Couleurs Principales
- **Vert Principal**: `#059669` (--primary-green)
- **Vert Secondaire**: `#10b981` (--secondary-green)  
- **Orange Accent**: `#f97316` (--accent-orange)
- **Texte Foncé**: `#1f2937` (--dark-text)
- **Texte Clair**: `#6b7280` (--light-text)

### Thème Visuel
- **Icône principale**: 🚀 Fusée (représentant l'innovation écologique)
- **Style**: Design moderne et professionnel
- **Framework**: Bootstrap 5 + CSS personnalisé
- **Typographie**: Inter, Segoe UI, system fonts

---

## 🗄️ Base de Données

### Tables Principales
1. **users** - Utilisateurs du système
2. **events** - Événements écologiques
3. **categories** - Catégories d'événements
4. **venues** - Lieux des événements  
5. **positions** - Postes bénévoles
6. **registrations** - Table pivot (Many-to-Many Users ↔ Events)
7. **event_positions** - Table pivot (Many-to-Many Events ↔ Positions)

### Relations Many-to-Many
- **Users ↔ Events** via `registrations` (participant/bénévole)
- **Events ↔ Positions** via `event_positions` (postes disponibles)

---

## 🛠️ Statut du Développement

### ✅ **Fonctionnalités Complètes**
- ✅ Système d'authentification Laravel
- ✅ Interface d'administration (Filament)
- ✅ Routes d'événements fonctionnelles
- ✅ Vues professionnelles avec design cohérent
- ✅ Base de données MySQL configurée
- ✅ Architecture Many-to-Many planifiée

### 🔄 **En Cours de Développement**
- 🔄 Intégration complète des modèles Eloquent
- 🔄 Données réelles (actuellement en mode mock)
- 🔄 Système de notifications
- 🔄 Interface CRUD administrative complète

### 📋 **À Venir**
- 📋 Seeding des données d'exemple
- 📋 Tests automatisés
- 📋 API REST complète
- 📋 Système de géolocalisation
- 📋 Notifications email

---

## 🚀 **Démarrage Rapide**

1. **Démarrer le serveur**:
   ```bash
   php artisan serve
   ```

2. **Accéder au site**: `http://127.0.0.1:8000`

3. **Admin panel**: `http://127.0.0.1:8000/admin`

4. **Explorer les événements**: `http://127.0.0.1:8000/events`

---

*Dernière mise à jour: {{ date('Y-m-d H:i:s') }}*