<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class VoirListePersonnesEnregistrees extends BaseController
{
    public function getIndex()
    { 
        // Affiche la liste_personnes_enregistees

         return view('liste_personnes_enregistees');
    }
}
