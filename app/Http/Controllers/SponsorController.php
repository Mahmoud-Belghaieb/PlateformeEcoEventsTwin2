<?php

namespace App\Http\Controllers;

use App\Models\Sponsor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SponsorController extends Controller
{
    /**
     * Display a listing of sponsors (Admin)
     */
    public function index(Request $request)
    {
        $query = Sponsor::query();

        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('level') && $request->level) {
            $query->where('sponsorship_level', $request->level);
        }

        if ($request->has('status') && $request->status) {
            $isActive = $request->status === 'active' ? 1 : 0;
            $query->where('is_active', $isActive);
        }

        $sponsors = $query->latest()->paginate(15)->withQueryString();

        return view('admin.sponsors.index', compact('sponsors'));
    }

    /**
     * Show the form for creating a new sponsor
     */
    public function create()
    {
        return view('admin.sponsors.create');
    }

    /**
     * Store a newly created sponsor
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'website' => 'nullable|url',
            'contact_email' => 'nullable|email',
            'contact_phone' => 'nullable|string|max:20',
            'sponsorship_level' => 'required|in:bronze,silver,gold,platinum',
            'contribution_amount' => 'nullable|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('sponsors', 'public');
        }

        Sponsor::create($validated);

        return redirect()->route('admin.sponsors.index')
            ->with('success', 'Sponsor ajouté avec succès!');
    }

    /**
     * Display the specified sponsor
     */
    public function show(Sponsor $sponsor)
    {
        $sponsor->load('produits');
        return view('admin.sponsors.show', compact('sponsor'));
    }

    /**
     * Show the form for editing the sponsor
     */
    public function edit(Sponsor $sponsor)
    {
        return view('admin.sponsors.edit', compact('sponsor'));
    }

    /**
     * Update the specified sponsor
     */
    public function update(Request $request, Sponsor $sponsor)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'website' => 'nullable|url',
            'contact_email' => 'nullable|email',
            'contact_phone' => 'nullable|string|max:20',
            'sponsorship_level' => 'required|in:bronze,silver,gold,platinum',
            'contribution_amount' => 'nullable|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('logo')) {
            // Delete old logo
            if ($sponsor->logo) {
                Storage::disk('public')->delete($sponsor->logo);
            }
            $validated['logo'] = $request->file('logo')->store('sponsors', 'public');
        }

        $sponsor->update($validated);

        return redirect()->route('admin.sponsors.index')
            ->with('success', 'Sponsor mis à jour avec succès!');
    }

    /**
     * Remove the specified sponsor
     */
    public function destroy(Sponsor $sponsor)
    {
        if ($sponsor->logo) {
            Storage::disk('public')->delete($sponsor->logo);
        }

        $sponsor->delete();

        return redirect()->route('admin.sponsors.index')
            ->with('success', 'Sponsor supprimé avec succès!');
    }

    /**
     * Display sponsors for public viewing
     */
    public function publicIndex()
    {
        $sponsors = Sponsor::active()->get();
        return view('sponsors.index', compact('sponsors'));
    }
}
