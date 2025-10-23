<?php

// Test direct de l'API Gemini pour EcoEvents
require_once 'vendor/autoload.php';

// Charger les variables d'environnement
$env = file_get_contents('.env');
preg_match('/GEMINI_API_KEY=(.+)/', $env, $matches);
$apiKey = trim($matches[1] ?? '');

if (empty($apiKey)) {
    echo "❌ Clé API Gemini non trouvée dans .env\n";
    exit(1);
}

echo "🤖 Test API Gemini Direct\n";
echo "========================\n";
echo "Clé API : " . substr($apiKey, 0, 10) . "...\n\n";

// Test avec gemini-2.0-flash
$url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=" . $apiKey;

$data = [
    'contents' => [
        [
            'parts' => [
                [
                    'text' => 'Dis simplement "Bonjour, je suis Gemini AI pour EcoEvents Tunisia"'
                ]
            ]
        ]
    ]
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "Code HTTP : $httpCode\n";

if ($httpCode === 200) {
    $result = json_decode($response, true);
    if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
        echo "✅ Succès ! Réponse IA :\n";
        echo $result['candidates'][0]['content']['parts'][0]['text'] . "\n";
    } else {
        echo "❌ Structure réponse inattendue :\n";
        echo $response . "\n";
    }
} else {
    echo "❌ Erreur API :\n";
    echo $response . "\n";
}

echo "\n";
echo "🎯 Si succès → Testez maintenant /ai/interface\n";
echo "🎯 Si erreur → Vérifiez votre clé API sur https://makersuite.google.com\n";
?>