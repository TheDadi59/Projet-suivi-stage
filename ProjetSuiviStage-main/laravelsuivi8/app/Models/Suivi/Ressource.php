<?php

namespace App\Models\Suivi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ressource extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ressource';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_ressource';


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
        'libelle' => "Sans titre",
        'url' => "Sans URL"
    ];

    use HasFactory;
}
