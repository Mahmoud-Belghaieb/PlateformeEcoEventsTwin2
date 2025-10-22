<?php

use Illuminate\Support\Facades\Mail;

echo "═══════════════════════════════════════════════════════════\n";
echo "    📧 TEST DE CONFIGURATION EMAIL - ECOEVENTS\n";
echo "═══════════════════════════════════════════════════════════\n\n";

// Afficher la configuration actuelle
echo "📊 Configuration actuelle:\n";
echo "   MAIL_MAILER: " . config('mail.default') . "\n";
echo "   MAIL_HOST: " . config('mail.mailers.smtp.host') . "\n";
echo "   MAIL_PORT: " . config('mail.mailers.smtp.port') . "\n";
echo "   MAIL_USERNAME: " . config('mail.mailers.smtp.username') . "\n";
echo "   MAIL_ENCRYPTION: " . config('mail.mailers.smtp.encryption') . "\n";
echo "   MAIL_FROM: " . config('mail.from.address') . "\n\n";

echo "📧 Envoi d'un email de test...\n\n";

try {
    Mail::raw(
        "Bonjour,\n\n" .
        "Ceci est un email de test depuis votre application EcoEvents.\n\n" .
        "Si vous recevez cet email, cela signifie que la configuration Gmail fonctionne correctement!\n\n" .
        "Configuration utilisée:\n" .
        "- SMTP Host: " . config('mail.mailers.smtp.host') . "\n" .
        "- SMTP Port: " . config('mail.mailers.smtp.port') . "\n" .
        "- Encryption: " . config('mail.mailers.smtp.encryption') . "\n\n" .
        "Cordialement,\n" .
        "L'équipe EcoEvents",
        function ($message) {
            $message->to(config('mail.mailers.smtp.username'))
                    ->subject('✅ Test Configuration Email - EcoEvents');
        }
    );

    echo "✅ SUCCESS! Email envoyé avec succès!\n\n";
    echo "📬 Vérifiez votre boîte mail: " . config('mail.mailers.smtp.username') . "\n";
    echo "   (Vérifiez aussi le dossier Spam)\n\n";
    echo "═══════════════════════════════════════════════════════════\n";
    
} catch (\Exception $e) {
    echo "❌ ERREUR lors de l'envoi de l'email!\n\n";
    echo "Message d'erreur:\n";
    echo $e->getMessage() . "\n\n";
    
    echo "🔧 Solutions possibles:\n";
    echo "1. Vérifiez que la validation en deux étapes est activée sur Google\n";
    echo "2. Vérifiez que vous utilisez un mot de passe d'application (pas votre mot de passe Gmail)\n";
    echo "3. Vérifiez qu'il n'y a pas d'espaces dans MAIL_PASSWORD\n";
    echo "4. Essayez de créer un nouveau mot de passe d'application\n\n";
    echo "═══════════════════════════════════════════════════════════\n";
    
    exit(1);
}
