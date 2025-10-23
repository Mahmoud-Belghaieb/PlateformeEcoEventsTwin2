<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test IA Gemini - EcoEvents</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root {
            --primary-green: #059669;
            --secondary-green: #10b981;
            --accent-orange: #f97316;
        }
        
        body {
            background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%);
            min-height: 100vh;
        }
        
        .ai-header {
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
        }
        
        .feature-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
        }
        
        .btn-ai {
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            border: none;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-ai:hover {
            background: linear-gradient(135deg, var(--secondary-green), var(--primary-green));
            color: white;
            transform: translateY(-2px);
        }
        
        .result-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 1rem;
            margin-top: 1rem;
            min-height: 100px;
        }
        
        .loading {
            display: none;
        }
        
        .loading.show {
            display: block;
        }
        
        .ai-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--accent-orange), #fb923c);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            color: white;
            font-size: 1.5rem;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-leaf text-success me-2"></i>
                <strong style="color: var(--primary-green)">EcoEvents</strong>
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="{{ route('home') }}">
                    <i class="fas fa-home me-1"></i> Accueil
                </a>
                <a class="nav-link" href="{{ route('events.index') }}">
                    <i class="fas fa-calendar me-1"></i> Événements
                </a>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <div class="ai-header">
        <div class="container text-center">
            <div class="ai-icon">
                <i class="fas fa-robot"></i>
            </div>
            <h1><i class="fas fa-brain me-2"></i>Interface Test IA Gemini</h1>
            <p class="lead">Testez toutes les fonctionnalités d'intelligence artificielle de votre plateforme EcoEvents</p>
        </div>
    </div>

    <div class="container pb-5">
        <!-- Configuration Status -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="feature-card">
                    <h5><i class="fas fa-cogs text-info me-2"></i>Configuration IA</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Modèle :</strong> Google Gemini 1.5 Flash</p>
                            <p><strong>Status :</strong> 
                                <span id="apiStatus" class="badge bg-warning">En attente de test</span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-outline-primary btn-sm" onclick="testConnection()">
                                <i class="fas fa-plug me-1"></i>Tester Connexion
                            </button>
                            <div id="connectionResult" class="mt-2"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Test Simple -->
            <div class="col-md-6">
                <div class="feature-card">
                    <h4><i class="fas fa-magic text-primary me-2"></i>Test Simple</h4>
                    <p class="text-muted">Test basique pour vérifier si l'IA répond.</p>
                    
                    <form id="simpleForm">
                        <div class="mb-3">
                            <label class="form-label">Question à l'IA</label>
                            <input type="text" class="form-control" name="prompt" 
                                   placeholder="Ex: Dis bonjour en français" 
                                   value="Dis simplement 'Bonjour, je suis Gemini AI pour EcoEvents'">
                        </div>
                        <button type="submit" class="btn btn-ai">
                            <i class="fas fa-paper-plane me-2"></i>Envoyer
                        </button>
                    </form>
                    
                    <div class="loading" id="simpleLoading">
                        <div class="text-center">
                            <div class="spinner-border text-success" role="status"></div>
                            <p class="mt-2">IA en réflexion...</p>
                        </div>
                    </div>
                    <div class="result-box" id="simpleResult">Cliquez sur "Envoyer" pour tester l'IA</div>
                </div>
            </div>

            <!-- Génération de Description -->
            <div class="col-md-6">
                <div class="feature-card">
                    <h4><i class="fas fa-file-alt text-success me-2"></i>Description d'Événement</h4>
                    <p class="text-muted">Génération automatique de descriptions.</p>
                    
                    <form id="descriptionForm">
                        <div class="mb-3">
                            <label class="form-label">Titre de l'événement</label>
                            <input type="text" class="form-control" name="title" 
                                   value="Nettoyage de la Plage de Carthage">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Type</label>
                                <select class="form-control" name="type">
                                    <option value="Nettoyage environnemental">Nettoyage</option>
                                    <option value="Plantation d'arbres">Plantation</option>
                                    <option value="Sensibilisation écologique">Sensibilisation</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Lieu</label>
                                <input type="text" class="form-control" name="location" value="Carthage, Tunisie">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label class="form-label">Date</label>
                                <input type="date" class="form-control" name="date" value="2025-12-01">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Objectif</label>
                                <input type="text" class="form-control" name="objective" 
                                       value="Nettoyer et sensibiliser à la pollution marine">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-ai mt-3">
                            <i class="fas fa-wand-magic-sparkles me-2"></i>Générer
                        </button>
                    </form>
                    
                    <div class="loading" id="descriptionLoading">
                        <div class="text-center">
                            <div class="spinner-border text-success" role="status"></div>
                            <p class="mt-2">Génération en cours...</p>
                        </div>
                    </div>
                    <div class="result-box" id="descriptionResult">Les descriptions apparaîtront ici...</div>
                </div>
            </div>

            <!-- Analyse de Sentiment -->
            <div class="col-md-6">
                <div class="feature-card">
                    <h4><i class="fas fa-heart text-danger me-2"></i>Analyse de Sentiment</h4>
                    <p class="text-muted">Détection automatique du sentiment.</p>
                    
                    <form id="sentimentForm">
                        <div class="mb-3">
                            <label class="form-label">Texte à analyser</label>
                            <textarea class="form-control" name="text" rows="3" 
                                      placeholder="Ex: Excellent événement ! J'ai adoré participer.">Excellent événement ! J'ai adoré participer au nettoyage de la plage. Très bien organisé et impact positif garanti !</textarea>
                        </div>
                        <button type="submit" class="btn btn-ai">
                            <i class="fas fa-chart-line me-2"></i>Analyser
                        </button>
                    </form>
                    
                    <div class="loading" id="sentimentLoading">
                        <div class="text-center">
                            <div class="spinner-border text-success" role="status"></div>
                            <p class="mt-2">Analyse en cours...</p>
                        </div>
                    </div>
                    <div class="result-box" id="sentimentResult">Les résultats d'analyse apparaîtront ici...</div>
                </div>
            </div>

            <!-- Conseils Écologiques -->
            <div class="col-md-6">
                <div class="feature-card">
                    <h4><i class="fas fa-lightbulb text-warning me-2"></i>Conseils Écologiques</h4>
                    <p class="text-muted">Conseils personnalisés pour l'environnement.</p>
                    
                    <form id="tipsForm">
                        <div class="mb-3">
                            <label class="form-label">Situation</label>
                            <select class="form-control" name="situation">
                                <option value="À la maison">À la maison</option>
                                <option value="Au travail">Au travail</option>
                                <option value="En voyage">En voyage</option>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Lieu</label>
                                <input type="text" class="form-control" name="location" value="Tunis, Tunisie">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Saison</label>
                                <select class="form-control" name="season">
                                    <option value="Automne" selected>Automne</option>
                                    <option value="Hiver">Hiver</option>
                                    <option value="Printemps">Printemps</option>
                                    <option value="Été">Été</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-ai mt-3">
                            <i class="fas fa-leaf me-2"></i>Obtenir Conseils
                        </button>
                    </form>
                    
                    <div class="loading" id="tipsLoading">
                        <div class="text-center">
                            <div class="spinner-border text-success" role="status"></div>
                            <p class="mt-2">Génération conseils...</p>
                        </div>
                    </div>
                    <div class="result-box" id="tipsResult">Les conseils apparaîtront ici...</div>
                </div>
            </div>
        </div>
                                        <i class="fas fa-sparkles"></i> Générer la description
                                    </button>
                                </form>
                            </div>
                            <div class="col-md-6">
                                <div class="card bg-light">
                                    <div class="card-header">
                                        <h6><i class="fas fa-file-alt"></i> Description générée</h6>
                                    </div>
                                    <div class="card-body">
                                        <div id="generated-description" class="text-muted">
                                            La description apparaîtra ici après génération...
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Suggestions d'événements personnalisées -->
                    <div class="mb-5">
                        <h4><i class="fas fa-lightbulb text-warning"></i> Suggestions d'événements personnalisées</h4>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Vos intérêts</label>
                                    <input type="text" id="user-interests" class="form-control" placeholder="Ex: Protection marine, reforestation" value="Environnement général">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Localisation</label>
                                    <input type="text" id="user-location" class="form-control" placeholder="Ex: Tunis, Sfax" value="Tunisie">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Niveau d'expérience</label>
                                    <select id="user-experience" class="form-control">
                                        <option value="Débutant">Débutant</option>
                                        <option value="Intermédiaire">Intermédiaire</option>
                                        <option value="Avancé">Avancé</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Disponibilité</label>
                                    <select id="user-availability" class="form-control">
                                        <option value="Week-ends">Week-ends</option>
                                        <option value="Soirées">Soirées</option>
                                        <option value="Flexible">Flexible</option>
                                    </select>
                                </div>
                                <button class="btn btn-warning" id="get-suggestions-btn">
                                    <i class="fas fa-search"></i> Obtenir des suggestions
                                </button>
                            </div>
                            <div class="col-md-8">
                                <div class="card bg-light">
                                    <div class="card-header">
                                        <h6><i class="fas fa-list"></i> Événements suggérés</h6>
                                    </div>
                                    <div class="card-body">
                                        <div id="event-suggestions" class="text-muted">
                                            Les suggestions apparaîtront ici...
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Analyse de sentiment et modération -->
                    <div class="mb-5">
                        <h4><i class="fas fa-shield-alt text-info"></i> Analyse de sentiment et modération</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Texte à analyser</label>
                                    <textarea id="text-to-analyze" class="form-control" rows="4" placeholder="Entrez un commentaire ou avis à analyser..."></textarea>
                                </div>
                                <div class="btn-group w-100" role="group">
                                    <button class="btn btn-info" id="analyze-sentiment-btn">
                                        <i class="fas fa-heart"></i> Analyser sentiment
                                    </button>
                                    <button class="btn btn-secondary" id="moderate-content-btn">
                                        <i class="fas fa-shield"></i> Modérer contenu
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card bg-light">
                                    <div class="card-header">
                                        <h6><i class="fas fa-chart-line"></i> Résultats d'analyse</h6>
                                    </div>
                                    <div class="card-body">
                                        <div id="analysis-results" class="text-muted">
                                            Les résultats apparaîtront ici...
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Conseils écologiques -->
                    <div class="mb-5">
                        <h4><i class="fas fa-leaf text-success"></i> Conseils écologiques personnalisés</h4>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Situation</label>
                                    <input type="text" id="eco-situation" class="form-control" placeholder="Ex: À la maison, au travail" value="Vie quotidienne">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Localisation</label>
                                    <input type="text" id="eco-location" class="form-control" value="Tunisie">
                                </div>
                                <button class="btn btn-success" id="get-eco-tips-btn">
                                    <i class="fas fa-seedling"></i> Obtenir des conseils
                                </button>
                            </div>
                            <div class="col-md-8">
                                <div class="card bg-light">
                                    <div class="card-header">
                                        <h6><i class="fas fa-tips"></i> Conseils écologiques</h6>
                                    </div>
                                    <div class="card-body">
                                        <div id="eco-tips" class="text-muted">
                                            Les conseils apparaîtront ici...
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Loading Modal -->
<div class="modal fade" id="loadingModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body text-center">
                <div class="spinner-border text-success" role="status">
                    <span class="visually-hidden">Chargement...</span>
                </div>
                <p class="mt-3">IA en cours de traitement...</p>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
