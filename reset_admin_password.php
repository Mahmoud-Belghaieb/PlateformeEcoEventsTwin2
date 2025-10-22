<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

echo "=== Resetting Admin Password ===" . PHP_EOL . PHP_EOL;

$admin = User::where('email', 'admin@ecoevents.com')->first();

if (!$admin) {
    echo "❌ Admin user not found!" . PHP_EOL;
    exit(1);
}

// Reset password
$admin->password = Hash::make('admin123');
$admin->role = 'admin'; // Ensure role is set
$admin->save();

echo "✅ Password reset successfully!" . PHP_EOL;
echo PHP_EOL;
echo "===========================================" . PHP_EOL;
echo "       ADMIN LOGIN CREDENTIALS" . PHP_EOL;
echo "===========================================" . PHP_EOL;
echo "Email:    admin@ecoevents.com" . PHP_EOL;
echo "Password: admin123" . PHP_EOL;
echo "===========================================" . PHP_EOL;
echo PHP_EOL;
echo "Login URL: http://localhost:8000/login" . PHP_EOL;
echo PHP_EOL;
echo "Admin Panel URLs:" . PHP_EOL;
echo "- Dashboard:  http://localhost:8000/admin" . PHP_EOL;
echo "- Sponsors:   http://localhost:8000/admin/sponsors" . PHP_EOL;
echo "- Products:   http://localhost:8000/admin/produits" . PHP_EOL;
echo "- Materials:  http://localhost:8000/admin/materiels" . PHP_EOL;
echo PHP_EOL;
