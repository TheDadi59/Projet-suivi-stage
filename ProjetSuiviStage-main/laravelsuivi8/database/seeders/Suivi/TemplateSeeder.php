<?php

namespace Database\Seeders\Suivi;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('template')->insert([

            ['id_template' => 1, 'libelle' => 'Stage', 'id_template_parent' => null],
            ['id_template'=> 2, 'libelle'=>'Stage de CI1 entrant CI1','id_template_parent' => 1],
            ['id_template'=> 3, 'libelle'=>'Stage de CI1 entrant CP1','id_template_parent' => 1],
            ['id_template'=> 4, 'libelle'=>'Stage de CI2','id_template_parent' => 1],
            ['id_template'=>5, 'libelle'=>'Stage de CI3', 'id_template_parent'=>1],
            ['id_template'=>6, 'libelle'=>'Stage de CP1', 'id_template_parent'=>1],
            ['id_template'=>7, 'libelle'=>'Stage de CP2', 'id_template_parent'=>1],

        ]);

    }
}

