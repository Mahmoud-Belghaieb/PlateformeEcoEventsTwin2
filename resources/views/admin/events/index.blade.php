@extends('layouts.admin')

@section('title', 'Events Management')

@section('content')
<div cla                            <div class="col-md-2 mb-3 mb-md-0">
                <select class="form-select" id="statusFilter">
                    <option value="">All Status</option>
                    <option value="draft">Draft</option>
                    <option value="pending">Pending Approval</option>
                    <option value="published">Published</option>
                    <option value="rejected">Rejected</option>
                    <option value="cancelled">Cancelled</option>
                    <option value="completed">Completed</option>
                </select>
            </div>ainer-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="container-fluid">
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
                        <i class="fas fa-plus me-1"></i>
                        Create New Event
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="stats-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-circle bg-primary me-3" style="width: 50px; height: 50px;">
                            <i class="fas fa-calendar fa-lg text-white"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 text-primary">{{ $events->total() }}</h4>
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
                        <div class="icon-circle bg-warning me-3" style="width: 50px; height: 50px;">
                            <i class="fas fa-clock fa-lg text-white"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 text-warning">{{ \App\Models\Event::where('status', 'pending')->count() }}</h4>
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
                        <div class="icon-circle bg-success me-3" style="width: 50px; height: 50px;">
                            <i class="fas fa-check-circle fa-lg text-white"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 text-success">{{ \App\Models\Event::where('status', 'published')->count() }}</h4>
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
                        <div class="icon-circle bg-info me-3" style="width: 50px; height: 50px;">
                            <i class="fas fa-users fa-lg text-white"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 text-info">{{ \App\Models\Registration::count() }}</h4>
                            <small class="text-muted">Total Registrations</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="search-filter-bar">
        <div class="row">
            <div class="col-md-4 mb-3 mb-md-0">
                <div class="position-relative">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" class="form-control" id="searchEvents" placeholder="Search events...">
                </div>
            </div>
            <div class="col-md-2 mb-3 mb-md-0">
                <select class="form-select" id="statusFilter">
                    <option value="">All Status</option>
                    <option value="upcoming">Upcoming</option>
                    <option value="past">Past</option>
                    <option value="today">Today</option>
                </select>
            </div>
            <div class="col-md-2 mb-3 mb-md-0">
                <select class="form-select" id="categoryFilter">
                    <option value="">All Categories</option>
                    @foreach(\App\Models\Category::all() as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 mb-3 mb-md-0">
                <select class="form-select" id="venueFilter">
                    <option value="">All Venues</option>
                    @foreach(\App\Models\Venue::all() as $venue)
                        <option value="{{ $venue->id }}">{{ $venue->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-outline-primary-green w-100" id="clearFilters">
                    <i class="fas fa-times me-1"></i>
                    Clear
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
                                        <div class="icon-circle bg-primary me-3" style="width: 45px; height: 45px;">
                                            @if($event->image)
                                                <img src="{{ asset('storage/' . $event->image) }}" 
                                                     alt="{{ $event->title }}" 
                                                     class="rounded-circle" 
                                                     style="width: 45px; height: 45px; object-fit: cover;">
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
                                        <span class="badge badge-soft-info">
                                            <i class="fas fa-tag me-1"></i>
                                            {{ $event->category->name }}
                                        </span>
                                    @else
                                        <span class="text-muted">No category</span>
                                    @endif
                                </td>
                                <td>
                                    @if($event->venue)
                                        <div>
                                            <strong class="d-block">{{ $event->venue->name }}</strong>
                                            <small class="text-muted">
                                                <i class="fas fa-map-marker-alt me-1"></i>
                                                {{ Str::limit($event->venue->location, 20) }}
                                            </small>
                                        </div>
                                    @else
                                        <span class="text-muted">No venue</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-primary d-block mb-1">
                                        {{ $event->start_date->format('M d, Y') }}
                                    </span>
                                    <small class="text-muted">
                                        <i class="fas fa-clock me-1"></i>
                                        {{ $event->start_date->format('H:i') }}
                                    </small>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-secondary me-2">
                                            {{ $event->registrations->count() }}
                                        </span>
                                        @if($event->capacity)
                                            <small class="text-muted">/ {{ $event->capacity }}</small>
                                            <div class="progress ms-2" style="width: 50px; height: 4px;">
                                                <div class="progress-bar bg-success" 
                                                     style="width: {{ min(($event->registrations->count() / $event->capacity) * 100, 100) }}%">
                                                </div>
                                            </div>
                                        @else
                                            <small class="text-muted">/ ∞</small>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @if($event->price > 0)
                                        <span class="text-success font-weight-bold">
                                            {{ number_format($event->price, 2) }} TND
                                        </span>
                                    @else
                                        <span class="badge badge-soft-success">FREE</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $statusClass = match($event->status) {
                                            'draft' => 'badge-soft-secondary',
                                            'pending' => 'badge-soft-warning',
                                            'published' => 'badge-soft-success',
                                            'rejected' => 'badge-soft-danger',
                                            'cancelled' => 'badge-soft-dark',
                                            'completed' => 'badge-soft-info',
                                            default => 'badge-soft-secondary'
                                        };
                                        
                                        $statusIcon = match($event->status) {
                                            'draft' => 'fas fa-file',
                                            'pending' => 'fas fa-clock',
                                            'published' => 'fas fa-check-circle',
                                            'rejected' => 'fas fa-times-circle',
                                            'cancelled' => 'fas fa-ban',
                                            'completed' => 'fas fa-flag-checkered',
                                            default => 'fas fa-question-circle'
                                        };
                                    @endphp
                                    <span class="badge {{ $statusClass }}">
                                        <i class="{{ $statusIcon }} me-1"></i>
                                        {{ ucfirst($event->status) }}
                                    </span>
                                    
                                    @if($event->status === 'pending')
                                        <br><small class="text-muted mt-1">Awaiting approval</small>
                                    @elseif($event->status === 'rejected' && $event->rejection_reason)
                                        <br><small class="text-danger mt-1" title="{{ $event->rejection_reason }}">
                                            <i class="fas fa-info-circle"></i> Rejected
                                        </small>
                                    @endif
                                </td>
                                <td class="pe-4">
                                    <div class="action-buttons">
                                        @if($event->status === 'pending')
                                            <!-- Approval buttons for pending events -->
                                            <form action="{{ route('admin.events.approve', $event) }}" 
                                                  method="POST" 
                                                  class="d-inline me-1"
                                                  onsubmit="return confirm('Are you sure you want to approve this event?')">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-success" 
                                                        title="Approve Event">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                            <button type="button" 
                                                    class="btn btn-sm btn-danger me-1" 
                                                    title="Reject Event"
                                                    onclick="showRejectModal({{ $event->id }}, '{{ $event->title }}')">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        @elseif($event->status === 'rejected')
                                            <!-- Set to pending button for rejected events -->
                                            <form action="{{ route('admin.events.pending', $event) }}" 
                                                  method="POST" 
                                                  class="d-inline me-1"
                                                  onsubmit="return confirm('Reset this event to pending status?')">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-warning" 
                                                        title="Set to Pending">
                                                    <i class="fas fa-undo"></i>
                                                </button>
                                            </form>
                                        @endif
                                        
                                        <!-- Standard action buttons -->
                                        <a href="{{ route('admin.events.show', $event) }}" 
                                           class="btn btn-sm btn-outline-info me-1" 
                                           title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.events.edit', $event) }}" 
                                           class="btn btn-sm btn-outline-primary me-1" 
                                           title="Edit Event">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.events.destroy', $event) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to delete this event?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-sm btn-outline-danger" 
                                                    title="Delete Event">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-calendar-alt fa-3x mb-3"></i>
                                        <p>No events found.</p>
                                        <a href="{{ route('admin.events.create') }}" class="btn btn-primary-green">
                                            <i class="fas fa-plus me-1"></i>
                                            Create First Event
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
        </div>
    </div>

    <!-- Pagination -->
    @if($events->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $events->links() }}
        </div>
    @endif
</div>

<!-- Reject Event Modal -->
<div class="modal fade" id="rejectEventModal" tabindex="-1" aria-labelledby="rejectEventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectEventModalLabel">
                    <i class="fas fa-times-circle text-danger me-2"></i>
                    Reject Event
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="rejectEventForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        You are about to reject the event: <strong id="eventTitleToReject"></strong>
                    </div>
                    
                    <div class="mb-3">
                        <label for="rejectionReason" class="form-label">
                            <i class="fas fa-comment me-1"></i>
                            Reason for rejection <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control" 
                                  id="rejectionReason" 
                                  name="rejection_reason" 
                                  rows="4" 
                                  placeholder="Please provide a reason for rejecting this event..."
                                  required></textarea>
                        <div class="form-text">
                            This reason will be visible to the event organizer.
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-times me-1"></i>
                        Reject Event
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add fade-in animation to table rows
        const rows = document.querySelectorAll('.event-row');
        rows.forEach((row, index) => {
            row.style.animationDelay = `${index * 0.05}s`;
            row.classList.add('fade-in');
        });
        
        // Search functionality
        const searchInput = document.getElementById('searchEvents');
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                rows.forEach(row => {
                    const eventTitle = row.querySelector('h6').textContent.toLowerCase();
                    const eventDescription = row.querySelector('small').textContent.toLowerCase();
                    
                    if (eventTitle.includes(searchTerm) || eventDescription.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        }
        
        // Clear filters
        const clearFiltersBtn = document.getElementById('clearFilters');
        if (clearFiltersBtn) {
            clearFiltersBtn.addEventListener('click', function() {
                document.getElementById('searchEvents').value = '';
                document.getElementById('statusFilter').value = '';
                document.getElementById('categoryFilter').value = '';
                document.getElementById('venueFilter').value = '';
                
                // Show all rows
                rows.forEach(row => {
                    row.style.display = '';
                });
            });
        }
        
        // Status filter
        const statusFilter = document.getElementById('statusFilter');
        if (statusFilter) {
            statusFilter.addEventListener('change', function() {
                const filterValue = this.value;
                rows.forEach(row => {
                    const statusBadge = row.querySelector('.badge');
                    const statusText = statusBadge ? statusBadge.textContent.toLowerCase().trim() : '';
                    
                    if (!filterValue || statusText.includes(filterValue.toLowerCase())) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        }
    });
    
    // Function to show reject modal
    function showRejectModal(eventId, eventTitle) {
        const modal = new bootstrap.Modal(document.getElementById('rejectEventModal'));
        const form = document.getElementById('rejectEventForm');
        const titleElement = document.getElementById('eventTitleToReject');
        const reasonTextarea = document.getElementById('rejectionReason');
        
        // Set form action
        form.action = `/admin/events/${eventId}/reject`;
        
        // Set event title
        titleElement.textContent = eventTitle;
        
        // Clear previous reason
        reasonTextarea.value = '';
        
        // Show modal
        modal.show();
        
        // Focus on textarea
        setTimeout(() => {
            reasonTextarea.focus();
        }, 500);
    }
</script>
@endpush