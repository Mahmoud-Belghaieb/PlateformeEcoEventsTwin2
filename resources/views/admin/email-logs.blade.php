@extends('layouts.admin')

@section('title', 'Logs des Emails de Réinitialisation')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="mb-1">
                                <i class="fas fa-envelope-open-text text-primary me-2"></i>
                                Logs des Emails
                            </h2>
                            <p class="text-muted mb-0">
                                Emails de réinitialisation de mot de passe envoyés
                            </p>
                        </div>
                        <div>
                            <button class="btn btn-primary" onclick="location.reload()">
                                <i class="fas fa-sync-alt me-2"></i>
                                Actualiser
                            </button>
                            @if($logExists)
                                <form method="POST" action="{{ route('admin.email-logs.clear') }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir vider tous les logs ?')">
                                        <i class="fas fa-trash me-2"></i>
                                        Vider les Logs
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alerts -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Stats -->
    @if($logExists)
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-primary bg-opacity-10 p-3 rounded">
                                    <i class="fas fa-envelope fa-2x text-primary"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="text-muted mb-1">Emails Trouvés</h6>
                                <h3 class="mb-0">{{ count($emails) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-success bg-opacity-10 p-3 rounded">
                                    <i class="fas fa-file-alt fa-2x text-success"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="text-muted mb-1">Taille du Log</h6>
                                <h3 class="mb-0">{{ $logSize }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-info bg-opacity-10 p-3 rounded">
                                    <i class="fas fa-cog fa-2x text-info"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="text-muted mb-1">Mode Email</h6>
                                <h3 class="mb-0">LOG</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Emails List -->
    <div class="row">
        <div class="col-12">
            @if(!$logExists)
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                        <h4>Fichier log introuvable</h4>
                        <p class="text-muted">Le fichier de log n'existe pas encore.</p>
                    </div>
                </div>
            @elseif(empty($emails))
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <h4>Aucun email trouvé</h4>
                        <p class="text-muted mb-4">
                            Aucun email de réinitialisation n'a été envoyé pour le moment.
                        </p>
                        <a href="{{ route('password.request') }}" class="btn btn-primary" target="_blank">
                            <i class="fas fa-key me-2"></i>
                            Tester "Mot de passe oublié"
                        </a>
                    </div>
                </div>
            @else
                @foreach($emails as $index => $email)
                    <div class="card border-0 shadow-sm mb-3">
                        <div class="card-header bg-white border-bottom">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="mb-1">
                                        <i class="fas fa-envelope text-primary me-2"></i>
                                        Réinitialisation de mot de passe
                                    </h5>
                                    <small class="text-muted">
                                        <i class="fas fa-clock me-1"></i>
                                        {{ $email['timestamp'] }}
                                    </small>
                                </div>
                                <span class="badge bg-primary">
                                    Email #{{ count($emails) - $index }}
                                </span>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Email destinataire -->
                            <div class="mb-3">
                                <label class="form-label text-muted mb-1">
                                    <i class="fas fa-user me-1"></i>
                                    Destinataire:
                                </label>
                                <div class="input-group">
                                    <input type="text" 
                                           class="form-control" 
                                           value="{{ $email['email'] }}" 
                                           readonly>
                                    <button class="btn btn-outline-secondary" 
                                            type="button" 
                                            onclick="copyText('{{ $email['email'] }}')">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Token -->
                            <div class="mb-3">
                                <label class="form-label text-muted mb-1">
                                    <i class="fas fa-key me-1"></i>
                                    Token:
                                </label>
                                <div class="input-group">
                                    <input type="text" 
                                           class="form-control font-monospace" 
                                           value="{{ $email['short_token'] }}" 
                                           readonly>
                                    <button class="btn btn-outline-secondary" 
                                            type="button" 
                                            onclick="copyText('{{ $email['token'] }}')">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- URL de réinitialisation -->
                            <div class="alert alert-success mb-0">
                                <label class="form-label mb-2">
                                    <i class="fas fa-link me-1"></i>
                                    <strong>Lien de réinitialisation:</strong>
                                </label>
                                <div class="input-group">
                                    <input type="text" 
                                           class="form-control" 
                                           value="{{ $email['url'] }}" 
                                           id="url-{{ $index }}"
                                           readonly>
                                    <button class="btn btn-outline-secondary" 
                                            type="button" 
                                            onclick="copyText('{{ $email['url'] }}')">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                    <a href="{{ $email['url'] }}" 
                                       class="btn btn-success" 
                                       target="_blank">
                                        <i class="fas fa-external-link-alt me-2"></i>
                                        Ouvrir
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <!-- Instructions -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm bg-light">
                <div class="card-body">
                    <h5 class="mb-3">
                        <i class="fas fa-info-circle text-info me-2"></i>
                        Comment ça fonctionne?
                    </h5>
                    <ol class="mb-0">
                        <li class="mb-2">
                            Les emails sont actuellement en <strong>mode LOG</strong> (développement)
                        </li>
                        <li class="mb-2">
                            Les emails ne sont pas envoyés réellement mais enregistrés dans 
                            <code>storage/logs/laravel.log</code>
                        </li>
                        <li class="mb-2">
                            Pour tester: Allez sur la page 
                            <a href="{{ route('password.request') }}" target="_blank">Mot de passe oublié</a>
                        </li>
                        <li class="mb-0">
                            Cette page se rafraîchit automatiquement toutes les 15 secondes
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function copyText(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Notification de succès
        const toast = document.createElement('div');
        toast.className = 'position-fixed top-0 end-0 p-3';
        toast.style.zIndex = '9999';
        toast.innerHTML = `
            <div class="toast show" role="alert">
                <div class="toast-header bg-success text-white">
                    <i class="fas fa-check-circle me-2"></i>
                    <strong class="me-auto">Copié!</strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                </div>
                <div class="toast-body">
                    Texte copié dans le presse-papiers
                </div>
            </div>
        `;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 3000);
    });
}

// Auto-refresh toutes les 15 secondes
setTimeout(() => {
    location.reload();
}, 15000);

console.log('📧 Page Email Logs chargée - Auto-refresh dans 15 secondes');
</script>
@endpush
@endsection
