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


        $personnes = $personne->findAll();
      
         
         return view('personnes/liste_personnes_enregistees', ['personnes' => $personnes ]);
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
    try {
         if ($this->request->getMethod() == 'post') {
        $data = [
            'idtypepersonne' => $this->request->getVar('type_personne'),
            'nom' => $this->request->getVar('nom'),
            'prenom' => $this->request->getVar('prenom'),
            'sexe' => $this->request->getVar('sexe'),
            'datenaissance' => $this->request->getVar('date_naissance'),
        ];

        // Add image handling here
        if ($this->request->getFile('photo')) {
            $photo = $this->request->getFile('photo');
            $photoName = time() . '.' . $photo->getClientExtension();
            $photo->move(ROOTPATH . 'public/photos', $photoName);
            $data['photo'] = $photoName;
        } else {
            // Set a default value if no image is uploaded
            $data['photo'] = 'etudiant_photo';
        }

        // Create a new instance of the Personne model and insert data
        $personne = new Personne();
        $personne->insert($data);

        // Fetch all persons from the database
        $personnes = $personne->findAll();
        

        // Load the view with the list of persons
        return view('personnes/liste_personnes_enregistees', ['personnes' => $personnes]);
    } } catch (\Exception $e) {
        
        log_message('error', $e->getMessage());

        $typesPersonne = new TypePersonne();

        // Récupérer les types de personnes
        $typesPersonne = $typesPersonne->findAll();
         // Charger la vue avec les données récupérées
         
         
         return view('personnes/enregistrer_une_personne', ['typesPersonne' => $typesPersonne]);
    }
}





// Suppresion d'une personne dans la bd

public function supprimerPersonne()
{
    $personne = new Personne();

    // Vérifiez si la clé 'id' existe dans la requête
    if ($this->request->getPost('id')) {
        $id = $this->request->getPost('id');

        // Ajoutez une condition WHERE pour spécifier l'ID à supprimer
        $personne->where('id', $id)->delete();

        // Pour le débogage - echo s'affiche dans la console
        echo json_encode(['success' => true, 'message' => 'Personne supprimée avec succès']);
    } else {
        // Gérez le cas où 'id' n'est pas défini, par exemple, en renvoyant une erreur.
        echo json_encode(['success' => false, 'message' => 'ID not provided']);
    }
}


}


