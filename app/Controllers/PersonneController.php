<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Personne;
use App\Models\TypePersonne;


class PersonneController extends BaseController
{
    
// Affichage de la liste des personnes enregistrées

    public function getIndex()
    { 
        
        $personne = new Personne();

        $typesPersonne = new TypePersonne();

        // Récupérer toutes les personnes
        $personnes = $personne->findAll();

         // Récupérer les types de personnes
         $typesPersonne = $typesPersonne->findAll();

         // Charger la vue avec les données récupérées
        //  return view('personnes/liste_personnes_enregistees');
         
         return view('personnes/liste_personnes_enregistees', ['personnes' => $personnes, 'typesPersonne' => $typesPersonne ]);
    }




// Affichage du formualire d'enregistrement d'une personne
 
    public function getRegisterForm()
    { 
        
        $typesPersonne = new TypePersonne();

        // Récupérer les types de personnes
        $typesPersonne = $typesPersonne->findAll();
         // Charger la vue avec les données récupérées
         
         return view('personnes/enregistrer_une_personne', ['typesPersonne' => $typesPersonne]);
    }




// Stockage des données dans la bd

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

        // Ajoutez la gestion de l'image ici
        if ($this->request->getFile('photo')) {
            $photo = $this->request->getFile('photo');
            $photoName = time() . '.' . $photo->getClientExtension();
            $photo->move(ROOTPATH . 'public/photos', $photoName);
            $data['photo'] = $photoName;
        } else {
            // Définissez une valeur par défaut si aucune image n'est téléchargée
            $data['photo'] = 'etudiant_photo';
        }

        $personne->insert($data);

        return view('personnes/liste_personnes_enregistees');
    }
}

}


