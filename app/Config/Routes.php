<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('login', 'LoginController::index');
$routes->post('login/auth', 'LoginController::auth');
$routes->get('logout', 'LoginController::logout');


//Dashhboard routes
$routes->get('admin', 'DashboardController::admin');
$routes->get('mechanic', 'DashboardController::mechanic');
$routes->get('receptionist', 'DashboardController::receptionist');
$routes->get('customer', 'DashboardController::customer');


//users dashboard routes
$routes->get('admin/users', 'UsersController::index');
$routes->get('admin/users/add', 'UsersController::add');
$routes->post('admin/users/create', 'UsersController::create');
$routes->get('admin/users/edit/(:num)', 'UsersController::edit/$1');
$routes->post('admin/users/update/(:num)', 'UsersController::update/$1');
$routes->get('admin/users/delete/(:num)', 'UsersController::delete/$1');
$routes->get('admin/users/details/(:num)', 'UsersController::details/$1');


//Admin dashboard routes
$routes->get('admin/dashboard', 'AdminDashboard::index');



$routes->get('user/step1', 'UsersController::addUserStep1'); // Step 1 view
$routes->post('user/step1', 'UsersController::addUserStep1'); // Handle POST request for Step 1


// $routes->post('user/add_step2', 'UsersController::add_step2'); // Handle POST request for Step 2
$routes->get('user/add_step3', 'UsersController::add_step3');

$routes->post('user/add_step3', 'UsersController::add_step3');
$routes->get('user/preview', 'UsersController::preview');

$routes->post('user/submit', 'UsersController::submit');

// $routes->post('user/add_step1', 'UsersController::addStep1');
$routes->get('user/step2', 'UsersController::add_step2'); // Step 2 view


$routes->get('user/step3', 'UsersController::addUserStep3'); // Step 3 view
$routes->post('user/step3', 'UsersController::add_step3');   // Handle POST request for Step 3
