<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Prepare data for the home page to avoid running queries in the blade
        $upcomingEvents = \App\Models\Event::with(['category', 'venue', 'creator'])
            ->withCount(['registrations', 'registrations as approved_registrations_count' => function ($query) {
                $query->where('status', 'approved');
            }])
            ->where('status', 'published')
            ->where('start_date', '>', now())
            ->orderBy('start_date', 'asc')
            ->limit(6)
            ->get();

        $stats = [
            'users' => \App\Models\User::count(),
            'active_users' => \App\Models\User::where('is_active', true)->count(),
            'published_events' => \App\Models\Event::where('status', 'published')->count(),
            'pending_events' => \App\Models\Event::where('status', 'pending')->count(),
            'registrations' => \App\Models\Registration::count(),
        ];

        return view('home', compact('upcomingEvents', 'stats'));
    }
}