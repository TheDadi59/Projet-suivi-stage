<?php

namespace App\Models\Suivi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LienRessourceJalon extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ressource_jalon';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    //protected $primaryKey = ['id_jalon', 'id_ressource'];
    protected $primaryKey = 'id_ressource_jalon';

    /**
     * The database connection that should be used by the model.
     *
     * @var string
     */
    protected $connection = 'suivi';

    use HasFactory;
}
