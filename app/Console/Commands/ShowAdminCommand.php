<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class ShowAdminCommand extends Command
{
    protected $signature = 'admin:show';

    protected $description = 'Afficher les informations de l\'administrateur';

    public function handle()
    {
        $admin = User::where('role', 'admin')->first();

        if (! $admin) {
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
                $admin->is_active ? 'Oui' : 'Non',
            ]]
        );

        return 0;
    }
}
