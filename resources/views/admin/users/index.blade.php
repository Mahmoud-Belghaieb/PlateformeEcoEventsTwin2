@extends('layouts.admin')

@section('title', 'Users Management')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0">
                        <i class="fas fa-users me-2"></i>
                        Users Management
                    </h1>
                    <p class="mb-0">Manage system users and their permissions</p>
                </div>
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary-green">
                    <i class="fas fa-plus me-1"></i>
                    Add New User
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="icon-circle bg-primary me-3" style="width: 50px; height: 50px;">
                        <i class="fas fa-users fa-lg text-white"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 text-primary">{{ $users->total() }}</h4>
                        <small class="text-muted">Total Users</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="icon-circle bg-success me-3" style="width: 50px; height: 50px;">
                        <i class="fas fa-user-check fa-lg text-white"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 text-success">{{ $users->where('status', 'active')->count() }}</h4>
                        <small class="text-muted">Active Users</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="icon-circle bg-warning me-3" style="width: 50px; height: 50px;">
                        <i class="fas fa-user-shield fa-lg text-white"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 text-warning">{{ $users->where('role', 'admin')->count() }}</h4>
                        <small class="text-muted">Administrators</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="icon-circle bg-info me-3" style="width: 50px; height: 50px;">
                        <i class="fas fa-user-plus fa-lg text-white"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 text-info">{{ $users->where('created_at', '>=', now()->subDays(30))->count() }}</h4>
                        <small class="text-muted">New This Month</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Search and Filters -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
                    <form method="GET" action="{{ route('admin.users.index') }}">
                <div class="row">
                    <div class="col-md-4">
                        <div class="search-box">
                            <i class="fas fa-search"></i>
                            <input type="text" name="search" class="form-control" 
                                   placeholder="Search users..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select name="role" class="form-select">
                            <option value="">All Roles</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="status" class="form-select">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary-green w-100">
                                <i class="fas fa-filter me-1"></i>
                                Filter
                            </button>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-redo"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-gradient-success text-white">
            <h5 class="mb-0">
                <i class="fas fa-users me-2"></i>
                Users List
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Joined</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="icon-circle bg-primary me-3" style="width: 40px; height: 40px;">
                                        <i class="fas fa-user text-white"></i>
                                    </div>
                                    <div class="user-info">
                                        <h6 class="mb-0">{{ $user->name }}</h6>
                                        <small class="text-muted">ID: {{ $user->id }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge {{ $user->role === 'admin' ? 'bg-warning' : 'bg-info' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $user->status === 'active' ? 'bg-success' : 'bg-danger' }}">
                                    {{ ucfirst($user->status) }}
                                </span>
                            </td>
                            <td>{{ $user->created_at->format('M d, Y') }}</td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('admin.users.show', $user) }}" 
                                       class="btn btn-outline-info" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.users.edit', $user) }}" 
                                       class="btn btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-warning" 
                                            onclick="toggleUserStatus({{ $user->id }})" title="Toggle Status">
                                        <i class="fas fa-power-off"></i>
                                    </button>
                                    @if($user->id !== auth()->id())
                                    <button type="button" class="btn btn-outline-danger" 
                                            onclick="deleteUser({{ $user->id }})" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="fas fa-users fa-3x mb-3"></i>
                                    <p>No users found.</p>
                                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary-green">
                                        <i class="fas fa-plus me-1"></i>
                                        Add First User
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
    @if(method_exists($users, 'links'))
        <div class="d-flex justify-content-center mt-4">
            {{ $users->links() }}
        </div>
    @endif
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this user? This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function deleteUser(userId) {
    const deleteForm = document.getElementById('deleteForm');
    deleteForm.action = `/admin/users/${userId}`;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}

function toggleUserStatus(userId) {
    fetch(`/admin/users/${userId}/toggle-status`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while updating user status.');
    });
}
</script>
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
    
    .stats-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
        border: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    }
    
    .stats-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    
    .icon-circle {
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }
    
    .search-box {
        position: relative;
    }
    
    .search-box .fa-search {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #6b7280;
        z-index: 10;
    }
    
    .search-box input {
        padding-left: 2.5rem;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
    }
    
    .search-box input:focus {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
    }
    
    .action-buttons .btn {
        margin: 0 2px;
        padding: 0.4rem 0.8rem;
        border-radius: 6px;
        transition: all 0.2s ease;
    }
    
    .action-buttons .btn:hover {
        transform: translateY(-1px);
    }
    
    .table th {
        border: none;
        font-weight: 600;
        color: var(--primary-green);
        background: rgba(5, 150, 105, 0.05);
        padding: 1rem 0.75rem;
    }
    
    .table td {
        border: none;
        padding: 1rem 0.75rem;
        vertical-align: middle;
    }
    
    .badge {
        font-size: 0.75rem;
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
</style>
@endpush