<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // On compte le nombre d'inscriptions pour chaque position
        $positions = Position::withCount('registrations')->paginate(15);
        return view('admin.positions.index', compact('positions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.positions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'requirements' => 'nullable|string|max:1000',
            'is_leadership' => 'required|boolean',
            'time_commitment' => 'nullable|numeric|min:0.5|max:24',
        ]);

        Position::create($request->all());

        return redirect()->route('admin.positions.index')
            ->with('success', 'Position created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Position $position)
    {
        return view('admin.positions.show', compact('position'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Position $position)
    {
        return view('admin.positions.edit', compact('position'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Position $position)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'requirements' => 'nullable|string|max:1000',
            'is_leadership' => 'required|boolean',
            'time_commitment' => 'nullable|numeric|min:0.5|max:24',
        ]);

        $position->update($request->all());

        return redirect()->route('admin.positions.index')
            ->with('success', 'Position updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Position $position)
    {
        // Vérifie s'il y a des inscriptions liées à cette position
        if ($position->registrations()->count() > 0) {
            return redirect()->route('admin.positions.index')
                ->with('error', 'Cannot delete position that has registrations associated with it.');
        }

        $position->delete();

        return redirect()->route('admin.positions.index')
            ->with('success', 'Position deleted successfully.');
    }
}
