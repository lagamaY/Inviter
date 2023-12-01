<?php

use CodeIgniter\Router\RouteCollection;


/**
 * @var RouteCollection $routes
 */


// Affichage de la liste des personnes enregistrées
$routes->get('/', 'PersonneController::getIndex', ['as' => 'accueil']);
$routes->get('/enregistrer-une-personne', 'PersonneController::getRegisterForm', ['as' => 'personnes.create']);

// Route Enregistrer les personnes avec ajax
$routes->post('/enregistrer-avec-ajax', 'PersonneController::store', ['as' => 'personnes.store']);
// Fin-Enregistrer avec ajax

// Route Enregistrer les personnes avec php
$routes->post('/enregistrer-avec-php', 'PersonneController::enregistrerAvecPhp', ['as' => 'enregistrerAvecPhp']);
// Fin-Enregistrer avec php

$routes->post('/edit-personne', 'PersonneController::editPersonne');

$routes->post('/update-personne', 'PersonneController::updatePersonne');

$routes->post('/supprimer-personne', 'PersonneController::supprimerPersonne', ['as' => 'personnes.delete']);

$routes->get('/liste-personnes', 'PersonneController::getListePersonnesAJour', ['as' => 'liste-personnes-apres-une-mise-a-jour']);






