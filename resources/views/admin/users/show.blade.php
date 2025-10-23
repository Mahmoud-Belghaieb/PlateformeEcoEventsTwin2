@extends('layouts.admin')

@section('title', 'Détails Utilisateur - ' . $user->name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-1">Détails de l'utilisateur</h1>
                    <p class="text-muted">Informations complètes de {{ $user->name }}</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Modifier
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Retour
                    </a>
                </div>
            </div>

            <div class="row">
                <!-- User Information Card -->
                <div class="col-lg-4">
                    <div class="card h-100">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-user"></i> Informations personnelles
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="text-center mb-4">
                                <div class="avatar-lg mx-auto mb-3">
                                    <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                        <span class="text-white fs-1">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                    </div>
                                </div>
                                <h4>{{ $user->name }}</h4>
                                <p class="text-muted">{{ $user->email }}</p>
                                <span class="badge bg-{{ $user->is_active ? 'success' : 'danger' }} fs-6">
                                    {{ $user->is_active ? 'Actif' : 'Inactif' }}
                                </span>
                            </div>

                            <div class="user-details">
                                <div class="row mb-3">
                                    <div class="col-sm-5"><strong>Rôle:</strong></div>
                                    <div class="col-sm-7">
                                        <span class="badge bg-info">
                                            @switch($user->role)
                                                @case('admin')
                                                    <i class="fas fa-crown"></i> Administrateur
                                                    @break
                                                @case('volunteer')
                                                    <i class="fas fa-hands-helping"></i> Bénévole
                                                    @break
                                                @case('participant')
                                                    <i class="fas fa-user"></i> Participant
                                                    @break
                                                @default
                                                    {{ ucfirst($user->role) }}
                                            @endswitch
                                        </span>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-5"><strong>Membre depuis:</strong></div>
                                    <div class="col-sm-7">{{ $stats['member_since'] }}</div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-5"><strong>Dernière connexion:</strong></div>
                                    <div class="col-sm-7">{{ $stats['last_login'] }}</div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-5"><strong>Date de création:</strong></div>
                                    <div class="col-sm-7">{{ $user->created_at->format('d/m/Y H:i') }}</div>
                                </div>

                                @if($user->phone)
                                    <div class="row mb-3">
                                        <div class="col-sm-5"><strong>Téléphone:</strong></div>
                                        <div class="col-sm-7">{{ $user->phone }}</div>
                                    </div>
                                @endif

                                @if($user->address)
                                    <div class="row mb-3">
                                        <div class="col-sm-5"><strong>Adresse:</strong></div>
                                        <div class="col-sm-7">{{ $user->address }}</div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statistics Card -->
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-header bg-success text-white">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-chart-bar"></i> Statistiques
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-md-3 mb-3">
                                    <div class="bg-light p-3 rounded">
                                        <h3 class="text-primary mb-1">{{ $stats['total_registrations'] }}</h3>
                                        <p class="text-muted mb-0">Total Inscriptions</p>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="bg-light p-3 rounded">
                                        <h3 class="text-success mb-1">{{ $stats['approved_registrations'] }}</h3>
                                        <p class="text-muted mb-0">Approuvées</p>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="bg-light p-3 rounded">
                                        <h3 class="text-warning mb-1">{{ $stats['pending_registrations'] }}</h3>
                                        <p class="text-muted mb-0">En attente</p>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="bg-light p-3 rounded">
                                        <h3 class="text-danger mb-1">{{ $stats['rejected_registrations'] }}</h3>
                                        <p class="text-muted mb-0">Refusées</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Registrations -->
                    <div class="card">
                        <div class="card-header bg-info text-white">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-calendar-check"></i> Inscriptions récentes
                            </h5>
                        </div>
                        <div class="card-body">
                            @if($user->registrations->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Événement</th>
                                                <th>Catégorie</th>
                                                <th>Date</th>
                                                <th>Statut</th>
                                                <th>Inscription</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($user->registrations->take(10) as $registration)
                                                <tr>
                                                    <td>
                                                        <strong>{{ $registration->event->title ?? 'Événement supprimé' }}</strong>
                                                        @if($registration->event && $registration->event->venue)
                                                            <br><small class="text-muted">{{ $registration->event->venue->name }}</small>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($registration->event && $registration->event->category)
                                                            <span class="badge bg-secondary">{{ $registration->event->category->name }}</span>
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($registration->event)
                                                            {{ $registration->event->start_date ? $registration->event->start_date->format('d/m/Y') : '-' }}
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-{{ 
                                                            $registration->status === 'approved' ? 'success' : 
                                                            ($registration->status === 'pending' ? 'warning' : 'danger') 
                                                        }}">
                                                            @switch($registration->status)
                                                                @case('approved')
                                                                    Approuvée
                                                                    @break
                                                                @case('pending')
                                                                    En attente
                                                                    @break
                                                                @case('rejected')
                                                                    Refusée
                                                                    @break
                                                                @default
                                                                    {{ ucfirst($registration->status) }}
                                                            @endswitch
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <small class="text-muted">{{ $registration->created_at->format('d/m/Y') }}</small>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                
                                @if($user->registrations->count() > 10)
                                    <div class="text-center mt-3">
                                        <a href="{{ route('admin.users.registrations', $user) }}" class="btn btn-outline-primary">
                                            Voir toutes les inscriptions ({{ $user->registrations->count() }})
                                        </a>
                                    </div>
                                @endif
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Aucune inscription trouvée</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .avatar-lg {
        width: 80px;
        height: 80px;
    }
    
    .user-details .row {
        border-bottom: 1px solid #f0f0f0;
        padding: 0.5rem 0;
    }
    
    .user-details .row:last-child {
        border-bottom: none;
    }
    
    .card {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        border: 1px solid rgba(0, 0, 0, 0.125);
    }
    
    .card-header {
        font-weight: 600;
    }
    
    .table th {
        border-top: none;
        font-weight: 600;
    }
</style>
@endpush
@endsection