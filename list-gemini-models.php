<?php

// Liste des modèles Gemini disponibles
require_once 'vendor/autoload.php';

// Charger les variables d'environnement
$env = file_get_contents('.env');
preg_match('/GEMINI_API_KEY=(.+)/', $env, $matches);
$apiKey = trim($matches[1] ?? '');

if (empty($apiKey)) {
    echo "❌ Clé API Gemini non trouvée dans .env\n";
    exit(1);
}

echo "🤖 Liste des Modèles Gemini Disponibles\n";
echo "=======================================\n";

// Lister les modèles
$url = "https://generativelanguage.googleapis.com/v1beta/models?key=" . $apiKey;

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "Code HTTP : $httpCode\n\n";

if ($httpCode === 200) {
    $result = json_decode($response, true);
    if (isset($result['models'])) {
        echo "✅ Modèles disponibles :\n";
        foreach ($result['models'] as $model) {
            $name = $model['name'];
            $methods = implode(', ', $model['supportedGenerationMethods'] ?? []);
            echo "- $name (Méthodes: $methods)\n";
        }
        
        echo "\n🎯 Recommandations pour .env :\n";
        foreach ($result['models'] as $model) {
            if (in_array('generateContent', $model['supportedGenerationMethods'] ?? [])) {
                $modelName = str_replace('models/', '', $model['name']);
                echo "GEMINI_MODEL=$modelName\n";
                break;
            }
        }
    } else {
        echo "❌ Structure réponse inattendue :\n";
        echo $response . "\n";
    }
} else {
    echo "❌ Erreur API :\n";
    echo $response . "\n";
}
?>