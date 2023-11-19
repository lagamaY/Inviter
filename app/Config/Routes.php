<?php

use CodeIgniter\Router\RouteCollection;


/**
 * @var RouteCollection $routes
 */


// Affichage de la liste des personnes enregistrées
$routes->get('/', 'PersonneController::getIndex', ['as' => 'accueil']);
$routes->get('/enregistrer-une-personne', 'PersonneController::getRegisterForm', ['as' => 'personnes.create']);
$routes->post('/enregistrer-une-personne', 'PersonneController::store', ['as' => 'personnes.store']);

$routes->post('/edit-personne', 'PersonneController::editPersonne');

$routes->post('/supprimer-personne', 'PersonneController::supprimerPersonne', ['as' => 'personnes.delete']);







