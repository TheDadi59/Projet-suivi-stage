<?php

namespace Database\Seeders\Suivi;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ActiviteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $dt = Carbon::now();
        $dateNow = $dt->toDateTimeString();

        DB::table('activite')->insert([

            // Stage de CI1 entrant CI1 Maxence Cockedey, cloturé et rempli
            ['id_activite'=> 1, 'id_template' => 2, 'id_utilisateur_referent' => 3, 'id_utilisateur_suivi' => 100, 'date_debut'=> $dateNow, 'est_cloture' => true],

            // Stage de CI1 entrant CP1 Maxence Cockedey, cloturé et rempli
            ['id_activite'=> 2, 'id_template' => 3, 'id_utilisateur_referent' => 3, 'id_utilisateur_suivi' => 100, 'date_debut'=> $dateNow, 'est_cloture' => false],

            //  Stage de CI2 Victor Sanchez
            ['id_activite'=> 3, 'id_template' => 4, 'id_utilisateur_referent' => 3, 'id_utilisateur_suivi' => 101, 'date_debut'=> $dateNow, 'est_cloture' => false],

            // Stage de CI2 Quentin Lemoigne
            ['id_activite'=> 4, 'id_template' => 4, 'id_utilisateur_referent' => 3, 'id_utilisateur_suivi' => 102, 'date_debut'=> "2023-02-10 12:09:41", 'est_cloture' => false],

            //  Stage de CI2 Victor Sanchez
            ['id_activite'=> 5, 'id_template' => 4, 'id_utilisateur_referent' => 103, 'id_utilisateur_suivi' => 101, 'date_debut'=> $dateNow, 'est_cloture' => false],

        ]);

    }
}

