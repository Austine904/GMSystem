<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

// --- Public routes ---
$routes->get('login', 'LoginController::index');
$routes->post('login/auth', 'LoginController::auth');
$routes->get('logout', 'LoginController::logout');
$routes->get('unauthorized', 'DashboardController::unauthorized');



//Add user routes
$routes->get('user/add_step1', 'UsersController::addStep1');
$routes->post('user/add_step1', 'UsersController::add_step1');
// $routes->get('user/getLastId/(:segment)', 'UsersController::getLastId/$1');

$routes->get('user/add_step2', 'UsersController::addStep2');
$routes->post('user/add_step2', 'UsersController::add_step2');

$routes->get('user/add_step3', 'UsersController::addStep3');
$routes->post('user/add_step3', 'UsersController::addUserStep3');
$routes->post('user/addUserStep3', 'UsersController::addUserStep3');

$routes->get('user/preview', 'UsersController::preview');
$routes->get('user/saveUser', 'UsersController::saveUser');

$routes->post('/save-step-data/(:num)', 'UserController::saveStepData/$1');

$routes->post('/final-submit', 'UserController::finalSubmit');

// $routes->get('user/getLastId/(:any)', 'UsersController::getLastId/$1');
$routes->get('user/getLastId', 'UsersController::getLastId');

$routes->get('user/preview', 'UsersController::preview');

$routes->post('user/submit', 'UsersController::submit');

$routes->get('user/success', 'UsersController::success');
$routes->get('user/failure', 'UsersController::failure');

$routes->post('admin/users/bulk_action', 'UsersController::bulk_action');



// --- Protected routes ---
// Admin-only
$routes->group('admin', ['filter' => 'auth:admin'], function ($routes) {
    
    // Dashboard
    $routes->get('/', 'DashboardController::admin');
    $routes->get('dashboard', 'DashboardController::admin');


    // Users
    $routes->get('users', 'UsersController::index');
    $routes->get('users/add', 'UsersController::add');
    $routes->post('users/create', 'UsersController::create');
    $routes->get('users/(:num)', 'UsersController::details/$1');
    $routes->get('users/edit/(:num)', 'UsersController::edit/$1');
    $routes->post('users/update/(:num)', 'UsersController::update/$1');
    $routes->get('users/delete/(:num)', 'UsersController::delete/$1');
    $routes->post('users/bulk_action', 'UsersController::bulk_action');
    $routes->get('users/fetch/(:num)', 'UsersController::details/$1');
    $routes->get('users/fetch', 'UsersController::fetchUsers');
    // $routes->get('users/fetch/(:num)', 'UsersController::fetchUserData/$1');
 

    // Vehicles
    $routes->get('vehicles', 'VehicleController::index');
    $routes->get('vehicles/fetch', 'VehicleController::fetchVehicles');
    $routes->post('vehicles/store', 'VehicleController::store');
    $routes->post('vehicles/update/(:num)', 'VehicleController::update/$1');
    $routes->post('vehicles/delete/(:num)', 'VehicleController::delete/$1');
    $routes->post('admin/vehicles/add', 'VehicleController::add');
    $routes->get('admin/vehicles/edit/(:num)', 'VehicleController::edit/$1');
    $routes->get('admin/vehicles/delete/(:num)', 'VehicleController::delete/$1');
    $routes->get('vehicles/details/(:num)', 'VehicleController::details/$1');


    // Jobs
    $routes->get('jobs', 'JobsController::index');
    $routes->get('jobs/add', 'JobsController::add');
    $routes->post('jobs/create', 'JobsController::create');
    $routes->get('jobs/(:num)', 'JobsController::details/$1');
    $routes->get('jobs/edit/(:num)', 'JobsController::edit/$1');
    $routes->post('jobs/update/(:num)', 'JobsController::update/$1');
    $routes->get('jobs/delete/(:num)', 'JobsController::delete/$1');
    $routes->post('jobs/bulk_action', 'JobsController::bulk_action');
});

// Receptionist-only
$routes->group('receptionist', ['filter' => 'auth:receptionist'], function ($routes) {
    $routes->get('/', 'DashboardController::receptionist');
});

// Mechanic-only
$routes->group('mechanic', ['filter' => 'auth:mechanic'], function ($routes) {
    $routes->get('/', 'DashboardController::mechanic');
});

// Customer-only
$routes->group('customer', ['filter' => 'auth:customer'], function ($routes) {
    $routes->get('/', 'DashboardController::customer');
});
