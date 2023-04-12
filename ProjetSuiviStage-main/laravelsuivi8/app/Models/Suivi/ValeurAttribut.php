<?php

namespace App\Models\Suivi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValeurAttribut extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'valeur_attribut';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    //protected $primaryKey = ['id_activite', 'id_attribut'];
    protected $primaryKey = 'id_valeur_attribut';

    /**
     * The database connection that should be used by the model.
     *
     * @var string
     */
    protected $connection = 'suivi';

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'valeur' => "Non définie",
    ];

    use HasFactory;
}
