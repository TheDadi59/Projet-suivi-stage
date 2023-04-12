<?php

namespace Database\Seeders\Suivi;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RessourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ressource')->insert([

            ['id_ressource' => 1, 'libelle' => 'Guide template', 'url' => 'https://imt-nord-europe.fr'],
            ['id_ressource'=> 2, 'libelle'=>'Fiche notation L3', 'url' => 'https://imt-nord-europe.fr/132q135d54sq'],
            ['id_ressource'=> 3, 'libelle'=>'Fiche appel tuteur', 'url' => 'https://imt-nord-europe.fr/4423'],

        ]);


        // Template 1 : 2 ressource (1 lui même + 1 parent)
        // Template 2 : 1 ressource (1 lui même)
        // Template 3 : 1 ressource (1parent)
        DB::table('ressource_template')->insert([
            ['id_template' => 1, 'id_ressource' => 1],
            ['id_template' => 2, 'id_ressource' => 2],
        ]);

        DB::table('ressource_jalon')->insert([
            ['id_jalon' => 3, 'id_ressource' => 2],
            ['id_jalon' => 6, 'id_ressource' => 2],
        ]);

    }
}

