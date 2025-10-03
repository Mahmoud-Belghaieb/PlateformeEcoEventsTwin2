<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

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

// Guest routes (only accessible when not logged in)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
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
});

// Public event routes
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{event:slug}', [EventController::class, 'show'])->name('events.show');

// Public avis routes (standalone)
Route::get('/avis', [AvisController::class, 'indexAll'])->name('avis.index.all');
Route::get('/avis/{avis}', [AvisController::class, 'show'])->name('avis.show');

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
});
