<?php

namespace App\Models\Suivi;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ValidationJalon extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'validation_jalon';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = ['id_activite', 'id_jalon'];
    //protected $primaryKey = 'id_validation_jalon';

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


    /**
     * -1 : passé, 0: auj, 1: futur
     * @var int Indique si le jalon est dans le passé, futur, aujourd'hui(pour la timeline)
     */
    public $relativite = false;


    /**
     * Echeance formaté : En retard de x, Dans x ..
     * @var String
     */
    public $etatFormate = "Inconnu";


    /**
     * Etat : -1 retard, 0 aujourd'hui, 1 futur
     * @var int
     */
    public $etat = 1;




    use HasFactory;
}
