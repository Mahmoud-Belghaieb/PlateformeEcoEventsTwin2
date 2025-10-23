<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:email {email?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test la configuration email en envoyant un email de test';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('═══════════════════════════════════════════════════════════');
        $this->info('    📧 TEST DE CONFIGURATION EMAIL - ECOEVENTS');
        $this->info('═══════════════════════════════════════════════════════════');
        $this->newLine();

        // Afficher la configuration
        $this->info('📊 Configuration actuelle:');
        $this->line('   MAIL_MAILER: '.config('mail.default'));
        $this->line('   MAIL_HOST: '.config('mail.mailers.smtp.host'));
        $this->line('   MAIL_PORT: '.config('mail.mailers.smtp.port'));
        $this->line('   MAIL_USERNAME: '.config('mail.mailers.smtp.username'));
        $this->line('   MAIL_ENCRYPTION: '.config('mail.mailers.smtp.encryption'));
        $this->line('   MAIL_FROM: '.config('mail.from.address'));
        $this->newLine();

        // Demander l'email destinataire
        $email = $this->argument('email') ?? config('mail.mailers.smtp.username');

        $this->info("📧 Envoi d'un email de test à: {$email}");
        $this->newLine();

        try {
            Mail::raw(
                "Bonjour,\n\n".
                "Ceci est un email de test depuis votre application EcoEvents.\n\n".
                "Si vous recevez cet email, cela signifie que la configuration Gmail fonctionne correctement! ✅\n\n".
                "Configuration utilisée:\n".
                '- SMTP Host: '.config('mail.mailers.smtp.host')."\n".
                '- SMTP Port: '.config('mail.mailers.smtp.port')."\n".
                '- Encryption: '.config('mail.mailers.smtp.encryption')."\n".
                '- From: '.config('mail.from.address')."\n\n".
                'Date: '.now()->format('d/m/Y H:i:s')."\n\n".
                "Cordialement,\n".
                "L'équipe EcoEvents",
                function ($message) use ($email) {
                    $message->to($email)
                        ->subject('✅ Test Configuration Email - EcoEvents');
                }
            );

            $this->newLine();
            $this->info('✅ SUCCESS! Email envoyé avec succès!');
            $this->newLine();
            $this->line("📬 Vérifiez votre boîte mail: {$email}");
            $this->line('   (Vérifiez aussi le dossier Spam si vous ne le voyez pas)');
            $this->newLine();
            $this->info('═══════════════════════════════════════════════════════════');

            return Command::SUCCESS;

        } catch (\Exception $e) {
            $this->newLine();
            $this->error('❌ ERREUR lors de l\'envoi de l\'email!');
            $this->newLine();
            $this->error('Message d\'erreur:');
            $this->line($e->getMessage());
            $this->newLine();

            $this->warn('🔧 Solutions possibles:');
            $this->line('1. Vérifiez que la validation en deux étapes est activée sur Google');
            $this->line('2. Vérifiez que vous utilisez un mot de passe d\'application (pas votre mot de passe Gmail)');
            $this->line('3. Vérifiez qu\'il n\'y a pas d\'espaces dans MAIL_PASSWORD du fichier .env');
            $this->line('4. Essayez de créer un nouveau mot de passe d\'application sur https://myaccount.google.com/apppasswords');
            $this->line('5. Vérifiez que MAIL_HOST=smtp.gmail.com et MAIL_PORT=587');
            $this->newLine();
            $this->info('═══════════════════════════════════════════════════════════');

            return Command::FAILURE;
        }
    }
}
