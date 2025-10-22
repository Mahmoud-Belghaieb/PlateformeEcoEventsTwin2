@extends('layouts.admin')

@section('title', 'Gestion des Commentaires')

@section('content')
<div class="page-header">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h3 mb-0 text-white">
                    <i class="fas fa-comments me-2"></i>Gestion des Commentaires
                </h1>
                <p class="text-white-50 mb-0">Modération et gestion des commentaires sur les avis</p>
            </div>
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#bulkApproveModal" id="bulkApproveBtn" style="display: none;">
                    <i class="fas fa-check me-1"></i>Approuver sélectionnés
                </button>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#bulkDeleteModal" id="bulkDeleteBtn" style="display: none;">
                    <i class="fas fa-trash me-1"></i>Supprimer sélectionnés
                </button>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card card-stats h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-circle bg-primary me-3" style="width: 50px; height: 50px;">
                            <i class="fas fa-comments fa-lg text-white"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 text-primary">{{ $stats['total'] }}</h4>
                            <small class="text-muted">Total Commentaires</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card card-stats h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-circle bg-warning me-3" style="width: 50px; height: 50px;">
                            <i class="fas fa-clock fa-lg text-white"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 text-warning">{{ $stats['pending'] }}</h4>
                            <small class="text-muted">En Attente</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card card-stats h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-circle bg-success me-3" style="width: 50px; height: 50px;">
                            <i class="fas fa-check fa-lg text-white"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 text-success">{{ $stats['approved'] }}</h4>
                            <small class="text-muted">Approuvés</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card card-stats h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-circle bg-info me-3" style="width: 50px; height: 50px;">
                            <i class="fas fa-reply fa-lg text-white"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 text-info">{{ $stats['replies'] }}</h4>
                            <small class="text-muted">Réponses</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="search-filter-bar">
        <form method="GET" action="{{ route('admin.commentaires.index') }}">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <input type="text" class="form-control" name="search" 
                               value="{{ request('search') }}"
                               placeholder="Rechercher par utilisateur ou contenu...">
                    </div>
                </div>
                <div class="col-md-2">
                    <select class="form-select" name="status">
                        <option value="">Tous les statuts</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>En attente</option>
                        <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approuvés</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select" name="type">
                        <option value="">Tous types</option>
                        <option value="root" {{ request('type') === 'root' ? 'selected' : '' }}>Commentaires</option>
                        <option value="reply" {{ request('type') === 'reply' ? 'selected' : '' }}>Réponses</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-1"></i>Rechercher
                    </button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('admin.commentaires.index') }}" class="btn btn-outline-secondary w-100">
                        <i class="fas fa-times me-1"></i>Effacer
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Commentaires Table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">
                <i class="fas fa-comments me-2"></i>Liste des Commentaires
            </h5>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="selectAll">
                <label class="form-check-label" for="selectAll">
                    Tout sélectionner
                </label>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="40">
                                <input type="checkbox" id="selectAllHeader" class="form-check-input">
                            </th>
                            <th>Utilisateur</th>
                            <th>Avis / Événement</th>
                            <th>Type</th>
                            <th>Contenu</th>
                            <th>Statut</th>
                            <th>Date</th>
                            <th width="120">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($commentaires as $commentaire)
                        <tr>
                            <td>
                                <input type="checkbox" class="form-check-input commentaire-checkbox" value="{{ $commentaire->id }}">
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-2">
                                        <div class="avatar-circle bg-primary">
                                            {{ strtoupper(substr($commentaire->user->name, 0, 1)) }}
                                        </div>
                                    </div>
                                    <div>
                                        <div class="fw-medium">{{ $commentaire->user->name }}</div>
                                        <small class="text-muted">{{ $commentaire->user->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="fw-medium">{{ Str::limit($commentaire->avis->event->title, 25) }}</div>
                                @if($commentaire->avis->title)
                                    <small class="text-muted">Avis: {{ Str::limit($commentaire->avis->title, 30) }}</small>
                                @else
                                    <small class="text-muted">Avis: {{ Str::limit($commentaire->avis->content, 30) }}</small>
                                @endif
                            </td>
                            <td>
                                @if($commentaire->parent_id)
                                    <span class="badge bg-info-soft">
                                        <i class="fas fa-reply me-1"></i>Réponse
                                    </span>
                                    @if($commentaire->parent && $commentaire->parent->user)
                                        <br><small class="text-muted">à {{ $commentaire->parent->user->name }}</small>
                                    @endif
                                @else
                                    <span class="badge bg-primary-soft">
                                        <i class="fas fa-comment me-1"></i>Commentaire
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="content-preview" title="{{ $commentaire->content }}">
                                    {{ Str::limit($commentaire->content, 60) }}
                                </div>
                            </td>
                            <td>
                                @if($commentaire->is_approved)
                                    <span class="badge bg-success-soft">
                                        <i class="fas fa-check me-1"></i>Approuvé
                                    </span>
                                    @if($commentaire->approvedBy)
                                        <br><small class="text-muted">par {{ $commentaire->approvedBy->name }}</small>
                                    @endif
                                @else
                                    <span class="badge bg-warning-soft">
                                        <i class="fas fa-clock me-1"></i>En attente
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div>{{ $commentaire->created_at->format('d/m/Y') }}</div>
                                <small class="text-muted">{{ $commentaire->created_at->format('H:i') }}</small>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('admin.commentaires.show', $commentaire->id) }}" 
                                       class="btn btn-outline-info" title="Voir">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    @if(!$commentaire->is_approved)
                                        <form action="{{ route('admin.commentaires.approve', $commentaire->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-success btn-sm" title="Approuver">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.commentaires.reject', $commentaire->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-warning btn-sm" 
                                                    onclick="return confirm('Rejeter ce commentaire ?')" title="Rejeter">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    @endif
                                    
                                    <form action="{{ route('admin.commentaires.destroy', $commentaire->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" 
                                                onclick="return confirm('Supprimer définitivement ce commentaire ?')" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="fas fa-comments fa-3x mb-3"></i>
                                    <p>Aucun commentaire trouvé.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($commentaires->hasPages())
        <div class="card-footer">
            {{ $commentaires->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Bulk Approve Modal -->
<div class="modal fade" id="bulkApproveModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Approuver les commentaires sélectionnés</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir approuver <span id="selectedCount">0</span> commentaires sélectionnés ?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <form id="bulkApproveForm" action="{{ route('admin.commentaires.bulk-approve') }}" method="POST">
                    @csrf
                    <input type="hidden" name="commentaire_ids" id="bulkApproveIds">
                    <button type="submit" class="btn btn-success">Approuver</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bulk Delete Modal -->
<div class="modal fade" id="bulkDeleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Supprimer les commentaires sélectionnés</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir supprimer définitivement <span id="selectedDeleteCount">0</span> commentaires sélectionnés ?</p>
                <p class="text-danger"><strong>Cette action est irréversible !</strong></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <form id="bulkDeleteForm" action="{{ route('admin.commentaires.bulk-delete') }}" method="POST">
                    @csrf
                    <input type="hidden" name="commentaire_ids" id="bulkDeleteIds">
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.avatar-circle {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: bold;
    font-size: 0.8rem;
}

.content-preview {
    max-width: 250px;
    cursor: help;
}

.bg-success-soft {
    background-color: rgba(25, 135, 84, 0.1) !important;
    color: #198754 !important;
}

.bg-warning-soft {
    background-color: rgba(255, 193, 7, 0.1) !important;
    color: #ffc107 !important;
}

.bg-info-soft {
    background-color: rgba(13, 202, 240, 0.1) !important;
    color: #0dcaf0 !important;
}

.bg-primary-soft {
    background-color: rgba(13, 110, 253, 0.1) !important;
    color: #0d6efd !important;
}

.table th {
    font-weight: 600;
    background-color: #f8f9fa;
}

.btn-group .btn {
    border-radius: 0.25rem !important;
    margin-right: 2px;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAllCheckbox = document.getElementById('selectAll');
    const selectAllHeaderCheckbox = document.getElementById('selectAllHeader');
    const commentaireCheckboxes = document.querySelectorAll('.commentaire-checkbox');
    const bulkApproveBtn = document.getElementById('bulkApproveBtn');
    const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
    
    // Handle select all functionality
    function handleSelectAll(checked) {
        commentaireCheckboxes.forEach(checkbox => {
            checkbox.checked = checked;
        });
        updateBulkButtons();
    }
    
    selectAllCheckbox.addEventListener('change', function() {
        handleSelectAll(this.checked);
        selectAllHeaderCheckbox.checked = this.checked;
    });
    
    selectAllHeaderCheckbox.addEventListener('change', function() {
        handleSelectAll(this.checked);
        selectAllCheckbox.checked = this.checked;
    });
    
    // Handle individual checkbox changes
    commentaireCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateBulkButtons();
            
            // Update select all checkboxes
            const allChecked = Array.from(commentaireCheckboxes).every(cb => cb.checked);
            const noneChecked = Array.from(commentaireCheckboxes).every(cb => !cb.checked);
            
            selectAllCheckbox.checked = allChecked;
            selectAllHeaderCheckbox.checked = allChecked;
            selectAllCheckbox.indeterminate = !allChecked && !noneChecked;
            selectAllHeaderCheckbox.indeterminate = !allChecked && !noneChecked;
        });
    });
    
    function updateBulkButtons() {
        const selectedCheckboxes = document.querySelectorAll('.commentaire-checkbox:checked');
        const selectedCount = selectedCheckboxes.length;
        
        if (selectedCount > 0) {
            bulkApproveBtn.style.display = 'block';
            bulkDeleteBtn.style.display = 'block';
            
            // Update modal content
            document.getElementById('selectedCount').textContent = selectedCount;
            document.getElementById('selectedDeleteCount').textContent = selectedCount;
            
            // Prepare form data
            const selectedIds = Array.from(selectedCheckboxes).map(cb => cb.value);
            document.getElementById('bulkApproveIds').value = JSON.stringify(selectedIds);
            document.getElementById('bulkDeleteIds').value = JSON.stringify(selectedIds);
        } else {
            bulkApproveBtn.style.display = 'none';
            bulkDeleteBtn.style.display = 'none';
        }
    }
});
</script>
@endpush