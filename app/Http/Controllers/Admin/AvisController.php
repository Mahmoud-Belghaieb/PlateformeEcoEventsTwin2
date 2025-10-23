<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Avis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AvisController extends Controller
{
    /**
     * Afficher tous les avis pour modération
     */
    public function index()
    {
        $query = Avis::with(['user', 'event', 'approvedBy']);

        // Filtres
        if (request('status')) {
            if (request('status') === 'pending') {
                $query->where('is_approved', false);
            } elseif (request('status') === 'approved') {
                $query->where('is_approved', true);
            }
        }

        if (request('rating')) {
            $query->where('rating', request('rating'));
        }

        if (request('search')) {
            $query->where(function($q) {
                $q->whereHas('user', function($userQuery) {
                    $userQuery->where('name', 'like', '%' . request('search') . '%')
                             ->orWhere('email', 'like', '%' . request('search') . '%');
                })
                ->orWhere('title', 'like', '%' . request('search') . '%')
                ->orWhere('content', 'like', '%' . request('search') . '%');
            });
        }

        $avis = $query->orderBy('created_at', 'desc')->paginate(15);

        $stats = [
            'total' => Avis::count(),
            'pending' => Avis::where('is_approved', false)->count(),
            'approved' => Avis::where('is_approved', true)->count(),
            'average_rating' => Avis::where('is_approved', true)->avg('rating') ?? 0
        ];

        return view('admin.avis.index', compact('avis', 'stats'));
    }

    /**
     * Afficher un avis spécifique
     */
    public function show($id)
    {
        $avis = Avis::with(['user', 'event', 'approvedBy', 'commentaires.user'])
            ->findOrFail($id);

        return view('admin.avis.show', compact('avis'));
    }

    /**
     * Approuver un avis
     */
    public function approve($id)
    {
        $avis = Avis::findOrFail($id);
        
        $avis->update([
            'is_approved' => true,
            'approved_at' => now(),
            'approved_by' => Auth::id()
        ]);

        return back()->with('success', 'Avis approuvé avec succès.');
    }

    /**
     * Rejeter un avis
     */
    public function reject($id)
    {
        $avis = Avis::findOrFail($id);
        $avis->delete();

        return back()->with('success', 'Avis rejeté et supprimé.');
    }

    /**
     * Supprimer un avis
     */
    public function destroy($id)
    {
        $avis = Avis::findOrFail($id);
        $avis->delete();

        return back()->with('success', 'Avis supprimé avec succès.');
    }

    /**
     * Approuver plusieurs avis en lot
     */
    public function bulkApprove(Request $request)
    {
        $request->validate([
            'avis_ids' => 'required|array',
            'avis_ids.*' => 'exists:avis,id'
        ]);

        Avis::whereIn('id', $request->avis_ids)
            ->update([
                'is_approved' => true,
                'approved_at' => now(),
                'approved_by' => Auth::id()
            ]);

        $count = count($request->avis_ids);
        return back()->with('success', "{$count} avis approuvés avec succès.");
    }

    /**
     * Supprimer plusieurs avis en lot
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'avis_ids' => 'required|array',
            'avis_ids.*' => 'exists:avis,id'
        ]);

        $count = count($request->avis_ids);
        Avis::whereIn('id', $request->avis_ids)->delete();

        return back()->with('success', "{$count} avis supprimés avec succès.");
    }
}
