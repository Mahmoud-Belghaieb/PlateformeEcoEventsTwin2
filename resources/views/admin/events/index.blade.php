@extends('layouts.admin')

@section('title', 'Events Management')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h3 mb-0">
                    <i class="fas fa-calendar-alt me-2"></i>
                    Events Management
                </h1>
                <p class="mb-0">Manage and organize eco-friendly events</p>
            </div>
            <div class="action-buttons">
                <a href="{{ route('admin.events.create') }}" class="btn btn-outline-light">
                    <i class="fas fa-plus me-1"></i> Create New Event
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="stats-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-circle bg-primary me-3" style="width:50px;height:50px;">
                            <i class="fas fa-calendar fa-lg text-white"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 text-primary">{{ $totals['total_events'] ?? $events->total() }}</h4>
                            <small class="text-muted">Total Events</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="stats-card warning">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-circle bg-warning me-3" style="width:50px;height:50px;">
                            <i class="fas fa-clock fa-lg text-white"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 text-warning">{{ $totals['pending'] ?? \App\Models\Event::where('status', 'pending')->count() }}</h4>
                            <small class="text-muted">Pending Approval</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="stats-card success">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-circle bg-success me-3" style="width:50px;height:50px;">
                            <i class="fas fa-check-circle fa-lg text-white"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 text-success">{{ $totals['published'] ?? \App\Models\Event::where('status', 'published')->count() }}</h4>
                            <small class="text-muted">Published Events</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="stats-card info">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-circle bg-info me-3" style="width:50px;height:50px;">
                            <i class="fas fa-users fa-lg text-white"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 text-info">{{ $totals['registrations'] ?? \App\Models\Registration::count() }}</h4>
                            <small class="text-muted">Total Registrations</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="search-filter-bar mb-3">
        <div class="row g-2">
            <div class="col-md-4">
                <div class="position-relative">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" class="form-control" id="searchEvents" placeholder="Search events...">
                </div>
            </div>
            <div class="col-md-2">
                <select class="form-select" id="statusFilter">
                    <option value="">All Status</option>
                    <option value="draft">Draft</option>
                    <option value="pending">Pending Approval</option>
                    <option value="published">Published</option>
                    <option value="rejected">Rejected</option>
                    <option value="cancelled">Cancelled</option>
                    <option value="completed">Completed</option>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select" id="categoryFilter">
                    <option value="">All Categories</option>
                    @foreach(\App\Models\Category::all() as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select" id="venueFilter">
                    <option value="">All Venues</option>
                    @foreach(\App\Models\Venue::all() as $venue)
                        <option value="{{ $venue->id }}">{{ $venue->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-outline-primary-green w-100" id="clearFilters">
                    <i class="fas fa-times me-1"></i> Clear
                </button>
            </div>
        </div>
    </div>

    <!-- Events Table -->
    <div class="card border-0 shadow-sm fade-in">
        <div class="card-body p-0">
            @if($events->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4">Event</th>
                            <th>Category</th>
                            <th>Venue</th>
                            <th>Date & Time</th>
                            <th>Participants</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th class="pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($events as $event)
                        <tr class="event-row" data-event-id="{{ $event->id }}">
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="icon-circle bg-primary me-3" style="width:45px;height:45px;">
                                        @if($event->image)
                                            <img src="{{ asset('storage/' . $event->image) }}" 
                                                 alt="{{ $event->title }}" 
                                                 class="rounded-circle" 
                                                 style="width:45px;height:45px;object-fit:cover;">
                                        @else
                                            <i class="fas fa-calendar text-white"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <h6 class="mb-0 text-gray-800">{{ Str::limit($event->title, 30) }}</h6>
                                        <small class="text-muted">{{ Str::limit($event->description, 40) }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($event->category)
                                    <span class="badge badge-soft-info"><i class="fas fa-tag me-1"></i>{{ $event->category->name }}</span>
                                @else
                                    <span class="text-muted">No category</span>
                                @endif
                            </td>
                            <td>
                                @if($event->venue)
                                    <div><strong class="d-block">{{ $event->venue->name }}</strong>
                                        <small class="text-muted"><i class="fas fa-map-marker-alt me-1"></i>{{ Str::limit($event->venue->location, 20) }}</small>
                                    </div>
                                @else
                                    <span class="text-muted">No venue</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-primary d-block mb-1">{{ $event->start_date->format('M d, Y') }}</span>
                                <small class="text-muted"><i class="fas fa-clock me-1"></i>{{ $event->start_date->format('H:i') }}</small>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-secondary me-2">{{ $event->registrations_count ?? 0 }}</span>
                                    @if($event->capacity)
                                        <small class="text-muted">/ {{ $event->capacity }}</small>
                                        <div class="progress ms-2" style="width:50px;height:4px;">
                                            <div class="progress-bar bg-success" style="width: {{ min((($event->registrations_count ?? 0)/$event->capacity)*100, 100) }}%"></div>
                                        </div>
                                    @else
                                        <small class="text-muted">/ ∞</small>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @if($event->price > 0)
                                    <span class="text-success font-weight-bold">{{ number_format($event->price,2) }} TND</span>
                                @else
                                    <span class="badge badge-soft-success">FREE</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $statusClass = match($event->status) {
                                        'draft'=>'badge-soft-secondary',
                                        'pending'=>'badge-soft-warning',
                                        'published'=>'badge-soft-success',
                                        'rejected'=>'badge-soft-danger',
                                        'cancelled'=>'badge-soft-dark',
                                        'completed'=>'badge-soft-info',
                                        default=>'badge-soft-secondary'
                                    };
                                    $statusIcon = match($event->status) {
                                        'draft'=>'fas fa-file',
                                        'pending'=>'fas fa-clock',
                                        'published'=>'fas fa-check-circle',
                                        'rejected'=>'fas fa-times-circle',
                                        'cancelled'=>'fas fa-ban',
                                        'completed'=>'fas fa-flag-checkered',
                                        default=>'fas fa-question-circle'
                                    };
                                @endphp
                                <span class="badge {{ $statusClass }}"><i class="{{ $statusIcon }} me-1"></i>{{ ucfirst($event->status) }}</span>
                                @if($event->status==='pending')
                                    <br><small class="text-muted mt-1">Awaiting approval</small>
                                @elseif($event->status==='rejected' && $event->rejection_reason)
                                    <br><small class="text-danger mt-1" title="{{ $event->rejection_reason }}"><i class="fas fa-info-circle"></i> Rejected</small>
                                @endif
                            </td>
                            <td class="pe-4">
                                <div class="action-buttons">
                                    @if($event->status==='pending')
                                        <form action="{{ route('admin.events.approve',$event) }}" method="POST" class="d-inline me-1" onsubmit="return confirm('Approve this event?')">@csrf @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-success" title="Approve"><i class="fas fa-check"></i></button>
                                        </form>
                                        <button type="button" class="btn btn-sm btn-danger me-1" title="Reject" onclick="showRejectModal({{ $event->id }}, '{{ $event->title }}')"><i class="fas fa-times"></i></button>
                                    @elseif($event->status==='rejected')
                                        <form action="{{ route('admin.events.pending',$event) }}" method="POST" class="d-inline me-1" onsubmit="return confirm('Reset to pending?')">@csrf @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-warning" title="Set to Pending"><i class="fas fa-undo"></i></button>
                                        </form>
                                    @endif
                                    <a href="{{ route('admin.events.show',$event) }}" class="btn btn-sm btn-outline-info me-1" title="View"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('admin.events.edit',$event) }}" class="btn btn-sm btn-outline-primary me-1" title="Edit"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('admin.events.destroy',$event) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this event?')">@csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">No events found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="card-footer">
                {{ $events->links() }}
            </div>
            @else
            <div class="text-center p-5">
                <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">No events available</h5>
                <p class="text-muted">Click on "Create New Event" to add your first event.</p>
            </div>
            @endif
        </div>
    </div>

    

  

<script>
function toggleChatbot() {
    const modalElement = document.getElementById('chatbotModal');
    const loader = document.getElementById('chatbotLoader');
    const iframe = document.getElementById('chatbotFrame');
    const errorDiv = document.getElementById('chatbotError');

    if(loader) loader.style.display = 'flex';
    if(iframe) iframe.style.display = 'none';
    if(errorDiv) errorDiv.style.display = 'none';

    const chatbaseId = "{{ env('CHATBASE_ID') }}";

    if(!chatbaseId) {
        if(loader) loader.style.display = 'none';
        if(errorDiv) errorDiv.style.display = 'flex';
        return;
    }

    iframe.onload = () => {
        loader.style.display = 'none';
        iframe.style.display = 'block';
        errorDiv.style.display = 'none';
    };

    iframe.onerror = () => {
        loader.style.display = 'none';
        iframe.style.display = 'none';
        errorDiv.style.display = 'flex';
    };

    iframe.src = `https://www.chatbase.co/embed?chatbotId=${chatbaseId}`;

    const chatbotModal = new bootstrap.Modal(modalElement);
    chatbotModal.show();
}
</script>

@endsection
