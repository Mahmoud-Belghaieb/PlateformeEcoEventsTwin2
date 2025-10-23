#!/bin/bash

echo "🤖 EcoEvents - Test Configuration IA Gemini"
echo "============================================="

# Vérifier si le fichier .env existe
if [ ! -f .env ]; then
    echo "❌ Fichier .env introuvable"
    exit 1
fi

# Vérifier la clé Gemini
if grep -q "GEMINI_API_KEY" .env; then
    echo "✅ Configuration GEMINI_API_KEY trouvée dans .env"
else
    echo "❌ GEMINI_API_KEY manquant dans .env"
    echo "   Ajoutez: GEMINI_API_KEY=votre-cle-ici"
fi

# Vérifier les fichiers IA
echo ""
echo "📁 Vérification fichiers IA:"

files=(
    "app/Services/GeminiAIService.php"
    "app/Http/Controllers/AIController.php" 
    "config/gemini.php"
    "resources/views/ai/interface.blade.php"
)

for file in "${files[@]}"; do
    if [ -f "$file" ]; then
        echo "✅ $file"
    else
        echo "❌ $file manquant"
    fi
done

# Test serveur
echo ""
echo "🌐 Test serveur Laravel:"
if pgrep -f "php.*serve" > /dev/null; then
    echo "✅ Serveur Laravel en cours d'exécution"
    echo "   Interface IA: http://127.0.0.1:8000/ai/interface"
else
    echo "⚠️  Serveur Laravel arrêté"
    echo "   Démarrer avec: php artisan serve"
fi

echo ""
echo "🎯 Étapes suivantes:"
echo "1. Obtenez votre clé Gemini: https://makersuite.google.com/app/apikey"
echo "2. Ajoutez-la dans .env: GEMINI_API_KEY=votre-cle"
echo "3. Nettoyez le cache: php artisan config:clear"
echo "4. Testez sur: http://127.0.0.1:8000/ai/interface"