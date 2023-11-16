<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Personne;
use App\Models\TypePersonne;


class PersonneController extends BaseController
{
    public function __construct()
	{
		helper(['url']);
	}


    public function getIndex()
    { 
        
        $personne = new Personne();

        // Récupérer toutes les personnes
        $personnes = $personne->findAll();

         // Récupérer les types de personnes
         $typesPersonne = $typesPersonne->findAll();

         // Charger la vue avec les données récupérées
         
         return view('personnes/liste_personnes_enregistees', ['personnes' => $personnes, 'typesPersonne' => $typesPersonne ]);
    }


// Affichage du formualire d'enregistrement
 
    public function getRegisterForm()
    { 
        
        $typesPersonne = new TypePersonne();

        // Récupérer les types de personnes
        $typesPersonne = $typesPersonne->findAll();
         // Charger la vue avec les données récupérées
         
         return view('personnes/enregistrer_une_personne', ['typesPersonne' => $typesPersonne]);
    }


// Enregistrement des données dans la bd

    public function store()
	{
		if ($this->request->getMethod() == "post") {

		

				$personne = new Personne();

				$data = [
					"idtypepersonne" => $this->request->getVar("type_personne"),
					"nom" => $this->request->getVar("nom"),
					"prenom" => $this->request->getVar("prenom"),
                    "sexe" => $this->request->getVar("sexe"),
                    "datenaissance" => $this->request->getVar("date_naissance"),
				];

				$personne->insert($data);
					
               
                return redirect()->route('index');
                
				
			
		}
	}
}


