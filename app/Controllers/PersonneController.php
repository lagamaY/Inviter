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

        $personnes = $personne->orderBy('id', 'desc')->findAll();

        // Ajoutez le libellé du type de personne à chaque personne
        foreach ($personnes as $personne) {
            $typePersonne = new TypePersonne(); 
            $typePersonne->idtypepersonne = $personne->idtypepersonne; 
            $personne->libelleTypePersonne = $typePersonne->getLibelle();
        }

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




// Enregistrement d'une personne dans la bd avec Ajax

public function store()
{
    try {
        // Valider les données
        $validation = \Config\Services::validation();

        $validation->setRules([
            'nom' => 'required|min_length[3]|max_length[15]',
            'prenom' => 'required|min_length[3]|max_length[15]',
            'sexe' => 'required|in_list[M,F]',
            'idtypepersonne' => 'required|numeric',
            'datenaissance' => 'required',
        ]);

        // Valider les règles
        if ($validation->withRequest($this->request)->run()) {

            // Crée une nouvelle instance du modèle Personne
            $personne = new Personne();

            // Récupère tous les champs du formulaire en une seule fois
            $data = $this->request->getPost();

            // Ajoutez cette condition avant le traitement du fichier
            if (!empty($_FILES['photo']['name'])) {
                // Traitement de l'image
                $photo = $this->request->getFile('photo');
                $photoName = time() . '.' . $photo->getClientExtension();
                $photo->move(ROOTPATH . 'public/photos', $photoName);
                $data['photo'] = $photoName;
            } else {
                // Définit une valeur par défaut si aucune image n'est téléchargée
                if ($data['idtypepersonne'] == 2) {
                    return $this->response->setJSON(['error' => true, 'messages' => $personne->errors()]);
                } else {
                    $data['photo'] = 'etudiant_photo';
                }
            }

            // Insertion des données si la validation réussit
            $personne->insert($data);

            // Redirection 

            $typesPersonne = new TypePersonne();

            // Récupérer les types de personnes
            $typesPersonneList = $typesPersonne->findAll();

            // Charger la vue avec les données récupérées
            $html = view('personnes/enregistrer_une_personne', ['typesPersonne' => $typesPersonneList]);

            return $this->response->setJSON(['success' => true, 'html' => $html, 'message' => 'ENREGISTREMENT EFFECTUE AVEC SUCCES']);
        } else {
            // En cas d'échec de la validation, renvoyer les erreurs
            return $this->response->setJSON(['error' => true, 'messages' => $validation->getErrors()]);
        }
    } catch (\Exception $e) {
        // En cas d'erreur, enregistre le message d'erreur
        log_message('error', $e->getMessage());

        // Crée une nouvelle instance du modèle TypePersonne
        $typesPersonne = new TypePersonne();

        // Récupère tous les types de personnes
        $typesPersonneList = $typesPersonne->findAll();

        // Charge la vue avec les données récupérées
        return view('personnes/enregistrer_une_personne', ['typesPersonne' => $typesPersonneList]);
    }
}






public function enregistrerAvecPhp()
{
    try {
        // Valider les données
        $validation = \Config\Services::validation();

        $validation->setRules([
            'nom' => 'required|min_length[3]|max_length[15]',
            'prenom' => 'required|min_length[3]|max_length[15]',
            'sexe' => 'required|in_list[M,F]',
            'idtypepersonne' => 'required|numeric',
            'datenaissance' => 'required',
        ], [
            'nom' => [
                'required' => 'Champ obligatoire avec 3 caractères au moins et 15 au plus.',
            ],
            'prenom' => [
                'required' => 'Champ obligatoire avec 3 caractères au moins et 15 au plus.',
            ],
            'sexe' => [
                'required' => 'Veuillez sélectionner le sexe.',
            ],
            'idtypepersonne' => [
                'required' => 'Veuillez sélectionner le type de personne.',
            ],
            'datenaissance' => [
                'required' => 'Le champ date de naissance est obligatoire.',
            ],
        ]);

        // Vérifie si la méthode de la requête est 'post'
        if ($this->request->getMethod() == 'post') {

            // Récupère tous les champs du formulaire en une seule fois
            $data = $this->request->getPost();

            // Valider les règles
            if ($validation->withRequest($this->request)->run()) {

                // Traitement de l'image
                if (!empty($_FILES['photo']['name'])) {
                    $photo = $this->request->getFile('photo');
                    $photoName = time() . '.' . $photo->getClientExtension();
                    $photo->move(ROOTPATH . 'public/photos', $photoName);
                    $data['photo'] = $photoName;
                } else {
                    $data['photo'] = 'etudiant_photo';
                }

                // Crée une nouvelle instance du modèle Personne et insère les données
                $personne = new Personne();
                $personne->insert($data);

                // Redirigez après l'enregistrement
                return redirect()->to(route_to('accueil'))->with('success', 'ENREGISTREMENT EFFECTUE AVEC SUCCES');
            } else {
                // Charge la vue avec les données récupérées
                return $this->afficherFormulaire($validation);
            }
        }
    } catch (\Exception $e) {
        // En cas d'erreur, enregistre le message d'erreur dans le journal des erreurs
        log_message('error', $e->getMessage());

        // Charge la vue avec les données récupérées
        return $this->afficherFormulaire($validation);
    }
}