$(document).ready(function() {
    // Génération de description d'événement
    $('#event-description-form').submit(function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        showLoading();
        
        $.ajax({
            url: '{{ route("ai.generate.description") }}',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    $('#generated-description').html('<div class="alert alert-success">' + response.description + '</div>');
                } else {
                    showError('Erreur lors de la génération de la description');
                }
                hideLoading();
            },
            error: function() {
                showError('Erreur de connexion');
                hideLoading();
            }
        });
    });

    // Suggestions d'événements
    $('#get-suggestions-btn').click(function() {
        const data = {
            interests: $('#user-interests').val(),
            location: $('#user-location').val(),
            experience_level: $('#user-experience').val(),
            availability: $('#user-availability').val()
        };
        
        showLoading();
        
        $.ajax({
            url: '{{ route("ai.suggest.events") }}',
            method: 'GET',
            data: data,
            success: function(response) {
                if (response.success) {
                    $('#event-suggestions').html('<div class="alert alert-info"><pre>' + response.suggestions + '</pre></div>');
                } else {
                    showError('Erreur lors de la génération des suggestions');
                }
                hideLoading();
            },
            error: function() {
                showError('Erreur de connexion');
                hideLoading();
            }
        });
    });

    // Analyse de sentiment
    $('#analyze-sentiment-btn').click(function() {
        const text = $('#text-to-analyze').val();
        if (!text.trim()) {
            alert('Veuillez entrer du texte à analyser');
            return;
        }
        
        showLoading();
        
        $.ajax({
            url: '{{ route("ai.analyze.sentiment") }}',
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                text: text
            },
            success: function(response) {
                if (response.success) {
                    const sentimentClass = getSentimentClass(response.sentiment);
                    $('#analysis-results').html(
                        '<div class="alert alert-' + sentimentClass + '">' +
                        '<strong>Sentiment:</strong> ' + response.sentiment + '<br>' +
                        '<strong>Confiance:</strong> ' + (response.confidence * 100).toFixed(1) + '%' +
                        '</div>'
                    );
                }
                hideLoading();
            },
            error: function() {
                showError('Erreur lors de l\'analyse');
                hideLoading();
            }
        });
    });

    // Modération de contenu
    $('#moderate-content-btn').click(function() {
        const content = $('#text-to-analyze').val();
        if (!content.trim()) {
            alert('Veuillez entrer du contenu à modérer');
            return;
        }
        
        showLoading();
        
        $.ajax({
            url: '{{ route("ai.moderate.content") }}',
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                content: content
            },
            success: function(response) {
                if (response.success) {
                    const moderationClass = response.approved ? 'success' : 'danger';
                    const moderationText = response.approved ? 'APPROUVÉ' : 'REJETÉ';
                    $('#analysis-results').html(
                        '<div class="alert alert-' + moderationClass + '">' +
                        '<strong>Modération:</strong> ' + moderationText + '<br>' +
                        '<strong>Action:</strong> ' + response.action +
                        '</div>'
                    );
                }
                hideLoading();
            },
            error: function() {
                showError('Erreur lors de la modération');
                hideLoading();
            }
        });
    });

    // Conseils écologiques
    $('#get-eco-tips-btn').click(function() {
        const data = {
            situation: $('#eco-situation').val(),
            location: $('#eco-location').val()
        };
        
        showLoading();
        
        $.ajax({
            url: '{{ route("ai.eco.tips") }}',
            method: 'GET',
            data: data,
            success: function(response) {
                if (response.success) {
                    $('#eco-tips').html('<div class="alert alert-success"><pre>' + response.tips + '</pre></div>');
                } else {
                    showError('Erreur lors de la génération des conseils');
                }
                hideLoading();
            },
            error: function() {
                showError('Erreur de connexion');
                hideLoading();
            }
        });
    });

    // Fonctions utilitaires
    function showLoading() {
        $('#loadingModal').modal('show');
    }

    function hideLoading() {
        $('#loadingModal').modal('hide');
    }

    function showError(message) {
        alert(message);
    }

    function getSentimentClass(sentiment) {
        switch(sentiment) {
            case 'POSITIF': return 'success';
            case 'NEGATIF': return 'danger';
            case 'NEUTRE': return 'secondary';
            default: return 'info';
        }
    }
});
</script>
@endsection

@endsection