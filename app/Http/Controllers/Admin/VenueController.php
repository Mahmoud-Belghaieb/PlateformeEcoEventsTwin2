<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Venue;
use Illuminate\Http\Request;

class VenueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $venues = Venue::withCount('events')->paginate(15);
        return view('admin.venues.index', compact('venues'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.venues.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'country' => 'nullable|string|max:100',
            'contact_phone' => 'nullable|string|max:20',
            'contact_email' => 'nullable|email|max:255',
            'capacity' => 'required|integer|min:1',
            'price_per_hour' => 'nullable|numeric|min:0',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'facilities' => 'nullable|array',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        
        // Convert is_active to boolean
        $data['is_active'] = $request->has('is_active') ? true : false;
        
        // Handle facilities array
        if ($request->has('facilities')) {
            $data['facilities'] = $request->facilities;
        }

        Venue::create($data);

        return redirect()->route('admin.venues.index')
            ->with('success', 'Venue created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Venue $venue)
    {
        return view('admin.venues.show', compact('venue'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Venue $venue)
    {
        return view('admin.venues.edit', compact('venue'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Venue $venue)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'country' => 'nullable|string|max:100',
            'contact_phone' => 'nullable|string|max:20',
            'contact_email' => 'nullable|email|max:255',
            'capacity' => 'required|integer|min:1',
            'price_per_hour' => 'nullable|numeric|min:0',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'facilities' => 'nullable|array',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        
        // Convert is_active to boolean
        $data['is_active'] = $request->has('is_active') ? true : false;
        
        // Handle facilities array
        if ($request->has('facilities')) {
            $data['facilities'] = $request->facilities;
        }

        $venue->update($data);

        return redirect()->route('admin.venues.index')
            ->with('success', 'Venue updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Venue $venue)
    {
        // Check if venue has events
        if ($venue->events()->count() > 0) {
            return redirect()->route('admin.venues.index')
                ->with('error', 'Cannot delete venue that has events associated with it.');
        }

        $venue->delete();

        return redirect()->route('admin.venues.index')
            ->with('success', 'Venue deleted successfully.');
    }
}
