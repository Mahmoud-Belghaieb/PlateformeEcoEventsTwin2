<?php

// Script pour créer un avis de test
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Avis;
use App\Models\User;
use App\Models\Event;

// Récupérer le premier utilisateur et le premier événement
$user = User::first();
$event = Event::first();

if (!$user || !$event) {
    echo "❌ Vous devez avoir au moins un utilisateur et un événement en base.\n";
    exit(1);
}

// Créer un avis de test
$avis = Avis::create([
    'user_id' => $user->id,
    'event_id' => $event->id,
    'rating' => 5,
    'title' => 'Excellent événement !',
    'content' => 'J\'ai adoré participer à cet événement. L\'organisation était parfaite, l\'ambiance géniale et j\'ai appris beaucoup de choses. Je recommande vivement !',
    'is_approved' => true,
    'approved_at' => now(),
    'approved_by' => $user->id
]);

echo "✅ Avis créé avec succès !\n";
echo "📝 Avis ID: {$avis->id}\n";
echo "👤 Utilisateur: {$user->name}\n";
echo "📅 Événement: {$event->title}\n";
echo "⭐ Note: {$avis->rating}/5\n";
echo "\n🔗 Voir les avis: http://127.0.0.1:8000/events/{$event->id}/avis\n";