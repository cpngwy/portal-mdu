<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');

$routes->get('/', 'Dashboard::index', ['filter'=>'auth']);
$routes->get('no-access', 'AuthController::noAccess');
$routes->get('admin/users', 'Users::index', ['filter' => 'auth']);
$routes->get('admin/users/assign/(:num)/(:alpha)', 'Users::assignRole/$1/$2', ['filter' => 'auth']);

service('auth')->routes($routes);
/**
 * Customizing Routes
 * If you need to customize how any of the auth features are handled, you can still use the service('auth')->routes() helper, but you will need to pass the except option with a list of routes to customize:
 * 
 * service('auth')->routes($routes, ['except' => ['login', 'register']]);
 * Then add the routes to your customized controllers:
 * 
 * 
 * $routes->get('login', '\App\Controllers\Auth\LoginController::loginView');
 * $routes->get('register', '\App\Controllers\Auth\RegisterController::registerView')
 */
// service('auth')->routes($routes, ['except' => ['login', 'register']]);
// $routes->get('login', '\App\Controllers\Auth\LoginController::loginView');
// $routes->get('register', '\App\Controllers\Auth\RegisterController::registerView');