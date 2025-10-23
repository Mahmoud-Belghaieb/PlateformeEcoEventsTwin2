<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user if it doesn't exist
        User::firstOrCreate(
            ['email' => 'admin@ecoevents.com'],
            [
                'name' => 'Administrateur EcoEvents',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // Create sample participant
        User::firstOrCreate(
            ['email' => 'participant@ecoevents.com'],
            [
                'name' => 'Jean Participant',
                'password' => Hash::make('participant123'),
                'role' => 'participant',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // Create sample volunteer
        User::firstOrCreate(
            ['email' => 'volunteer@ecoevents.com'],
            [
                'name' => 'Marie Bénévole',
                'password' => Hash::make('volunteer123'),
                'role' => 'volunteer',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );
    }
}
