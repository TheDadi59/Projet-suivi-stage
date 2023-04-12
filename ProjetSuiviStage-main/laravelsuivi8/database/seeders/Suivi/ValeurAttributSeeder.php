<?php

namespace Database\Seeders\Suivi;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ValeurAttributSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('valeur_attribut')->insert([

            // id_attribut = 1 => Localisation
            ['id_activite'=> 1, 'id_attribut'=> 1, 'valeur' => "Lille"],

            // id_attrbiut = 2 => Nom entreprise
            ['id_activite'=> 1, 'id_attribut'=> 2, 'valeur' => "Orange"],

            // id_attrbiut = 3 => Sujet du stage
            ['id_activite'=> 1, 'id_attribut'=> 3, 'valeur' => "Ce stage est l’occasion pour l’élève-ingénieur de développer à la fois sa compréhension des enjeux stratégiques de l'entreprise mais aussi de mieux appréhender la contribution des ingénieurs à la performance et au développement de celle-ci.

Intégré au sein d'une équipe d'ingénieurs il sera amené à :
- co-piloter un ou plusieurs projets,
- gérer, synthétiser, améliorer et communiquer sur des indicateurs d'activité et/ou de performance,
- participer au développement de solutions technologiques ou managériales,
- accompagner les équipes à l'intégration du changement et l'appropriation de nouveaux process.

Les compétences à développer principalement au sein du référentiel de l’ingénieur IMT Nord Europe sont :
- la résolution de problèmes,
- l’innovation, l’ingéniosité : créativité, initiative, esprit d’entreprise,
- la gestion de projet, le travail en équipe et en réseau, l’animation,
- le sens relationnel, la capacité de mobilisation, de conviction,
- la gestion du stress,
- le leadership : influence"],

            // id_attrbiut = 4 => Tuteur entreprise
            ['id_activite'=> 1, 'id_attribut'=> 4, 'valeur' => "BRY Bénédicte"],

            // id_attrbiut = 5 => Taches confiées
            ['id_activite'=> 1, 'id_attribut'=> 5, 'valeur' => "Dans de cette équipe, vous serez en charge :

- De mettre en oeuvre des scripts de vérification actuellement exécutés manuellement.
- D'intégrer ces scripts dans un enchainement automatisé.
- De mettre en oeuvre une interface utilisateur rendant compte de la progression et regroupant la consultation des résultats.
"],

            // id_attribut = 1 => Localisation
            ['id_activite'=> 2, 'id_attribut'=> 1, 'valeur' => "Roubaix"],

            // id_attrbiut = 2 => Nom entreprise
            ['id_activite'=> 2, 'id_attribut'=> 2, 'valeur' => "OVH"],


            // id_attribut = 1 => Localisation
            ['id_activite'=> 3, 'id_attribut'=> 1, 'valeur' => "Orchies"],

            // id_attrbiut = 2 => Nom entreprise
            ['id_activite'=> 3, 'id_attribut'=> 2, 'valeur' => "Free"],


            // id_attribut = 1 => Localisation
            ['id_activite'=> 4, 'id_attribut'=> 1, 'valeur' => "Douai"],

            // id_attrbiut = 2 => Nom entreprise
            ['id_activite'=> 4, 'id_attribut'=> 2, 'valeur' => "ENEDIS"],
        ]);

    }
}

