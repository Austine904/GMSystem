<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

// --- Public routes ---
$routes->get('login', 'LoginController::index');
$routes->post('login/auth', 'LoginController::auth');
$routes->get('logout', 'LoginController::logout');
$routes->get('unauthorized', 'DashboardController::unauthorized');


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
