<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Event;
use App\Models\User;
use App\Models\Category;
use App\Models\Venue;

// Create events with different statuses
$user = User::first();
$category = Category::first();
$venue = Venue::first();

if ($user && $category && $venue) {
    // Pending event
    Event::create([
        'title' => 'Eco Workshop - Pending Approval',
        'description' => 'This event is waiting for admin approval.',
        'slug' => 'eco-workshop-pending-' . uniqid(),
        'start_date' => now()->addDays(7),
        'end_date' => now()->addDays(7)->addHours(2),
        'price' => 25.00,
        'max_participants' => 30,
        'category_id' => $category->id,
        'venue_id' => $venue->id,
        'created_by' => $user->id,
        'status' => 'pending',
    ]);
    
    // Rejected event
    Event::create([
        'title' => 'Green Energy Summit - Rejected',
        'description' => 'This event was rejected by the admin.',
        'slug' => 'green-energy-summit-rejected-' . uniqid(),
        'start_date' => now()->addDays(10),
        'end_date' => now()->addDays(10)->addHours(3),
        'price' => 50.00,
        'max_participants' => 50,
        'category_id' => $category->id,
        'venue_id' => $venue->id,
        'created_by' => $user->id,
        'status' => 'rejected',
        'rejection_reason' => 'Event content does not align with our eco-friendly guidelines.',
    ]);
    
    echo 'Test events created successfully!' . PHP_EOL;
    echo 'Pending event: Eco Workshop - Pending Approval' . PHP_EOL;
    echo 'Rejected event: Green Energy Summit - Rejected' . PHP_EOL;
} else {
    echo 'Missing required data:' . PHP_EOL;
    echo 'User exists: ' . ($user ? 'Yes' : 'No') . PHP_EOL;
    echo 'Category exists: ' . ($category ? 'Yes' : 'No') . PHP_EOL;
    echo 'Venue exists: ' . ($venue ? 'Yes' : 'No') . PHP_EOL;
}