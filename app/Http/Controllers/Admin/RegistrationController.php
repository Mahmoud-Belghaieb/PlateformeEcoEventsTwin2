<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Models\Event;
use App\Models\User;
use App\Models\Position;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Registration::with(['user', 'event.venue', 'event.category', 'position']);

        // Apply filters
        if ($request->filled('event')) {
            $query->where('event_id', $request->event);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('position')) {
            $query->where('position_id', $request->position);
        }

        if ($request->filled('date')) {
            $query->whereHas('event', function($q) use ($request) {
                $q->whereDate('date', $request->date);
            });
        }

        if ($request->filled('search')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $registrations = $query->latest()->paginate(15);

        return view('admin.registrations.index', compact('registrations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        $events = Event::where('date', '>=', now())->get();
        $positions = Position::all();
        return view('admin.registrations.create', compact('users', 'events', 'positions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'event_id' => 'required|exists:events,id',
            'position_id' => 'nullable|exists:positions,id',
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);

        // Check if user already registered for this event
        $existingRegistration = Registration::where('user_id', $request->user_id)
            ->where('event_id', $request->event_id)
            ->first();

        if ($existingRegistration) {
            return redirect()->back()
                ->with('error', 'User is already registered for this event.');
        }

        // Check event capacity
        $event = Event::find($request->event_id);
        if ($event->registrations()->where('status', '!=', 'cancelled')->count() >= $event->max_participants) {
            return redirect()->back()
                ->with('error', 'Event has reached maximum capacity.');
        }

        Registration::create($request->all());

        return redirect()->route('admin.registrations.index')
            ->with('success', 'Registration created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Registration $registration)
    {
        $registration->load(['user', 'event.venue', 'event.category', 'position']);
        return view('admin.registrations.show', compact('registration'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Registration $registration)
    {
        $users = User::all();
        $events = Event::all();
        $positions = Position::all();
        return view('admin.registrations.edit', compact('registration', 'users', 'events', 'positions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Registration $registration)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'event_id' => 'required|exists:events,id',
            'position_id' => 'nullable|exists:positions,id',
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);

        // If changing status to confirmed, check capacity
        if ($request->status === 'confirmed' && $registration->status !== 'confirmed') {
            $event = Event::find($request->event_id);
            $confirmedCount = $event->registrations()->where('status', 'confirmed')->count();
            
            if ($confirmedCount >= $event->max_participants) {
                return redirect()->back()
                    ->with('error', 'Event has reached maximum capacity.');
            }
        }

        $registration->update($request->all());

        return redirect()->route('admin.registrations.index')
            ->with('success', 'Registration updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Registration $registration)
    {
        $registration->delete();

        return redirect()->route('admin.registrations.index')
            ->with('success', 'Registration deleted successfully.');
    }

    /**
     * Approve a registration
     */
    public function approve(Registration $registration)
    {
        // Check if event has capacity
        $event = $registration->event;
        $approvedCount = $event->registrations()->where('status', 'approved')->count();
        
        if ($approvedCount >= $event->max_participants) {
            return redirect()->back()
                ->with('error', 'L\'événement a atteint sa capacité maximale.');
        }

        $registration->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => auth()->id()
        ]);

        return redirect()->back()
            ->with('success', 'Inscription approuvée avec succès.');
    }

    /**
     * Reject a registration
     */
    public function reject(Request $request, Registration $registration)
    {
        $request->validate([
            'rejection_reason' => 'nullable|string|max:1000'
        ]);

        $registration->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
            'approved_by' => auth()->id()
        ]);

        return redirect()->back()
            ->with('success', 'Inscription rejetée avec succès.');
    }

    /**
     * Cancel a registration
     */
    public function cancel(Registration $registration)
    {
        $registration->update([
            'status' => 'cancelled'
        ]);

        return redirect()->back()
            ->with('success', 'Inscription annulée avec succès.');
    }
}
