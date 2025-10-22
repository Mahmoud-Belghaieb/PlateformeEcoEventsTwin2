<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Event;
use App\Models\Venue;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run()
    {
        // Vérifier si on a déjà des événements
        if (Event::count() > 0) {
            $this->command->info('Des événements existent déjà. Seeder ignoré.');

            return;
        }

        // Créer quelques catégories si elles n'existent pas
        $ecoCategorie = Category::firstOrCreate([
            'name' => 'Écologie',
            'slug' => 'ecologie',
            'is_active' => true,
        ]);

        $nettoyageCategorie = Category::firstOrCreate([
            'name' => 'Nettoyage',
            'slug' => 'nettoyage',
            'is_active' => true,
        ]);

        // Créer quelques lieux si ils n'existent pas
        $plage = Venue::firstOrCreate([
            'name' => 'Plage de Carthage',
            'address' => 'Avenue Habib Bourguiba',
            'city' => 'Carthage',
            'postal_code' => '2016',
            'country' => 'Tunisie',
        ]);

        $parc = Venue::firstOrCreate([
            'name' => 'Parc Belvedère',
            'address' => 'Avenue Taieb Mhiri',
            'city' => 'Tunis',
            'postal_code' => '1002',
            'country' => 'Tunisie',
        ]);

        // Créer des événements de test
        $events = [
            [
                'title' => 'Grand Nettoyage de Plage - Carthage',
                'slug' => 'grand-nettoyage-plage-carthage',
                'description' => 'Rejoignez-nous pour une matinée de nettoyage de la magnifique plage de Carthage. Ensemble, préservons notre environnement marin et sensibilisons le public à la pollution plastique.',
                'start_date' => Carbon::now()->addDays(15)->setTime(9, 0),
                'end_date' => Carbon::now()->addDays(15)->setTime(12, 0),
                'max_participants' => 50,
                'price' => 0,
                'status' => 'published',
                'category_id' => $nettoyageCategorie->id,
                'venue_id' => $plage->id,
                'created_by' => 1,
            ],
            [
                'title' => 'Atelier Compostage et Jardinage Urbain',
                'slug' => 'atelier-compostage-jardinage-urbain',
                'description' => 'Découvrez les techniques de compostage et apprenez à créer votre propre jardin urbain. Un atelier pratique pour adopter un mode de vie plus écologique.',
                'start_date' => Carbon::now()->addDays(8)->setTime(14, 0),
                'end_date' => Carbon::now()->addDays(8)->setTime(17, 0),
                'max_participants' => 25,
                'price' => 15.00,
                'status' => 'published',
                'category_id' => $ecoCategorie->id,
                'venue_id' => $parc->id,
                'created_by' => 1,
            ],
            [
                'title' => 'Marche Écologique au Parc Belvedère',
                'slug' => 'marche-ecologique-parc-belvedere',
                'description' => 'Une marche découverte de la biodiversité urbaine avec des experts naturalistes. Apprenez à reconnaître la faune et la flore locales.',
                'start_date' => Carbon::now()->addDays(22)->setTime(16, 0),
                'end_date' => Carbon::now()->addDays(22)->setTime(18, 30),
                'max_participants' => 30,
                'price' => 0,
                'status' => 'published',
                'category_id' => $ecoCategorie->id,
                'venue_id' => $parc->id,
                'created_by' => 1,
            ],
        ];

        foreach ($events as $eventData) {
            Event::create($eventData);
        }

        $this->command->info('✅ Événements créés avec succès !');
        $this->command->info('📊 Total événements : '.Event::count());
    }
}
