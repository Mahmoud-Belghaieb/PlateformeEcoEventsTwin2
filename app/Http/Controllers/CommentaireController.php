<?php

namespace App\Http\Controllers;

use App\Models\Avis;
use App\Models\Commentaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentaireController extends Controller
{
    /**
     * Créer un nouveau commentaire
     */
    public function store(Request $request, $avisId)
    {
        $request->validate([
            'content' => 'required|string|min:5|max:500',
            'parent_id' => 'nullable|exists:commentaires,id',
        ]);

        $avis = Avis::findOrFail($avisId);

        // Vérifier que si c'est une réponse, le commentaire parent existe et appartient au même avis
        if ($request->parent_id) {
            $parentComment = Commentaire::where('id', $request->parent_id)
                ->where('avis_id', $avisId)
                ->firstOrFail();
        }

        Commentaire::create([
            'user_id' => Auth::id(),
            'avis_id' => $avisId,
            'parent_id' => $request->parent_id,
            'content' => $request->content,
            'is_approved' => false, // Nécessite une approbation admin
        ]);

        return back()->with('success', 'Votre commentaire a été soumis et sera publié après modération.');
    }

    /**
     * Afficher le formulaire d'édition d'un commentaire
     */
    public function edit($id)
    {
        $commentaire = Commentaire::where('id', $id)
            ->where('user_id', Auth::id())
            ->with(['avis.event'])
            ->firstOrFail();

        return view('commentaires.edit', compact('commentaire'));
    }

    /**
     * Mettre à jour un commentaire
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string|min:5|max:500',
        ]);

        $commentaire = Commentaire::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $commentaire->update([
            'content' => $request->content,
            'is_approved' => false, // Nécessite une nouvelle approbation après modification
        ]);

        return redirect()->route('avis.index', $commentaire->avis->event_id)
            ->with('success', 'Votre commentaire a été mis à jour et sera republié après modération.');
    }

    /**
     * Supprimer un commentaire
     */
    public function destroy($id)
    {
        $commentaire = Commentaire::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $eventId = $commentaire->avis->event_id;
        $commentaire->delete();

        return redirect()->route('avis.index', $eventId)
            ->with('success', 'Votre commentaire a été supprimé.');
    }

    /**
     * Répondre à un commentaire
     */
    public function reply(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string|min:5|max:500',
        ]);

        $parentComment = Commentaire::findOrFail($id);

        Commentaire::create([
            'user_id' => Auth::id(),
            'avis_id' => $parentComment->avis_id,
            'parent_id' => $parentComment->id,
            'content' => $request->content,
            'is_approved' => false,
        ]);

        return back()->with('success', 'Votre réponse a été soumise et sera publiée après modération.');
    }
}
