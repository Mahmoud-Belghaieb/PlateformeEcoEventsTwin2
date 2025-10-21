@extends('layouts.admin')

@section('title', 'User Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.users.index') }}">Users</a>
                    </li>
                    <li class="breadcrumb-item active">{{ $user->name }}</li>
                </ol>
            </nav>

            <div class="row">
                <div class="col-md-8">
                    <!-- User Information Card -->
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary-green text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-user me-2"></i>
                                {{ $user->name }}
                                @if(!$user->is_active)
                                    <span class="badge bg-secondary ms-2">Inactive</span>
                                @endif
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Basic Information</h6>
                                    <table class="table table-sm">
                                        <tr>
                                            <td><strong>Name:</strong></td>
                                            <td>{{ $user->name }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Email:</strong></td>
                                            <td>{{ $user->email }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Role:</strong></td>
                                            <td>
                                                @php
                                                    $roleColors = [
                                                        'admin' => 'danger',
                                                        'participant' => 'primary',
                                                        'volunteer' => 'success'
                                                    ];
                                                    $roleLabels = [
                                                        'admin' => 'Administrateur',
                                                        'participant' => 'Participant',
                                                        'volunteer' => 'Bénévole'
                                                    ];
                                                @endphp
                                                <span class="badge bg-{{ $roleColors[$user->role] ?? 'secondary' }}">
                                                    {{ $roleLabels[$user->role] ?? ucfirst($user->role) }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Status:</strong></td>
                                            <td>
                                                @if($user->is_active)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-secondary">Inactive</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @if($user->phone)
                                        <tr>
                                            <td><strong>Phone:</strong></td>
                                            <td>{{ $user->phone }}</td>
                                        </tr>
                                        @endif
                                        @if($user->date_of_birth)
                                        <tr>
                                            <td><strong>Date of Birth:</strong></td>
                                            <td>{{ $user->date_of_birth->format('M d, Y') }}</td>
                                        </tr>
                                        @endif
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <h6>Account Information</h6>
                                    <table class="table table-sm">
                                        <tr>
                                            <td><strong>Registered:</strong></td>
                                            <td>{{ $user->created_at->format('M d, Y H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Last Updated:</strong></td>
                                            <td>{{ $user->updated_at->format('M d, Y H:i') }}</td>
                                        </tr>
                                        @if($user->last_login_at)
                                        <tr>
                                            <td><strong>Last Login:</strong></td>
                                            <td>{{ $user->last_login_at->format('M d, Y H:i') }}</td>
                                        </tr>
                                        @endif
                                        @if($user->email_verified_at)
                                        <tr>
                                            <td><strong>Email Verified:</strong></td>
                                            <td>
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check me-1"></i>
                                                    {{ $user->email_verified_at->format('M d, Y') }}
                                                </span>
                                            </td>
                                        </tr>
                                        @else
                                        <tr>
                                            <td><strong>Email Verified:</strong></td>
                                            <td>
                                                <span class="badge bg-warning">
                                                    <i class="fas fa-times me-1"></i>
                                                    Not verified
                                                </span>
                                            </td>
                                        </tr>
                                        @endif
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-1"></i>
                                    Back to Users
                                </a>
                                <div>
                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning me-2">
                                        <i class="fas fa-edit me-1"></i>
                                        Edit User
                                    </a>
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $user) }}" 
                                              method="POST" class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">
                                                <i class="fas fa-trash me-1"></i>
                                                Delete User
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Registrations -->
                    @if($user->registrations->count() > 0)
                    <div class="card shadow-sm mt-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">
                                <i class="fas fa-calendar me-2"></i>
                                Recent Event Registrations
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Event</th>
                                            <th>Category</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th>Registered</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($user->registrations->take(10) as $registration)
                                        <tr>
                                            <td>
                                                <strong>{{ $registration->event->title }}</strong><br>
                                                <small class="text-muted">{{ Str::limit($registration->event->description, 50) }}</small>
                                            </td>
                                            <td>
                                                @if($registration->event->category)
                                                    <span class="badge" style="background-color: {{ $registration->event->category->color }};">
                                                        {{ $registration->event->category->name }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $registration->event->start_date->format('M d, Y') }}
                                                @if($registration->event->start_date->lt(now()))
                                                    <br><small class="text-muted">(Past)</small>
                                                @elseif($registration->event->start_date->gt(now()))
                                                    <br><small class="text-success">(Upcoming)</small>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $registration->status === 'confirmed' ? 'success' : ($registration->status === 'pending' ? 'warning' : 'danger') }}">
                                                    {{ ucfirst($registration->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $registration->created_at->format('M d, Y') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @if($user->registrations->count() > 10)
                                <div class="text-center mt-3">
                                    <a href="{{ route('admin.users.registrations', $user) }}" class="btn btn-outline-primary">
                                        View All Registrations ({{ $user->registrations->count() }})
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>

                <div class="col-md-4">
                    <!-- Statistics Card -->
                    <div class="card shadow-sm">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">
                                <i class="fas fa-chart-pie me-2"></i>
                                User Statistics
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-12 mb-3">
                                    <h3 class="text-primary-green mb-0">{{ $stats['total_registrations'] }}</h3>
                                    <small class="text-muted">Total Registrations</small>
                                </div>
                                <div class="col-6 mb-3">
                                    <h4 class="text-info mb-0">{{ $stats['upcoming_events'] }}</h4>
                                    <small class="text-muted">Upcoming Events</small>
                                </div>
                                <div class="col-6 mb-3">
                                    <h4 class="text-success mb-0">{{ $stats['attended_events'] }}</h4>
                                    <small class="text-muted">Attended Events</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="card shadow-sm mt-3">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">
                                <i class="fas fa-bolt me-2"></i>
                                Quick Actions
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                @if($user->id !== auth()->id())
                                    <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-{{ $user->is_active ? 'warning' : 'success' }} w-100">
                                            <i class="fas fa-{{ $user->is_active ? 'pause' : 'play' }} me-1"></i>
                                            {{ $user->is_active ? 'Deactivate' : 'Activate' }} User
                                        </button>
                                    </form>
                                @endif
                                
                                @if($user->registrations->count() > 0)
                                    <a href="{{ route('admin.users.registrations', $user) }}" class="btn btn-outline-info">
                                        <i class="fas fa-list me-1"></i>
                                        View All Registrations
                                    </a>
                                @endif
                                
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-outline-primary">
                                    <i class="fas fa-edit me-1"></i>
                                    Edit Profile
                                </a>
                            </div>
                        </div>
                    </div>

                    @if(!$user->email_verified_at)
                    <!-- Email Verification Notice -->
                    <div class="card bg-warning bg-opacity-10 mt-3">
                        <div class="card-body">
                            <h6 class="card-title text-warning">
                                <i class="fas fa-exclamation-triangle me-1"></i>
                                Email Not Verified
                            </h6>
                            <p class="card-text small mb-0">
                                This user hasn't verified their email address yet. They may have limited access to certain features.
                            </p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection