<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

echo '=== EcoEvents Admin Creator ==='.PHP_EOL.PHP_EOL;

// Check existing users
echo 'Current Users:'.PHP_EOL;
$users = User::all();
foreach ($users as $user) {
    echo "- ID: {$user->id} | Name: {$user->name} | Email: {$user->email} | Role: ".($user->role ?? 'user').PHP_EOL;
}
echo PHP_EOL;

// Check if admin exists
$adminExists = User::where('role', 'admin')->exists();

if ($adminExists) {
    echo 'Admin user already exists!'.PHP_EOL;
    $admin = User::where('role', 'admin')->first();
    echo PHP_EOL;
    echo '=== ADMIN CREDENTIALS ==='.PHP_EOL;
    echo "Email: {$admin->email}".PHP_EOL;
    echo 'Password: (you need to reset it if forgotten)'.PHP_EOL;
    echo PHP_EOL;

    echo 'Do you want to create a NEW admin user? (yes/no): ';
    $handle = fopen('php://stdin', 'r');
    $line = fgets($handle);
    if (trim($line) != 'yes') {
        echo 'Exiting...'.PHP_EOL;
        exit;
    }
    fclose($handle);
}

// Create new admin
echo PHP_EOL.'Creating new admin user...'.PHP_EOL;

$admin = User::create([
    'name' => 'Admin',
    'email' => 'admin@ecoevents.tn',
    'password' => Hash::make('admin123'),
    'role' => 'admin',
    'email_verified_at' => now(),
]);

echo PHP_EOL;
echo '✅ Admin user created successfully!'.PHP_EOL;
echo PHP_EOL;
echo '==========================================='.PHP_EOL;
echo '       ADMIN LOGIN CREDENTIALS'.PHP_EOL;
echo '==========================================='.PHP_EOL;
echo 'Email:    admin@ecoevents.tn'.PHP_EOL;
echo 'Password: admin123'.PHP_EOL;
echo '==========================================='.PHP_EOL;
echo PHP_EOL;
echo '⚠️  Please change this password after first login!'.PHP_EOL;
echo PHP_EOL;
echo 'You can now login at: http://localhost:8000/login'.PHP_EOL;
echo PHP_EOL;
