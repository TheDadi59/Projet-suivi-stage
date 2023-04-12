<?php

namespace Database\Seeders\Suivi;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttributSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('attribut')->insert([
            ['id_attribut'=> 1, 'libelle'=> "Localisation stage"],
            ['id_attribut'=> 2, 'libelle'=> "Nom entreprise"],
            ['id_attribut'=> 3, 'libelle'=> "Sujet du stage"],
            ['id_attribut'=> 4, 'libelle'=> "Tuteur externe"],
            ['id_attribut'=> 5, 'libelle'=> "Taches confiées"],
        ]);

    }
}

