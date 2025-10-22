# Script pour afficher les emails de réinitialisation de mot de passe
# Usage: .\show-reset-emails.ps1

Write-Host "═══════════════════════════════════════════════════════════════" -ForegroundColor Green
Write-Host "    📧 EMAILS DE RÉINITIALISATION - ECOEVENTS" -ForegroundColor Green
Write-Host "═══════════════════════════════════════════════════════════════" -ForegroundColor Green
Write-Host ""

$logFile = "storage\logs\laravel.log"

if (-not (Test-Path $logFile)) {
    Write-Host "❌ Fichier log introuvable: $logFile" -ForegroundColor Red
    exit
}

Write-Host "📂 Lecture du fichier: $logFile" -ForegroundColor Cyan
Write-Host ""

# Lire le contenu du fichier
$content = Get-Content $logFile -Raw

# Extraire les URLs de reset password
$urls = [regex]::Matches($content, 'http[s]?://[^\s]+reset-password/[^\s]+')

if ($urls.Count -eq 0) {
    Write-Host "ℹ️  Aucun email de réinitialisation trouvé." -ForegroundColor Yellow
    Write-Host ""
    Write-Host "💡 Pour tester:" -ForegroundColor Cyan
    Write-Host "   1. Allez sur: http://127.0.0.1:8004/forgot-password" -ForegroundColor White
    Write-Host "   2. Entrez: admin@admin.com" -ForegroundColor White
    Write-Host "   3. Relancez ce script" -ForegroundColor White
    Write-Host ""
} else {
    Write-Host "✅ $($urls.Count) lien(s) de réinitialisation trouvé(s):" -ForegroundColor Green
    Write-Host ""
    
    $counter = 1
    foreach ($url in $urls) {
        Write-Host "[$counter] " -NoNewline -ForegroundColor Yellow
        Write-Host $url.Value -ForegroundColor White
        $counter++
    }
    
    Write-Host ""
    Write-Host "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" -ForegroundColor Gray
    Write-Host ""
    
    # Afficher le dernier URL
    $lastUrl = $urls[-1].Value
    Write-Host "📋 Dernier lien (copié dans le presse-papiers):" -ForegroundColor Cyan
    Write-Host $lastUrl -ForegroundColor Green
    
    # Copier dans le presse-papiers
    Set-Clipboard -Value $lastUrl
    
    Write-Host ""
    Write-Host "✅ URL copiée! Collez-la dans votre navigateur (Ctrl+V)" -ForegroundColor Green
    Write-Host ""
    
    # Proposer d'ouvrir automatiquement
    $response = Read-Host "Voulez-vous ouvrir ce lien maintenant? (o/n)"
    if ($response -eq "o" -or $response -eq "O") {
        Start-Process $lastUrl
    }
}

Write-Host ""
Write-Host "═══════════════════════════════════════════════════════════════" -ForegroundColor Green
