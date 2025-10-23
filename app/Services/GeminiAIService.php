<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class GeminiAIService
{
    protected $apiKey;
    protected $model;
    protected $baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models/';

    public function __construct()
    {
        $this->apiKey = config('gemini.api_key');
        $this->model = config('gemini.model', 'gemini-1.5-flash');
    }

    /**
     * Générer du contenu avec Gemini
     */
    public function generateContent($prompt, array $options = [])
    {
        try {
            $url = $this->baseUrl . $this->model . ':generateContent?key=' . $this->apiKey;

            $payload = [
                'contents' => [
                    [
                        'parts' => [
                            [
                                'text' => $prompt
                            ]
                        ]
                    ]
                ]
            ];

            // Ajouter des paramètres de génération si fournis
            if (!empty($options)) {
                $payload['generationConfig'] = $options;
            }

            $response = Http::timeout(30)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                ])
                ->post($url, $payload);

            if ($response->successful()) {
                $data = $response->json();
                return $data['candidates'][0]['content']['parts'][0]['text'] ?? null;
            }

            Log::error('Gemini API Error: ' . $response->body());
            return null;

        } catch (Exception $e) {
            Log::error('Gemini Service Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Générer une description d'événement écologique
     */
    public function generateEventDescription($eventData)
    {
        $prompt = "Génère une description captivante et professionnelle pour un événement écologique avec les informations suivantes :

Titre : {$eventData['title']}
Type : {$eventData['type']}
Lieu : {$eventData['location']}
Date : {$eventData['date']}
Objectif : {$eventData['objective']}

La description doit :
- Être engageante et motivante
- Mettre l'accent sur l'impact environnemental positif
- Encourager la participation communautaire
- Faire maximum 200 mots
- Être en français
- Inclure des mots-clés écologiques pertinents

Format : Description directe sans titre ni formatage.";

        return $this->generateContent($prompt, [
            'maxOutputTokens' => 300,
            'temperature' => 0.7
        ]);
    }

    /**
     * Suggérer des événements personnalisés
     */
    public function suggestEcoEvents($userProfile)
    {
        $prompt = "Suggère 3 événements écologiques personnalisés pour un utilisateur avec ce profil :

Intérêts : {$userProfile['interests']}
Localisation : {$userProfile['location']}
Niveau d'expérience : {$userProfile['experience_level']}
Disponibilité : {$userProfile['availability']}

Chaque suggestion doit inclure :
- Titre de l'événement
- Type d'activité
- Impact environnemental attendu
- Durée estimée

Format : Liste numérotée, chaque événement en 2-3 lignes maximum.
Langue : Français";

        return $this->generateContent($prompt, [
            'maxOutputTokens' => 400,
            'temperature' => 0.8
        ]);
    }

    /**
     * Analyser le sentiment d'un avis/commentaire
     */
    public function analyzeSentiment($text)
    {
        $prompt = "Analyse le sentiment de ce commentaire sur un événement écologique :

\"$text\"

Réponds uniquement par :
- POSITIF (si le commentaire est favorable, enthousiaste, satisfait)
- NEGATIF (si le commentaire est critique, mécontent, déçu)  
- NEUTRE (si le commentaire est factuel, sans émotion marquée)

Réponse :";

        $result = $this->generateContent($prompt, [
            'maxOutputTokens' => 10,
            'temperature' => 0.1
        ]);

        // Normaliser la réponse
        if ($result) {
            $sentiment = strtoupper(trim($result));
            if (in_array($sentiment, ['POSITIF', 'NEGATIF', 'NEUTRE'])) {
                return $sentiment;
            }
        }

        return 'NEUTRE'; // Valeur par défaut
    }

    /**
     * Modération de contenu
     */
    public function moderateContent($content)
    {
        $prompt = "Évalue si ce contenu est approprié pour une plateforme d'événements écologiques :

\"$content\"

Vérifie :
- Langage inapproprié ou offensant
- Contenu hors-sujet (non écologique)
- Spam ou promotion excessive
- Informations fausses sur l'environnement

Réponds uniquement par :
- APPROUVE (si le contenu est approprié)
- REJETE (si le contenu doit être modéré)

Réponse :";

        $result = $this->generateContent($prompt, [
            'maxOutputTokens' => 10,
            'temperature' => 0.1
        ]);

        if ($result) {
            $moderation = strtoupper(trim($result));
            if (in_array($moderation, ['APPROUVE', 'REJETE'])) {
                return $moderation === 'APPROUVE';
            }
        }

        return false; // Rejeter par défaut en cas de doute
    }

    /**
     * Calculer l'impact carbone d'un événement
     */
    public function calculateCarbonImpact($eventData)
    {
        $prompt = "Estime l'impact carbone potentiellement économisé par cet événement écologique :

Type d'événement : {$eventData['type']}
Nombre de participants : {$eventData['participants']}
Durée : {$eventData['duration']}
Activités : {$eventData['activities']}

Fournis :
- Estimation CO2 économisé (en kg)
- Équivalence concrète (ex: X arbres plantés, Y voitures retirées)
- Impact environnemental principal

Format : Réponse courte et claire, maximum 3 lignes.";

        return $this->generateContent($prompt, [
            'maxOutputTokens' => 150,
            'temperature' => 0.6
        ]);
    }

    /**
     * Générer des conseils écologiques personnalisés
     */
    public function generateEcoTips($context)
    {
        $prompt = "Donne 3 conseils écologiques pratiques et réalisables pour :

Contexte : {$context['situation']}
Localisation : {$context['location']}
Saison : {$context['season']}

Chaque conseil doit :
- Être actionnable immédiatement
- Avoir un impact environnemental mesurable
- Être adapté au contexte tunisien
- Être en français

Format : Liste à puces, chaque conseil en 1 ligne.";

        return $this->generateContent($prompt, [
            'maxOutputTokens' => 200,
            'temperature' => 0.7
        ]);
    }
}