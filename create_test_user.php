<?php

require 'vendor/autoload.php';

$app = require 'bootstrap/app.php';
$app->boot();

// Créer un utilisateur de test
$user = \App\Models\User::firstOrCreate([
    'email' => 'test@example.com',
], [
    'name' => 'Utilisateur Test',
    'password' => bcrypt('password'),
    'role' => 'participant',
    'is_active' => true,
    'email_verified_at' => now(),
]);

echo "Utilisateur de test créé:\n";
echo "Email: test@example.com\n";
echo "Mot de passe: password\n";
echo "ID: {$user->id}\n";
