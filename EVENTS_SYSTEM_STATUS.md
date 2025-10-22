## 🎯 **Système Events ↔ Users (Many-to-Many via registrations) - CRÉÉ !**

### ✅ **Architecture Mise en Place**

**Tables Créées :**
- ✅ `categories` - Catégories d'événements
- ✅ `venues` - Lieux d'événements  
- ✅ `positions` - Postes/rôles pour bénévoles
- ✅ `events` - Événements principaux
- ✅ `event_positions` - Jointure événements ↔ postes
- ✅ **`registrations`** - **Jointure Events ↔ Users (MANY-TO-MANY)**

### 🔗 **Relation Many-to-Many Events ↔ Users**

**Table `registrations` (Pivot Table) :**
```sql
- id (PK)
- event_id (FK vers events)
- user_id (FK vers users)  
- type (participant/volunteer)
- position_id (FK vers positions, nullable)
- status (pending/approved/rejected/cancelled)
- motivation (texte)
- registered_at (datetime)
- approved_at (datetime)
- approved_by (FK vers users)
- attended (boolean)
- rating (1-5 étoiles)
- feedback (texte)
- UNIQUE(event_id, user_id) - Un utilisateur par événement
```

### 📊 **Relations Configurées dans les Modèles**

**Event Model :**
```php
// Relation Many-to-Many principale
public function users()
{
    return $this->belongsToMany(User::class, 'registrations')
                ->withPivot('type', 'status', 'motivation', 'registered_at', 'attended', 'rating')
                ->withTimestamps();
}

// Relations spécialisées
public function participants()  // Participants uniquement
public function volunteers()    // Bénévoles uniquement
public function registrations() // Toutes les inscriptions
```

**User Model :**
```php
// Relation Many-to-Many inverse
public function events()
{
    return $this->belongsToMany(Event::class, 'registrations')
                ->withPivot('type', 'status', 'motivation', 'attended', 'rating')
                ->withTimestamps();
}

// Relations spécialisées
public function participatedEvents()  // Événements comme participant
public function volunteeredEvents()   // Événements comme bénévole
public function registrations()       // Toutes les inscriptions
```

### 🚀 **Contrôleur EventController Créé**

**Méthodes Principales :**
- `register()` - Inscrire un utilisateur à un événement
- `myEvents()` - Événements de l'utilisateur (via relation Many-to-Many)
- `testRelations()` - Test des relations Many-to-Many

### 💡 **Exemples d'Utilisation**

**1. Inscrire un utilisateur à un événement :**
```php
Registration::create([
    'event_id' => $event->id,
    'user_id' => Auth::id(),
    'type' => 'participant',
    'registered_at' => now(),
    'status' => 'approved'
]);
```

**2. Obtenir tous les utilisateurs d'un événement :**
```php
$event = Event::find(1);
$users = $event->users; // Many-to-Many via registrations
$participants = $event->participants;
$volunteers = $event->volunteers;
```

**3. Obtenir tous les événements d'un utilisateur :**
```php
$user = User::find(1);
$events = $user->events; // Many-to-Many via registrations
$participatedEvents = $user->participatedEvents;
$volunteeredEvents = $user->volunteeredEvents;
```

**4. Vérifier une inscription :**
```php
if ($event->isUserRegistered($userId)) {
    // Utilisateur déjà inscrit
}

$registration = $event->getUserRegistration($userId);
```

### 🎯 **Fonctionnalités Incluses**

- ✅ **Inscription unique** par utilisateur et par événement
- ✅ **Double type** : participant OU bénévole
- ✅ **Système d'approbation** avec statuts
- ✅ **Suivi de présence** et évaluations
- ✅ **Jointure avec postes** pour les bénévoles
- ✅ **Audit trail** (qui a approuvé, quand)

### 📈 **Prêt pour Extension**

Le système est prêt pour :
- Interface web de gestion des inscriptions
- API REST pour mobile
- Notifications automatiques
- Système de paiement (si prix > 0)
- Rapports et statistiques

**🎉 La relation Many-to-Many Events ↔ Users via registrations est OPÉRATIONNELLE !**