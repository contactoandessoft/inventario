<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->setAutoRoute(true);//

$routes->get('/', 'Login::index');
$routes->post('auth', 'Login::auth');
$routes->get('logout', 'Login::logout');

$routes->get('register', 'usuario::index');
$routes->post('register', 'usuario::create');
$routes->get('password-request', 'usuario::linkrequestform');
$routes->get('password-email', 'usuario::sendresetlinkcorreo');

$routes->get('home', 'Home::index');

$routes->get('obtenerEquipo/(:segment)', 'Formulario::obtenerEquipo/$1');
$routes->get('formulario', 'Formulario::index');
$routes->post('registrar', 'Formulario::registrar');

$routes->get('editarform/(:num)', 'EditarForm::index/$1');
$routes->get('editar/(:num)', 'EditarForm::index/$1');
$routes->post('editar/(:num)', 'EditarForm::actualizar/$1');

$routes->get('editar/(:num)', 'EditarForm::index/$1');
$routes->get('editarresponsable/(:num)', 'EditarResponsable::index/$1');

$routes->get('marcas/eliminar/(:num)', 'Marcas::eliminar/$1');
$routes->get('editarmarca/(:num)', 'EditarMarca::index/$1');
$routes->post('editarmarca/actualizar', 'EditarMarca::actualizar');


/*$routes->get('obtenerEquipo/(:segment)', 'Editar::obtenerEquipo/$1');
$routes->get('editar/index/(:num)', 'Editar::index/$1');
$routes->post('editar/update/(:num)', 'Editar::update/$1');
$routes->post('editar/actualizar', 'Editar::actualizar');*/



