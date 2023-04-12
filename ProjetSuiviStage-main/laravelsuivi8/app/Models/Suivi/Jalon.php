<?php

namespace App\Models\Suivi;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jalon extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'jalon';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_jalon';


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
        'description' => "Description par défaut",
        'echeance' => 0,
        'pour_utilisateur_suivi' => 0,
        'notable' => 0,
    ];



    public function formaterDateEcheance($activite){
        return Carbon::parse(strtotime($activite->date_debut)+$this->echeance)->format('d/m/o');
    }


    /**
     * Renvoi la date de validation formaté, (nécessite les données d'un validationjalon)
     * @return string
     */
    public function formaterDateValidation() {
        return Carbon::parse(strtotime($this->date_validation))->format('d/m/o');
    }


    /**
     * Mise en cache des ressources liés au jalon
     * @var
     */
    public $ressources;

    /**
     * Renvoit les ressources liés à ce jalon
     * @return void
     */
    public function getRessources()
    {
        return LienRessourceJalon::join('ressource', 'ressource.id_ressource', '=', 'ressource_jalon.id_ressource')
            ->where('id_jalon', '=', $this->id_jalon)
            ->get();
    }

    /**
     * Mise à jour de l'état courant du jalon (utilise les attributs liés au modèle validation jalon
     * @param $activite
     * @return void
     */
    public function majEtat($activite)
    {
        $ech = Carbon::parse(strtotime($activite->date_debut) + $this->echeance);
        $aujd = Carbon::now();

        // maj est passe

        $this->etat = 2;

        if($this->valide)
        {
            $this->etatFormate = "Validé";
            $this->etat = 1;
        } else {

            if ($ech->isSameDay($aujd)) {
                $this->etatFormate = "Aujourd'hui";
                $this->etat = 0;
            } else {

                if($aujd->isAfter($ech))
                {
                    $ecart = abs($aujd->diffInDays($ech));

                    // en retard
                    $this->etatFormate = "En retard de " .$ecart.' jour'.($ecart > 1 ? "s" : "");
                    $this->etat = -1;
                } else {

                    $ecart = abs($aujd->diffInDays($ech));

                    // en avance
                    if($ecart > 14)
                    {
                        $this->etatFormate = "Dans ".round($ecart/7)." semaines";
                    } else {

                        if($ecart == 0)
                        {
                            $this->etatFormate = "Demain";
                        } else {
                            $this->etatFormate = "Dans " .$ecart.' jour'.($ecart > 1 ? "s" : "");
                        }
                    }
                }

            }

        }

        if ($ech->isSameDay($aujd)) {

            $this->relativite = 0;

        } else if ($ech->isAfter($aujd)) {
            $this->relativite = 1;
        } else {
            $this->relativite = -1;

        }


        // récuperation des ressources
        $this->ressources = $this->getRessources();


    }
    use HasFactory;
}
