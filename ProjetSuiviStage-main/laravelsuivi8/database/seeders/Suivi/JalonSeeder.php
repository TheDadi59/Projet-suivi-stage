<?php

namespace Database\Seeders\Suivi;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JalonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('jalon')->insert([

            //4 semaines après le début pour CI2
            [
                'id_jalon' => 1,
                'id_template' => 4,
                'libelle'=> 'Appel tuteur entreprise',
                'description'=>"RDV téléphonique avec le tuteur entreprise et rédaction du compte-rendu sur la fiche de suivi",
                'echeance'=> 3600*24*7*4,
                'pour_utilisateur_suivi'=>0,
                'notable'=>0
            ],

            //27 semaines après le début pour CI2
            [
                'id_jalon'=> 2,
                'id_template'=>4,
                'libelle'=>'Evaluation du rapport',
                'description'=>"Evaluation du rapport de stage et envoi dp-stages@imt-nord-europe.fr (confidentiel)",
                'echeance'=>3600*24*7*25,
                'pour_utilisateur_suivi'=>0,
                'notable'=>1
            ],

            //7 semaines après le début pour CI1 entrant CI1
            [
                'id_jalon'=> 3,
                'id_template'=>2,
                'libelle'=>'Appel tuteur entreprise',
                'description'=>"RDV téléphonique avec le tuteur entreprise et rédaction du compte-rendu sur la fiche de suivi",
                'echeance'=> 3600*24*7*4,
                'pour_utilisateur_suivi'=>0,
                'notable'=>0
            ],

            //25 semaines après le début pour CI1 entrant CI1
            ['id_jalon'=> 4, 'id_template'=>2, 'libelle'=>'Evaluation du rapport', 'description'=>"Evaluation du rapport de stage et envoi à C.Fatrez (si confidentiel)", 'echeance'=>3600*24*7*25, 'pour_utilisateur_suivi'=>0, 'notable'=>1],

            //23 semaines aprèes le début pour CI1 entrant CI1
            ['id_jalon'=> 5, 'id_template'=>2, 'libelle'=>'Soutenance', 'description'=>'Soutenance uniquement pour les entrants CI1', 'echeance'=>3600*24*7*23, 'pour_utilisateur_suivi'=>0, 'notable'=>1],

            //7 semaines après le début pour CI1 entrant CP1
            ['id_jalon'=> 6, 'id_template'=> 3, 'libelle'=>'Appel tuteur entreprise', 'description'=>'RDV téléphonique avec le tuteur entreprise et rédaction du compte-rendu sur la fiche de suivi', 'echeance'=> 3600*24*7*4, 'pour_utilisateur_suivi'=>0, 'notable'=>0],

            //25 semaines après le début pour CI1 entrant CP1
            ['id_jalon'=>7, 'id_template'=>3, 'libelle'=>'Evaluation', 'description'=>'Evaluation du rapport de stage et du poster, et envoi à C.Fatrez (si confidentiel)', 'echeance'=>3600*24*7*25, 'pour_utilisateur_suivi'=>0, 'notable'=>1],

            //7 semaines après le début pour CI3
            ['id_jalon'=>8, 'id_template'=>5, 'libelle'=>'Appel tuteur entreprise', 'description'=>'RDV téléphonique avec le tuteur entreprise et rédaction du compte-rendu sur la fiche de suivi', 'echeance'=> 3600*24*7*7, 'pour_utilisateur_suivi'=>0, 'notable'=>0],

            //7 semaines après le début pour CI3
            ['id_jalon'=>9, 'id_template'=>5, 'libelle'=>'Contact étudiant', 'description'=>"contact avec l'étudiant (mail, téléphone, visio...)", 'echeance'=> 3600*24*7*7, 'pour_utilisateur_suivi'=>0, 'notable'=>0],

            //24 semaines après le début pour CI3
            ['id_jalon'=>10, 'id_template'=>5, 'libelle'=>'Evaluation du rapport', 'description'=>'Evaluation du rapport de stage et envoi dp-stages@imt-nord-europe.fr (confidentiel)', 'echeance'=>3600*24*7*24, 'pour_utilisateur_suivi'=>0, 'notable'=>1],

            //24 semaines aprèes le début pour CI1 entrant CI3
            ['id_jalon'=>11, 'id_template'=>5, 'libelle'=>'Soutenance', 'description'=>'Soutenance', 'echeance'=>3600*24*7*24, 'pour_utilisateur_suivi'=>0, 'notable'=>1],

            //4 semaines après le début pour CP1
            ['id_jalon'=>12, 'id_template'=>6, 'libelle'=>'Appel tuteur entreprise', 'description'=>'RDV téléphonique avec le tuteur entreprise et rédaction du compte-rendu sur la fiche de suivi', 'echeance'=> 3600*24*7*4, 'pour_utilisateur_suivi'=>0, 'notable'=>0],

            //10 semaines après le début pour CP1
            ['id_jalon'=>13, 'id_template'=>6, 'libelle'=>'Validation rapport', 'description'=>'validation par mail du rapport par le référent stage', 'echeance'=>3600*24*7*10, 'pour_utilisateur_suivi'=>0 , 'notable'=>0],

            //11 semaines après le début pour CP1
            ['id_jalon'=>14, 'id_template'=>6, 'libelle'=>'Evaluation du rapport', 'description'=>'Evaluation du rapport de stage et envoi à D.Staelens (dp-stages@imt-nord-europe.fr)', 'echeance'=>3600*24*7*11, 'pour_utilisateur_suivi'=>0, 'notable'=>1],

            //4 semaines après le début pour CP2
            ['id_jalon'=>15, 'id_template'=>7, 'libelle'=>'Appel tuteur entreprise', 'description'=>'RDV téléphonique avec le tuteur entreprise et rédaction du compte-rendu sur la fiche de suivi', 'echeance'=> 3600*24*7*4, 'pour_utilisateur_suivi'=>0, 'notable'=>0],

            //15 semaines après le début pour CP2
            ['id_jalon'=>16, 'id_template'=>7, 'libelle'=>'Evaluation du rapport', 'description'=>'Evaluation du rapport de stage et envoi à D.Staelens (dp-stages@imt-nord-europe.fr)', 'echeance'=>3600*24*7*15, 'pour_utilisateur_suivi'=>0, 'notable'=>1],

            //15 semaines après le début pour CP2
            ['id_jalon'=>17, 'id_template'=>7, 'libelle'=>'Soutenance', 'description'=>'Soutencance', 'echeance'=>3600*24*7*15, 'pour_utilisateur_suivi'=>0, 'notable'=>1],


        ]);

    }
}

