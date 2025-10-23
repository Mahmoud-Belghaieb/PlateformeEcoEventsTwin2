@extends('layouts.admin')

@section('title', 'IA Gemini Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-lg" style="background: linear-gradient(135deg, #059669, #10b981);">
                <div class="card-body py-4 text-white">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h1 class="h2 mb-3 fw-bold">
                                <i class="fas fa-robot me-3" style="color: #f97316;"></i>
                                Tableau de Bord IA Gemini
                            </h1>
                            <p class="mb-0 opacity-85 fs-5">
                                Administration et contrôle des fonctionnalités d'intelligence artificielle
                            </p>
                            <div class="mt-3">
                                <span class="badge bg-light text-dark me-2">
                                    <i class="fas fa-brain me-1"></i>
                                    Google Gemini 2.0 Flash
                                </span>
                                <span id="statusBadge" class="badge bg-warning text-dark">
                                    <i class="fas fa-clock me-1"></i>
                                    Vérification en cours...
                                </span>
                            </div>
                        </div>
                        <div class="col-md-4 text-end">
                            <div class="text-white-50">
                                <i class="fas fa-brain fa-4x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Configuration Status -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="icon-circle bg-primary mx-auto mb-3" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; border-radius: 50%;">
                        <i class="fas fa-cog fa-lg text-white"></i>
                    </div>
                    <h5 class="card-title">Configuration API</h5>
                    <p class="text-muted">Statut de la connexion Gemini</p>
                    <div id="configStatus">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Chargement...</span>
                        </div>
                    </div>
                    <button class="btn btn-outline-primary btn-sm mt-2" onclick="testApiConnection()">
                        <i class="fas fa-sync-alt me-1"></i>Test Connexion
                    </button>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="icon-circle bg-success mx-auto mb-3" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; border-radius: 50%;">
                        <i class="fas fa-chart-bar fa-lg text-white"></i>
                    </div>
                    <h5 class="card-title">Utilisation Quotidienne</h5>
                    <p class="text-muted">Requêtes IA aujourd'hui</p>
                    <h3 class="text-success" id="dailyUsage">-</h3>
                    <small class="text-muted">/ 1500 requêtes</small>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="icon-circle bg-info mx-auto mb-3" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; border-radius: 50%;">
                        <i class="fas fa-users fa-lg text-white"></i>
                    </div>
                    <h5 class="card-title">Accès Interface</h5>
                    <p class="text-muted">Interface utilisateur IA</p>
                    <a href="{{ route('ai.interface') }}" class="btn btn-info btn-sm" target="_blank">
                        <i class="fas fa-external-link-alt me-1"></i>Ouvrir Interface
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Fonctionnalités IA -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light border-0">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-cogs me-2"></i>Fonctionnalités IA Disponibles
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <!-- Génération de Descriptions -->
                        <div class="col-md-6">
                            <div class="feature-card p-3 border rounded">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="icon-circle bg-success me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 50%;">
                                        <i class="fas fa-file-alt text-white"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Génération de Descriptions</h6>
                                        <small class="text-muted">Auto-génération descriptions événements</small>
                                    </div>
                                </div>
                                <form id="descriptionForm">
                                    <div class="row g-2">
                                        <div class="col-md-6">
                                            <input type="text" class="form-control form-control-sm" name="title" placeholder="Titre événement" value="Plantation d'Arbres Tunis">
                                        </div>
                                        <div class="col-md-6">
                                            <select class="form-control form-control-sm" name="type">
                                                <option value="Plantation d'arbres">Plantation</option>
                                                <option value="Nettoyage environnemental">Nettoyage</option>
                                                <option value="Sensibilisation écologique">Sensibilisation</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row g-2 mt-2">
                                        <div class="col-md-6">
                                            <input type="text" class="form-control form-control-sm" name="location" placeholder="Lieu" value="Parc Belvédère, Tunis">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="date" class="form-control form-control-sm" name="date" value="{{ date('Y-m-d', strtotime('+7 days')) }}">
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <input type="text" class="form-control form-control-sm" name="objective" placeholder="Objectif" value="Créer un espace vert communautaire">
                                    </div>
                                    <button type="submit" class="btn btn-success btn-sm mt-2">
                                        <i class="fas fa-magic me-1"></i>Générer
                                    </button>
                                </form>
                                <div id="descriptionResult" class="mt-3" style="display: none;"></div>
                            </div>
                        </div>

                        <!-- Analyse de Sentiment -->
                        <div class="col-md-6">
                            <div class="feature-card p-3 border rounded">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="icon-circle bg-warning me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 50%;">
                                        <i class="fas fa-heart text-white"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Analyse de Sentiment</h6>
                                        <small class="text-muted">Classification automatique commentaires</small>
                                    </div>
                                </div>
                                <form id="sentimentForm">
                                    <textarea class="form-control form-control-sm" name="text" rows="3" placeholder="Texte à analyser...">Excellent événement ! Très bien organisé, j'ai adoré participer à cette initiative écologique. Bravo à toute l'équipe !</textarea>
                                    <button type="submit" class="btn btn-warning btn-sm mt-2">
                                        <i class="fas fa-chart-line me-1"></i>Analyser
                                    </button>
                                </form>
                                <div id="sentimentResult" class="mt-3" style="display: none;"></div>
                            </div>
                        </div>

                        <!-- Conseils Écologiques -->
                        <div class="col-md-6">
                            <div class="feature-card p-3 border rounded">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="icon-circle bg-info me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 50%;">
                                        <i class="fas fa-lightbulb text-white"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Conseils Écologiques</h6>
                                        <small class="text-muted">Conseils personnalisés Tunisie</small>
                                    </div>
                                </div>
                                <form id="tipsForm">
                                    <div class="row g-2">
                                        <div class="col-md-6">
                                            <select class="form-control form-control-sm" name="situation">
                                                <option value="À la maison">À la maison</option>
                                                <option value="Au travail">Au travail</option>
                                                <option value="En voyage">En voyage</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control form-control-sm" name="location" value="Tunis, Tunisie">
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-info btn-sm mt-2">
                                        <i class="fas fa-leaf me-1"></i>Obtenir Conseils
                                    </button>
                                </form>
                                <div id="tipsResult" class="mt-3" style="display: none;"></div>
                            </div>
                        </div>

                        <!-- Test Simple -->
                        <div class="col-md-6">
                            <div class="feature-card p-3 border rounded">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="icon-circle bg-primary me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 50%;">
                                        <i class="fas fa-play text-white"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Test Rapide</h6>
                                        <small class="text-muted">Vérification IA fonctionnelle</small>
                                    </div>
                                </div>
                                <form id="quickTestForm">
                                    <input type="text" class="form-control form-control-sm" name="prompt" placeholder="Message test..." value="Présente-toi en tant qu'IA EcoEvents Tunisia">
                                    <button type="submit" class="btn btn-primary btn-sm mt-2">
                                        <i class="fas fa-paper-plane me-1"></i>Test IA
                                    </button>
                                </form>
                                <div id="quickTestResult" class="mt-3" style="display: none;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Configuration Info -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light border-0">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>Information Configuration
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h6>Configuration Actuelle</h6>
                            <ul class="list-unstyled">
                                <li><strong>Modèle :</strong> <code>{{ config('gemini.model', 'Non configuré') }}</code></li>
                                <li><strong>Clé API :</strong> <code>{{ config('gemini.api_key') ? substr(config('gemini.api_key'), 0, 10) . '...' : 'Non configurée' }}</code></li>
                                <li><strong>Limite quotidienne :</strong> 1500 requêtes/jour (Gratuit)</li>
                                <li><strong>Limite par minute :</strong> 15 requêtes/minute</li>
                            </ul>
                        </div>
                        <div class="col-md-4">
                            <h6>Actions Rapides</h6>
                            <div class="d-grid gap-2">
                                <a href="{{ route('ai.interface') }}" class="btn btn-outline-primary btn-sm" target="_blank">
                                    <i class="fas fa-external-link-alt me-1"></i>Interface Utilisateur
                                </a>
                                <button class="btn btn-outline-info btn-sm" onclick="clearCache()">
                                    <i class="fas fa-trash me-1"></i>Nettoyer Cache
                                </button>
                                <a href="https://makersuite.google.com/app/apikey" target="_blank" class="btn btn-outline-success btn-sm">
                                    <i class="fas fa-key me-1"></i>Gérer Clé API
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // CSRF Token
    const token = $('meta[name="csrf-token"]').attr('content');
    
    // Test automatique de connexion au chargement
    setTimeout(testApiConnection, 1000);
    
    // Test de connexion API
    window.testApiConnection = async function() {
        $('#configStatus').html('<div class="spinner-border spinner-border-sm text-primary"></div> Test...');
        
        try {
            const response = await fetch('/ai/test-simple', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                },
                body: JSON.stringify({ prompt: 'Test admin connexion' })
            });
            
            if (response.ok) {
                $('#configStatus').html('<div class="alert alert-success alert-sm mb-0"><i class="fas fa-check me-1"></i>Connecté</div>');
                $('#statusBadge').removeClass('bg-warning').addClass('bg-success').html('<i class="fas fa-check me-1"></i>Opérationnel');
            } else {
                throw new Error('Connexion échouée');
            }
        } catch (error) {
            $('#configStatus').html('<div class="alert alert-danger alert-sm mb-0"><i class="fas fa-times me-1"></i>Erreur API</div>');
            $('#statusBadge').removeClass('bg-warning').addClass('bg-danger').html('<i class="fas fa-exclamation me-1"></i>Erreur');
        }
    };
    
    // Génération description
    $('#descriptionForm').on('submit', async function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const data = Object.fromEntries(formData);
        
        $('#descriptionResult').show().html('<div class="spinner-border spinner-border-sm"></div> Génération...');
        
        try {
            const response = await fetch('/ai/generate-event-description', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                },
                body: JSON.stringify(data)
            });
            
            const result = await response.json();
            if (result.success) {
                $('#descriptionResult').html(`<div class="alert alert-success alert-sm"><strong>Description générée :</strong><br>${result.description}</div>`);
            } else {
                $('#descriptionResult').html('<div class="alert alert-danger alert-sm">Erreur de génération</div>');
            }
        } catch (error) {
            $('#descriptionResult').html('<div class="alert alert-danger alert-sm">Erreur réseau</div>');
        }
    });
    
    // Analyse sentiment
    $('#sentimentForm').on('submit', async function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const data = Object.fromEntries(formData);
        
        $('#sentimentResult').show().html('<div class="spinner-border spinner-border-sm"></div> Analyse...');
        
        try {
            const response = await fetch('/ai/analyze-sentiment', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                },
                body: JSON.stringify(data)
            });
            
            const result = await response.json();
            if (result.success) {
                const badgeClass = result.sentiment === 'POSITIF' ? 'success' : result.sentiment === 'NEGATIF' ? 'danger' : 'secondary';
                $('#sentimentResult').html(`<div class="alert alert-${badgeClass} alert-sm"><strong>Sentiment :</strong> <span class="badge bg-${badgeClass}">${result.sentiment}</span></div>`);
            } else {
                $('#sentimentResult').html('<div class="alert alert-danger alert-sm">Erreur d\'analyse</div>');
            }
        } catch (error) {
            $('#sentimentResult').html('<div class="alert alert-danger alert-sm">Erreur réseau</div>');
        }
    });
    
    // Conseils écologiques
    $('#tipsForm').on('submit', async function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const params = new URLSearchParams(formData);
        
        $('#tipsResult').show().html('<div class="spinner-border spinner-border-sm"></div> Génération...');
        
        try {
            const response = await fetch(`/ai/generate-eco-tips?${params}`, {
                headers: { 'X-CSRF-TOKEN': token }
            });
            
            const result = await response.json();
            if (result.success) {
                $('#tipsResult').html(`<div class="alert alert-info alert-sm"><strong>Conseils :</strong><br><div style="white-space: pre-line;">${result.tips}</div></div>`);
            } else {
                $('#tipsResult').html('<div class="alert alert-danger alert-sm">Erreur génération conseils</div>');
            }
        } catch (error) {
            $('#tipsResult').html('<div class="alert alert-danger alert-sm">Erreur réseau</div>');
        }
    });
    
    // Test rapide
    $('#quickTestForm').on('submit', async function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const data = Object.fromEntries(formData);
        
        $('#quickTestResult').show().html('<div class="spinner-border spinner-border-sm"></div> Test...');
        
        try {
            const response = await fetch('/ai/test-simple', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                },
                body: JSON.stringify(data)
            });
            
            const result = await response.json();
            if (result.success) {
                $('#quickTestResult').html(`<div class="alert alert-success alert-sm"><strong>Réponse IA :</strong><br>${result.response}</div>`);
            } else {
                $('#quickTestResult').html('<div class="alert alert-danger alert-sm">Test échoué</div>');
            }
        } catch (error) {
            $('#quickTestResult').html('<div class="alert alert-danger alert-sm">Erreur test</div>');
        }
    });
    
    // Nettoyer cache
    window.clearCache = async function() {
        try {
            const response = await fetch('/admin/clear-cache', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': token }
            });
            
            if (response.ok) {
                alert('Cache nettoyé avec succès !');
                location.reload();
            } else {
                alert('Erreur lors du nettoyage du cache');
            }
        } catch (error) {
            alert('Erreur réseau');
        }
    };
});
</script>
@endsection