private function afficherFormulaire($validation)
{
    // Crée une nouvelle instance du modèle TypePersonne
    $typesPersonne = new TypePersonne();

    // Récupère tous les types de personnes
    $typesPersonne = $typesPersonne->findAll();

    // Charge la vue avec les données récupérées
    return view('personnes/enregistrer_une_personne', ['typesPersonne' => $typesPersonne, 'errors' => $validation->getErrors()]);

}







// Affichage du formulaire avec les données de la personne souhaitant modifier ces informations

public function editPersonne()
{
    $personne = new Personne();

    // Vérifiez si la clé 'id' existe dans la requête
    if ($this->request->getPost('id')) {
        
        $id = $this->request->getPost('id');

        $personne = $personne->find($id);

        $typePersonne = new TypePersonne();

        // Récupère tous les types de personnes
        $typesPersonne = $typePersonne->findAll();
        
        // Récupère le type assoscié à chaque personne
            
         $typePersonne->idtypepersonne = $personne->idtypepersonne; 

         $personne->libelleTypePersonne = $typePersonne->getLibelle();
        
        
        $html = view('personnes/edit_personne_enregistree', ['personne' => $personne, 'typesPersonne' => $typesPersonne]);


        // Pour le débogage - echo s'affiche dans la console
        // echo json_encode( $personne);

        return $this->response->setJSON(['success' => true, 'html' => $html]);
        

    } else {
        // Gérez le cas où 'id' n'est pas défini, par exemple, en renvoyant une erreur.
        echo json_encode(['success' => false, 'message' => 'ID not provided']);
    }
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
                'idtypepersonne' => $this->request->getPost('type_personne'),
                'nom' => $this->request->getPost('nom'),
                'prenom' => $this->request->getPost('prenom'),
                'sexe' => $this->request->getPost('sexe'),
                'datenaissance' => $this->request->getPost('date_naissance'),
            ];

    
             // Vérifiez si l'input photo est présent

            if (!empty($_FILES['photo']['name'])) {

                $photo = $this->request->getFile('photo');
            
                if ($photo->isValid() && !$photo->hasMoved()) {
                    $photoName = time() . '.' . $photo->getClientExtension();
                    $photo->move(ROOTPATH . 'public/photos', $photoName);
                    $data['photo'] = $photoName;
                } 
            } else {

                if($this->request->getVar('type_personne') == 1){

                    $data['photo'] = 'etudiant_photo';

                }  
            }

            // Vérifie s'il existe des règles de validation dans le modèle
            if (!empty($personne->validationRules)) {
                
                if (!$personne->validate($data)) {
                    // Si la validation échoue, renvoie les erreurs au client
                    return $this->response->setJSON(['error' => true, 'messages' => $personne->errors()]);
                }else {

               // Mise à jour des données
                
                $personne->update($id, $data);

                
                // Vérifiez s'il y a une ancienne photo à supprimer
                if ($personneTrouve->photo !== 'etudiant_photo') {

                    $oldPhotoPath = FCPATH . 'public/photos/' . $personneTrouve->photo;
                    
                    if (file_exists($oldPhotoPath)) {

                        unlink($oldPhotoPath); 
                    }
                }

                // Page à retourner 

                $personnes = $personne->findAll();
                // Ajoutez le libellé du type de personne à chaque personne
                foreach ($personnes as $personne) {
                    $typePersonne = new TypePersonne(); 
                    $typePersonne->idtypepersonne = $personne->idtypepersonne; 
                    $personne->libelleTypePersonne = $typePersonne->getLibelle();
                }
        
                       
                    $html = view('personnes/liste_personnes_enregistees', ['personnes' => $personnes ]);


                    return $this->response->setJSON(['success' => true, 'html' => $html, 'message' => 'Modification effectuée avec succès !']);
                 }
            }
            

            
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

        // Vérifiez d'abord si l'enregistrement existe
        $existingRecord = $personne->find($id);

        if ($existingRecord) {

            // Vérifiez s'il y a une ancienne photo à supprimer
            if ($existingRecord->photo !== 'etudiant_photo') {

                $oldPhotoPath = FCPATH . 'public/photos/' . $existingRecord->photo;
                
                if (file_exists($oldPhotoPath)) {

                    unlink($oldPhotoPath); 
                }
            }
            // L'enregistrement existe, vous pouvez maintenant le supprimer logiquement
            $affectedRows = $personne->delete(['id' => $id]);

            if ($affectedRows > 0) {
                // Suppression logique réussie
                return $this->response->setJSON(['success' => true, 'message' => 'Personne supprimée avec succès']);
            } else {
                // Aucune suppression logique n'a été effectuée
                return $this->response->setJSON(['success' => false, 'message' => 'Aucune personne trouvée pour l\'ID fourni']);
            }
        } else {
            // Aucun enregistrement trouvé pour l'ID fourni
            return $this->response->setJSON(['success' => false, 'message' => 'Aucune personne trouvée pour l\'ID fourni']);
        }
    } else {
        // Gérez le cas où 'id' n'est pas défini, par exemple, en renvoyant une erreur.
        echo json_encode(['success' => false, 'message' => 'ID not provided']);
    }
}





}


