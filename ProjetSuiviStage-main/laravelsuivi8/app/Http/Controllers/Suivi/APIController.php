<?php

namespace App\Http\Controllers\Suivi;

use App\Helpers\IdentificationHelper;
use App\Models\Suivi\Activite;
use App\Models\Suivi\FichierValidationJalon;
use App\Models\Suivi\Template;
use App\Models\Suivi\ValidationJalon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class APIController extends BaseController
{

    /**
     * Liste des extensions autorisées pour l'upload des fichiers de jalons
     */
    const EXTENSIONS_AUTORISES = array("txt", "doc", "docx", "pdf", "xls", "png", "jpg", "jpeg", "odt");


    /**
     * Route API pour valider un jalon
     * @return void
     */
    public function postValiderJalon(Request $request) {

        $error = IdentificationHelper::identification($this->appli);

        if (empty($error)){

            $idActivite = $request->input("id_activite");
            $idJalon = $request->input("id_jalon");

            // TODO CSRF

            if(empty($idActivite) || empty($idJalon))
            {
                return response(json_encode(array(
                    "success" => false,
                    "message" => "Il manque les champs id_jalon et id_activite."
                )));
            }

            $activite = Activite::find($idActivite);

            if(empty($activite))
            {
                return response(json_encode(array(
                    "success" => false,
                    "message" => "Activité inconnue."
                )));
            }

            // vérifier que l'utilisateur de la session est bien referant OU suivi sinon pas accès
            if($activite->id_utilisateur_referent != session("ID_UTILISATEUR") && $activite->id_utilisateur_suivi != session("ID_UTILISATEUR"))
            {
                return response(json_encode(array(
                    "success" => false,
                    "message" => "Vous n'avez pas accès à ce contenu"
                )));
            }

            // indique s'il s'agit d'un utilisateur suivi (true) ou tuteur (false)
            $estUtilisateurSuivi = $activite->id_utilisateur_suivi == session("ID_UTILISATEUR");


            // vérification du jalon
            $jalon = $activite->getJalonAvecValidationJalon($idJalon, $estUtilisateurSuivi);

            // n'a pas accès / n'est pas cohérent par rapport au template
            if(!isset($jalon))
            {
                return response(json_encode(array(
                    "success" => false,
                    "message" => "Ce jalon n'est pas valide !"
                )));
            }

            // si déjà validé on bloque TODO : à modifier pour permettre modification
            if($jalon->valide)
            {
                return response(json_encode(array(
                    "success" => false,
                    "message" => "Ce jalon est déjà validé !"
                )));
            }

            // vérifications des paramètres : message, date, nombreFichiers, fichier-x

            $rawMessage = $request->input('message');
            $rawDate = $request->input('date');

            if(empty($rawMessage) || empty($rawDate))
            {
                return response(json_encode(array(
                    "success" => false,
                    "message" => "Les champs message et date sont requis."
                )));
            }

            if(strlen($rawMessage) > 8000)
            {
                return response(json_encode(array(
                    "success" => false,
                    "message" => "Le message doit faire moins de 8000 caractères."
                )));
            }



            if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$rawDate)) {
                return response(json_encode(array(
                    "success" => false,
                    "message" => "Le format de la date n'est pas correct."
                )));
            }
            $date = Carbon::parse(strtotime($rawDate));


            // vérification des fichiers
            $fichiers = $request->allFiles();

            if(count($fichiers) > env("NOMBRE_MAX_FICHIERS"))
            {
                return response(json_encode(array(
                    "success" => false,
                    "message" => "Vous ne pouvez pas joindre plus de 10 fichiers."
                )));
            }

            // TODO : Si les modifications sont autorisés, il faudra vérifier existance de fichiers et faire le ménage

            // vérification taille et extension
            foreach($fichiers as $fichier)
            {
                if($fichier->getSize() > env("TAILLE_MAX_FICHIER"))
                {
                    return response(json_encode(array(
                        "success" => false,
                        "message" => "La taille maximale pour un fichier est de ".(env("TAILLE_MAX_FICHIER")/1000/1000).' mo.'
                    )));
                }

                if(!in_array($fichier->extension(), self::EXTENSIONS_AUTORISES))
                {
                    return response(
                        json_encode(
                            array(
                        "success" => false,
                        "message" => 'Seules les extensions suivantes sont autorisés : '.join(', ', self::EXTENSIONS_AUTORISES )
                        )
                        )
                    );
                }

            }

            // stockage des fichiers
            $index = 1;

            $nomDossier = $activite->template->libelle;
            $utilisateurSuivi = $activite->utilisateurSuivi;

            if(empty($utilisateurSuivi))
            {
                return response(json_encode(array(
                    "success" => false,
                    "message" => "Impossible de récupérer l'utilisateur suivi."
                )));
            }

            /**
             * Configuration du nom du fichier sur le serveur
             *
             * Nom Prénom - Nom du jalon
             */
            $baseNomFichier = $utilisateurSuivi->lib_nom.' '.$utilisateurSuivi->lib_prenom.' - '.$jalon->libelle.' ';

            foreach($fichiers as $fichier)
            {
                // <baseNomFichier> <1-n>.ext
                $nomFichierServeur = $baseNomFichier.' '.$index.'.'.$fichier->extension();

                Storage::disk('fichiers_jalons')->putFileAs(
                    $nomDossier, $fichier, $nomFichierServeur
                );

                // localisation au sein du storage (sous dossier/fichier.extension)
                $localisation = $nomDossier.'/'.$nomFichierServeur;

                // ajouter dans bdd

                $fichierValidationJalon = new FichierValidationJalon();
                $fichierValidationJalon->id_activite = $idActivite;
                $fichierValidationJalon->id_jalon = $idJalon;
                $fichierValidationJalon->nom_original = $fichier->getClientOriginalName();
                $fichierValidationJalon->taille = $fichier->getSize();
                $fichierValidationJalon->date_upload = Carbon::now()->toDateTimeString();
                $fichierValidationJalon->localisation = $localisation;

                $fichierValidationJalon->save();

                $index++;
            }

            // mise à jour / ajout du confirmation jalon



            if(isset($jalon->validation_id_jalon))
            {
                // exste déjà : update
                //var_dump("OKKKK");
                ValidationJalon::where("id_activite", '=', $idActivite)->where("id_jalon", '=', $idJalon)->update([

                    'date_validation' => $date->toDateTimeString(),
                    'valide' => true,
                    'commentaire' => $rawMessage
                ]);

                return response(json_encode(array(
                    "success" => true,
                    "message" => "OK Validation jalon modifié"
                )));
            } else {
                //var_dump("KKKKK");
                // ajout
                ValidationJalon::insert(

                    ['id_activite' => $idActivite,
                        'id_jalon' => $idJalon,
                        'date_validation' => $date->toDateString(),
                        'valide' => true,
                        'commentaire' => $rawMessage]

                );




                return response(json_encode(array(
                    "success" => true,
                    "message" => "OK Validation jalon ajouté"
                )));
            }




        } else {
            return response(json_encode(array(
                "success" => false,
                "message" => "Authentification invalide"
            )));
        }
    }

    /**
     * Renvoi le JSON pour le datatable de la page suivi
     * @param $idTemplateParent
     * @return void
     */
    public function getListeActivite(Request $request, $idTemplateParent){

        $error = IdentificationHelper::identification($this->appli);

        if (empty($error)){

            // demande vue dp, vérifier perm
            if($request->has("vueDp"))
            {
                // TODO Securité route : Vérifier que le rôle soit DP
                //if( est pas dp )
                //{
                    // erreur
                    // return
                //}


            }


            // TODO : vérifier contenu variable $idTemplateParent

            $listeTemplates = Template::getTemplatesEnfant($idTemplateParent);

            $listeActivites = array();

            $vueDp = $request->has("vueDp");

            foreach($listeTemplates as $template)
            {
                foreach($template->getActivites($vueDp ? false : session("ID_UTILISATEUR")) as $activite)
                {

                    $activite->majEtat($activite->id_utilisateur_suivi == session("ID_UTILISATEUR"), $vueDp);

                    $utilisateurSuivi = $activite->utilisateurSuivi;


                    // ajouter le get etat et etat formate

                    $jsonActivite = array(

                        "id_activite" => $activite->id_activite,
                        "libelle_template" => $template->libelle,
                        "utilisateur_lie" => $utilisateurSuivi->lib_prenom.' '.$utilisateurSuivi->lib_nom,
                        "date_debut" => $activite->formaterDateDebut(),
                        "etat" => $activite->etat,
                        "etat_formate" => $activite->etatFormate,

                        "attributs" => array()
                    );



                    if($vueDp)
                    {
                        // ajouter infos tuteur
                        $utilisateurReferent = $activite->utilisateurReferent;

                        $jsonActivite["utilisateur_referent"] = $utilisateurReferent->lib_prenom.' '.$utilisateurReferent->lib_nom;

                        if($activite->etat != 4) {
                            $jsonActivite["date_prochain_jalon"] = $activite->prochainJalonEcheanceFormate;
                            $jsonActivite["destinataire_prochain_jalon"] = $activite->destinataireProchaineJalon;

                        } else {
                            $jsonActivite["date_prochain_jalon"] = "-";
                            $jsonActivite["destinataire_prochain_jalon"] = "-";
                        }
                    }

                    foreach($activite->getValeursAttributsAvecLibelle() as $attribut)
                    {
                        $jsonActivite["attributs"][$attribut->id_attribut] = array(
                            "libelle" => $attribut->libelle,
                            "valeur" => $attribut->valeur
                        );
                    }

                    array_push($listeActivites, $jsonActivite);
                }
            }

            echo json_encode(array("data" => $listeActivites));

        } else {
            echo json_encode(array(
               "success" => false,
               "message" => "Authentification invalide"
            ));

        }
    }
}
