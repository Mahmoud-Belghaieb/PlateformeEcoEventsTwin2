<?php

namespace App\Http\Controllers;

use App\Models\Avis;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AvisController extends Controller
{
    /**
     * Afficher les avis d'un événement
     */
    public function index($eventId)
    {
        $event = Event::with(['avisApprouves.user', 'avisApprouves.commentairesApprouves.user'])->findOrFail($eventId);
        
        $avis = $event->avisApprouves()
            ->with(['user', 'commentairesApprouves.user', 'commentairesApprouves.reponsesApprouvees.user'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $noteMoyenne = $event->noteMoyenne();
        $nombreAvis = $event->nombreAvis();
        $repartitionNotes = Avis::repartitionNotesEvent($eventId);

        // Vérifier si l'utilisateur connecté a déjà donné un avis
        $userAvis = null;
        if (Auth::check()) {
            $userAvis = Avis::where('user_id', Auth::id())
                ->where('event_id', $eventId)
                ->first();
        }

        // Vérifier si l'utilisateur a participé à l'événement
        $hasParticipated = false;
        if (Auth::check()) {
            $hasParticipated = $event->registrations()
                ->where('user_id', Auth::id())
                ->where('status', 'approved')
                ->exists();
        }

        return view('avis.index', compact(
            'event', 
            'avis', 
            'noteMoyenne', 
            'nombreAvis', 
            'repartitionNotes',
            'userAvis',
            'hasParticipated'
        ));
    }

    /**
     * Afficher le formulaire de création d'avis
     */
    public function create($eventId)
    {
        $event = Event::findOrFail($eventId);
        
        // Vérifier si l'utilisateur a déjà donné un avis
        $existingAvis = Avis::where('user_id', Auth::id())
            ->where('event_id', $eventId)
            ->first();

        if ($existingAvis) {
            return redirect()->route('avis.index', $eventId)
                ->with('error', 'Vous avez déjà donné un avis pour cet événement.');
        }

        // Vérifier si l'utilisateur a participé à l'événement
        $hasParticipated = $event->registrations()
            ->where('user_id', Auth::id())
            ->where('status', 'approved')
            ->exists();

        if (!$hasParticipated) {
            return redirect()->route('avis.index', $eventId)
                ->with('error', 'Vous devez avoir participé à cet événement pour donner un avis.');
        }

        return view('avis.create', compact('event'));
    }

    /**
     * Créer un nouvel avis
     */
    public function store(Request $request, $eventId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'nullable|string|max:255',
            'content' => 'required|string|min:10|max:1000'
        ]);

        $event = Event::findOrFail($eventId);

        // Vérifier si l'utilisateur a déjà donné un avis
        $existingAvis = Avis::where('user_id', Auth::id())
            ->where('event_id', $eventId)
            ->first();

        if ($existingAvis) {
            return back()->with('error', 'Vous avez déjà donné un avis pour cet événement.');
        }

        // Vérifier si l'utilisateur a participé à l'événement
        $hasParticipated = $event->registrations()
            ->where('user_id', Auth::id())
            ->where('status', 'approved')
            ->exists();

        if (!$hasParticipated) {
            return back()->with('error', 'Vous devez avoir participé à cet événement pour donner un avis.');
        }

        Avis::create([
            'user_id' => Auth::id(),
            'event_id' => $eventId,
            'rating' => $request->rating,
            'title' => $request->title,
            'content' => $request->content,
            'is_approved' => false // Nécessite une approbation admin
        ]);

        return redirect()->route('avis.index', $eventId)
            ->with('success', 'Votre avis a été soumis et sera publié après modération.');
    }

    /**
     * Afficher le formulaire d'édition d'un avis
     */
    public function edit($id)
    {
        $avis = Avis::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('avis.edit', compact('avis'));
    }

    /**
     * Mettre à jour un avis
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'nullable|string|max:255',
            'content' => 'required|string|min:10|max:1000'
        ]);

        $avis = Avis::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $avis->update([
            'rating' => $request->rating,
            'title' => $request->title,
            'content' => $request->content,
            'is_approved' => false // Nécessite une nouvelle approbation après modification
        ]);

        return redirect()->route('avis.index', $avis->event_id)
            ->with('success', 'Votre avis a été mis à jour et sera republié après modération.');
    }

    /**
     * Supprimer un avis
     */
    public function destroy($id)
    {
        $avis = Avis::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $eventId = $avis->event_id;
        $avis->delete();

        return redirect()->route('avis.index', $eventId)
            ->with('success', 'Votre avis a été supprimé.');
    }
}
