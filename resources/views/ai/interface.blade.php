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

        <!-- Info Configuration -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="alert alert-info">
                    <h5><i class="fas fa-info-circle me-2"></i>Configuration requise</h5>
                    <p><strong>Pour que l'IA fonctionne, vous devez :</strong></p>
                    <ol>
                        <li>Obtenir une clé API Gemini gratuite : <a href="https://makersuite.google.com/app/apikey" target="_blank">https://makersuite.google.com/app/apikey</a></li>
                        <li>Ajouter la clé dans votre fichier .env : <code>GEMINI_API_KEY=votre-cle-ici</code></li>
                        <li>Nettoyer le cache : <code>php artisan config:clear</code></li>
                    </ol>
                    <p class="mb-0"><strong>Limites gratuites :</strong> 1500 requêtes/jour, 15 requêtes/minute</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // CSRF Token
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        // Test de connexion
        async function testConnection() {
            document.getElementById('connectionResult').innerHTML = '<div class="spinner-border spinner-border-sm"></div> Test...';
            
            try {
                const response = await fetch('/ai/test-simple', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                    },
                    body: JSON.stringify({ prompt: 'Test de connexion' })
                });
                
                if (response.ok) {
                    document.getElementById('apiStatus').className = 'badge bg-success';
                    document.getElementById('apiStatus').textContent = 'Connecté';
                    document.getElementById('connectionResult').innerHTML = '<small class="text-success">✓ Connexion réussie</small>';
                } else {
                    throw new Error('Erreur de connexion');
                }
            } catch (error) {
                document.getElementById('apiStatus').className = 'badge bg-danger';
                document.getElementById('apiStatus').textContent = 'Erreur';
                document.getElementById('connectionResult').innerHTML = '<small class="text-danger">✗ Vérifiez votre clé API</small>';
            }
        }

        // Test simple
        document.getElementById('simpleForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(e.target);
            const data = Object.fromEntries(formData);
            
            showLoading('simpleLoading');
            
            try {
                const result = await makeAIRequest('test-simple', data);
                document.getElementById('simpleResult').innerHTML = `
                    <div class="alert alert-success">
                        <strong>✓ IA répond :</strong><br>
                        ${result.response || result.description || 'Réponse reçue avec succès'}
                    </div>
                `;
            } catch (error) {
                showError('simpleResult', 'Test simple échoué');
            } finally {
                hideLoading('simpleLoading');
            }
        });

        // Description
        document.getElementById('descriptionForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(e.target);
            const data = Object.fromEntries(formData);
            
            showLoading('descriptionLoading');
            
            try {
                const result = await makeAIRequest('generate-event-description', data);
                document.getElementById('descriptionResult').innerHTML = `
                    <div class="alert alert-success">
                        <h6>✓ Description générée :</h6>
                        <p>${result.description}</p>
                    </div>
                `;
            } catch (error) {
                showError('descriptionResult', 'Génération échouée');
            } finally {
                hideLoading('descriptionLoading');
            }
        });

        // Sentiment
        document.getElementById('sentimentForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(e.target);
            const data = Object.fromEntries(formData);
            
            showLoading('sentimentLoading');
            
            try {
                const result = await makeAIRequest('analyze-sentiment', data);
                const sentimentClass = result.sentiment === 'POSITIF' ? 'success' : 
                                    result.sentiment === 'NEGATIF' ? 'danger' : 'warning';
                
                document.getElementById('sentimentResult').innerHTML = `
                    <div class="alert alert-${sentimentClass}">
                        <strong>Sentiment détecté :</strong> ${result.sentiment}
                    </div>
                `;
            } catch (error) {
                showError('sentimentResult', 'Analyse échouée');
            } finally {
                hideLoading('sentimentLoading');
            }
        });

        // Tips
        document.getElementById('tipsForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(e.target);
            const params = new URLSearchParams(formData);
            
            showLoading('tipsLoading');
            
            try {
                const response = await fetch(`/ai/generate-eco-tips?${params}`, {
                    headers: { 'X-CSRF-TOKEN': token }
                });
                
                if (!response.ok) throw new Error('Erreur réseau');
                
                const result = await response.json();
                document.getElementById('tipsResult').innerHTML = `
                    <div class="alert alert-info">
                        <h6>✓ Conseils personnalisés :</h6>
                        <div style="white-space: pre-line;">${result.tips}</div>
                    </div>
                `;
            } catch (error) {
                showError('tipsResult', 'Génération conseils échouée');
            } finally {
                hideLoading('tipsLoading');
            }
        });

        // Fonctions utilitaires
        async function makeAIRequest(endpoint, data) {
            const response = await fetch(`/ai/${endpoint}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                },
                body: JSON.stringify(data)
            });
            
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}`);
            }
            
            return await response.json();
        }

        function showLoading(elementId) {
            document.getElementById(elementId).classList.add('show');
        }

        function hideLoading(elementId) {
            document.getElementById(elementId).classList.remove('show');
        }

        function showError(resultId, message) {
            document.getElementById(resultId).innerHTML = `
                <div class="alert alert-danger">
                    <strong>❌ Erreur :</strong> ${message}<br>
                    <small>Vérifiez votre clé API Gemini dans le fichier .env</small>
                </div>
            `;
        }

        // Test automatique au chargement
        window.addEventListener('load', () => {
            setTimeout(testConnection, 1000);
        });
    </script>
</body>
</html>