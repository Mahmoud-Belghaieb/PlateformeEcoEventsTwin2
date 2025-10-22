# 🌿 EcoEvents - Plateforme de Gestion d'Événements Écologiques

<p align="center">
    <img src="https://img.shields.io/badge/Laravel-12.31.1-FF2D20?style=for-the-badge&logo=laravel" alt="Laravel">
    <img src="https://img.shields.io/badge/PHP-8.2.29-777BB4?style=for-the-badge&logo=php" alt="PHP">
    <img src="https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql" alt="MySQL">
    <img src="https://github.com/balsemkhouniblossom/PlateformeEcoEventsTwin2/actions/workflows/ci.yml/badge.svg" alt="CI Status">
    <img src="https://img.shields.io/badge/Status-Active-success?style=for-the-badge" alt="Status">
</p>

## 📖 À Propos d'EcoEvents

EcoEvents est une plateforme web moderne dédiée à la gestion et à l'organisation d'événements écologiques. Développée avec Laravel 12, elle permet aux utilisateurs de découvrir, créer et participer à des événements environnementaux tels que le nettoyage de plages, la plantation d'arbres, et les campagnes de sensibilisation.

### 🎯 Mission
Faciliter l'organisation d'événements écologiques et mobiliser les communautés pour la protection de l'environnement.

### 🌍 Informations Régionales
- **Devise utilisée** : TND (Dinar Tunisien)
- **Localisation** : Tunisie
- **Langue principale** : Français

## ✨ Fonctionnalités Principales

### 🔐 Système d'Authentification
- **Inscription/Connexion** sécurisée avec validation
- **Système de rôles** : Admin, Participant, Bénévole
- **Gestion des profils** utilisateurs
- **Middleware de protection** des routes

### 👥 Gestion des Utilisateurs (Admin)
- **Panel d'administration** avec interface moderne
- **CRUD complet** des utilisateurs
- **Statistiques en temps réel**
- **Filtrage et recherche** avancés
- **Gestion des statuts** (actif/inactif)

### 🎪 Système d'Événements
- **Gestion complète des événements** avec CRUD
- **Catégorisation** des événements (nettoyage, plantation, sensibilisation)
- **Gestion des lieux** avec géolocalisation
- **Système de postes/rôles** pour bénévoles
- **Inscriptions avec approbation**

### 🔗 Relations Many-to-Many
- **Events ↔ Users** via table `registrations`
- **Events ↔ Positions** via table `event_positions`
- **Gestion des inscriptions** participants/bénévoles
- **Suivi de présence** et évaluations

### 🎨 Interface Utilisateur
- **Design moderne** avec thème vert/orange
- **Interface responsive** Bootstrap 5
- **Icônes Font Awesome** avec thème fusée 🚀
- **Gradients professionnels** et animations
- **UX optimisée** pour tous les appareils

## 🗂 Structure de la Base de Données

### Tables Principales
```sql
├── users                    # Utilisateurs avec rôles
├── categories              # Catégories d'événements
├── venues                  # Lieux d'événements ✅ ACTIF
├── positions              # Postes/rôles pour bénévoles ✅ ACTIF
├── events                 # Événements principaux ✅ ACTIF
├── event_positions        # Jointure événements ↔ postes ✅ ACTIF
└── registrations         # Jointure événements ↔ utilisateurs (Many-to-Many) ✅ ACTIF        # Jointure événements ↔ postes
└── registrations         # Jointure événements ↔ utilisateurs (Many-to-Many)
```

### Relations Clés
- **Users ↔ Events** (Many-to-Many via registrations)
- **Events ↔ Categories** (One-to-Many)
- **Events ↔ Venues** (One-to-Many)
- **Events ↔ Positions** (Many-to-Many via event_positions)

## 🚀 Installation et Configuration

### Prérequis
- PHP 8.2+
- Composer
- MySQL 8.0+
- Node.js & NPM (pour les assets)

