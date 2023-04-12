<?php

namespace App\Models\Suivi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FichierValidationJalon extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'fichier_validation_jalon';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_fichier_validation_jalon';

    /**
     * The database connection that should be used by the model.
     *
     * @var string
     */
    protected $connection = 'suivi';

    /**
     * @var bool
     */
    public $timestamps = false;

    use HasFactory;
}
