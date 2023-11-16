<?php

use CodeIgniter\Router\RouteCollection;


/**
 * @var RouteCollection $routes
 */


// Affichage de la liste des personnes enregistrées
$routes->get('/liste-personnes-enregistrees', 'PersonneController::getIndex', ['as' => 'index']);
$routes->get('/enregistrer-une-personne', 'PersonneController::getRegisterForm');
$routes->post('/enregistrer-une-personne', 'PersonneController::store', ['as' => 'personnes.store']);