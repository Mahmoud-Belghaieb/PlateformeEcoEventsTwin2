<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Event;
use App\Models\Materiel;
use App\Models\Panier;
use App\Models\Position;
use App\Models\Produit;
use App\Models\Registration;
use App\Models\Sponsor;
use App\Models\User;
use App\Models\Venue;

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
            // New modules stats
            'total_sponsors' => Sponsor::count(),
            'active_sponsors' => Sponsor::where('is_active', true)->count(),
            'total_products' => Produit::count(),
            'available_products' => Produit::where('is_available', true)->where('stock', '>', 0)->count(),
            'total_materials' => Materiel::count(),
            'available_materials' => Materiel::where('is_available', true)->count(),
            'pending_carts' => Panier::where('status', 'pending')->count(),
            'total_orders' => Panier::where('status', 'ordered')->count(),
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
