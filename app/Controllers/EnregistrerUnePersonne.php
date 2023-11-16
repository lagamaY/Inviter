<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Controller;


class EnregistrerUnePersonne extends BaseController
{
    public function index()
    {
        // Retourne la page qui affiche le formulaire pour enregistrer une personne

         return view('enregistrer_une_personne');
       
    }
}
