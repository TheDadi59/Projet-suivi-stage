<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ActiviteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id_utilisateur_referent' => 3,
            'id_utilisateur_suivit' => 3,
            'date_debut' => $this->faker->dateTime,
            'est_cloture' => false,
            //
        ];
    }
}
