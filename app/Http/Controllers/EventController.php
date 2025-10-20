<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;
use App\Models\Category;
use App\Models\Registration;
use App\Models\Avis;

class EventController extends Controller
{
    public function index()
    {
        // Récupérer les événements publiés avec leurs relations
        $events = Event::with(['category', 'venue'])
            ->where('status', 'published')
            ->orderBy('start_date', 'asc')
            ->get();
        
        // Récupérer toutes les catégories pour le filtrage
        $categories = Category::where('is_active', true)->get();
        
        return view('events.index', compact('events', 'categories'));
    }

    public function show($slug)
    {
        // Trouver l'événement par son slug avec toutes ses relations
        $event = Event::with(['category', 'venue', 'positions', 'registrations.user', 'avisApprouves.user', 'avisApprouves.commentaires.user'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();
        
        $isRegistered = false;
        if (Auth::check()) {
            $isRegistered = $event->isUserRegistered(Auth::id());
        }
        
        // Récupérer les avis approuvés avec pagination
        $avis = $event->avisApprouves()
            ->with(['user', 'commentaires' => function($query) {
                $query->where('is_approved', true)->with('user');
            }])
            ->orderBy('created_at', 'desc')
            ->paginate(5);
        
        // Calculer les statistiques des avis
        $avisStats = [
            'total' => $event->nombreAvis(),
            'moyenne' => round($event->noteMoyenne(), 1),
            'repartition' => $event->repartitionNotes()
        ];
        
        return view('events.show', compact('event', 'isRegistered', 'avis', 'avisStats'));
    }

    public function myEvents()
    {
        // Vérifier que l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $userId = Auth::id();
        
        // Récupérer les événements où l'utilisateur est participant
        $participatedEvents = Event::whereHas('registrations', function($query) use ($userId) {
            $query->where('user_id', $userId)
                  ->where('type', 'participant')
                  ->where('status', 'approved');
        })->with(['category', 'venue'])->get();

        // Récupérer les événements où l'utilisateur est bénévole
        $volunteeredEvents = Event::whereHas('registrations', function($query) use ($userId) {
            $query->where('user_id', $userId)
                  ->where('type', 'volunteer')
                  ->where('status', 'approved');
        })->with(['category', 'venue', 'positions'])->get();
        
        return view('events.my-events', compact('participatedEvents', 'volunteeredEvents'));
    }

    public function register(Request $request, $eventId)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour vous inscrire.');
        }

        $event = Event::findOrFail($eventId);
        $userId = Auth::id();

        // Vérifier si l'utilisateur est déjà inscrit
        if ($event->isUserRegistered($userId)) {
            return back()->with('warning', 'Vous êtes déjà inscrit à cet événement.');
        }

        // Vérifier la capacité de l'événement
        $approvedCount = $event->registrations()->where('status', 'approved')->count();
        if ($event->max_participants && $approvedCount >= $event->max_participants) {
            return back()->with('error', 'Cet événement a atteint sa capacité maximale.');
        }

        // Créer l'inscription - toujours en attente pour approbation admin
        Registration::create([
            'event_id' => $eventId,
            'user_id' => $userId,
            'type' => $request->input('type', 'participant'),
            'position_id' => $request->input('position_id'),
            'status' => 'pending', // Toujours en attente
            'motivation' => $request->input('motivation'),
            'registered_at' => now(),
            'approved_at' => null,
            'approved_by' => null
        ]);

        return back()->with('success', 'Votre inscription a été soumise avec succès ! Elle est en attente d\'approbation par l\'administrateur.');
    }

    public function testRelations()
    {
        // Statistiques réelles de la base de données
        $stats = [
            'total_events' => Event::count(),
            'published_events' => Event::where('status', 'published')->count(),
            'total_registrations' => Registration::count(),
            'participants' => Registration::where('type', 'participant')->count(),
            'volunteers' => Registration::where('type', 'volunteer')->count(),
            'categories' => Category::count(),
            'venues' => \App\Models\Venue::count(),
            'positions' => \App\Models\Position::count()
        ];

        // Exemples de relations Many-to-Many
        $examples = [];
        
        // Récupérer quelques événements avec leurs utilisateurs
        $eventsWithUsers = Event::with(['users' => function($query) {
            $query->take(3); // Limiter à 3 utilisateurs par événement
        }])->take(2)->get();

        foreach ($eventsWithUsers as $event) {
            $examples[] = [
                'event' => $event->title,
                'registered_users' => $event->users->count(),
                'users_sample' => $event->users->pluck('name')->toArray()
            ];
        }

        return response()->json([
            'message' => 'Système Many-to-Many Events ↔ Users opérationnel',
            'status' => 'Base de données intégrée avec succès',
            'statistics' => $stats,
            'relation_examples' => $examples,
            'tables_status' => [
                'categories' => 'Active',
                'venues' => 'Active', 
                'positions' => 'Active',
                'events' => 'Active',
                'registrations' => 'Active - Many-to-Many principale'
            ]
        ]);
    }
}
