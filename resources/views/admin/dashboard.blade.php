@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient-primary text-white border-0 shadow-lg">
                <div class="card-body py-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h1 class="h2 mb-3 fw-bold">
                                <i class="fas fa-rocket me-3 text-warning"></i>
                                Welcome to EcoEvents Admin Dashboard
                            </h1>
                            <p class="mb-0 opacity-85 fs-5">
                                Manage your environmental events, users, and registrations from this central hub.
                            </p>
                            <div class="mt-3">
                                <span class="badge bg-light text-dark me-2">
                                    <i class="fas fa-calendar me-1"></i>
                                    {{ \Carbon\Carbon::now()->format('l, F j, Y') }}
                                </span>
                                <span class="badge bg-warning text-dark">
                                    <i class="fas fa-clock me-1"></i>
                                    {{ \Carbon\Carbon::now()->format('H:i') }}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-4 text-end">
                            <div class="text-white-50">
                                <i class="fas fa-chart-line fa-4x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100 transform-hover">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-2">
                                <i class="fas fa-calendar me-1"></i>
                                Total Events
                            </div>
                            <div class="h4 mb-0 font-weight-bold text-gray-800">
                                {{ \App\Models\Event::count() }}
                            </div>
                            <div class="text-muted small mt-1">
                                <i class="fas fa-arrow-up text-success me-1"></i>
                                Active system
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="icon-circle bg-primary">
                                <i class="fas fa-calendar fa-lg text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100 transform-hover">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-2">
                                <i class="fas fa-users me-1"></i>
                                Total Users
                            </div>
                            <div class="h4 mb-0 font-weight-bold text-gray-800">
                                {{ \App\Models\User::count() }}
                            </div>
                            <div class="text-muted small mt-1">
                                <i class="fas fa-user-plus text-success me-1"></i>
                                Community growing
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="icon-circle bg-success">
                                <i class="fas fa-users fa-lg text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100 transform-hover">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-2">
                                <i class="fas fa-clipboard-list me-1"></i>
                                Total Registrations
                            </div>
                            <div class="h4 mb-0 font-weight-bold text-gray-800">
                                {{ \App\Models\Registration::count() }}
                            </div>
                            <div class="text-muted small mt-1">
                                <i class="fas fa-chart-line text-info me-1"></i>
                                Engagement high
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="icon-circle bg-info">
                                <i class="fas fa-clipboard-list fa-lg text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100 transform-hover">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-2">
                                <i class="fas fa-clock me-1"></i>
                                Pending Registrations
                            </div>
                            <div class="h4 mb-0 font-weight-bold text-gray-800">
                                {{ \App\Models\Registration::where('status', 'pending')->count() }}
                            </div>
                            <div class="text-muted small mt-1">
                                <i class="fas fa-exclamation-triangle text-warning me-1"></i>
                                Needs attention
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="icon-circle bg-warning">
                                <i class="fas fa-clock fa-lg text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Management Sections -->
    <div class="row">
        <!-- Quick Actions -->
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-bolt me-2"></i>
                        Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <a href="{{ route('admin.events.create') }}" class="btn btn-primary-green btn-block w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3">
                                <i class="fas fa-plus fa-2x mb-2"></i>
                                <span class="font-weight-bold">Create Event</span>
                                <small class="text-light">Start organizing</small>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('admin.categories.create') }}" class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3">
                                <i class="fas fa-tags fa-2x mb-2"></i>
                                <span class="font-weight-bold">Add Category</span>
                                <small class="text-muted">Organize events</small>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('admin.venues.create') }}" class="btn btn-outline-success w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3">
                                <i class="fas fa-map-marker-alt fa-2x mb-2"></i>
                                <span class="font-weight-bold">Add Venue</span>
                                <small class="text-muted">Event locations</small>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('admin.positions.create') }}" class="btn btn-outline-warning w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3">
                                <i class="fas fa-user-plus fa-2x mb-2"></i>
                                <span class="font-weight-bold">Add Position</span>
                                <small class="text-muted">Team roles</small>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-history me-2"></i>
                        Recent Activity
                    </h5>
                    <a href="{{ route('admin.events.index') }}" class="btn btn-sm btn-outline-light">
                        <i class="fas fa-eye me-1"></i>
                        View All
                    </a>
                </div>
                <div class="card-body">
                    @php
                        $recentEvents = \App\Models\Event::with(['category', 'venue'])
                            ->latest('created_at')
                            ->take(5)
                            ->get();
                    @endphp
                    
                    @forelse($recentEvents as $event)
                        <div class="d-flex align-items-center mb-3 p-3 bg-light rounded-3 transform-hover">
                            <div class="me-3">
                                <div class="icon-circle bg-primary" style="width: 45px; height: 45px;">
                                    <i class="fas fa-calendar fa-lg text-white"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1 text-gray-800">{{ Str::limit($event->title, 30) }}</h6>
                                <div class="d-flex align-items-center">
                                    <small class="text-muted me-2">
                                        <i class="fas fa-clock me-1"></i>
                                        {{ $event->start_date->format('M d, Y') }}
                                    </small>
                                    @if($event->venue)
                                        <small class="text-muted">
                                            <i class="fas fa-map-marker-alt me-1"></i>
                                            {{ Str::limit($event->venue->name, 15) }}
                                        </small>
                                    @endif
                                </div>
                            </div>
                            <div>
                                @if($event->start_date >= now())
                                    <span class="badge bg-success">
                                        <i class="fas fa-check-circle me-1"></i>
                                        Upcoming
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        <i class="fas fa-history me-1"></i>
                                        Past
                                    </span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                            <h6 class="text-muted">No recent activity</h6>
                            <p class="text-muted small">Create an event to see activity here.</p>
                        </div>
                    @endforelse
                    
                    @if($recentEvents->count() > 0)
                        <div class="text-center mt-3 pt-3 border-top">
                            <a href="{{ route('admin.events.index') }}" class="btn btn-sm btn-outline-primary-green">
                                <i class="fas fa-list me-1"></i>
                                View All Events
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Management Overview -->
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-cogs me-2"></i>
                        System Management
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-2">
                            <a href="{{ route('admin.events.index') }}" class="text-decoration-none">
                                <div class="card border-0 bg-gradient-primary text-white h-100 transform-hover">
                                    <div class="card-body text-center py-4">
                                        <i class="fas fa-calendar-alt fa-3x mb-3"></i>
                                        <h6 class="card-title font-weight-bold">Events</h6>
                                        <p class="card-text">
                                            <span class="badge bg-light text-dark">{{ \App\Models\Event::count() }}</span>
                                            <br><small>Total events</small>
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-2">
                            <a href="{{ route('admin.categories.index') }}" class="text-decoration-none">
                                <div class="card border-0 bg-gradient-success text-white h-100 transform-hover">
                                    <div class="card-body text-center py-4">
                                        <i class="fas fa-tags fa-3x mb-3"></i>
                                        <h6 class="card-title font-weight-bold">Categories</h6>
                                        <p class="card-text">
                                            <span class="badge bg-light text-dark">{{ \App\Models\Category::count() }}</span>
                                            <br><small>Event types</small>
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-2">
                            <a href="{{ route('admin.venues.index') }}" class="text-decoration-none">
                                <div class="card border-0 bg-gradient-info text-white h-100 transform-hover">
                                    <div class="card-body text-center py-4">
                                        <i class="fas fa-map-marker-alt fa-3x mb-3"></i>
                                        <h6 class="card-title font-weight-bold">Venues</h6>
                                        <p class="card-text">
                                            <span class="badge bg-light text-dark">{{ \App\Models\Venue::count() }}</span>
                                            <br><small>Locations</small>
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-2">
                            <a href="{{ route('admin.positions.index') }}" class="text-decoration-none">
                                <div class="card border-0 bg-gradient-warning text-white h-100 transform-hover">
                                    <div class="card-body text-center py-4">
                                        <i class="fas fa-users fa-3x mb-3"></i>
                                        <h6 class="card-title font-weight-bold">Positions</h6>
                                        <p class="card-text">
                                            <span class="badge bg-light text-dark">{{ \App\Models\Position::count() }}</span>
                                            <br><small>Team roles</small>
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-2">
                            <a href="{{ route('admin.registrations.index') }}" class="text-decoration-none">
                                <div class="card border-0 bg-gradient-secondary text-white h-100 transform-hover">
                                    <div class="card-body text-center py-4">
                                        <i class="fas fa-clipboard-list fa-3x mb-3"></i>
                                        <h6 class="card-title font-weight-bold">Registrations</h6>
                                        <p class="card-text">
                                            <span class="badge bg-light text-dark">{{ \App\Models\Registration::count() }}</span>
                                            <br><small>Sign-ups</small>
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-2">
                            <a href="{{ route('admin.dashboard') }}" class="text-decoration-none">
                                <div class="card border-0 bg-gradient-dark text-white h-100 transform-hover">
                                    <div class="card-body text-center py-4">
                                        <i class="fas fa-chart-bar fa-3x mb-3"></i>
                                        <h6 class="card-title font-weight-bold">Analytics</h6>
                                        <p class="card-text">
                                            <span class="badge bg-light text-dark">Live</span>
                                            <br><small>Reports</small>
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
                        
                        <div class="col-md-2 text-center mb-3">
                            <a href="{{ route('admin.users.index') }}" class="text-decoration-none">
                                <div class="card border-0 bg-light h-100">
                                    <div class="card-body">
                                        <i class="fas fa-users fa-2x text-success mb-2"></i>
                                        <h6 class="card-title">Users</h6>
                                        <p class="card-text small text-muted">{{ \App\Models\User::count() }} total</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        
                        <div class="col-md-2 text-center mb-3">
                            <a href="{{ route('admin.categories.index') }}" class="text-decoration-none">
                                <div class="card border-0 bg-light h-100">
                                    <div class="card-body">
                                        <i class="fas fa-tags fa-2x text-info mb-2"></i>
                                        <h6 class="card-title">Categories</h6>
                                        <p class="card-text small text-muted">{{ \App\Models\Category::count() }} total</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        
                        <div class="col-md-2 text-center mb-3">
                            <a href="{{ route('admin.venues.index') }}" class="text-decoration-none">
                                <div class="card border-0 bg-light h-100">
                                    <div class="card-body">
                                        <i class="fas fa-map-marker-alt fa-2x text-warning mb-2"></i>
                                        <h6 class="card-title">Venues</h6>
                                        <p class="card-text small text-muted">{{ \App\Models\Venue::count() }} total</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        
                        <div class="col-md-2 text-center mb-3">
                            <a href="{{ route('admin.positions.index') }}" class="text-decoration-none">
                                <div class="card border-0 bg-light h-100">
                                    <div class="card-body">
                                        <i class="fas fa-user-cog fa-2x text-danger mb-2"></i>
                                        <h6 class="card-title">Positions</h6>
                                        <p class="card-text small text-muted">{{ \App\Models\Position::count() }} total</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        
                        <div class="col-md-2 text-center mb-3">
                            <a href="{{ route('admin.registrations.index') }}" class="text-decoration-none">
                                <div class="card border-0 bg-light h-100">
                                    <div class="card-body">
                                        <i class="fas fa-clipboard-list fa-2x text-secondary mb-2"></i>
                                        <h6 class="card-title">Registrations</h6>
                                        <p class="card-text small text-muted">{{ \App\Models\Registration::count() }} total</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
}

.border-left-primary {
    border-left: 4px solid var(--primary-green) !important;
}

.border-left-success {
    border-left: 4px solid var(--secondary-green) !important;
}

.border-left-info {
    border-left: 4px solid #36b9cc !important;
}

.border-left-warning {
    border-left: 4px solid var(--accent-orange) !important;
}

.btn-block {
    width: 100%;
}

.card-body .row .col-md-2 .card:hover {
    transform: translateY(-2px);
    transition: transform 0.2s;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}
</style>
@endsection