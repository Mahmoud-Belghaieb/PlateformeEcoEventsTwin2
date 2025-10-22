@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0">
                        <i class="fas fa-user-edit me-2"></i>
                        Edit User: {{ $user->name }}
                    </h1>
                    <p class="mb-0">Update user information and permissions</p>
                </div>
                <div>
                    <a href="{{ route('admin.users.show', $user) }}" class="btn btn-outline-info me-2">
                        <i class="fas fa-eye me-1"></i>
                        View User
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary-green">
                        <i class="fas fa-arrow-left me-1"></i>
                        Back to Users
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Form -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-gradient-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-user-edit me-2"></i>
                        User Information
                    </h5>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <strong>Please fix the following errors:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('admin.users.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <!-- Name -->
                            <div class="col-md-6 mb-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', $user->name) }}" 
                                           placeholder="Enter full name" required>
                                    <label for="name">
                                        <i class="fas fa-user me-1"></i>
                                        Full Name *
                                    </label>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="col-md-6 mb-4">
                                <div class="form-floating">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email', $user->email) }}" 
                                           placeholder="Enter email address" required>
                                    <label for="email">
                                        <i class="fas fa-envelope me-1"></i>
                                        Email Address *
                                    </label>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Role -->
                            <div class="col-md-6 mb-4">
                                <div class="form-floating">
                                    <select class="form-select @error('role') is-invalid @enderror" 
                                            id="role" name="role" required>
                                        @foreach($roles as $value => $label)
                                            <option value="{{ $value }}" {{ old('role', $user->role) === $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="role">
                                        <i class="fas fa-user-tag me-1"></i>
                                        User Role *
                                    </label>
                                    @error('role')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="col-md-6 mb-4">
                                <label class="form-label font-weight-bold">
                                    <i class="fas fa-toggle-on me-1"></i>
                                    Account Status
                                </label>
                                <div class="form-check form-switch" style="padding-left: 3rem;">
                                    <input class="form-check-input" type="checkbox" role="switch" 
                                           id="is_active" name="is_active" value="1" 
                                           {{ old('is_active', $user->is_active) ? 'checked' : '' }}
                                           style="margin-left: -2.5rem;">
                                    <label class="form-check-label" for="is_active">
                                        Account is Active
                                    </label>
                                </div>
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Inactive users cannot log in to the system
                                </div>
                            </div>
                        </div>

                        <!-- Current Status Alert -->
                        @if($user->id === auth()->id())
                        <div class="alert alert-warning" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Warning:</strong> You are editing your own account. Be careful when changing your role or status.
                        </div>
                        @endif

                        <!-- Form Actions -->
                        <div class="d-flex justify-content-between align-items-center mt-4 pt-4 border-top">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-1"></i>
                                Cancel
                            </a>
                            <div class="action-buttons">
                                <button type="submit" class="btn btn-primary-green">
                                    <i class="fas fa-save me-1"></i>
                                    Update User
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- User Info Sidebar -->
        <div class="col-lg-4">
            <!-- Current User Info -->
            <div class="card border-0 shadow-sm fade-in mb-4">
                <div class="card-header bg-gradient-info text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Current User Information
                    </h6>
                </div>
                <div class="card-body">
                    <div class="user-info-item mb-3">
                        <strong class="d-block">Account Created:</strong>
                        <span class="text-muted">{{ $user->created_at->format('M d, Y \a\t H:i') }}</span>
                    </div>
                    
                    <div class="user-info-item mb-3">
                        <strong class="d-block">Last Login:</strong>
                        <span class="text-muted">
                            {{ $user->last_login_at ? $user->last_login_at->format('M d, Y \a\t H:i') : 'Never logged in' }}
                        </span>
                    </div>
                    
                    <div class="user-info-item mb-3">
                        <strong class="d-block">Current Status:</strong>
                        <span class="badge {{ $user->is_active ? 'bg-success' : 'bg-danger' }}">
                            {{ $user->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    
                    <div class="user-info-item">
                        <strong class="d-block">Current Role:</strong>
                        <span class="badge bg-primary">{{ ucfirst($user->role) }}</span>
                    </div>
                </div>
            </div>

            <!-- Admin Guidelines -->
            <div class="card border-0 shadow-sm fade-in">
                <div class="card-header bg-gradient-warning text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-shield-alt me-2"></i>
                        Admin Guidelines
                    </h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-3 d-flex">
                            <i class="fas fa-user-shield text-info me-3 mt-1"></i>
                            <div>
                                <strong>Role Changes</strong>
                                <small class="d-block text-muted">Be careful when changing user roles and permissions</small>
                            </div>
                        </li>
                        <li class="mb-3 d-flex">
                            <i class="fas fa-ban text-danger me-3 mt-1"></i>
                            <div>
                                <strong>Account Status</strong>
                                <small class="d-block text-muted">Inactive users cannot access the system</small>
                            </div>
                        </li>
                        <li class="mb-3 d-flex">
                            <i class="fas fa-envelope text-primary me-3 mt-1"></i>
                            <div>
                                <strong>Email Changes</strong>
                                <small class="d-block text-muted">Email addresses must be unique in the system</small>
                            </div>
                        </li>
                        <li class="mb-0 d-flex">
                            <i class="fas fa-save text-success me-3 mt-1"></i>
                            <div>
                                <strong>Save Changes</strong>
                                <small class="d-block text-muted">Review all changes before updating the user</small>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .page-header {
        background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
        color: white;
        margin: -20px -20px 2rem -20px;
        padding: 2rem 0;
        border-radius: 0 0 20px 20px;
    }
    
    .form-floating .form-control:focus ~ label,
    .form-floating .form-control:not(:placeholder-shown) ~ label {
        transform: scale(0.85) translateY(-0.5rem) translateX(0.15rem);
    }
    
    .form-check-input:checked {
        background-color: var(--primary-green);
        border-color: var(--primary-green);
    }
    
    .user-info-item {
        padding: 0.5rem 0;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .user-info-item:last-child {
        border-bottom: none;
    }
    
    .fade-in {
        animation: fadeIn 0.5s ease-out;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .form-check-input {
        width: 2.5em;
        height: 1.25em;
    }
    
    .form-switch .form-check-input {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='3' fill='rgba%28255,255,255,1%29'/%3e%3c/svg%3e");
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add animation to form elements
        const formElements = document.querySelectorAll('.form-floating input, .form-floating select');
        formElements.forEach((element, index) => {
            element.style.animationDelay = `${index * 0.1}s`;
            element.parentElement.classList.add('fade-in');
        });
    });
</script>
@endpush