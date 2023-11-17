<?php

use CodeIgniter\Router\RouteCollection;


/**
 * @var RouteCollection $routes
 */


// Affichage de la liste des personnes enregistrées
$routes->get('/', 'PersonneController::getIndex');
$routes->get('/enregistrer-une-personne', 'PersonneController::getRegisterForm', ['as' => 'personnes.create']);
$routes->post('/enregistrer-une-personne', 'PersonneController::store', ['as' => 'personnes.store']);
$routes->post('/supprimer-personne', 'PersonneController::supprimerPersonne', ['as' => 'personnes.delete']);


// $routes->get('/supprimer-personne', 'PersonneController::supprimerPersonne', ['as' => 'personnes.delete']);




