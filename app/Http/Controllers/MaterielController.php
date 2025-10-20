<?php

namespace App\Http\Controllers;

use App\Models\Materiel;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MaterielController extends Controller
{
    // Admin: List all materials
    public function index()
    {
        $materiels = Materiel::with('event')->paginate(10);
        return view('admin.materiels.index', compact('materiels'));
    }

    // Admin: Show create form
    public function create()
    {
        $events = Event::all();
        return view('admin.materiels.create', compact('events'));
    }

    // Admin: Store new material
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
            'condition' => 'required|in:good,fair,poor',
            'value' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'event_id' => 'nullable|exists:events,id',
            'is_available' => 'boolean'
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('materiels', 'public');
        }

        Materiel::create($validated);

        return redirect()->route('admin.materiels.index')->with('success', 'Matériel créé avec succès!');
    }

    // Admin: Show single material
    public function show(Materiel $materiel)
    {
        $materiel->load('event');
        return view('admin.materiels.show', compact('materiel'));
    }

    // Admin: Show edit form
    public function edit(Materiel $materiel)
    {
        $events = Event::all();
        return view('admin.materiels.edit', compact('materiel', 'events'));
    }

    // Admin: Update material
    public function update(Request $request, Materiel $materiel)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
            'condition' => 'required|in:good,fair,poor',
            'value' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'event_id' => 'nullable|exists:events,id',
            'is_available' => 'boolean'
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($materiel->image) {
                Storage::disk('public')->delete($materiel->image);
            }
            $validated['image'] = $request->file('image')->store('materiels', 'public');
        }

        $materiel->update($validated);

        return redirect()->route('admin.materiels.index')->with('success', 'Matériel mis à jour avec succès!');
    }

    // Admin: Delete material
    public function destroy(Materiel $materiel)
    {
        if ($materiel->image) {
            Storage::disk('public')->delete($materiel->image);
        }
        
        $materiel->delete();

        return redirect()->route('admin.materiels.index')->with('success', 'Matériel supprimé avec succès!');
    }
}
