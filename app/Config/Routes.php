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


//Add user routes
$routes->get('user/add_step1', 'UsersController::addStep1');
$routes->post('user/add_step1', 'UsersController::add_step1');
$routes->get('user/getLastId/(:segment)', 'UsersController::getLastId/$1');
 // Handle POST request for Step 1

$routes->get('user/add_step2', 'UsersController::addStep2');
$routes->post('user/add_step2', 'UsersController::add_step2');


$routes->get('user/add_step3', 'UsersController::addStep3');
$routes->post('user/add_step3', 'UsersController::addUserStep3');
$routes->post('user/addUserStep3', 'UsersController::addUserStep3');
// Handle POST request for Step 3

$routes->get('user/preview', 'UsersController::preview');
$routes->get('user/saveUser', 'UsersController::saveUser');



$routes->post('/save-step-data/(:num)', 'UserController::saveStepData/$1');

$routes->post('/final-submit', 'UserController::finalSubmit');

$routes->get('user/getLastId/(:any)', 'UsersController::getLastId/$1');
$routes->get('user/getLastId', 'UsersController::getLastId');

$routes->get('user/preview', 'UsersController::preview');

$routes->post('user/submit', 'UsersController::submit');

$routes->get('user/success', 'UsersController::success');
$routes->get('user/failure', 'UsersController::failure');


