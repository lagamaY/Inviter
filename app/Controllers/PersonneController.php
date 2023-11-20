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
        // Vérifie si la méthode de la requête est 'post'
        if ($this->request->getMethod() == 'post') { 
            // Récupère les données du formulaire
            $data = [
                'idtypepersonne' => $this->request->getVar('type_personne'),
                'nom' => $this->request->getVar('nom'),
                'prenom' => $this->request->getVar('prenom'),
                'sexe' => $this->request->getVar('sexe'),
                'datenaissance' => $this->request->getVar('date_naissance'),
            ];

            // Ajoutez cette condition avant le traitement du fichier
            if (!empty($_FILES['photo']['name'])) {
                // Traitement de l'image
                $photo = $this->request->getFile('photo');
                $photoName = time() . '.' . $photo->getClientExtension();
                $photo->move(ROOTPATH . 'public/photos', $photoName);
                $data['photo'] = $photoName;
            } else {
                // Définit une valeur par défaut si aucune image n'est téléchargée
                $data['photo'] = 'etudiant_photo';
            }

            // Crée une nouvelle instance du modèle Personne et insère les données
            $personne = new Personne();
            $personne->insert($data);

          
            // Redirection vers la route nommée 'accueil'
            return redirect()->to(route_to('accueil'));

        }
    } catch (\Exception $e) {
        // En cas d'erreur, enregistre le message d'erreur
        log_message('error', $e->getMessage());

        // Crée une nouvelle instance du modèle TypePersonne
        $typesPersonne = new TypePersonne();

        // Récupère tous les types de personnes
        $typesPersonne = $typesPersonne->findAll();
        
        // Charge la vue avec les données récupérées
        return view('personnes/enregistrer_une_personne', ['typesPersonne' => $typesPersonne]);
    }
}




// Affichage du formulaire avec les données de la personne souhaitant modifier ces informations

public function editPersonne()
{
    $personne = new Personne();

    // Vérifiez si la clé 'id' existe dans la requête
    if ($this->request->getPost('id')) {
        
        $id = $this->request->getPost('id');

        $personne = $personne->find($id);

        $typesPersonne = new TypePersonne();

        // Récupère tous les types de personnes
        $typesPersonne = $typesPersonne->findAll();
        
        
        $html = view('personnes/edit_personne_enregistree', ['personne' => $personne, 'typesPersonne' => $typesPersonne]);


        // Pour le débogage - echo s'affiche dans la console
        // echo json_encode(['success' => true, $personne]);

        return $this->response->setJSON(['success' => true, 'html' => $html]);
        

    } else {
        // Gérez le cas où 'id' n'est pas défini, par exemple, en renvoyant une erreur.
        echo json_encode(['success' => false, 'message' => 'ID not provided']);
    }
}



// Cette page s'affiche après la mise à jour d'une personne
public function getListePersonnesAJour()
{
    // Récupérez la liste mise à jour des personnes depuis la base de données
    $personnes = $this->personne->findAll(); // Assurez-vous d'adapter cela à votre modèle de personne

    // Chargez la vue correspondante avec les nouvelles données
    return view('personnes/liste_personnes_mis_a_jour', ['personnes' => $personnes]);
}


// Mise à jour des données de la personne dans la BD.

public function updatePersonne()
{
    $personne = new Personne();

    // Vérifiez si la clé 'id' existe dans la requête

    if ($this->request->getPost('id')) {
        
        $id = $this->request->getPost('id');

        $personneTrouve = $personne->find($id);

        if($personneTrouve){

            $data = [
                'idtypepersonne' => $this->request->getVar('type_personne'),
                'nom' => $this->request->getVar('nom'),
                'prenom' => $this->request->getVar('prenom'),
                'sexe' => $this->request->getVar('sexe'),
                'datenaissance' => $this->request->getVar('date_naissance'),
            ];
    
            // !empty($_FILES['photo']['name']) vérifie si l'input de type file a été soumis
            if (!empty($_FILES['photo']['name'])) {
                // Traitement de l'image
                $photo = $this->request->getFile('photo');
                $photoName = time() . '.' . $photo->getClientExtension();
                $photo->move(ROOTPATH . 'public/photosUpdate', $photoName);
                $data['photo'] = $photoName;
            } else {
                // Définit une valeur par défaut si aucune image n'est téléchargée
                $data['photo'] = 'etudiant_photo';
            }
    
                // Crée une nouvelle instance du modèle Personne et insère les données
                
                $personne->update($id, $data);

                // Redirection vers la nouvelle vue de liste après la mise à jour
                return redirect()->to(route_to('liste-personnes-apres-une-mise-a-jour'));
                
    
    
            // Pour le débogage - echo s'affiche dans la console
            //  echo json_encode(['success' => true, $personne]);

        }
 

    } else {
        // Gérez le cas où 'id' n'est pas défini, par exemple, en renvoyant une erreur.
        echo json_encode(['success' => false, 'message' => 'ID non trouvé']);
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


