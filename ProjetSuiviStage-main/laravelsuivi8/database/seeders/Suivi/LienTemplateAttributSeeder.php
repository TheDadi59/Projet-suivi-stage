<?php

namespace Database\Seeders\Suivi;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LienTemplateAttributSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('template_attribut')->insert([
            ['id_attribut'=> 1, 'id_template' => 1, 'obligatoire'=> true],
            ['id_attribut'=> 2, 'id_template' => 1, 'obligatoire'=> true],

            ['id_attribut'=> 1, 'id_template' => 2, 'obligatoire'=> true],
            ['id_attribut'=> 2, 'id_template' => 2, 'obligatoire'=> true],
        ]);

    }
}

