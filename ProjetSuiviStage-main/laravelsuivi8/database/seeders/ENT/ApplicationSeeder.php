<?php

namespace Database\Seeders\ENT;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::connection('ent')->table('application')->insert([
            [
                'id_application' => 41,
                'lib_application' => 'Mon Profil',
                'lib_version' => '1.0'
            ],
            [
                'id_application' => 4,
                'lib_application' => 'SuiviOld',
                'lib_version' => '1.0'
            ],

        ]);






    }
}
