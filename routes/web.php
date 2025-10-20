<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController as PublicHomeController;

// Public homepage route (shared for guests and authenticated users)
Route::get('/', [PublicHomeController::class, 'index'])->name('home');

// Authentication routes
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\VenueController;
use App\Http\Controllers\Admin\PositionController;
use App\Http\Controllers\Admin\AdminEventController;
use App\Http\Controllers\Admin\RegistrationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AvisController;
use App\Http\Controllers\CommentaireController;
use App\Http\Controllers\SponsorController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\MaterielController;
use App\Http\Controllers\PanierController;

// Guest routes (only accessible when not logged in)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    
    // Password reset routes
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    // Note: '/home' route intentionally removed to keep homepage at '/'
    // Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // My events
    Route::get('/my-events', [EventController::class, 'myEvents'])->name('my-events');
    
    // Event registration
    Route::post('/events/{event}/register', [EventController::class, 'register'])->name('events.register');
    
    // Avis routes
    Route::get('/events/{event}/avis', [AvisController::class, 'index'])->name('avis.index');
    Route::get('/events/{event}/avis/create', [AvisController::class, 'create'])->name('avis.create');
    Route::post('/events/{event}/avis', [AvisController::class, 'store'])->name('avis.store');
    Route::get('/avis/{avis}/edit', [AvisController::class, 'edit'])->name('avis.edit');
    Route::put('/avis/{avis}', [AvisController::class, 'update'])->name('avis.update');
    Route::delete('/avis/{avis}', [AvisController::class, 'destroy'])->name('avis.destroy');
    
    // Commentaires routes
    Route::post('/avis/{avis}/commentaires', [CommentaireController::class, 'store'])->name('commentaires.store');
    Route::get('/commentaires/{commentaire}/edit', [CommentaireController::class, 'edit'])->name('commentaires.edit');
    Route::put('/commentaires/{commentaire}', [CommentaireController::class, 'update'])->name('commentaires.update');
    Route::delete('/commentaires/{commentaire}', [CommentaireController::class, 'destroy'])->name('commentaires.destroy');
    Route::post('/commentaires/{commentaire}/reply', [CommentaireController::class, 'reply'])->name('commentaires.reply');
    
    // Panier routes (authenticated users only)
    Route::get('/panier', [PanierController::class, 'index'])->name('panier.index');
    Route::post('/panier', [PanierController::class, 'store'])->name('panier.store');
    Route::put('/panier/{panier}', [PanierController::class, 'update'])->name('panier.update');
    Route::delete('/panier/{panier}', [PanierController::class, 'destroy'])->name('panier.destroy');
    Route::post('/panier/clear', [PanierController::class, 'clear'])->name('panier.clear');
    Route::post('/panier/checkout', [PanierController::class, 'checkout'])->name('panier.checkout');
    Route::get('/mes-commandes', [PanierController::class, 'orders'])->name('panier.orders');
});

// Public event routes
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{event:slug}', [EventController::class, 'show'])->name('events.show');

// Public avis routes (standalone)
Route::get('/avis', [AvisController::class, 'indexAll'])->name('avis.index.all');
Route::get('/avis/{avis}', [AvisController::class, 'show'])->name('avis.show');

// Public product routes
Route::get('/produits', [ProduitController::class, 'publicIndex'])->name('produits.index');
Route::get('/produits/{produit}', [ProduitController::class, 'publicShow'])->name('produits.show');

// Public sponsors route
Route::get('/sponsors', [SponsorController::class, 'publicIndex'])->name('sponsors.index');

// Public materials route
Route::get('/materiels', [MaterielController::class, 'publicIndex'])->name('materiels.index');

// Test route for relations
Route::get('/test-relations', [EventController::class, 'testRelations'])->name('test.relations');

// Admin routes
Route::middleware(['auth', App\Http\Middleware\RoleMiddleware::class.':admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // User Management
    Route::resource('users', UserManagementController::class);
    Route::post('users/{user}/toggle-status', [UserManagementController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::get('users/{user}/registrations', [UserManagementController::class, 'showRegistrations'])->name('users.registrations');
    
    // Category Management
    Route::resource('categories', CategoryController::class);
    
    // Venue Management
    Route::resource('venues', VenueController::class);
    
    // Position Management
    Route::resource('positions', PositionController::class);
    
    // Event Management (Admin)
    Route::resource('events', AdminEventController::class);
    Route::post('events/{event}/approve', [AdminEventController::class, 'approve'])->name('events.approve');
    Route::post('events/{event}/reject', [AdminEventController::class, 'reject'])->name('events.reject');
    Route::post('events/{event}/pending', [AdminEventController::class, 'setPending'])->name('events.pending');
    
    // Registration Management
    Route::resource('registrations', RegistrationController::class);
    Route::post('registrations/{registration}/approve', [RegistrationController::class, 'approve'])->name('registrations.approve');
    Route::post('registrations/{registration}/reject', [RegistrationController::class, 'reject'])->name('registrations.reject');
    Route::post('registrations/{registration}/cancel', [RegistrationController::class, 'cancel'])->name('registrations.cancel');
    
    // Avis Management (Admin)
    Route::resource('avis', \App\Http\Controllers\Admin\AvisController::class)->only(['index', 'show', 'destroy']);
    Route::patch('avis/{avis}/approve', [\App\Http\Controllers\Admin\AvisController::class, 'approve'])->name('avis.approve');
    Route::delete('avis/{avis}/reject', [\App\Http\Controllers\Admin\AvisController::class, 'reject'])->name('avis.reject');
    Route::post('avis/bulk-approve', [\App\Http\Controllers\Admin\AvisController::class, 'bulkApprove'])->name('avis.bulk-approve');
    Route::post('avis/bulk-delete', [\App\Http\Controllers\Admin\AvisController::class, 'bulkDelete'])->name('avis.bulk-delete');
    
    // Commentaires Management (Admin)
    Route::resource('commentaires', \App\Http\Controllers\Admin\CommentaireController::class)->only(['index', 'show', 'destroy']);
    Route::patch('commentaires/{commentaire}/approve', [\App\Http\Controllers\Admin\CommentaireController::class, 'approve'])->name('commentaires.approve');
    Route::delete('commentaires/{commentaire}/reject', [\App\Http\Controllers\Admin\CommentaireController::class, 'reject'])->name('commentaires.reject');
    Route::post('commentaires/bulk-approve', [\App\Http\Controllers\Admin\CommentaireController::class, 'bulkApprove'])->name('commentaires.bulk-approve');
    Route::post('commentaires/bulk-delete', [\App\Http\Controllers\Admin\CommentaireController::class, 'bulkDelete'])->name('commentaires.bulk-delete');
    
    // Email Logs Management
    Route::get('email-logs', [\App\Http\Controllers\Admin\EmailLogController::class, 'index'])->name('email-logs');
    Route::post('email-logs/clear', [\App\Http\Controllers\Admin\EmailLogController::class, 'clear'])->name('email-logs.clear');
    
    // Sponsors Management
    Route::resource('sponsors', SponsorController::class);
    
    // Produits Management
    Route::resource('produits', ProduitController::class);
    
    // Materiels Management
    Route::resource('materiels', MaterielController::class);
    
    // Panier (Cart Orders) Management
    Route::get('panier', [PanierController::class, 'adminIndex'])->name('panier.index');
    Route::get('panier/{panier}', [PanierController::class, 'adminShow'])->name('panier.show');
    Route::patch('panier/{panier}/status', [PanierController::class, 'updateStatus'])->name('panier.update-status');
    Route::delete('panier/{panier}', [PanierController::class, 'adminDestroy'])->name('panier.destroy');
});
