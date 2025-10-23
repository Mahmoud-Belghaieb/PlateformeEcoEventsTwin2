<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    /**
     * Display the user's profile
     */
    public function show()
    {
        return view('profile.show');
    }

    /**
     * Update the user's role
     */
    public function updateRole(Request $request)
    {
        $request->validate([
            'role' => 'required|in:participant,volunteer',
        ]);

        $user = Auth::user();

        // Prevent admin role changes through this method
        if ($request->role === 'admin' && ! $user->isAdmin()) {
            return back()->withErrors(['role' => 'Vous ne pouvez pas changer votre rôle vers administrateur.']);
        }

        $oldRole = $user->role;
        $user->role = $request->role;
        $user->save();

        Log::info('User role updated', [
            'user_id' => $user->id,
            'old_role' => $oldRole,
            'new_role' => $request->role,
        ]);

        return back()->with('success', 'Votre rôle a été mis à jour avec succès.');
    }
}
