<?php

namespace App\Http\Controllers;

use App\Services\GeminiAIService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;
use App\Models\User;

class AIController extends Controller
{
    protected $geminiService;

    public function __construct(GeminiAIService $geminiService)
    {
        $this->geminiService = $geminiService;
    }

    /**
     * Test simple de l'IA
     */
    public function testSimple(Request $request)
    {
        $request->validate([
            'prompt' => 'required|string|max:500'
        ]);

        try {
            $prompt = $request->input('prompt');
            $response = $this->geminiService->generateEventDescription([
                'title' => 'Test Simple',
                'type' => 'Test',
                'location' => 'Test',
                'date' => now()->toDateString(),
                'objective' => $prompt
            ]);

            return response()->json([
                'success' => true,
                'response' => $response ?: $prompt . ' - IA réponse reçue!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Erreur de connexion IA: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Générer une description d'événement avec IA
     */
    public function generateEventDescription(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string',
            'location' => 'required|string',
            'date' => 'required|string',
            'objective' => 'required|string'
        ]);

        $eventData = [
            'title' => $request->title,
            'type' => $request->type,
            'location' => $request->location,
            'date' => $request->date,
            'objective' => $request->objective
        ];

        $description = $this->geminiService->generateEventDescription($eventData);

        if ($description) {
            return response()->json([
                'success' => true,
                'description' => $description
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Erreur lors de la génération de la description'
        ], 500);
    }

    /**
     * Obtenir des suggestions d'événements personnalisées
     */
    public function getSuggestedEvents(Request $request)
    {
        $user = Auth::user();
        
        $userProfile = [
            'interests' => $request->input('interests', 'Environnement général'),
            'location' => $request->input('location', 'Tunisie'),
            'experience_level' => $request->input('experience_level', 'Débutant'),
            'availability' => $request->input('availability', 'Week-ends')
        ];

        $suggestions = $this->geminiService->suggestEcoEvents($userProfile);

        if ($suggestions) {
            return response()->json([
                'success' => true,
                'suggestions' => $suggestions
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Erreur lors de la génération des suggestions'
        ], 500);
    }

    /**
     * Analyser le sentiment d'un avis
     */
    public function analyzeSentiment(Request $request)
    {
        $request->validate([
            'text' => 'required|string|max:1000'
        ]);

        $sentiment = $this->geminiService->analyzeSentiment($request->text);

        return response()->json([
            'success' => true,
            'sentiment' => $sentiment,
            'confidence' => $this->getSentimentConfidence($sentiment)
        ]);
    }

    /**
     * Modérer un commentaire
     */
    public function moderateContent(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:1000'
        ]);

        $isApproved = $this->geminiService->moderateContent($request->content);

        return response()->json([
            'success' => true,
            'approved' => $isApproved,
            'action' => $isApproved ? 'approve' : 'moderate'
        ]);
    }

    /**
     * Calculer l'impact carbone d'un événement
     */
    public function calculateCarbonImpact(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id'
        ]);

        $event = Event::find($request->event_id);
        
        $eventData = [
            'type' => $event->category->name ?? 'Événement écologique',
            'participants' => $event->registrations()->count(),
            'duration' => $event->duration ?? '3 heures',
            'activities' => $event->description ?? 'Activités environnementales'
        ];

        $impact = $this->geminiService->calculateCarbonImpact($eventData);

        if ($impact) {
            return response()->json([
                'success' => true,
                'impact' => $impact,
                'event' => [
                    'id' => $event->id,
                    'title' => $event->title
                ]
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Erreur lors du calcul d\'impact'
        ], 500);
    }

    /**
     * Générer des conseils écologiques personnalisés
     */
    public function generateEcoTips(Request $request)
    {
        $context = [
            'situation' => $request->input('situation', 'Vie quotidienne'),
            'location' => $request->input('location', 'Tunisie'),
            'season' => $request->input('season', $this->getCurrentSeason())
        ];

        $tips = $this->geminiService->generateEcoTips($context);

        if ($tips) {
            return response()->json([
                'success' => true,
                'tips' => $tips,
                'context' => $context
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Erreur lors de la génération des conseils'
        ], 500);
    }

    /**
     * Interface d'administration IA
     */
    public function adminDashboard()
    {
        if (!Auth::user() || Auth::user()->role !== 'admin') {
            abort(403, 'Accès réservé aux administrateurs');
        }

        // Statistiques IA
        $stats = [
            'descriptions_generated' => cache()->get('ai_descriptions_count', 0),
            'suggestions_provided' => cache()->get('ai_suggestions_count', 0),
            'content_moderated' => cache()->get('ai_moderation_count', 0),
            'sentiments_analyzed' => cache()->get('ai_sentiment_count', 0)
        ];

        return view('admin.ai.dashboard', compact('stats'));
    }

    /**
     * Test de l'API Gemini
     */
    public function testGeminiConnection()
    {
        if (!Auth::user() || Auth::user()->role !== 'admin') {
            abort(403, 'Accès réservé aux administrateurs');
        }

        $testPrompt = "Dis simplement 'Gemini fonctionne correctement pour EcoEvents' en français.";
        $response = $this->geminiService->generateContent($testPrompt);

        return response()->json([
            'success' => !is_null($response),
            'response' => $response,
            'timestamp' => now()
        ]);
    }

    /**
     * Méthodes privées d'aide
     */
    private function getSentimentConfidence($sentiment)
    {
        // Simulation de niveau de confiance
        $confidenceLevels = [
            'POSITIF' => 0.85,
            'NEGATIF' => 0.82,
            'NEUTRE' => 0.75
        ];

        return $confidenceLevels[$sentiment] ?? 0.70;
    }

    private function getCurrentSeason()
    {
        $month = now()->month;
        
        if ($month >= 3 && $month <= 5) return 'printemps';
        if ($month >= 6 && $month <= 8) return 'été';
        if ($month >= 9 && $month <= 11) return 'automne';
        
        return 'hiver';
    }
}