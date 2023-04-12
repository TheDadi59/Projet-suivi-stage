<?php

namespace App\Http\Controllers\Suivi;

use Illuminate\Routing\Controller;

class BaseController extends Controller
{
    public function __construct(){
        $this->appli = '4';
    }

    public function getMenus(){
        return session("MENU_".$this->appli);
    }
}
