<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Create admin user
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

        // Create organizer user
        User::firstOrCreate(
            ['email' => 'organisateur@ecoevents.com'],
            [
                'name' => 'Marc Organisateur',
                'password' => Hash::make('organisateur123'),
                'role' => 'organizer',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // Create volunteer user
        User::firstOrCreate(
            ['email' => 'benevole@ecoevents.com'],
            [
                'name' => 'Marie Bénévole',
                'password' => Hash::make('benevole123'),
                'role' => 'volunteer',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // Create participant user
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

        // Créer d'autres utilisateurs que vous aviez avant
        // Ajoutez ici les autres utilisateurs que vous souhaitez recréer
        User::firstOrCreate(
            ['email' => 'emna.borgi33@gmail.com'],
            [
                'name' => 'Emna Borgi',
                'password' => Hash::make('password123'),
                'role' => 'participant',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );
    }
}