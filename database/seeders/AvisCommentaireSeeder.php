<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Avis;
use App\Models\Commentaire;
use App\Models\User;
use App\Models\Event;
use App\Models\Registration;

class AvisCommentaireSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();
        $events = Event::all();

        if ($users->count() === 0 || $events->count() === 0) {
            $this->command->info('Pas d\'utilisateurs ou d\'événements trouvés. Création de données de base...');
            
            // Créer quelques utilisateurs si aucun n'existe
            if ($users->count() === 0) {
                $users = collect([
                    User::create([
                        'name' => 'Alice Martin',
                        'email' => 'alice@example.com',
                        'password' => bcrypt('password'),
                        'role' => 'participant',
                        'is_active' => true,
                    ]),
                    User::create([
                        'name' => 'Bob Dupont',
                        'email' => 'bob@example.com',
                        'password' => bcrypt('password'),
                        'role' => 'participant',
                        'is_active' => true,
                    ]),
                    User::create([
                        'name' => 'Claire Rousseau',
                        'email' => 'claire@example.com',
                        'password' => bcrypt('password'),
                        'role' => 'participant',
                        'is_active' => true,
                    ]),
                ]);
            }
        }

        // Créer des inscriptions pour que les utilisateurs puissent donner des avis
        foreach ($events->take(3) as $event) {
            foreach ($users->take(3) as $user) {
                // Créer une inscription approuvée
                Registration::updateOrCreate([
                    'user_id' => $user->id,
                    'event_id' => $event->id,
                ], [
                    'type' => 'participant',
                    'status' => 'approved',
                    'registered_at' => now()->subDays(rand(10, 30)),
                    'approved_at' => now()->subDays(rand(5, 25)),
                    'approved_by' => 1, // Admin
                ]);
            }
        }

        // Créer des avis de test
        $avisTexts = [
            [
                'title' => 'Événement fantastique !',
                'content' => 'J\'ai participé à cet événement éco-responsable et j\'ai été absolument ravi ! L\'organisation était parfaite, les intervenants très compétents et l\'ambiance conviviale. J\'ai beaucoup appris sur les gestes écologiques au quotidien.',
                'rating' => 5
            ],
            [
                'title' => 'Très enrichissant',
                'content' => 'Une expérience très positive. Les ateliers étaient bien organisés et les informations partagées très utiles. Quelques petits points d\'amélioration possibles sur la logistique mais dans l\'ensemble, très satisfait.',
                'rating' => 4
            ],
            [
                'title' => 'Bonne initiative',
                'content' => 'Contenu intéressant et pertinent. L\'événement m\'a permis de découvrir de nouvelles pratiques écologiques. L\'équipe était accueillante et disponible pour répondre aux questions.',
                'rating' => 4
            ],
            [
                'title' => 'Correct mais peut mieux faire',
                'content' => 'L\'événement était correct dans l\'ensemble. Quelques aspects pourraient être améliorés, notamment la durée de certains ateliers qui étaient un peu courts. Mais l\'idée générale est bonne.',
                'rating' => 3
            ],
            [
                'title' => 'Excellente sensibilisation',
                'content' => 'Parfait pour sensibiliser aux enjeux environnementaux ! Les activités étaient variées et adaptées à tous les âges. Bravo pour cette belle initiative qui mérite d\'être renouvelée.',
                'rating' => 5
            ],
            [
                'title' => 'Déçu par l\'organisation',
                'content' => 'L\'idée de l\'événement était bonne mais l\'organisation laissait à désirer. Trop d\'attente entre les ateliers et manque de communication. Dommage car le contenu était intéressant.',
                'rating' => 2
            ]
        ];

        $commentaireTexts = [
            'Merci pour ce retour positif ! Cela nous encourage à continuer.',
            'Nous prenons note de vos remarques pour améliorer nos prochains événements.',
            'Ravi que l\'événement vous ait plu ! À bientôt pour de nouvelles aventures éco-responsables.',
            'Nous sommes désolés que l\'organisation n\'ait pas été à la hauteur. Nous travaillons à nous améliorer.',
            'Merci d\'avoir participé ! Votre retour nous aide à progresser.',
            'Excellent retour ! N\'hésitez pas à partager votre expérience autour de vous.',
            'Nous sommes ravis que vous ayez apprécié nos ateliers !',
            'Merci pour vos suggestions constructives.',
        ];

        $reponsesTexts = [
            'Tout à fait d\'accord avec vous !',
            'Merci pour ce complément d\'information.',
            'J\'ai eu la même expérience, très enrichissant !',
            'Merci pour ce partage d\'expérience.',
            'Excellente remarque !',
            'Je suis du même avis.',
        ];

        foreach ($events->take(3) as $event) {
            // Créer 2-4 avis par événement
            $nombreAvis = rand(2, 4);
            $usersForEvent = $users->shuffle()->take($nombreAvis);
            
            foreach ($usersForEvent as $index => $user) {
                $avisData = $avisTexts[array_rand($avisTexts)];
                
                $avis = Avis::create([
                    'user_id' => $user->id,
                    'event_id' => $event->id,
                    'rating' => $avisData['rating'],
                    'title' => $avisData['title'],
                    'content' => $avisData['content'],
                    'is_approved' => rand(0, 1) == 1, // 50% de chance d'être approuvé
                    'approved_at' => rand(0, 1) == 1 ? now()->subDays(rand(1, 5)) : null,
                    'approved_by' => rand(0, 1) == 1 ? 1 : null, // Admin
                ]);

                // Créer 1-3 commentaires par avis (60% de chance)
                if (rand(1, 10) <= 6) {
                    $nombreCommentaires = rand(1, 3);
                    $usersForComments = $users->where('id', '!=', $user->id)->shuffle()->take($nombreCommentaires);
                    
                    foreach ($usersForComments as $commentUser) {
                        $commentaire = Commentaire::create([
                            'user_id' => $commentUser->id,
                            'avis_id' => $avis->id,
                            'content' => $commentaireTexts[array_rand($commentaireTexts)],
                            'is_approved' => rand(0, 1) == 1, // 50% de chance d'être approuvé
                            'approved_at' => rand(0, 1) == 1 ? now()->subDays(rand(1, 3)) : null,
                            'approved_by' => rand(0, 1) == 1 ? 1 : null,
                        ]);

                        // Créer une réponse au commentaire (30% de chance)
                        if (rand(1, 10) <= 3) {
                            $replyUser = $users->where('id', '!=', $commentUser->id)->random();
                            Commentaire::create([
                                'user_id' => $replyUser->id,
                                'avis_id' => $avis->id,
                                'parent_id' => $commentaire->id,
                                'content' => $reponsesTexts[array_rand($reponsesTexts)],
                                'is_approved' => rand(0, 1) == 1,
                                'approved_at' => rand(0, 1) == 1 ? now()->subDays(rand(1, 2)) : null,
                                'approved_by' => rand(0, 1) == 1 ? 1 : null,
                            ]);
                        }
                    }
                }
            }
        }

        $this->command->info('✅ Avis et commentaires créés avec succès !');
        $this->command->info('📊 Statistiques :');
        $this->command->info('   - Avis créés : ' . Avis::count());
        $this->command->info('   - Avis approuvés : ' . Avis::where('is_approved', true)->count());
        $this->command->info('   - Commentaires créés : ' . Commentaire::count());
        $this->command->info('   - Commentaires approuvés : ' . Commentaire::where('is_approved', true)->count());
    }
}
