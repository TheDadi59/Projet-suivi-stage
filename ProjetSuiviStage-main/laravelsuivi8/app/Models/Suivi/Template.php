<?php

namespace App\Models\Suivi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'template';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_template';


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
    ];


    /**
     * Renvoit les enfants d'un template et lui même (par défaut) (template ayant comme parent l'id transmis en paramètre)
     * @param $idTemplateParent
     * @return mixed
     */
    static function getTemplatesEnfant($idTemplateParent, $inclureParent = true) {

        if($inclureParent) {
            return Template::where('id_template_parent', '=', $idTemplateParent)->orWhere('id_template', '=', $idTemplateParent)->get();
        } else {
            return Template::where('id_template_parent', '=', $idTemplateParent)->get();
        }
    }

    /**
     * Renvoi les activités liées à ce template et à un utilisateur referent (sauf si l'id vaut false dans ce cas on ne filtre pas)
     * @return void
     */
    function getActivites($idUtilisateurReferent)
    {

        if($idUtilisateurReferent === false)
        {
            // vue dp : pas de filtre
            return $this->hasMany(Activite::class, 'id_template')->getResults();
        }

        return $this->hasMany(Activite::class, 'id_template')->where('id_utilisateur_referent', '=', $idUtilisateurReferent)->getResults();
    }


    use HasFactory;
}
