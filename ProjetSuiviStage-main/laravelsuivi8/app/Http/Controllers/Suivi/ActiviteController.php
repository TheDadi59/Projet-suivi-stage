<?php

namespace App\Http\Controllers\Suivi;

use App\Helpers\IdentificationHelper;
use App\Models\Suivi\Activite;
use App\Models\Suivi\Attribut;
use App\Models\Suivi\ValeurAttribut;

class ActiviteController extends BaseController
{

    /**
     * Controleur pour afifcher le détail d'une activité
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function detailActivite($id){

        // Vérification existance session
        $error = IdentificationHelper::identification($this->appli);

        if (empty($error) && isset($id)){

            $activite = Activite::find($id);

            if(empty($activite))
            {
                return view('error', ['menus' => $this->getMenus(), 'message' => "Cette activité n'existe pas !"]);
            }

            // vérifier que l'utilisateur de la session est bien referant sinon pas accès

            // TODO : Logiquement on pourra donner accès à cette page aussi à l'utilisateur suivi, la pluplart des fonctions ayant été conçues pour gérer cela.

            if($activite->id_utilisateur_referent != session("ID_UTILISATEUR"))
            {
                return view('error', ['menus' => $this->getMenus(), 'message' => "Vous n'avez pas accès à ce contenu !"]);
            }

            // récuperation de ses jalons et tri dans l'ordre d'arrivé
            $collectionJalons= $activite->getJalonsAvecValidationJalon($activite->id_utilisateur_suivi == session("ID_UTILISATEUR"), false);



            // maj de chaque jalon
            foreach ($collectionJalons as $validationJalon){
                $validationJalon->majEtat($activite);
            }

            // joindre valeurs_attributs en fonction de l'id
            $valeurs_attributs = ValeurAttribut::where("id_activite",$id)->get();

            // joindre valeurs_attributs en fonction de l'id
            $attributs = Attribut::all();


            return view('activite', ['menus' => $this->getMenus(), 'activite' => $activite, 'jalons' => $collectionJalons,'attributs'=>$attributs,'valeurs_attributs'=>$valeurs_attributs, 'jalonActif'=> $activite->getProchainJalon($activite->id_utilisateur_suivi == session("ID_UTILISATEUR"))]);


        }
        return view('error', ['menus' => $this->getMenus(), 'message' => $error]);
    }
}
