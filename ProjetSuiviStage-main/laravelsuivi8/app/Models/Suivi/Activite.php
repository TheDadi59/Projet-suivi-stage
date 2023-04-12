<?php

namespace App\Models\Suivi;

use App\Models\Ent\Utilisateur;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class Activite extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'activite';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_activite';


    /**
     * The database connection that should be used by the model.
     *
     * @var string
     */
    protected $connection = 'suivi';



    public $etatFormate = "Inconnu";

    // 0 : inconnu, 1 : en retard, 2 : jour J, 3 : en avance, 4 : cloture
    public $etat = 0;

    /**
     * Renvoi les activités liées à un référent
     * @param $session
     * @return void
     */
    public static function getActivitesReferent($idUtilisateur)
    {
        return Activite::where("id_utilisateur_referent", "=", $idUtilisateur);
    }


    /**
     * Récupérer le template associé
     */
    public function template(): BelongsTo {
        return $this->belongsTo(Template::class, 'id_template');
    }

    /**
     * Récupérer l'utilisateur suivi associé
     */
    public function utilisateurSuivi(): BelongsTo {
        return $this->belongsTo(Utilisateur::class, 'id_utilisateur_suivi');
    }

    /**
     * Récupérer l'utilisateur référent associé
     */
    public function utilisateurReferent(): BelongsTo {
        return $this->belongsTo(Utilisateur::class, 'id_utilisateur_referent');
    }

    /**
     * Renvoi les valeurs des attributs avec la libelle
     * @return mixed
     */
    public function getValeursAttributsAvecLibelle() {

        // TODO : ajouter un filtre sur les colonnes selectionnnés afin de réduire la taille req

        return ValeurAttribut::join('attribut', 'attribut.id_attribut', '=', 'valeur_attribut.id_attribut')
            ->where('id_activite', '=', $this->id_activite)
            ->get();
    }

    /**
     * Renvoie la valeur d'un attribut de l'activité
     * @param $id_attribut
     * @return ValeurAttribut
     */
    public function valeurAttribut($id_attribut): ValeurAttribut
    {
        return ValeurAttribut::where([['id_activite', '=', $this->id_activite],['id_attribut', '=', $id_attribut]])->first();
    }

    public function formaterDateDebut(){
        //   return Carbon::parse($this->date_debut)->format('l j F o');
        return Carbon::parse($this->date_debut)->format('d/m/o');
    }

    /**
     * Renvoi le Jalon (+ validation jalon si existant) associé à l'ID et au status de l'utilisateur (suivi ou tuteur)
     * Renvoi null si l'id du jalon n'est pas lié au template de l'activité OU si le status de l'utilisateur n'est pas conforme avec celui indiqué dans le jalon
     * @param $idJalon integer
     * @param bool $estUtilisateurSuivi boolean
     * @return mixed
     */
    public function getJalonAvecValidationJalon($idJalon, $estUtilisateurSuivi) {

        return Jalon::leftJoin('validation_jalon', function($join) {
            $join->on('validation_jalon.id_jalon', '=', 'jalon.id_jalon');
            $join->on('validation_jalon.id_activite', '=', DB::raw($this->id_activite));
        })->where('jalon.id_jalon', '=', $idJalon)->where('jalon.id_template', '=', $this->id_template)->where('jalon.pour_utilisateur_suivi', '=',$estUtilisateurSuivi)
            ->select('jalon.*','validation_jalon.date_validation as date_validation','validation_jalon.valide as valide', 'validation_jalon.commentaire as commentaire', 'validation_jalon.id_jalon as validation_id_jalon')
            ->first();
    }

    /**
     * Renvoi la liste des jalons liés au template avec le validation jalon associé (s'il existe)
     * @param bool $estUtilisateurSuivi : Indique si l'on a le point du vue de l'utilisateur suivi ou non (filtre les jalons en conséquence)
     * @param bool $orderByAsc : Ordre de tri
     * @return mixed
     */
    public function getJalonsAvecValidationJalon($estUtilisateurSuivi, $orderByAsc = true)
    {
        return Jalon::leftJoin('validation_jalon', function($join) {
            $join->on('validation_jalon.id_jalon', '=', 'jalon.id_jalon');
            $join->on('validation_jalon.id_activite', '=', DB::raw($this->id_activite));
        })->where('id_template', '=', $this->id_template)->where('pour_utilisateur_suivi', '=', $estUtilisateurSuivi)
            ->orderBy('jalon.echeance', $orderByAsc ? 'asc' : 'desc')
            ->select('jalon.*','validation_jalon.date_validation as date_validation','validation_jalon.valide as valide', 'validation_jalon.commentaire as commentaire', 'validation_jalon.id_jalon as validation_id_jalon')
            ->get();

    }

    /**
     * Renvoi la liste des jalons liés au template avec le validation jalon associé (s'il existe), filtre uniquement ceux qui ne sont pas valide (valide = 0 OU validation jalon inexistant)
     * @param bool $estUtilisateurSuivi : Indique si l'on a le point du vue de l'utilisateur suivi ou non (filtre les jalons en conséquence)
     * @param bool $ignorerUtilisateurSuivi permet d'ignorer le point de vue (tuteur / suivi)
     * @return mixed
     */
    public function getJalonsAvecValidationJalonNonValide($estUtilisateurSuivi, $ignorerUtilisateurSuivi = false)
    {
        // utilisé pour vue dp : on s'en fiche d'être dans le point de vue utilisateur suivi
        if($ignorerUtilisateurSuivi === true)
        {
            return Jalon::leftJoin('validation_jalon', function($join) {
                $join->on('validation_jalon.id_jalon', '=', 'jalon.id_jalon');
                $join->on('validation_jalon.id_activite', '=', DB::raw($this->id_activite));
            })
                ->where('id_template', '=', $this->id_template)
                ->where(function($q) {
                    $q->orWhere('validation_jalon.valide', '!=', 1);
                    $q->orWhereNull('validation_jalon.valide');
                })
                ->orderBy('jalon.echeance', 'asc')
                ->select('jalon.*','validation_jalon.date_validation as date_validation','validation_jalon.valide as valide', 'validation_jalon.commentaire as commentaire', 'validation_jalon.id_jalon as validation_id_jalon') // fix pour éviter que dans le cas où validation jalon null le jalon_id soit overide par null
                ->get();
        }


        return Jalon::leftJoin('validation_jalon', function($join) {
            $join->on('validation_jalon.id_jalon', '=', 'jalon.id_jalon');
            $join->on('validation_jalon.id_activite', '=', DB::raw($this->id_activite));
        })
            ->where('id_template', '=', $this->id_template)
            ->where(function($q) {
                $q->orWhere('validation_jalon.valide', '!=', 1);
                $q->orWhereNull('validation_jalon.valide');
            })
            ->where('pour_utilisateur_suivi', '=', $estUtilisateurSuivi)
            ->orderBy('jalon.echeance', 'asc')
            ->select('jalon.*','validation_jalon.date_validation as date_validation','validation_jalon.valide as valide', 'validation_jalon.commentaire as commentaire', 'validation_jalon.id_jalon as validation_id_jalon') // fix pour éviter que dans le cas où validation jalon null le jalon_id soit overide par null
            ->get();
    }

    /**
     * Renvoi le prochain jalon à valider
     * @param bool $estUtilisateurSuivi : Indique si l'on a le point du vue de l'utilisateur suivi ou non (filtre les jalons en conséquence)
     * @param $listJalonsNonValides : Permet de fournir un tableau de jalons pour économiser la bdd.
     * @param bool $ignorerUtilisateurSuivi permet d'ignorer le point de vue (tuteur / suivi)
     *
     * @return Jalon
     */
    public function getProchainJalon($estUtilisateurSuivi, $listJalonsNonValides = false, $ignorerUtilisateurSuivi = false) {

        // on ne fait une requete que si on a pas le données transmises
        if($listJalonsNonValides === false) {
            $listJalonsNonValides = $this->getJalonsAvecValidationJalonNonValide($estUtilisateurSuivi, $ignorerUtilisateurSuivi);
        }

        // on garde le plus vieux
        $prochainJalon = false;

        // on récupere le jalon théorique le plus proche
        foreach($listJalonsNonValides as $validationJalon) {
            if($prochainJalon === false || $validationJalon->echeance < $prochainJalon->echeance)
            {
                $prochainJalon = $validationJalon;
            }
        }

        return $prochainJalon;
    }

    /**
     * Prépare les attributs pour la vue
     * - etat
     * @return void
     */
    public function majEtat($estUtilisateurSuivi = false, $vueDp = false) {
        if($this->est_cloture)
        {

            $this->etatFormate = "Cloturé";
            $this->etat = 4;
        } else {

            // on verifie si ya des jalons non validés
            $jalonNonValides = $this->getJalonsAvecValidationJalonNonValide($estUtilisateurSuivi, $vueDp);




            if(count($jalonNonValides) > 0)
            {
                // on récupère les jalons associés à nos validation jalons non validés.
                $prochainJalon = $this->getProchainJalon($estUtilisateurSuivi, $jalonNonValides);



                $dateEcheance = Carbon::parse(strtotime($this->date_debut) + $prochainJalon->echeance);

                if($vueDp)
                {
                    $this->destinataireProchaineJalon = $prochainJalon->pour_utilisateur_suivi ? "Etudiant" : "Tuteur";
                    $this->prochainJalonEcheanceFormate = $prochainJalon->formaterDateEcheance($this);

                }

                $dateActuelle = Carbon::now();

                if($dateActuelle->isSameDay($dateEcheance))
                {
                    $this->etat = 2;
                    $this->etatFormate = "Aujourd'hui";

                } else {

                    if($dateActuelle->isAfter($dateEcheance))
                    {

                        $this->etat = 1;

                       $ecart = abs($dateActuelle->diffInDays($dateEcheance));

                        // en retard
                        $this->etatFormate = "En retard de " .$ecart.' jour'.($ecart > 1 ? "s" : "");
                    } else {

                        $this->etat = 3;


                        $ecart = abs($dateActuelle->diffInDays($dateEcheance));

                        // en avance
                        if($this->etatEcart > 14)
                        {
                            $this->etatFormate = "Dans ".round($ecart/7)." semaines";
                        } else {

                            $this->etatFormate = "Dans " .$ecart.' jour'.($ecart > 1 ? "s" : "");
                        }
                    }

                }
            } else {
                $this->etatFormate = "Terminé";
            }
        }
    }



    use HasFactory;
}
