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
});

$routes->group('user', ['filter' => 'group:user'], function($routes) {
    $routes->get('dashboard', 'User\DashboardController::index');
});
