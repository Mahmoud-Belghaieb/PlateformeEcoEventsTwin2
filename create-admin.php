<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

use App\Models\User;
use Illuminate\Support\Facades\Hash;

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Supprimer l'ancien admin s'il existe
User::where('email', 'admin@ecoevents.com')->delete();

// Créer le nouvel administrateur
$admin = new User;
$admin->name = 'Administrateur';
$admin->email = 'admin@ecoevents.com';
$admin->password = Hash::make('admin123');
$admin->role = 'admin';
$admin->is_active = true;
$admin->email_verified_at = now();
$admin->save();

echo "Administrateur créé avec succès!\n";
echo "Email: admin@ecoevents.com\n";
echo "Mot de passe: admin123\n";
