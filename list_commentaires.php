<?php

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Commentaire;

echo "💬 Commentaires existants:\n\n";

$commentaires = Commentaire::with(['user', 'avis.event'])->get();

if ($commentaires->count() == 0) {
    echo "❌ Aucun commentaire trouvé\n";
} else {
    foreach ($commentaires as $c) {
        echo "🆔 ID: {$c->id}\n";
        echo "👤 Utilisateur: {$c->user->name}\n";
        echo "⭐ Avis: {$c->avis->title}\n";
        echo "📅 Événement: {$c->avis->event->title}\n";
        echo '💬 Contenu: '.substr($c->content, 0, 50)."...\n";
        echo '✓ Approuvé: '.($c->is_approved ? 'Oui' : 'Non')."\n";
        echo "🔗 URL Admin: http://127.0.0.1:8000/admin/commentaires/{$c->id}\n";
        echo "---\n";
    }
}
