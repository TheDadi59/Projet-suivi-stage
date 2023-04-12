<?php

namespace Database\Seeders;

use Database\Seeders\ENT\ApplicationSeeder;
use Database\Seeders\ENT\MenuSeeder;
use Database\Seeders\ENT\TypeUtilisateurSeeder;
use Database\Seeders\ENT\UtilisateurSeeder;
use Database\Seeders\Suivi\ActiviteSeeder;
use Database\Seeders\Suivi\AttributSeeder;
use Database\Seeders\Suivi\JalonSeeder;
use Database\Seeders\Suivi\LienTemplateAttributSeeder;
use Database\Seeders\Suivi\RessourceSeeder;
use Database\Seeders\Suivi\TemplateSeeder;
use Database\Seeders\Suivi\ValeurAttributSeeder;
use Database\Seeders\Suivi\ValidationJalonSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // ENT
        $this->call([
            ApplicationSeeder::class,
            MenuSeeder::class,
            TypeUtilisateurSeeder::class,
            UtilisateurSeeder::class,
        ]);

        // Suivi
        $this->call([
            TemplateSeeder::class,
            AttributSeeder::class,
            ActiviteSeeder::class,
            ValeurAttributSeeder::class,
            JalonSeeder::class,
            ValidationJalonSeeder::class,
            LienTemplateAttributSeeder::class,
            RessourceSeeder::class
        ]);

    }

}
