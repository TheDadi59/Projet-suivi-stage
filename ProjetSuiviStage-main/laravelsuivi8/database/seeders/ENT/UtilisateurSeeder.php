<?php

namespace Database\Seeders\ENT;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UtilisateurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    protected $connection = 'ent';
    public function run()
    {
        DB::connection('ent')->table('utilisateur')->insert([
            [
                'id_utilisateur' => 3,
                'lib_nom' => 'Fabresse',
                'lib_prenom' => 'Isabelle',
                'id_type_utilisateur' => 2,
                'lib_adr_mail' => 'isabelle.fabresse@imt-lille-douai.fr',
            ],
            [
                'id_utilisateur' => 100,
                'lib_nom' => 'Cockedey',
                'lib_prenom' => 'Maxence',
                'id_type_utilisateur' => 2,
                'lib_adr_mail' => 'maxence.cockedey@etu.imt-nord-europe.fr',
            ],
            [
                'id_utilisateur' => 101,
                'lib_nom' => 'Sanchez',
                'lib_prenom' => 'Victor',
                'id_type_utilisateur' => 2,
                'lib_adr_mail' => 'victor.sanchez@etu.imt-nord-europe.fr',
            ],
            [
                'id_utilisateur' => 102,
                'lib_nom' => 'Lemoigne',
                'lib_prenom' => 'Quentin',
                'id_type_utilisateur' => 2,
                'lib_adr_mail' => 'quentin.lemoigne@etu.imt-nord-europe.fr',
            ],
            [
                'id_utilisateur' => 103,
                'lib_nom' => 'Nom tuteur',
                'lib_prenom' => 'Prénom tuteur',
                'id_type_utilisateur' => 2,
                'lib_adr_mail' => 'r.r@imt-lille-douai.fr',
            ],
        ]);
    }
}
