# 🤖 EcoEvents - Test Configuration IA Gemini
# =============================================

Write-Host "🤖 EcoEvents - Test Configuration IA Gemini" -ForegroundColor Green
Write-Host "============================================="

# Vérifier si le fichier .env existe
if (!(Test-Path .env)) {
    Write-Host "❌ Fichier .env introuvable" -ForegroundColor Red
    exit 1
}

# Vérifier la clé Gemini
if (Select-String -Path .env -Pattern "GEMINI_API_KEY") {
    Write-Host "✅ Configuration GEMINI_API_KEY trouvée dans .env" -ForegroundColor Green
} else {
    Write-Host "❌ GEMINI_API_KEY manquant dans .env" -ForegroundColor Red
    Write-Host "   Ajoutez: GEMINI_API_KEY=votre-cle-ici" -ForegroundColor Yellow
}

# Vérifier les fichiers IA
Write-Host ""
Write-Host "📁 Vérification fichiers IA:" -ForegroundColor Cyan

$files = @(
    "app/Services/GeminiAIService.php",
    "app/Http/Controllers/AIController.php", 
    "config/gemini.php",
    "resources/views/ai/interface.blade.php"
)

foreach ($file in $files) {
    if (Test-Path $file) {
        Write-Host "✅ $file" -ForegroundColor Green
    } else {
        Write-Host "❌ $file manquant" -ForegroundColor Red
    }
}

# Test serveur
Write-Host ""
Write-Host "🌐 Test serveur Laravel:" -ForegroundColor Cyan
$process = Get-Process | Where-Object {$_.ProcessName -like "*php*" -and $_.CommandLine -like "*serve*"}
if ($process) {
    Write-Host "✅ Serveur Laravel en cours d'exécution" -ForegroundColor Green
    Write-Host "   Interface IA: http://127.0.0.1:8000/ai/interface" -ForegroundColor Blue
} else {
    Write-Host "⚠️  Serveur Laravel arrêté" -ForegroundColor Yellow
    Write-Host "   Démarrer avec: php artisan serve" -ForegroundColor Blue
}

Write-Host ""
Write-Host "🎯 Étapes suivantes:" -ForegroundColor Magenta
Write-Host "1. Obtenez votre clé Gemini: https://makersuite.google.com/app/apikey"
Write-Host "2. Ajoutez-la dans .env: GEMINI_API_KEY=votre-cle"
Write-Host "3. Nettoyez le cache: php artisan config:clear"
Write-Host "4. Testez sur: http://127.0.0.1:8000/ai/interface"