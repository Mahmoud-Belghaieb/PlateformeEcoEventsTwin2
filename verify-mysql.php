<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "========================================\n";
echo "EcoEvents - Database Connection Status\n";
echo "========================================\n\n";

try {
    // Test database connection
    $pdo = DB::connection()->getPDO();
    echo "✓ MySQL Connection: SUCCESS\n";
    echo "  Database: " . DB::connection()->getDatabaseName() . "\n";
    echo "  Driver: " . DB::connection()->getDriverName() . "\n\n";
    
    // Check users
    $userCount = App\Models\User::count();
    echo "✓ Users in database: {$userCount}\n\n";
    
    if ($userCount > 0) {
        echo "User accounts:\n";
        $users = App\Models\User::select('name', 'email', 'role', 'is_active')->get();
        foreach ($users as $user) {
            $status = $user->is_active ? 'Active' : 'Inactive';
            echo "  - {$user->name} ({$user->email})\n";
            echo "    Role: {$user->role} | Status: {$status}\n\n";
        }
    }
    
    echo "🎉 Your Laravel project is successfully connected to MySQL via XAMPP!\n";
    echo "   You can access phpMyAdmin at: http://localhost/phpmyadmin\n";
    
} catch (Exception $e) {
    echo "✗ Database Connection Failed: " . $e->getMessage() . "\n";
    echo "  Make sure XAMPP MySQL service is running.\n";
}

echo "\n========================================\n";
?>