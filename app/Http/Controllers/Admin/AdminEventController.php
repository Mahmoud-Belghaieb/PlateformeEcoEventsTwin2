<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Category;
use App\Models\Venue;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminEventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::with(['category', 'venue', 'registrations'])
            ->latest('start_date')
            ->paginate(15);
        return view('admin.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $venues = Venue::all();
        $positions = Position::all();
        return view('admin.events.create', compact('categories', 'venues', 'positions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date|after_or_equal:today',
            'capacity' => 'nullable|integer|min:1',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'venue_id' => 'required|exists:venues,id',
            'status' => 'required|in:draft,pending,published,rejected,cancelled,completed',
            'positions' => 'nullable|array',
            'positions.*' => 'exists:positions,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $eventData = $request->except(['positions', 'image', 'action', 'capacity']);
        $eventData['slug'] = Str::slug($request->title . '-' . uniqid());
        $eventData['created_by'] = auth()->id();
        
        // Set end_date to start_date + 2 hours if not provided
        if (!isset($eventData['end_date'])) {
            $startDate = new \DateTime($request->start_date);
            $startDate->add(new \DateInterval('PT2H')); // Add 2 hours
            $eventData['end_date'] = $startDate->format('Y-m-d H:i:s');
        }
        
        // Map capacity to max_participants
        if ($request->has('capacity') && $request->capacity) {
            $eventData['max_participants'] = $request->capacity;
        }
        
        // Set status based on action if provided
        if ($request->has('action')) {
            $eventData['status'] = $request->action === 'draft' ? 'draft' : 'published';
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('events', 'public');
            $eventData['featured_image'] = $imagePath;
        }

        $event = Event::create($eventData);

        // Attach positions if provided
        if ($request->has('positions')) {
            $event->positions()->attach($request->positions);
        }

        return redirect()->route('admin.events.index')
            ->with('success', 'Event created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        $event->load(['category', 'venue', 'positions', 'registrations.user']);
        return view('admin.events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        $categories = Category::all();
        $venues = Venue::all();
        $positions = Position::all();
        $event->load('positions');
        return view('admin.events.edit', compact('event', 'categories', 'venues', 'positions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'capacity' => 'nullable|integer|min:1',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'venue_id' => 'required|exists:venues,id',
            'status' => 'required|in:draft,pending,published,rejected,cancelled,completed',
            'positions' => 'nullable|array',
            'positions.*' => 'exists:positions,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $eventData = $request->except(['positions', 'image', 'action', 'capacity']);
        
        // Map capacity to max_participants
        if ($request->has('capacity') && $request->capacity) {
            $eventData['max_participants'] = $request->capacity;
        }
        
        // Update slug if title changed
        if ($event->title !== $request->title) {
            $eventData['slug'] = Str::slug($request->title . '-' . uniqid());
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($event->featured_image) {
                \Storage::disk('public')->delete($event->featured_image);
            }
            $imagePath = $request->file('image')->store('events', 'public');
            $eventData['featured_image'] = $imagePath;
        }

        $event->update($eventData);

        // Sync positions
        if ($request->has('positions')) {
            $event->positions()->sync($request->positions);
        } else {
            $event->positions()->detach();
        }

        return redirect()->route('admin.events.index')
            ->with('success', 'Event updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        // Check if event has registrations
        if ($event->registrations()->count() > 0) {
            return redirect()->route('admin.events.index')
                ->with('error', 'Cannot delete event that has registrations.');
        }

        // Delete image if exists
        if ($event->featured_image) {
            \Storage::disk('public')->delete($event->featured_image);
        }

        $event->delete();

        return redirect()->route('admin.events.index')
            ->with('success', 'Event deleted successfully.');
    }

    /**
     * Approve an event
     */
    public function approve(Event $event)
    {
        $event->update([
            'status' => 'published',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'rejection_reason' => null
        ]);

        return redirect()->back()
            ->with('success', 'Événement approuvé et publié avec succès.');
    }

    /**
     * Reject an event
     */
    public function reject(Request $request, Event $event)
    {
        $request->validate([
            'rejection_reason' => 'nullable|string|max:1000'
        ]);

        $event->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'rejection_reason' => $request->rejection_reason
        ]);

        return redirect()->back()
            ->with('success', 'Événement rejeté avec succès.');
    }

    /**
     * Set event as pending
     */
    public function setPending(Event $event)
    {
        $event->update([
            'status' => 'pending',
            'approved_by' => null,
            'approved_at' => null,
            'rejection_reason' => null
        ]);

        return redirect()->back()
            ->with('success', 'Événement mis en attente d\'approbation.');
    }
}
