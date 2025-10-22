@extends('layouts.admin')

@section('title', 'Users Management')

@section('content')
<div class="container-fluid"
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background: var(--background);
        }

        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--secondary-green) 100%);
            box-shadow: 4px 0 15px rgba(5, 150, 105, 0.1);
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.9);
            border-radius: 12px;
            margin: 4px 0;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            transform: translateX(5px);
        }

        .card {
            border: none;
            box-shadow: var(--shadow);
            border-radius: 16px;
            border: 1px solid rgba(16, 185, 129, 0.1);
        }

        .stats-card {
            background: linear-gradient(135deg, var(--white) 0%, #f8fafc 100%);
        }

        .role-badge {
            font-size: 0.8rem;
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 600;
        }

        .role-admin { 
            background: linear-gradient(135deg, var(--accent-orange), #ea580c); 
            color: white; 
        }

        .role-participant { 
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green)); 
            color: white; 
        }

        .role-volunteer { 
            background: linear-gradient(135deg, #3b82f6, #1d4ed8); 
            color: white; 
        }

        .status-active { color: var(--secondary-green); font-weight: 600; }
        .status-inactive { color: #dc3545; font-weight: 600; }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            border: none;
            border-radius: 12px;
            font-weight: 600;
            padding: 10px 24px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(5, 150, 105, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(5, 150, 105, 0.4);
            background: linear-gradient(135deg, var(--secondary-green), var(--primary-green));
        }

        .btn-outline-primary {
            border: 2px solid var(--primary-green);
            color: var(--primary-green);
            border-radius: 12px;
            font-weight: 600;
            padding: 8px 20px;
            transition: all 0.3s ease;
        }

        .btn-outline-primary:hover {
            background: var(--primary-green);
            border-color: var(--primary-green);
            transform: translateY(-1px);
        }

        .btn-warning {
            background: linear-gradient(135deg, var(--accent-orange), #ea580c);
            border: none;
            border-radius: 12px;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
        }

        .btn-warning:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(249, 115, 22, 0.4);
        }

        .btn-danger {
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-danger:hover {
            transform: translateY(-1px);
        }

        .table {
            border-radius: 12px;
            overflow: hidden;
        }

        .table th {
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            color: white;
            font-weight: 600;
            border: none;
            padding: 15px;
        }

        .table td {
            padding: 15px;
            vertical-align: middle;
            border-bottom: 1px solid rgba(16, 185, 129, 0.1);
        }

        .table tbody tr:hover {
            background: rgba(16, 185, 129, 0.05);
            transition: all 0.2s ease;
        }

        .page-header {
            background: linear-gradient(135deg, var(--white) 0%, #f8fafc 100%);
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
            border: 1px solid rgba(16, 185, 129, 0.1);
        }

        .page-title {
            color: var(--dark-text);
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .page-subtitle {
            color: var(--light-text);
            margin: 0;
        }

        .search-box {
            border: 2px solid rgba(16, 185, 129, 0.2);
            border-radius: 12px;
            padding: 12px 16px;
            transition: all 0.3s ease;
        }

        .search-box:focus {
            border-color: var(--primary-green);
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        }

        .stats-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-green);
        }

        .stats-label {
            color: var(--light-text);
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar p-3">
                <div class="d-flex align-items-center mb-4">
                    <i class="fas fa-rocket text-white me-2" style="font-size: 1.5rem;"></i>
                    <h4 class="text-white mb-0">EcoEvents Admin</h4>
                </div>
                <ul class="nav nav-pills flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">
                            <i class="fas fa-home me-2"></i>Accueil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('admin.users.index') }}">
                            <i class="fas fa-users me-2"></i>Gestion des utilisateurs
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-calendar me-2"></i>Gestion des événements
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-chart-bar me-2"></i>Statistiques
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 p-4">
                <div class="page-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="page-title">
                                <i class="fas fa-users me-3" style="color: var(--primary-green);"></i>
                                Gestion des utilisateurs
                            </h2>
                            <p class="page-subtitle">Gérez tous les utilisateurs de votre plateforme EcoEvents</p>
                        </div>
                        <div>
                            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Nouvel utilisateur
                            </a>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3 mt-3">
                        <span class="text-muted">Connecté en tant que: {{ Auth::user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                <i class="fas fa-sign-out-alt me-1"></i>Déconnexion
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="row mb-4">
                    <div class="col-md-2">
                        <div class="card stats-card text-center p-3">
                            <div class="stats-number">{{ $stats['total'] }}</div>
                            <div class="stats-label">Total utilisateurs</div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card stats-card text-center p-3">
                            <div class="stats-number" style="color: var(--accent-orange);">{{ $stats['admins'] }}</div>
                            <div class="stats-label">Administrateurs</div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card stats-card text-center p-3">
                            <div class="stats-number">{{ $stats['participants'] }}</div>
                            <div class="stats-label">Participants</div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card stats-card text-center p-3">
                            <div class="stats-number" style="color: #3b82f6;">{{ $stats['volunteers'] }}</div>
                            <div class="stats-label">Bénévoles</div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card stats-card text-center p-3">
                            <div class="stats-number" style="color: var(--secondary-green);">{{ $stats['active'] }}</div>
                            <div class="stats-label">Actifs</div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card stats-card text-center p-3">
                            <div class="stats-number" style="color: #dc3545;">{{ $stats['total'] - $stats['active'] }}</div>
                            <div class="stats-label">Inactifs</div>
                        </div>
                    </div>
                </div>

                <!-- Success/Error Messages -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Search and Filters -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text bg-transparent border-end-0">
                                        <i class="fas fa-search" style="color: var(--primary-green);"></i>
                                    </span>
                                    <input type="text" class="form-control search-box border-start-0" placeholder="Rechercher par nom, email...">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex gap-2">
                                    <select class="form-select search-box" id="roleFilter">
                                        <option value="">Tous les rôles</option>
                                        <option value="admin">Administrateurs</option>
                                        <option value="participant">Participants</option>
                                        <option value="volunteer">Bénévoles</option>
                                    </select>
                                    <select class="form-select search-box" id="statusFilter">
                                        <option value="">Tous les statuts</option>
                                        <option value="active">Actifs</option>
                                        <option value="inactive">Inactifs</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Users Table -->
                <div class="card">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Utilisateur</th>
                                    <th>Email</th>
                                    <th>Rôle</th>
                                    <th>Statut</th>
                                    <th>Inscription</th>
                                    <th>Dernière connexion</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 40px; height: 40px;">
                                                    {{ substr($user->name, 0, 1) }}
                                                </div>
                                                <div>
                                                    <strong>{{ $user->name }}</strong>
                                                    @if($user->id === auth()->id())
                                                        <span class="badge bg-warning text-dark ms-1">Vous</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            <span class="role-badge role-{{ $user->role }}">
                                                {{ $user->getRoleDisplayName() }}
                                            </span>
                                        </td>
                                        <td>
                                            <i class="fas fa-circle {{ $user->is_active ? 'status-active' : 'status-inactive' }}"></i>
                                            {{ $user->is_active ? 'Actif' : 'Inactif' }}
                                        </td>
                                        <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            {{ $user->last_login_at ? $user->last_login_at->format('d/m/Y H:i') : 'Jamais' }}
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-outline-primary" title="Modifier">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @if($user->id !== auth()->id())
                                                    <button type="button" class="btn btn-outline-{{ $user->is_active ? 'warning' : 'success' }}" 
                                                            onclick="toggleUserStatus({{ $user->id }})" 
                                                            title="{{ $user->is_active ? 'Désactiver' : 'Activer' }}">
                                                        <i class="fas fa-{{ $user->is_active ? 'ban' : 'check' }}"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-outline-danger" 
                                                            onclick="deleteUser({{ $user->id }})" 
                                                            title="Supprimer">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-muted">
                                            Aucun utilisateur trouvé
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination -->
                @if($users->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmer la suppression</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Êtes-vous sûr de vouloir supprimer cet utilisateur ? Cette action est irréversible.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <form id="deleteForm" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
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
        });
    }
</script>
@endpush