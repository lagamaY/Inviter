<?php

use CodeIgniter\Router\RouteCollection;


/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Affichage du formulaire pour enregistrer une nouvelle personne

$routes->get('/enregistrer-une-personne', 'EnregistrerUnePersonne::index');

// Affichage de la liste des personnes enregistrées
$routes->get('/liste-personnes-enregistrees', 'VoirListePersonnesEnregistrees::getIndex');