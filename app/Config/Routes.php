<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');


$routes->get('/', 'Dashboard::index', ['filter'=>'auth']);
$routes->get('/dashboard/gross_amount_monthly', 'Dashboard::gross_amount_monthly', ['filter'=>'auth']);
$routes->post('/dashboard/gross_amount_monthly', 'Dashboard::gross_amount_monthly', ['filter'=>'auth']);
$routes->get('/dashboard/status_percentage', 'Dashboard::status_percentage', ['filter'=>'auth']);
$routes->post('/dashboard/status_percentage', 'Dashboard::status_percentage', ['filter'=>'auth']);
$routes->get('no-access', 'AuthController::noAccess');
$routes->get('user', 'Users::index', ['filter' => 'auth']);
$routes->get('user/edit/(:num)', 'Users::edit/$1', ['filter' => 'auth']);
$routes->post('user/update/(:num)', 'Users::update/$1', ['filter' => 'auth']);
$routes->get('user/new', 'Users::new', ['filter' => 'auth']);
$routes->post('user/register', 'Users::register_user', ['filter' => 'auth']);
$routes->get('user/assign/(:num)/(:alpha)', 'Users::assignRole/$1/$2', ['filter' => 'auth']);
$routes->post('user/update_seller_buyer/(:num)', 'Users::update_seller_buyer/$1', ['filter' => 'auth']);
$routes->get('user/lists', 'Users::lists', ['filter' => 'auth']);
$routes->post('user/lists', 'Users::lists', ['filter' => 'auth']);
$routes->get('user/profile', 'Users::profile', ['filter' => 'auth']);
$routes->post('user/updateprofilepassword', 'Users::edit_profile_password', ['filter' => 'auth']);
$routes->get('seller', 'Seller::index', ['filter' => 'auth']);
$routes->get('seller/add', 'Seller::add', ['filter' => 'auth']);
$routes->post('seller/store', 'Seller::store', ['filter' => 'auth']);
$routes->get('seller/edit/(:num)', 'Seller::edit/$1', ['filter' => 'auth']);
$routes->post('seller/update/(:num)', 'Seller::update/$1', ['filter' => 'auth']);
$routes->get('seller/lists', 'Seller::lists', ['filter' => 'auth']);
$routes->get('buyer', 'Buyer::index', ['filter' => 'auth']);
$routes->get('buyer/add', 'Buyer::add', ['filter' => 'auth']);
$routes->post('buyer/store', 'Buyer::store', ['filter' => 'auth']);
$routes->get('buyer/edit/(:num)', 'Buyer::edit/$1', ['filter' => 'auth']);
$routes->post('buyer/update/(:num)', 'Buyer::update/$1', ['filter' => 'auth']);
$routes->get('buyer/lists', 'Buyer::lists', ['filter' => 'auth']);
$routes->get('factoring', 'Factoring::index', ['filter' => 'auth']);
$routes->get('factoring/create', 'Factoring::create', ['filter' => 'auth']);
$routes->get('factoring/edit/(:num)', 'Factoring::edit/$1', ['filter' => 'auth']);
$routes->get('factoring/update/(:num)', 'Factoring::update/$1', ['filter' => 'auth']);
$routes->get('factoring/lists', 'Factoring::lists', ['filter' => 'auth']);
$routes->post('factoring/lists', 'Factoring::lists', ['filter' => 'auth']);
$routes->post('factoring/store', 'Factoring::store', ['filter' => 'auth']);
$routes->post('factoring/update/(:num)', 'Factoring::update/$1', ['filter' => 'auth']);
$routes->post('factoringitem/store/(:num)', 'FactoringItem::store/$1', ['filter' => 'auth']);
$routes->post('buyeraddress/store/(:num)', 'BuyerAddress::store/$1', ['filter' => 'auth']);
$routes->post('buyerrepresentative/store/(:num)', 'BuyerRepresentative::store/$1', ['filter' => 'auth']);
$routes->post('sellerbuyer/store/(:num)', 'SellerBuyer::store/$1', ['filter' => 'auth']);
$routes->post('file/upload/(:num)/(:any)/(:any)', 'FileUpload::upload/$1/$2/$3', ['filter' => 'auth']);
$routes->get('factoring/upload/(:num)', 'Factoring::upload/$1', ['filter' => 'auth']);


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