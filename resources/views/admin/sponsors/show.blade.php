@extends('layouts.admin')

@section('title', 'Sponsor Details')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="mb-2">
                    <i class="fas fa-handshake me-2"></i>
                    Sponsor Details
                </h1>
                <p class="mb-0 opacity-90">View complete information about this sponsor</p>
            </div>
            <div>
                <a href="{{ route('admin.sponsors.edit', $sponsor) }}" class="btn btn-warning me-2">
                    <i class="fas fa-edit me-2"></i>Edit Sponsor
                </a>
                <a href="{{ route('admin.sponsors.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Sponsors
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Sponsor Logo -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-gradient-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-image me-2"></i>Sponsor Logo</h5>
                </div>
                <div class="card-body text-center">
                    @if($sponsor->logo)
                        <img src="{{ asset('storage/' . $sponsor->logo) }}" 
                             alt="{{ $sponsor->name }}" 
                             class="img-fluid rounded shadow-sm"
                             style="max-height: 300px; object-fit: contain;">
                    @else
                        <div class="bg-gradient-secondary text-white d-flex align-items-center justify-content-center rounded" 
                             style="height: 300px;">
                            <i class="fas fa-handshake fa-5x opacity-50"></i>
                        </div>
                        <p class="text-muted mt-3">No logo available</p>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card shadow-sm mt-3">
                <div class="card-header bg-gradient-secondary text-white">
                    <h5 class="mb-0"><i class="fas fa-bolt me-2"></i>Quick Actions</h5>
                </div>
                <div class="card-body">
                    <a href="{{ route('admin.sponsors.edit', $sponsor) }}" class="btn btn-warning w-100 mb-2">
                        <i class="fas fa-edit me-2"></i>Edit Sponsor
                    </a>
                    @if($sponsor->website)
                        <a href="{{ $sponsor->website }}" target="_blank" class="btn btn-info w-100 mb-2">
                            <i class="fas fa-external-link-alt me-2"></i>Visit Website
                        </a>
                    @endif
                    <form action="{{ route('admin.sponsors.destroy', $sponsor) }}" method="POST" 
                          onsubmit="return confirm('Are you sure you want to delete this sponsor?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="fas fa-trash me-2"></i>Delete Sponsor
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sponsor Information -->
        <div class="col-md-8">
            <!-- Basic Information -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-gradient-success text-white">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Basic Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Sponsor Name</label>
                            <h5 class="mb-0">{{ $sponsor->name }}</h5>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Sponsorship Level</label>
                            <h5>
                                @php
                                    $levelColors = [
                                        'platinum' => 'secondary',
                                        'gold' => 'warning',
                                        'silver' => 'light text-dark',
                                        'bronze' => 'danger'
                                    ];
                                    $color = $levelColors[$sponsor->sponsorship_level] ?? 'primary';
                                @endphp
                                <span class="badge bg-{{ $color }} px-3 py-2 fs-6">
                                    <i class="fas fa-award me-1"></i>{{ ucfirst($sponsor->sponsorship_level) }}
                                </span>
                            </h5>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="text-muted small">Description</label>
                            <p class="mb-0">{{ $sponsor->description ?? 'No description provided' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-gradient-info text-white">
                    <h5 class="mb-0"><i class="fas fa-address-book me-2"></i>Contact Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Email</label>
                            <p class="mb-0">
                                @if($sponsor->email)
                                    <a href="mailto:{{ $sponsor->email }}" class="text-decoration-none">
                                        <i class="fas fa-envelope me-2 text-primary"></i>{{ $sponsor->email }}
                                    </a>
                                @else
                                    <span class="text-muted">Not provided</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Phone</label>
                            <p class="mb-0">
                                @if($sponsor->phone)
                                    <a href="tel:{{ $sponsor->phone }}" class="text-decoration-none">
                                        <i class="fas fa-phone me-2 text-success"></i>{{ $sponsor->phone }}
                                    </a>
                                @else
                                    <span class="text-muted">Not provided</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="text-muted small">Website</label>
                            <p class="mb-0">
                                @if($sponsor->website)
                                    <a href="{{ $sponsor->website }}" target="_blank" class="text-decoration-none">
                                        <i class="fas fa-globe me-2 text-info"></i>{{ $sponsor->website }}
                                        <i class="fas fa-external-link-alt ms-1 small"></i>
                                    </a>
                                @else
                                    <span class="text-muted">Not provided</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Financial Information -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-gradient-warning text-white">
                    <h5 class="mb-0"><i class="fas fa-dollar-sign me-2"></i>Financial Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Contribution Amount</label>
                            <h3 class="text-success mb-0">
                                <i class="fas fa-lira-sign me-2"></i>{{ number_format($sponsor->contribution_amount, 2) }} TND
                            </h3>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Status</label>
                            <h5>
                                @if($sponsor->is_active)
                                    <span class="badge bg-success px-3 py-2 fs-6">
                                        <i class="fas fa-check-circle me-1"></i>Active
                                    </span>
                                @else
                                    <span class="badge bg-danger px-3 py-2 fs-6">
                                        <i class="fas fa-times-circle me-1"></i>Inactive
                                    </span>
                                @endif
                            </h5>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Metadata -->
            <div class="card shadow-sm">
                <div class="card-header bg-gradient-dark text-white">
                    <h5 class="mb-0"><i class="fas fa-clock me-2"></i>Metadata</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="text-muted small">Created At</label>
                            <p class="mb-0">
                                <i class="fas fa-calendar-plus me-2 text-primary"></i>
                                {{ $sponsor->created_at->format('M d, Y - h:i A') }}
                            </p>
                            <small class="text-muted">{{ $sponsor->created_at->diffForHumans() }}</small>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">Last Updated</label>
                            <p class="mb-0">
                                <i class="fas fa-calendar-edit me-2 text-success"></i>
                                {{ $sponsor->updated_at->format('M d, Y - h:i A') }}
                            </p>
                            <small class="text-muted">{{ $sponsor->updated_at->diffForHumans() }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
