<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Pages::view/home');
$routes->get('/home', 'Pages::view/home');
$routes->get('/about', 'Pages::view/about');

// ACCOUNTS
// Login
$routes->get('/account/login', 'Login::view/login');
$routes->post('/account/login/request', 'Login::userLoginRequest');
// Sign-up
$routes->get('/account/create', 'Login::view/signup');
$routes->post('/account/create/request', 'Login::userSignUpRequest');
// Logouts
$routes->get('/account/logout', 'Login::logout');

// MEMBERS
// Members portal
$routes->get('/members', 'Members::index');
// Bar
$routes->get('/members/bar', 'Bar::index');

// GOLF
// golf
$routes->get('/golf', 'golf::index');
$routes->get('/golf/booking/', 'golf::booking/redirect'); // Don't allow direct access to /booking
$routes->get('/golf/booking/(:num)', 'golf::booking/$1/GET'); // GET: For editing existing bookings
$routes->post('/golf/booking/(:num)', 'golf::booking/$1/POST'); // POST: For editing existing bookings
$routes->get('/golf/booking/create', 'golf::newBooking/GET'); // For creating a new booking
$routes->post('/golf/booking/create', 'golf::newBooking/POST'); // POST: for adding new booking to the database
$routes->post('/golf/booking/delete', 'golf::deleteBooking'); // POST: to delete bookings

// API
// Get
$routes->get('/api/members/get', 'API::memberGet');
$routes->get('/api/bookings/get', 'API::bookingGet');
$routes->get('/api/bookings/times/getavailable', 'API::timeGet');
$routes->get('/api/member/get/id/(:num)', 'API::memberIdGet/$1');
$routes->get('/api/admin/advancedmemberget/(:num)', 'API::advancedMemberGet/$1');

// ADMINISTRATION
// Admin home
$routes->get('/admin', 'Admin::index');
$routes->get('/admin/users', 'Admin::index/manage_user');
$routes->get('/admin/golf', 'Admin::index/manage_golf');
$routes->post('/admin/golf/removetimeset', 'Admin::removeTime');
$routes->post('/admin/golf/addtimeset', 'Admin::addTime');
$routes->get('/admin/bar', 'Admin::private/manage_bar');

$routes->post('/admin/users', 'Admin::save_usr');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
