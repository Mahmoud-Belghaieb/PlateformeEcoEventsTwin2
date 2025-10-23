<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Materiel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MaterielController extends Controller
{
    // Admin: List all materials with filters
    public function index(Request $request)
    {
        $query = Materiel::with('event');

        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%'.$request->search.'%');
        }

        if ($request->has('category') && $request->category) {
            $query->where('type', $request->category);
        }

        if ($request->has('condition') && $request->condition) {
            $query->where('condition', $request->condition);
        }

        $materiels = $query->latest()->paginate(15)->withQueryString();
        // For the category select in the view, provide distinct types
        $categories = Materiel::distinct()->pluck('type');

        return view('admin.materiels.index', compact('materiels', 'categories'));
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
            'is_available' => 'boolean',
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
            'is_available' => 'boolean',
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

    /**
     * Display materials for public viewing with filters
     */
    public function publicIndex(Request $request)
    {
        $query = Materiel::with('event');

        // Only show available by default
        if ($request->has('is_available') && $request->is_available !== '') {
            $query->where('is_available', (int) $request->is_available);
        }

        if ($request->has('category') && $request->category) {
            // The DB column is `type`; map the UI `category` filter to `type`.
            $query->where('type', $request->category);
        }

        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%'.$request->search.'%');
        }

        $materiels = $query->latest()->paginate(12)->withQueryString();
        // Get distinct types from the DB to populate the category select in the UI
        $categories = Materiel::distinct()->pluck('type');

        return view('materiels.index', compact('materiels', 'categories'));
    }
}
