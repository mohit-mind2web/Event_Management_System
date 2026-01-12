<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Register Route
$routes->get('register', 'Auth\RegisterController::registerView');
$routes->post('register', 'Auth\RegisterController::registerAction');

// Login Routes
$routes->get('login', 'Auth\LoginController::loginView');
$routes->post('login', 'Auth\LoginController::loginAction');
$routes->get('logout', 'Auth\LoginController::logoutAction');

service('auth')->routes($routes);

// Dashboard Routes for Role Verification
$routes->group('admin', ['filter' => 'group:admin,superadmin'], function($routes) {
    $routes->get('dashboard', 'Admin\DashboardController::index');
});

$routes->group('organizer', ['filter' => 'group:organizer'], function($routes) {
    $routes->get('dashboard', 'Organizer\DashboardController::index');
    $routes->get('createevent', 'Organizer\CreateeventController::index');
    $routes->get('myevents', 'Organizer\MyEventsController::index');
    $routes->get('events/view/(:num)', 'Organizer\EventDetailsController::view/$1');
    $routes->get('events/edit/(:num)', 'Organizer\EventDetailsController::edit/$1');
});


$routes->group('user', ['filter' => 'group:user'], function($routes) {
    $routes->get('dashboard', 'User\DashboardController::index');
});

$routes->post('api/events', 'Api\EventController::create');
$routes->post('api/events/update/(:num)', 'Api\EventController::update/$1');
$routes->get('api/categories/(:num)/subcategories', 'Api\SubcategoryController::getByCategory/$1');