### Installation
```bash


# Installer les dépendances PHP
composer install

# Copier le fichier d'environnement
copy .env.example .env

# Générer la clé d'application
php artisan key:generate

# Configurer la base de données dans .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ecoevent_db
DB_USERNAME=root
DB_PASSWORD=

# Exécuter les migrations
php artisan migrate

# Lancer les seeders (optionnel)
php artisan db:seed

# Démarrer le serveur
php artisan serve
```

### Configuration XAMPP
1. Démarrer Apache et MySQL dans XAMPP
2. Créer la base de données `ecoevent_db`
3. Configurer les credentials dans `.env`

## 🎮 Utilisation


### URLs Principales
- **Accueil** : `http://127.0.0.1:8000/`
- **Connexion** : `http://127.0.0.1:8000/login`
- **Inscription** : `http://127.0.0.1:8000/register`
- **Admin Panel** : `http://127.0.0.1:8000/admin/users`

## 🛠 Technologies Utilisées

### Backend
- **Laravel 12.31.1** - Framework PHP
- **MySQL 8.0** - Base de données
- **Eloquent ORM** - Gestion des relations
- **Middleware** - Protection des routes

### Frontend
- **Bootstrap 5** - Framework CSS
- **Font Awesome 6** - Icônes
- **CSS Custom Properties** - Thème personnalisé
- **JavaScript Vanilla** - Interactions

### Outils de Développement
- **Composer** - Gestionnaire de dépendances PHP
- **Artisan** - CLI Laravel
- **Migrations** - Versioning de la base de données
- **Seeders** - Données de test

## 📁 Structure du Projet

```
ecoEvents/
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/UserManagementController.php
│   │   └── EventController.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Event.php
│   │   ├── Category.php
│   │   ├── Venue.php
│   │   ├── Position.php
│   │   └── Registration.php
│   └── Middleware/RoleMiddleware.php
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   └── views/
│       ├── auth/
│       ├── admin/
│       └── events/
└── routes/web.php
```

## 🔧 Fonctionnalités Avancées

### Système de Rôles
- **Admin** : Gestion complète des utilisateurs et événements
- **Participant** : Inscription aux événements
- **Bénévole** : Candidature aux postes bénévoles

### Gestion des Événements
- Création d'événements avec catégories
- Gestion des inscriptions et approbations
- Suivi de présence et évaluations
- Système de postes pour bénévoles

### Interface d'Administration
- Dashboard avec statistiques
- Gestion CRUD des utilisateurs
- Filtrage et recherche avancés
- Design moderne et responsive

## 🚧 Développement Futur

### Fonctionnalités Prévues
- [ ] API REST pour applications mobiles
- [ ] Système de notifications en temps réel
- [ ] Géolocalisation avancée des événements
- [ ] Système de paiement pour événements payants
- [ ] Rapports et analytics détaillés
- [ ] Chat en temps réel pour les équipes

## 🤝 Contribution

Les contributions sont les bienvenues ! Pour contribuer :

1. Fork le projet
2. Créer une branche feature (`git checkout -b feature/AmazingFeature`)
3. Commit les changements (`git commit -m 'Add AmazingFeature'`)
4. Push vers la branche (`git push origin feature/AmazingFeature`)
5. Ouvrir une Pull Request

## 📄 Licence

Ce projet est sous licence MIT. Voir le fichier `LICENSE` pour plus de détails.

## 👨‍💻 Développeur

**Balsem Khouni Blossom**
- GitHub: [@balsemkhouniblossom](https://github.com/balsemkhouniblossom)
- Email: contact@ecoevent.com

## 🙏 Remerciements

- Laravel Framework pour la base solide
- Bootstrap pour l'interface utilisateur
- Font Awesome pour les icônes
- La communauté open source

---

<p align="center">
    <strong>🌍 Ensemble pour un avenir plus vert ! 🌱</strong>
</p>
