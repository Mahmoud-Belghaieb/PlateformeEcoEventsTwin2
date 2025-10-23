<?php

// Script pour créer un commentaire de test
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Avis;
use App\Models\Commentaire;
use App\Models\User;

// Récupérer le premier utilisateur et le premier avis
$user = User::first();
$avis = Avis::first();

if (! $user || ! $avis) {
    echo "❌ Vous devez avoir au moins un utilisateur et un avis en base.\n";
    echo "💡 Créez d'abord un avis avec: php create_test_avis.php\n";
    exit(1);
}

// Créer un commentaire de test
$commentaire = Commentaire::create([
    'user_id' => $user->id,
    'avis_id' => $avis->id,
    'parent_id' => null, // Commentaire principal (pas de réponse)
    'content' => 'Merci pour ce partage ! Je suis tout à fait d\'accord avec votre avis.',
    'is_approved' => true,
    'approved_at' => now(),
    'approved_by' => $user->id,
]);

echo "✅ Commentaire créé avec succès !\n";
echo "📝 Commentaire ID: {$commentaire->id}\n";
echo "👤 Utilisateur: {$user->name}\n";
echo "⭐ Avis concerné: {$avis->title}\n";
echo "💬 Contenu: {$commentaire->content}\n";
echo "\n🔗 Voir les avis: http://127.0.0.1:8000/events/{$avis->event_id}/avis\n";
