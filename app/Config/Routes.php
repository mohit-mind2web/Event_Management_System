<?php

use CodeIgniter\Router\RouteCollection;
use CodeIgniter\Shield\Commands\User;

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
    $routes->get('eventregistrations', 'Admin\EventRegistration::index');
    $routes->get('eventregistrationdetails/(:num)','Admin\EventRegistration::eventregistrationdetails/$1');
    $routes->get('eventregistrationdetails/(:num)/export', 'Admin\EventRegistration::export/$1');
    $routes->get('paymentmonitoring','Admin\PaymentMonitorController::index');
    
    // Manage Categories Routes
    $routes->get('manage-categories', 'Admin\ManageCategoriesController::index');
    $routes->post('manage-categories/store', 'Admin\ManageCategoriesController::storeCategory');
    $routes->post('manage-categories/store-subcategory', 'Admin\ManageCategoriesController::storeSubcategory');
    $routes->get('manage-categories/delete/(:num)', 'Admin\ManageCategoriesController::deleteCategory/$1');
    $routes->get('manage-categories/delete-subcategory/(:num)', 'Admin\ManageCategoriesController::deleteSubcategory/$1');
    
    // Manage Users Routes
    $routes->get('manage-users', 'Admin\ManageUsersController::index');
    $routes->get('manage-users/toggle-status/(:num)', 'Admin\ManageUsersController::toggleStatus/$1');
});

$routes->group('organizer', ['filter' => 'group:organizer'], function($routes) {
    $routes->get('dashboard', 'Organizer\DashboardController::index');
    $routes->get('createevent', 'Organizer\CreateeventController::index');
    $routes->get('myevents', 'Organizer\MyEventsController::index');
    $routes->get('events/view/(:num)', 'Organizer\EventDetailsController::view/$1');
    $routes->get('events/edit/(:num)', 'Organizer\EventDetailsController::edit/$1');
    $routes->get('eventregistrations', 'Organizer\EventRegistrationController::index');
    $routes->get('eventregistrationdetails/(:num)', 'Organizer\EventRegistrationController::eventregistrationdetails/$1');
    $routes->get('eventregistrationdetails/(:num)/export', 'Organizer\EventRegistrationController::exportEventRegistrations/$1');
    $routes->get('profile/(:num)','Organizer\ProfileController::index/$1');
    $routes->post('profile/update/(:num)','Organizer\ProfileController::update/$1');
    
    // QR Code Check-in Routes
    $routes->get('scan-ticket', 'Organizer\EventRegistrationController::scan');
    $routes->post('check-in', 'Organizer\EventRegistrationController::processCheckIn');

});


$routes->group('user', ['filter' => 'group:user'], function($routes) {
    $routes->get('home','User\HomeController::index');
    $routes->get('events', 'User\EventsController::index');
    $routes->get('events/view/(:num)', 'User\EventdetailController::view/$1');
    
    // Registration & Payment Routes
    $routes->get('events/register/(:num)', 'User\EventRegistrationController::register/$1');
    $routes->get('events/summary/(:num)', 'User\EventRegistrationController::summary/$1');
    $routes->post('events/confirm', 'User\EventRegistrationController::confirm');
    $routes->get('ticket/(:num)', 'User\TicketController::index/$1');
    
    $routes->post('payment/checkout', 'User\PaymentController::checkout');
    $routes->get('payment/success', 'User\PaymentController::success');
    $routes->get('payment/cancel', 'User\PaymentController::cancel');

    $routes->get('registrations', 'User\MyRegistrationsController::index');
    $routes->get('payments', 'User\TransactionsController::index');
    $routes->get('profile/(:num)', 'User\ProfileController::index/$1');
    $routes->post('profile/update/(:num)', 'User\ProfileController::update/$1');
});

$routes->post('api/events', 'Api\EventController::create');
$routes->post('api/events/update/(:num)', 'Api\EventController::update/$1');
$routes->get('api/categories/(:num)/subcategories', 'Api\SubcategoryController::getByCategory/$1');
