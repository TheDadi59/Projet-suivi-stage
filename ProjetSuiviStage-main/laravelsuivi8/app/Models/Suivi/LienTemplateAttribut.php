<?php

namespace App\Models\Suivi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LienTemplateAttribut extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'template_attribut';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    //protected $primaryKey = ['id_attribut', 'id_template'];
    protected $primaryKey = 'id_template_attribut';

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
        'obligatoire' => false,
    ];

    use HasFactory;
}
