@extends('layouts.admin')

@section('title', 'Registrations Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center bg-primary-green text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-clipboard-list me-2"></i>
                        Event Registrations Management
                    </h5>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.registrations.export-csv', request()->query()) }}" 
                           class="btn btn-light btn-sm"
                           title="Exporter en CSV">
                            <i class="fas fa-file-csv me-1"></i>
                            Export CSV
                        </a>
                        <select class="form-select form-select-sm text-dark" id="headerStatusFilter" style="width: auto;">
                            <option value="">All Statuses</option>
                            <option value="pending" {{ request('status')==='pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ request('status')==='approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ request('status')==='rejected' ? 'selected' : '' }}>Rejected</option>
                            <option value="cancelled" {{ request('status')==='cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Filters -->
                    <form id="filtersForm" method="GET" action="{{ route('admin.registrations.index') }}" class="row mb-4 g-2">
                        <div class="col-md-3">
                            <select class="form-select" id="eventFilter" name="event">
                                <option value="">All Events</option>
                                @foreach(\App\Models\Event::orderBy('start_date', 'desc')->get() as $event)
                                    <option value="{{ $event->id }}" {{ (string)$event->id === (string)request('event') ? 'selected' : '' }}>
                                        {{ Str::limit($event->title, 30) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="positionFilter" name="position">
                                <option value="">All Positions</option>
                                @foreach(\App\Models\Position::all() as $position)
                                    <option value="{{ $position->id }}" {{ (string)$position->id === (string)request('position') ? 'selected' : '' }}>
                                        {{ $position->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="date" class="form-control" id="dateFilter" name="date" value="{{ request('date') }}" placeholder="Filter by date">
                        </div>
                        <div class="col-md-3">
                            <div class="input-group">
                                <input type="text" class="form-control" id="searchFilter" name="search" value="{{ request('search') }}" placeholder="Search users...">
                                <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                                <a href="{{ route('admin.registrations.index') }}" class="btn btn-outline-secondary" title="Reset filters"><i class="fas fa-undo"></i></a>
                            </div>
                        </div>
                        <input type="hidden" name="status" id="statusInput" value="{{ request('status') }}">
                    </form>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>User</th>
                                    <th>Event</th>
                                    <th>Position</th>
                                    <th>Registration Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($registrations as $registration)
                                <tr>
                                    <td>{{ $registration->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="me-2">
                                                <div class="bg-primary-green text-white rounded-circle d-flex align-items-center justify-content-center" 
                                                     style="width: 32px; height: 32px; font-size: 12px;">
                                                    {{ strtoupper(substr($registration->user->name, 0, 2)) }}
                                                </div>
                                            </div>
                                            <div>
                                                <strong>{{ $registration->user->name }}</strong>
                                                <br><small class="text-muted">{{ $registration->user->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <strong class="text-primary-green">{{ Str::limit($registration->event->title, 25) }}</strong>
                                            <br><small class="text-muted">
                                                {{ $registration->event->start_date->format('M d, Y') }} at {{ $registration->event->start_date->format('H:i') }}
                                            </small>
                                            @if($registration->event->venue)
                                                <br><small class="text-info">{{ $registration->event->venue->name }}</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @if($registration->position)
                                            <span class="badge bg-{{ $registration->position->is_leadership ? 'warning' : 'secondary' }}">
                                                {{ $registration->position->name }}
                                                @if($registration->position->is_leadership)
                                                    <i class="fas fa-crown ms-1"></i>
                                                @endif
                                            </span>
                                        @else
                                            <span class="text-muted font-italic">No position</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div>
                                            <strong>{{ $registration->created_at->format('M d, Y') }}</strong>
                                            <br><small class="text-muted">{{ $registration->created_at->format('H:i') }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        @switch($registration->status)
                                            @case('pending')
                                                <span class="badge bg-warning text-dark">
                                                    <i class="fas fa-clock me-1"></i>En attente
                                                </span>
                                                @break
                                            @case('approved')
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check me-1"></i>Approuvé
                                                </span>
                                                @break
                                            @case('rejected')
                                                <span class="badge bg-danger">
                                                    <i class="fas fa-times me-1"></i>Rejeté
                                                </span>
                                                @break
                                            @case('cancelled')
                                                <span class="badge bg-secondary">
                                                    <i class="fas fa-ban me-1"></i>Annulé
                                                </span>
                                                @break
                                            @default
                                                <span class="badge bg-secondary">Inconnu</span>
                                        @endswitch
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('admin.registrations.show', $registration) }}" 
                                               class="btn btn-outline-info" title="Voir">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            
                                            @if($registration->status === 'pending')
                                                <!-- Approve Button -->
                                                <form action="{{ route('admin.registrations.approve', $registration) }}" 
                                                      method="POST" class="d-inline"
                                                      onsubmit="return confirm('Êtes-vous sûr de vouloir approuver cette inscription ?')">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-success" title="Approuver">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                                
                                                <!-- Reject Button with Modal -->
                                                <button type="button" class="btn btn-outline-danger" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#rejectModal{{ $registration->id }}" 
                                                        title="Rejeter">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                                
                                                <!-- Reject Modal -->
                                                <div class="modal fade" id="rejectModal{{ $registration->id }}" tabindex="-1">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <form action="{{ route('admin.registrations.reject', $registration) }}" method="POST">
                                                                @csrf
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Rejeter l'inscription</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p>Êtes-vous sûr de vouloir rejeter l'inscription de <strong>{{ $registration->user->name }}</strong> pour l'événement <strong>{{ $registration->event->title }}</strong> ?</p>
                                                                    <div class="mb-3">
                                                                        <label for="rejection_reason{{ $registration->id }}" class="form-label">Raison du rejet (optionnel)</label>
                                                                        <textarea class="form-control" 
                                                                                  id="rejection_reason{{ $registration->id }}" 
                                                                                  name="rejection_reason" 
                                                                                  rows="3" 
                                                                                  placeholder="Expliquez pourquoi cette inscription est rejetée..."></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                                    <button type="submit" class="btn btn-danger">Rejeter</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            @elseif($registration->status === 'approved')
                                                <!-- Cancel approved registration -->
                                                <form action="{{ route('admin.registrations.cancel', $registration) }}" 
                                                      method="POST" class="d-inline"
                                                      onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette inscription approuvée ?')">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-warning" title="Annuler">
                                                        <i class="fas fa-ban"></i>
                                                    </button>
                                                </form>
                                            @elseif($registration->status === 'rejected')
                                                <!-- Re-approve rejected registration -->
                                                <form action="{{ route('admin.registrations.approve', $registration) }}" 
                                                      method="POST" class="d-inline"
                                                      onsubmit="return confirm('Êtes-vous sûr de vouloir approuver cette inscription rejetée ?')">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-success" title="Approuver">
                                                        <i class="fas fa-redo"></i>
                                                    </button>
                                                </form>
                                            @endif

                                            <!-- Delete Button -->
                                            <form action="{{ route('admin.registrations.destroy', $registration) }}" 
                                                  method="POST" class="d-inline"
                                                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer définitivement cette inscription ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger" title="Supprimer">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-clipboard-list fa-3x mb-3"></i>
                                            <p>No registrations found.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if(method_exists($registrations, 'links'))
                        <div class="d-flex justify-content-center mt-4">
                            {{ $registrations->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Summary Cards -->
<div class="row mt-4">
    <div class="col-md-3">
        <div class="card bg-warning bg-opacity-10">
            <div class="card-body text-center">
                <h3 class="text-warning mb-0">{{ \App\Models\Registration::where('status', 'pending')->count() }}</h3>
                <small class="text-muted">Inscriptions en attente</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success bg-opacity-10">
            <div class="card-body text-center">
                <h3 class="text-success mb-0">{{ \App\Models\Registration::where('status', 'approved')->count() }}</h3>
                <small class="text-muted">Inscriptions approuvées</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-danger bg-opacity-10">
            <div class="card-body text-center">
                <h3 class="text-danger mb-0">{{ \App\Models\Registration::where('status', 'rejected')->count() }}</h3>
                <small class="text-muted">Inscriptions rejetées</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-primary bg-opacity-10">
            <div class="card-body text-center">
                <h3 class="text-primary mb-0">{{ \App\Models\Registration::count() }}</h3>
                <small class="text-muted">Total des inscriptions</small>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('filtersForm');
    const eventFilter = document.getElementById('eventFilter');
    const positionFilter = document.getElementById('positionFilter');
    const dateFilter = document.getElementById('dateFilter');
    const searchFilter = document.getElementById('searchFilter');
    const headerStatusFilter = document.getElementById('headerStatusFilter');
    const statusInput = document.getElementById('statusInput');

    function submitForm() { form.submit(); }

    [eventFilter, positionFilter, dateFilter].forEach(el => el && el.addEventListener('change', submitForm));
    if (headerStatusFilter) {
        headerStatusFilter.addEventListener('change', function() {
            statusInput.value = headerStatusFilter.value;
            submitForm();
        });
    }
    if (searchFilter) {
        searchFilter.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') submitForm();
        });
    }
});
</script>
@endpush
@endsection