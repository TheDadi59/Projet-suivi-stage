<?php

namespace App\Http\Controllers\Suivi;

use App\Helpers\IdentificationHelper;
use App\Models\Ent\Utilisateur;
use App\Models\Suivi\Activite;
use App\Models\Suivi\Template;

class ListeStagesController extends BaseController
{
    /**
     * Listing des stages général (point de vue tuteur)
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function listeStages(){

        // Vérification existance session
        $error = IdentificationHelper::identification($this->appli);

        if (empty($error)){
            return view('liste_stages',
                ['menus' => $this->getMenus()]);
        } else {
            return view('error', ['menus' => $this->getMenus(), 'message' => $error]);
        }
    }

    /**
     * Listing des stages (point de vue DP)
     * @return void
     */
    public function listeStagesDP()
    {
        // Vérification existance session
        $error = IdentificationHelper::identification($this->appli);

        if (empty($error)){

            // TODO Securité route : Vérifier que le rôle soit DP

            $listeTemplates = Template::where("id_template_parent", "=", "1")->get();

            return view('liste_stages_dp',
                ['menus' => $this->getMenus(), 'listeTemplates' => $listeTemplates]);
        } else {
            return view('error', ['menus' => $this->getMenus(), 'message' => $error]);
        }
    }
}
