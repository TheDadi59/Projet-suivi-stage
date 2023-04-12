<?php

namespace Database\Seeders\Suivi;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ValidationJalonSeeder extends Seeder
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

        DB::table('validation_jalon')->insert([

            //   // Stage de CI1 entrant CI1 Maxence Cockedey tout est validé
            ['id_activite'=> 1, 'id_jalon'=> 3, 'date_validation' => $dateNow, 'valide' => true, 'commentaire' => 'Parfait 1',  'note' => null],
            ['id_activite'=> 1, 'id_jalon'=> 4, 'date_validation' => $dateNow, 'valide' => true, 'commentaire' => 'Parfait 2',  'note' => 10.0],
            ['id_activite'=> 1, 'id_jalon'=> 5, 'date_validation' => $dateNow, 'valide' => true, 'commentaire' => 'Parfait 3', 'note' => 15.3],

            // 2 premiers jalons validés activité Maxence template Stage M1 (CI2)
            ['id_activite'=> 2, 'id_jalon'=> 1, 'date_validation' => $dateNow, 'valide' => true, 'commentaire' => 'RAS',  'note' => null],
            ['id_activite'=> 2, 'id_jalon'=> 2, 'date_validation' => $dateNow, 'valide' => true, 'commentaire' => 'RAS',  'note' => 17.5],



            // victor
           /* ['id_activite'=> 3, 'id_jalon'=> 4, 'date_validation' => null, 'valide' => false, 'commentaire' => null],
            ['id_activite'=> 3, 'id_jalon'=> 5, 'date_validation' => null, 'valide' => false, 'commentaire' => null],
            ['id_activite'=> 3, 'id_jalon'=> 6, 'date_validation' => null, 'valide' => false, 'commentaire' => null],

            // quentin
            ['id_activite'=> 4, 'id_jalon'=> 4, 'date_validation' => null, 'valide' => false, 'commentaire' => null],
            ['id_activite'=> 4, 'id_jalon'=> 5, 'date_validation' => null, 'valide' => false, 'commentaire' => null],
            ['id_activite'=> 4, 'id_jalon'=> 6, 'date_validation' => null, 'valide' => false, 'commentaire' => null],*/


        ]);

    }
}

