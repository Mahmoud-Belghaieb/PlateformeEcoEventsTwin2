<?php

// Test direct de création de commentaire
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Commentaire;
use App\Models\Avis;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

echo "🧪 Test de création de commentaire...\n\n";

// Simuler une requête
$user = User::first();
$avis = Avis::first();

if (!$user || !$avis) {
    echo "❌ Pas d'utilisateur ou d'avis en base\n";
    exit(1);
}

// Simuler l'authentification
Auth::login($user);

echo "👤 Utilisateur connecté: {$user->name}\n";
echo "⭐ Avis cible: {$avis->title}\n";
echo "📝 Création du commentaire...\n\n";

try {
    // Simuler la validation
    $content = "Ceci est un commentaire de test créé automatiquement.";
    
    if (strlen($content) < 5) {
        throw new Exception("Contenu trop court");
    }
    
    if (strlen($content) > 500) {
        throw new Exception("Contenu trop long");
    }
    
    // Créer le commentaire
    $commentaire = Commentaire::create([
        'user_id' => $user->id,
        'avis_id' => $avis->id,
        'parent_id' => null,
        'content' => $content,
        'is_approved' => true,
        'approved_at' => now(),
        'approved_by' => $user->id
    ]);
    
    echo "✅ Commentaire créé avec succès !\n";
    echo "🆔 ID: {$commentaire->id}\n";
    echo "💬 Contenu: {$commentaire->content}\n";
    echo "📅 Créé le: {$commentaire->created_at}\n";
    echo "✓ Approuvé: " . ($commentaire->is_approved ? 'Oui' : 'Non') . "\n";
    
    // Vérifier en base
    $check = Commentaire::find($commentaire->id);
    echo "\n🔍 Vérification en base:\n";
    echo $check ? "✅ Commentaire trouvé en base" : "❌ Commentaire non trouvé en base";
    echo "\n\n🔗 Voir: http://127.0.0.1:8000/events/{$avis->event_id}/avis\n";
    
} catch (Exception $e) {
    echo "❌ Erreur: " . $e->getMessage() . "\n";
}