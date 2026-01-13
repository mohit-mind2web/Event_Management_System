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
    $routes->get('event-approval', 'Admin\EventrequestController::index');
    $routes->get('event-details/(:num)', 'Admin\EventdetailsController::view/$1');
    $routes->get('event-details/approve/(:num)', 'Admin\EventdetailsController::approve/$1');
    $routes->get('event-details/reject/(:num)', 'Admin\EventdetailsController::reject/$1');
    $routes->get('allevents', 'Admin\AlleventsController::index');
    
    // Manage Categories Routes
    $routes->get('manage-categories', 'Admin\ManageCategoriesController::index');
    $routes->post('manage-categories/store', 'Admin\ManageCategoriesController::storeCategory');
    $routes->post('manage-categories/store-subcategory', 'Admin\ManageCategoriesController::storeSubcategory');
    $routes->get('manage-categories/delete/(:num)', 'Admin\ManageCategoriesController::deleteCategory/$1');
    $routes->get('manage-categories/delete-subcategory/(:num)', 'Admin\ManageCategoriesController::deleteSubcategory/$1');
});

$routes->group('organizer', ['filter' => 'group:organizer'], function($routes) {
    $routes->get('dashboard', 'Organizer\DashboardController::index');
    $routes->get('createevent', 'Organizer\CreateeventController::index');
    $routes->get('myevents', 'Organizer\MyEventsController::index');
    $routes->get('events/view/(:num)', 'Organizer\EventDetailsController::view/$1');
    $routes->get('events/edit/(:num)', 'Organizer\EventDetailsController::edit/$1');
});


$routes->group('user', ['filter' => 'group:user'], function($routes) {
    $routes->get('events', 'User\EventsController::index');
    $routes->get('events/view/(:num)', 'User\EventdetailController::view/$1');
    $routes->get('events/register/(:num)', 'User\EventRegistrationController::register/$1');
    $routes->get('events/payment/(:num)', 'User\EventRegistrationController::payment/$1');
    $routes->post('events/process-payment', 'User\EventRegistrationController::processPayment');
    $routes->get('registrations', 'User\MyRegistrationsController::index');
});

$routes->post('api/events', 'Api\EventController::create');
$routes->post('api/events/update/(:num)', 'Api\EventController::update/$1');
$routes->get('api/categories/(:num)/subcategories', 'Api\SubcategoryController::getByCategory/$1');
