@extends('layouts.admin')

@section('title', 'Create New Event')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0">
                        <i class="fas fa-plus-circle me-2"></i>
                        Create New Event
                    </h1>
                    <p class="mb-0">Add a new event to the eco-friendly events system</p>
                </div>
                <a href="{{ route('admin.events.index') }}" class="btn btn-outline-light">
                    <i class="fas fa-arrow-left me-1"></i>
                    Back to Events
                </a>
            </div>
        </div>
    </div>

    <!-- Create Form -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm fade-in">
                <div class="card-header bg-gradient-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-edit me-2"></i>
                        Event Details
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <!-- Title -->
                            <div class="col-md-12 mb-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                           id="title" name="title" value="{{ old('title') }}" 
                                           placeholder="Enter event title" required>
                                    <label for="title">
                                        <i class="fas fa-heading me-1"></i>
                                        Event Title *
                                    </label>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="col-md-12 mb-4">
                                <label for="description" class="form-label font-weight-bold">
                                    <i class="fas fa-align-left me-1"></i>
                                    Description *
                                </label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" name="description" rows="4" 
                                          placeholder="Describe the event in detail..." required>{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Start Date & Price -->
                            <div class="col-md-6 mb-4">
                                <div class="form-floating">
                                    <input type="datetime-local" class="form-control @error('start_date') is-invalid @enderror" 
                                           id="start_date" name="start_date" value="{{ old('start_date') }}" required>
                                    <label for="start_date">
                                        <i class="fas fa-calendar me-1"></i>
                                        Start Date & Time *
                                    </label>
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="price" class="form-label font-weight-bold">
                                    <i class="fas fa-money-bill me-1"></i>
                                    Price (TND) *
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-coins"></i>
                                    </span>
                                    <input type="number" class="form-control @error('price') is-invalid @enderror" 
                                           id="price" name="price" value="{{ old('price') }}" 
                                           step="0.01" min="0" placeholder="0.00" required>
                                    <span class="input-group-text">TND</span>
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Category & Venue -->
                            <div class="col-md-6 mb-4">
                                <div class="form-floating">
                                    <select class="form-select @error('category_id') is-invalid @enderror" 
                                            id="category_id" name="category_id" required>
                                        <option value="">Choose category...</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="category_id">
                                        <i class="fas fa-tags me-1"></i>
                                        Category *
                                    </label>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <div class="form-floating">
                                    <select class="form-select @error('venue_id') is-invalid @enderror" 
                                            id="venue_id" name="venue_id" required>
                                        <option value="">Choose venue...</option>
                                        @foreach($venues as $venue)
                                            <option value="{{ $venue->id }}" {{ old('venue_id') == $venue->id ? 'selected' : '' }}>
                                                {{ $venue->name }} - {{ $venue->location }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="venue_id">
                                        <i class="fas fa-map-marker-alt me-1"></i>
                                        Venue *
                                    </label>
                                    @error('venue_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Capacity & Status -->
                            <div class="col-md-6 mb-4">
                                <div class="form-floating">
                                    <input type="number" class="form-control @error('capacity') is-invalid @enderror" 
                                           id="capacity" name="capacity" value="{{ old('capacity') }}" 
                                           min="1" placeholder="Maximum attendees">
                                    <label for="capacity">
                                        <i class="fas fa-users me-1"></i>
                                        Capacity (Optional)
                                    </label>
                                    @error('capacity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <div class="form-floating">
                                    <select class="form-select @error('status') is-invalid @enderror" 
                                            id="status" name="status" required>
                                        <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                        <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                    <label for="status">
                                        <i class="fas fa-toggle-on me-1"></i>
                                        Status *
                                    </label>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Image Upload -->
                            <div class="col-md-12 mb-4">
                                <label for="image" class="form-label font-weight-bold">
                                    <i class="fas fa-image me-1"></i>
                                    Event Image
                                </label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                       id="image" name="image" accept="image/*">
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Upload a high-quality image (JPG, PNG, GIF) - Max 2MB
                                </div>
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="d-flex justify-content-between align-items-center mt-4 pt-4 border-top">
                            <a href="{{ route('admin.events.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-1"></i>
                                Cancel
                            </a>
                            <div class="action-buttons">
                                <button type="submit" name="action" value="draft" class="btn btn-outline-primary-green me-2">
                                    <i class="fas fa-save me-1"></i>
                                    Save as Draft
                                </button>
                                <button type="submit" name="action" value="publish" class="btn btn-primary-green">
                                    <i class="fas fa-rocket me-1"></i>
                                    Publish Event
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Positions & Quick Actions Sidebar -->
        <div class="col-lg-4">
            <!-- Required Positions -->
            <div class="card border-0 shadow-sm fade-in mb-4">
                <div class="card-header bg-gradient-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-user-friends me-2"></i>
                        Required Positions
                    </h5>
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-3">
                        <i class="fas fa-info-circle me-1"></i>
                        Select volunteer positions needed for this event
                    </p>
                    
                    @if($positions->count() > 0)
                        <div class="positions-list">
                            @foreach($positions as $position)
                                <div class="form-check mb-3 p-3 bg-light rounded">
                                    <input class="form-check-input" type="checkbox" 
                                           name="positions[]" value="{{ $position->id }}" 
                                           id="position_{{ $position->id }}"
                                           {{ in_array($position->id, old('positions', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label w-100" for="position_{{ $position->id }}">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-circle bg-info me-3" style="width: 35px; height: 35px;">
                                                <i class="fas fa-user text-white"></i>
                                            </div>
                                            <div>
                                                <strong class="d-block">{{ $position->name }}</strong>
                                                @if($position->description)
                                                    <small class="text-muted">{{ Str::limit($position->description, 40) }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state py-4">
                            <i class="fas fa-user-plus"></i>
                            <h6>No positions available</h6>
                            <p>Create volunteer positions first</p>
                            <a href="{{ route('admin.positions.create') }}" class="btn btn-sm btn-outline-primary-green">
                                <i class="fas fa-plus me-1"></i>
                                Create Position
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Event Guidelines -->
            <div class="card border-0 shadow-sm fade-in mb-4">
                <div class="card-header bg-gradient-warning text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-lightbulb me-2"></i>
                        Event Guidelines
                    </h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-3 d-flex">
                            <i class="fas fa-leaf text-success me-3 mt-1"></i>
                            <div>
                                <strong>Eco-Friendly Focus</strong>
                                <small class="d-block text-muted">Ensure events promote environmental awareness</small>
                            </div>
                        </li>
                        <li class="mb-3 d-flex">
                            <i class="fas fa-users text-info me-3 mt-1"></i>
                            <div>
                                <strong>Community Engagement</strong>
                                <small class="d-block text-muted">Encourage local participation and collaboration</small>
                            </div>
                        </li>
                        <li class="mb-3 d-flex">
                            <i class="fas fa-clock text-warning me-3 mt-1"></i>
                            <div>
                                <strong>Realistic Planning</strong>
                                <small class="d-block text-muted">Set appropriate capacity and timing</small>
                            </div>
                        </li>
                        <li class="mb-0 d-flex">
                            <i class="fas fa-save text-primary me-3 mt-1"></i>
                            <div>
                                <strong>Save as Draft</strong>
                                <small class="d-block text-muted">Review details before publishing</small>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="card border-0 shadow-sm fade-in">
                <div class="card-header bg-gradient-secondary text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-chart-bar me-2"></i>
                        System Overview
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="stats-card text-center p-3">
                                <h4 class="mb-0 text-primary">{{ \App\Models\Event::count() }}</h4>
                                <small class="text-muted">Total Events</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stats-card text-center p-3">
                                <h4 class="mb-0 text-success">{{ \App\Models\Category::count() }}</h4>
                                <small class="text-muted">Categories</small>
                            </div>
                        </div>
                    </div>
                    <hr class="my-3">
                    <div class="text-center">
                        <small class="text-muted">
                            <i class="fas fa-rocket me-1"></i>
                            Building a sustainable future together
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .positions-list .form-check {
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }
    
    .positions-list .form-check:hover {
        border-color: var(--primary-green);
        transform: translateY(-2px);
    }
    
    .positions-list .form-check-input:checked + .form-check-label {
        color: var(--primary-green);
        font-weight: 600;
    }
    
    .form-floating .form-control:focus ~ label,
    .form-floating .form-control:not(:placeholder-shown) ~ label {
        transform: scale(0.85) translateY(-0.5rem) translateX(0.15rem);
    }
    
    .stats-card {
        background: white;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    
    .stats-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    
    .icon-circle {
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }
    
    .page-header {
        background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
        color: white;
        margin: -20px -20px 2rem -20px;
        padding: 2rem 0;
        border-radius: 0 0 20px 20px;
    }
    
    .fade-in {
        animation: fadeIn 0.5s ease-out;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Set minimum date to today
        const startDateInput = document.getElementById('start_date');
        const now = new Date();
        now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
        startDateInput.min = now.toISOString().slice(0, 16);
        
        // Add animation to position checkboxes
        const positionChecks = document.querySelectorAll('.positions-list .form-check');
        positionChecks.forEach((check, index) => {
            check.style.animationDelay = `${index * 0.1}s`;
            check.classList.add('fade-in');
        });
        
        // Form validation feedback
        const form = document.querySelector('form');
        const submitButtons = document.querySelectorAll('button[type="submit"]');
        
        form.addEventListener('submit', function() {
            submitButtons.forEach(btn => {
                btn.disabled = true;
                const icon = btn.querySelector('i');
                icon.className = 'fas fa-spinner fa-spin me-1';
            });
        });
        
        // Auto-resize textarea
        const textarea = document.getElementById('description');
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
    });
</script>
@endpush