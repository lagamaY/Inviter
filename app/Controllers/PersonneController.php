<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Personne;

class PersonneController extends BaseController
{
   

    public function getIndex()
    { 
        
        $personne = new Personne();

        // Récupérer toutes les personnes
        $personnes = $personne->findAll();
         // Charger la vue avec les données récupérées
         return view('personnes/liste_personnes_enregistees', ['personnes' => $personnes]);
    }
}
