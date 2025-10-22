@extends('layouts.admin')

@section('title', 'Sponsors Management')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header mb-4">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="mb-2">
                        <i class="fas fa-handshake me-2"></i>
                        Sponsors Management
                    </h1>
                    <p class="mb-0 opacity-90">Manage partnership sponsors and their contributions</p>
                </div>
                <a href="{{ route('admin.sponsors.create') }}" class="btn btn-primary-green btn-lg shadow">
                    <i class="fas fa-plus me-2"></i>Add New Sponsor
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="stats-card">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="icon-circle bg-primary">
                        <i class="fas fa-handshake text-white"></i>
                    </div>
                    <div class="text-end">
                        <h2 class="mb-0 fw-bold">{{ $sponsors->total() }}</h2>
                        <small class="text-muted">Total Sponsors</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stats-card">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="icon-circle bg-success">
                        <i class="fas fa-check-circle text-white"></i>
                    </div>
                    <div class="text-end">
                        <h2 class="mb-0 fw-bold">{{ $sponsors->where('is_active', true)->count() }}</h2>
                        <small class="text-muted">Active</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stats-card warning">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="icon-circle bg-warning">
                        <i class="fas fa-star text-white"></i>
                    </div>
                    <div class="text-end">
                        <h2 class="mb-0 fw-bold">{{ $sponsors->where('sponsorship_level', 'platinum')->count() + $sponsors->where('sponsorship_level', 'gold')->count() }}</h2>
                        <small class="text-muted">Premium</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stats-card info">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="icon-circle bg-info">
                        <i class="fas fa-lira-sign text-white"></i>
                    </div>
                    <div class="text-end">
                        <h2 class="mb-0 fw-bold">{{ number_format($sponsors->sum('contribution_amount'), 2) }} TND</h2>
                        <small class="text-muted">Total Contributions</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.sponsors.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Search</label>
                    <input type="text" name="search" class="form-control" placeholder="Search by name..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Level</label>
                    <select name="level" class="form-select">
                        <option value="">All Levels</option>
                        <option value="platinum" {{ request('level') == 'platinum' ? 'selected' : '' }}>Platinum</option>
                        <option value="gold" {{ request('level') == 'gold' ? 'selected' : '' }}>Gold</option>
                        <option value="silver" {{ request('level') == 'silver' ? 'selected' : '' }}>Silver</option>
                        <option value="bronze" {{ request('level') == 'bronze' ? 'selected' : '' }}>Bronze</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary-green flex-grow-1">
                            <i class="fas fa-filter me-2"></i>Filter
                        </button>
                        <a href="{{ route('admin.sponsors.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-redo"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Sponsors Table -->
    <div class="card shadow-sm">
        <div class="card-header bg-gradient-success text-white">
            <h5 class="mb-0">
                <i class="fas fa-list me-2"></i>All Sponsors
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-gradient-success text-white">
                        <tr>
                            <th>Logo</th>
                            <th>Name</th>
                            <th>Website</th>
                            <th>Contact</th>
                            <th>Level</th>
                            <th>Contribution</th>
                            <th>Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sponsors as $sponsor)
                            <tr>
                                <td>
                                    @if($sponsor->logo)
                                        <img src="{{ Storage::url($sponsor->logo) }}" alt="{{ $sponsor->name }}" class="rounded shadow-sm" style="height: 50px; width: 50px; object-fit: cover;">
                                    @else
                                        <div class="bg-gradient-secondary text-white d-flex align-items-center justify-content-center rounded shadow-sm" style="width: 50px; height: 50px;">
                                            <strong>{{ substr($sponsor->name, 0, 1) }}</strong>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $sponsor->name }}</strong><br>
                                    @if($sponsor->description)
                                        <small class="text-muted">{{ Str::limit($sponsor->description, 40) }}</small>
                                    @endif
                                </td>
                                <td>
                                    @if($sponsor->website)
                                        <a href="{{ $sponsor->website }}" target="_blank" class="text-decoration-none">
                                            <i class="fas fa-external-link-alt me-1"></i>{{ Str::limit($sponsor->website, 25) }}
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($sponsor->contact_email)
                                        <small><i class="fas fa-envelope me-1"></i>{{ $sponsor->contact_email }}</small><br>
                                    @endif
                                    @if($sponsor->contact_phone)
                                        <small><i class="fas fa-phone me-1"></i>{{ $sponsor->contact_phone }}</small>
                                    @endif
                                    @if(!$sponsor->contact_email && !$sponsor->contact_phone)
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $levelColors = [
                                            'platinum' => 'dark',
                                            'gold' => 'warning',
                                            'silver' => 'secondary',
                                            'bronze' => 'info'
                                        ];
                                        $color = $levelColors[$sponsor->sponsorship_level] ?? 'secondary';
                                    @endphp
                                    <span class="badge bg-{{ $color }} px-3 py-2">
                                        <i class="fas fa-award me-1"></i>{{ ucfirst($sponsor->sponsorship_level) }}
                                    </span>
                                </td>
                                <td><strong class="text-success">{{ number_format($sponsor->contribution_amount, 2) }} TND</strong></td>
                                <td>
                                    @if($sponsor->is_active)
                                        <span class="badge bg-success px-3 py-2">
                                            <i class="fas fa-check-circle me-1"></i>Active
                                        </span>
                                    @else
                                        <span class="badge bg-danger px-3 py-2">
                                            <i class="fas fa-times-circle me-1"></i>Inactive
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="action-buttons d-flex justify-content-center gap-1">
                                        <a href="{{ route('admin.sponsors.show', $sponsor) }}" class="btn btn-sm btn-info" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.sponsors.edit', $sponsor) }}" class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.sponsors.destroy', $sponsor) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this sponsor?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <div class="empty-state">
                                        <i class="fas fa-handshake"></i>
                                        <h5>No Sponsors Found</h5>
                                        <p>There are no sponsors in the system yet.</p>
                                        <a href="{{ route('admin.sponsors.create') }}" class="btn btn-primary-green">
                                            <i class="fas fa-plus me-2"></i>Add First Sponsor
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($sponsors->hasPages())
            <div class="card-footer bg-light">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted">
                        Showing {{ $sponsors->firstItem() }} to {{ $sponsors->lastItem() }} of {{ $sponsors->total() }} sponsors
                    </div>
                    {{ $sponsors->links() }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
