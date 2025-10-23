<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class ShowAdminCommand extends Command
{
    protected $signature = 'admin:show';
    protected $description = 'Afficher les informations de l\'administrateur';

    public function handle()
    {
        $admin = User::where('role', 'admin')->first();

        if (!$admin) {
            $this->error('Aucun administrateur trouvé dans la base de données !');
            return 1;
        }

        $this->info('Informations de l\'administrateur :');
        $this->table(
            ['ID', 'Nom', 'Email', 'Rôle', 'Actif'],
            [[
                $admin->id,
                $admin->name,
                $admin->email,
                $admin->role,
                $admin->is_active ? 'Oui' : 'Non'
            ]]
        );

        return 0;
    }
}