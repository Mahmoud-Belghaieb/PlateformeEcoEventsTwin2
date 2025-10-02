<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\User;
use App\Models\Registration;
use App\Models\Category;
use App\Models\Venue;
use App\Models\Position;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_events' => Event::count(),
            'total_users' => User::count(),
            'total_registrations' => Registration::count(),
            'pending_registrations' => Registration::where('status', 'pending')->count(),
            'upcoming_events' => Event::where('start_date', '>=', now())->count(),
            'past_events' => Event::where('start_date', '<', now())->count(),
            'total_categories' => Category::count(),
            'total_venues' => Venue::count(),
            'total_positions' => Position::count(),
        ];

        $recent_events = Event::with(['category', 'venue'])
            ->latest('created_at')
            ->take(5)
            ->get();

        $recent_registrations = Registration::with(['user', 'event'])
            ->latest('created_at')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_events', 'recent_registrations'));
    }
}