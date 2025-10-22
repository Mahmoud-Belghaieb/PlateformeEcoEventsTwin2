<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commentaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentaireController extends Controller
{
    /**
     * Afficher tous les commentaires pour modération
     */
    public function index()
    {
        $query = Commentaire::with(['user', 'avis.event', 'approvedBy', 'parent.user']);

        // Filtres
        if (request('status')) {
            if (request('status') === 'pending') {
                $query->where('is_approved', false);
            } elseif (request('status') === 'approved') {
                $query->where('is_approved', true);
            }
        }

        if (request('type')) {
            if (request('type') === 'root') {
                $query->whereNull('parent_id');
            } elseif (request('type') === 'reply') {
                $query->whereNotNull('parent_id');
            }
        }

        if (request('search')) {
            $query->where(function ($q) {
                $q->whereHas('user', function ($userQuery) {
                    $userQuery->where('name', 'like', '%'.request('search').'%')
                        ->orWhere('email', 'like', '%'.request('search').'%');
                })
                    ->orWhere('content', 'like', '%'.request('search').'%');
            });
        }

        $commentaires = $query->orderBy('created_at', 'desc')->paginate(15);

        $stats = [
            'total' => Commentaire::count(),
            'pending' => Commentaire::where('is_approved', false)->count(),
            'approved' => Commentaire::where('is_approved', true)->count(),
            'replies' => Commentaire::whereNotNull('parent_id')->count(),
        ];

        return view('admin.commentaires.index', compact('commentaires', 'stats'));
    }

    /**
     * Afficher un commentaire spécifique
     */
    public function show($id)
    {
        $commentaire = Commentaire::with(['user', 'avis.event', 'approvedBy', 'parent.user', 'reponses.user'])
            ->findOrFail($id);

        return view('admin.commentaires.show', compact('commentaire'));
    }

    /**
     * Approuver un commentaire
     */
    public function approve($id)
    {
        $commentaire = Commentaire::findOrFail($id);

        $commentaire->update([
            'is_approved' => true,
            'approved_at' => now(),
            'approved_by' => Auth::id(),
        ]);

        return back()->with('success', 'Commentaire approuvé avec succès.');
    }

    /**
     * Rejeter un commentaire
     */
    public function reject($id)
    {
        $commentaire = Commentaire::findOrFail($id);
        $commentaire->delete();

        return back()->with('success', 'Commentaire rejeté et supprimé.');
    }

    /**
     * Supprimer un commentaire
     */
    public function destroy($id)
    {
        $commentaire = Commentaire::findOrFail($id);
        $commentaire->delete();

        return back()->with('success', 'Commentaire supprimé avec succès.');
    }

    /**
     * Approuver plusieurs commentaires en lot
     */
    public function bulkApprove(Request $request)
    {
        $request->validate([
            'commentaire_ids' => 'required|array',
            'commentaire_ids.*' => 'exists:commentaires,id',
        ]);

        Commentaire::whereIn('id', $request->commentaire_ids)
            ->update([
                'is_approved' => true,
                'approved_at' => now(),
                'approved_by' => Auth::id(),
            ]);

        $count = count($request->commentaire_ids);

        return back()->with('success', "{$count} commentaires approuvés avec succès.");
    }

    /**
     * Supprimer plusieurs commentaires en lot
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'commentaire_ids' => 'required|array',
            'commentaire_ids.*' => 'exists:commentaires,id',
        ]);

        $count = count($request->commentaire_ids);
        Commentaire::whereIn('id', $request->commentaire_ids)->delete();

        return back()->with('success', "{$count} commentaires supprimés avec succès.");
    }
}
