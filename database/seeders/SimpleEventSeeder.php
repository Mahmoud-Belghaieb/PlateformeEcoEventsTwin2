<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SimpleEventSeeder extends Seeder
{
    public function run()
    {
        // Insérer des catégories directement avec DB
        DB::table('categories')->insert([
            [
                'name' => 'Nettoyage Environnemental',
                'slug' => 'nettoyage-environnemental',
                'description' => 'Événements de nettoyage de plages, forêts et espaces naturels',
                'color' => '#059669',
                'icon' => 'fa-broom',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Plantation d\'arbres',
                'slug' => 'plantation-arbres',
                'description' => 'Actions de reforestation et plantation',
                'color' => '#10b981',
                'icon' => 'fa-tree',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sensibilisation',
                'slug' => 'sensibilisation',
                'description' => 'Conférences et ateliers de sensibilisation écologique',
                'color' => '#f97316',
                'icon' => 'fa-lightbulb',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Insérer des lieux
        DB::table('venues')->insert([
            [
                'name' => 'Plage de La Marsa',
                'description' => 'Belle plage tunisienne nécessitant un nettoyage régulier',
                'address' => 'Corniche de La Marsa',
                'city' => 'La Marsa',
                'postal_code' => '2078',
                'country' => 'Tunisie',
                'latitude' => 36.8785,
                'longitude' => 10.3247,
                'capacity' => 200,
                'facilities' => '["parking", "toilettes", "accès_handicapés"]',
                'contact_email' => 'plage@tunis.tn',
                'contact_phone' => '+216 71 234 567',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Parc National de Ichkeul',
                'description' => 'Parc naturel tunisien pour la reforestation et conservation',
                'address' => 'Route de Ichkeul',
                'city' => 'Bizerte',
                'postal_code' => '7000',
                'country' => 'Tunisie',
                'latitude' => 37.1500,
                'longitude' => 9.6750,
                'capacity' => 100,
                'facilities' => '["parking", "refuge"]',
                'contact_email' => 'parcnational@environnement.tn',
                'contact_phone' => '+216 70 987 654',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Insérer des postes
        DB::table('positions')->insert([
            [
                'title' => 'Coordinateur d\'équipe',
                'description' => 'Responsable d\'une équipe de bénévoles',
                'responsibilities' => 'Organiser, diriger et motiver une équipe de 10-15 bénévoles',
                'requirements' => 'Expérience en management d\'équipe souhaitée',
                'type' => 'coordinator',
                'required_count' => 1,
                'hourly_rate' => 45.00, // TND par heure
                'requires_training' => true,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Bénévole collecte',
                'description' => 'Participation au nettoyage et à la collecte des déchets',
                'responsibilities' => 'Ramasser les déchets, trier selon les consignes',
                'requirements' => 'Aucune expérience requise, motivation essentielle',
                'type' => 'volunteer',
                'required_count' => 20,
                'hourly_rate' => null,
                'requires_training' => false,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Insérer des événements
        DB::table('events')->insert([
            [
                'title' => 'Grand Nettoyage de Plage - La Marsa 2025',
                'slug' => 'grand-nettoyage-plage-la-marsa-2025',
                'description' => 'Rejoignez-nous pour une journée dédiée au nettoyage de la belle plage de La Marsa.',
                'short_description' => 'Nettoyage collectif de la plage de La Marsa',
                'category_id' => 1,
                'venue_id' => 1,
                'created_by' => 1,
                'start_date' => '2025-11-15 09:00:00',
                'end_date' => '2025-11-15 17:00:00',
                'registration_start' => '2025-10-15 00:00:00',
                'registration_end' => '2025-11-10 23:59:59',
                'max_participants' => 150,
                'price' => 0.00,
                'status' => 'published',
                'requirements' => '{"age_minimum": 16, "equipement": "gants fournis"}',
                'featured_image' => null,
                'gallery' => null,
                'is_featured' => true,
                'requires_approval' => false,
                'cancellation_policy' => 'Annulation gratuite jusqu\'à 48h avant l\'événement',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Plantation d\'Arbres - Parc Ichkeul',
                'slug' => 'plantation-arbres-ichkeul',
                'description' => 'Participez à un effort de reforestation dans le magnifique Parc National de Ichkeul.',
                'short_description' => 'Action de reforestation au Parc Ichkeul',
                'category_id' => 2,
                'venue_id' => 2,
                'created_by' => 1,
                'start_date' => '2025-12-01 08:00:00',
                'end_date' => '2025-12-01 16:00:00',
                'registration_start' => '2025-11-01 00:00:00',
                'registration_end' => '2025-11-25 23:59:59',
                'max_participants' => 80,
                'price' => 15.00,
                'status' => 'published',
                'requirements' => '{"age_minimum": 18, "condition_physique": "bonne"}',
                'featured_image' => null,
                'gallery' => null,
                'is_featured' => false,
                'requires_approval' => true,
                'cancellation_policy' => 'Remboursement intégral jusqu\'à 1 semaine avant',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Quelques inscriptions exemple
        DB::table('registrations')->insert([
            [
                'event_id' => 1,
                'user_id' => 1,
                'type' => 'participant',
                'position_id' => null,
                'status' => 'approved',
                'motivation' => null,
                'registered_at' => now(),
                'approved_at' => now(),
                'approved_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $this->command->info('✅ Données d\'événements créées avec succès !');
        $this->command->info('💰 Devises utilisées : TND (Dinar Tunisien)');
    }
}
