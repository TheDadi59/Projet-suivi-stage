<?php

namespace App\Models\Suivi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LienRessourceTemplate extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ressource_template';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    //protected $primaryKey = ['id_template', 'id_ressource'];
    protected $primaryKey = 'id_ressource_template';

    /**
     * The database connection that should be used by the model.
     *
     * @var string
     */
    protected $connection = 'suivi';

    use HasFactory;
}
