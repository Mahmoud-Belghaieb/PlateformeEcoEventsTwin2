<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\Venue;
use App\Models\Position;
use App\Models\Event;
use App\Models\User;
use App\Models\Registration;

class EventSystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Créer des catégories
        $categories = [
            [
                'name' => 'Nettoyage Environnemental',
                'slug' => 'nettoyage-environnemental',
                'description' => 'Événements de nettoyage de plages, forêts et espaces naturels',
                'color' => '#059669',
                'icon' => 'fa-broom',
                'is_active' => true,
            ],
            [
                'name' => 'Plantation d\'arbres',
                'slug' => 'plantation-arbres',
                'description' => 'Actions de reforestation et plantation',
                'color' => '#10b981',
                'icon' => 'fa-tree',
                'is_active' => true,
            ],
            [
                'name' => 'Sensibilisation',
                'slug' => 'sensibilisation',
                'description' => 'Conférences et ateliers de sensibilisation écologique',
                'color' => '#f97316',
                'icon' => 'fa-lightbulb',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // 2. Créer des lieux
        $venues = [
            [
                'name' => 'Plage de Marseille',
                'description' => 'Belle plage méditerranéenne nécessitant un nettoyage régulier',
                'address' => 'Boulevard de la Corniche',
                'city' => 'Marseille',
                'postal_code' => '13007',
                'country' => 'France',
                'latitude' => 43.2965,
                'longitude' => 5.3698,
                'capacity' => 200,
                'facilities' => ['parking', 'toilettes', 'accès_handicapés'],
                'contact_email' => 'plage@tunis.tn',
                'contact_phone' => '+216 71 234 567',
                'is_active' => true,
            ],
            [
                'name' => 'Parc National du Mercantour',
                'description' => 'Parc naturel pour la reforestation',
                'address' => 'Route du Mercantour',
                'city' => 'Nice',
                'postal_code' => '06000',
                'country' => 'France',
                'latitude' => 44.0582,
                'longitude' => 7.0334,
                'capacity' => 100,
                'facilities' => ['parking', 'refuge'],
                'contact_email' => 'parcnational@environnement.tn',
                'contact_phone' => '+216 70 987 654',
                'is_active' => true,
            ],
        ];

        foreach ($venues as $venue) {
            Venue::create($venue);
        }

        // 3. Créer des postes
        $positions = [
            [
                'title' => 'Coordinateur d\'équipe',
                'description' => 'Responsable d\'une équipe de bénévoles',
                'responsibilities' => 'Organiser, diriger et motiver une équipe de 10-15 bénévoles',
                'requirements' => 'Expérience en management d\'équipe souhaitée',
                'type' => 'coordinator',
                'required_count' => 1,
                'hourly_rate' => 15.00,
                'requires_training' => true,
                'is_active' => true,
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
            ],
            [
                'title' => 'Spécialiste plantation',
                'description' => 'Expert en techniques de plantation d\'arbres',
                'responsibilities' => 'Superviser la plantation, former les bénévoles',
                'requirements' => 'Connaissances en botanique ou sylviculture',
                'type' => 'staff',
                'required_count' => 3,
                'hourly_rate' => 20.00,
                'requires_training' => false,
                'is_active' => true,
            ],
        ];

        foreach ($positions as $position) {
            Position::create($position);
        }

        // 4. Créer des événements
        $events = [
            [
                'title' => 'Grand Nettoyage de Plage - Marseille 2025',
                'slug' => 'grand-nettoyage-plage-marseille-2025',
                'description' => 'Rejoignez-nous pour une journée dédiée au nettoyage de la belle plage de Marseille. Ensemble, nous collecterons les déchets, sensibiliserons le public et préserverons notre environnement marin.',
                'short_description' => 'Nettoyage collectif de la plage de Marseille',
                'category_id' => 1,
                'venue_id' => 1,
                'created_by' => 1, // Admin user
                'start_date' => '2025-11-15 09:00:00',
                'end_date' => '2025-11-15 17:00:00',
                'registration_start' => '2025-10-15 00:00:00',
                'registration_end' => '2025-11-10 23:59:59',
                'max_participants' => 150,
                'price' => 0.00,
                'status' => 'published',
                'requirements' => ['age_minimum' => 16, 'equipement' => 'gants fournis'],
                'featured_image' => null,
                'gallery' => null,
                'is_featured' => true,
                'requires_approval' => false,
                'cancellation_policy' => 'Annulation gratuite jusqu\'à 48h avant l\'événement',
            ],
            [
                'title' => 'Plantation d\'Arbres - Parc du Mercantour',
                'slug' => 'plantation-arbres-mercantour',
                'description' => 'Participez à un effort de reforestation dans le magnifique Parc National du Mercantour. Une journée pour contribuer à la préservation de nos forêts.',
                'short_description' => 'Action de reforestation dans le Mercantour',
                'category_id' => 2,
                'venue_id' => 2,
                'created_by' => 1,
                'start_date' => '2025-12-01 08:00:00',
                'end_date' => '2025-12-01 16:00:00',
                'registration_start' => '2025-11-01 00:00:00',
                'registration_end' => '2025-11-25 23:59:59',
                'max_participants' => 80,
                'price' => 5.00,
                'status' => 'published',
                'requirements' => ['age_minimum' => 18, 'condition_physique' => 'bonne'],
                'featured_image' => null,
                'gallery' => null,
                'is_featured' => false,
                'requires_approval' => true,
                'cancellation_policy' => 'Remboursement intégral jusqu\'à 1 semaine avant',
            ],
        ];

        foreach ($events as $event) {
            Event::create($event);
        }

        // 5. Associer les postes aux événements (Many-to-Many)
        $eventPositions = [
            // Événement 1 (Nettoyage plage) - Postes requis
            ['event_id' => 1, 'position_id' => 1, 'required_count' => 2, 'filled_count' => 0],
            ['event_id' => 1, 'position_id' => 2, 'required_count' => 25, 'filled_count' => 0],
            
            // Événement 2 (Plantation) - Postes requis
            ['event_id' => 2, 'position_id' => 1, 'required_count' => 1, 'filled_count' => 0],
            ['event_id' => 2, 'position_id' => 3, 'required_count' => 2, 'filled_count' => 0],
            ['event_id' => 2, 'position_id' => 2, 'required_count' => 15, 'filled_count' => 0],
        ];

        foreach ($eventPositions as $eventPosition) {
            DB::table('event_positions')->insert(array_merge($eventPosition, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        // 6. Créer des inscriptions d'exemple (Many-to-Many Events ↔ Users)
        $registrations = [
            // Utilisateur 2 (participant) s'inscrit aux 2 événements
            [
                'event_id' => 1,
                'user_id' => 2,
                'type' => 'participant',
                'position_id' => null,
                'status' => 'approved',
                'motivation' => null,
                'registered_at' => now(),
                'approved_at' => now(),
                'approved_by' => 1,
            ],
            [
                'event_id' => 2,
                'user_id' => 2,
                'type' => 'participant',
                'position_id' => null,
                'status' => 'pending',
                'motivation' => 'Passionné par l\'environnement, je souhaite contribuer à la reforestation.',
                'registered_at' => now(),
            ],
            
            // Utilisateur 3 (bénévole) s'inscrit comme bénévole
            [
                'event_id' => 1,
                'user_id' => 3,
                'type' => 'volunteer',
                'position_id' => 2, // Bénévole collecte
                'status' => 'approved',
                'motivation' => 'Je veux aider à nettoyer notre belle plage !',
                'registered_at' => now(),
                'approved_at' => now(),
                'approved_by' => 1,
            ],
            [
                'event_id' => 2,
                'user_id' => 3,
                'type' => 'volunteer',
                'position_id' => 3, // Spécialiste plantation
                'status' => 'approved',
                'motivation' => 'J\'ai une formation en botanique et je veux partager mes connaissances.',
                'registered_at' => now(),
                'approved_at' => now(),
                'approved_by' => 1,
            ],
        ];

        foreach ($registrations as $registration) {
            Registration::create($registration);
        }

        $this->command->info('✅ Système d\'événements créé avec succès !');
        $this->command->info('📊 Relations Many-to-Many Events ↔ Users via registrations configurées');
        $this->command->info('🎯 2 événements créés avec des inscriptions d\'exemple');
    }
}
