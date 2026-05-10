<?php

namespace Config;

$routes = Services::routes();

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Auth');
$routes->setDefaultMethod('index');

// ============================================
// ADMIN AUTH ROUTES
// ============================================
$routes->get('/', 'Auth::index');
$routes->get('/login', 'Auth::login');
$routes->post('/auth/doLogin', 'Auth::doLogin');
$routes->get('/register', 'Auth::register');
$routes->post('/auth/doRegister', 'Auth::doRegister');
$routes->get('/logout', 'Auth::logout');

// ============================================
// CUSTOMER ROUTES
// ============================================
$routes->get('/customer', 'CustomerAuth::login');
$routes->get('/customer/login', 'CustomerAuth::login');
$routes->get('/customer/register', 'CustomerAuth::register');
$routes->post('/customer/auth/doLogin', 'CustomerAuth::doLogin');
$routes->post('/customer/auth/doRegister', 'CustomerAuth::doRegister');
$routes->get('/customer/logout', 'CustomerAuth::logout');

$routes->get('/customer/store', 'CustomerStore::index');
$routes->get('/customer/products', 'CustomerStore::products');
$routes->get('/customer/productDetail/(:num)', 'CustomerStore::productDetail/$1');
$routes->get('/customer/track-order', 'CustomerStore::trackOrder');
$routes->get('/customer/order/(:any)', 'CustomerStore::viewOrder/$1');
$routes->post('/customer/placeOrder', 'CustomerStore::placeOrder');
$routes->get('/customer/account', 'CustomerAuth::myAccount');
$routes->get('/customer/dashboard', 'CustomerAuth::dashboard');

// ============================================
// RIDER ROUTES - MAKE SURE THESE EXIST
// ============================================
$routes->get('/rider', 'Rider::login');
$routes->get('/rider/login', 'Rider::login');
$routes->post('/rider/doLogin', 'Rider::doLogin');
$routes->get('/rider/register', 'Rider::register');          // THIS MUST EXIST
$routes->post('/rider/doRegister', 'Rider::doRegister');     // THIS MUST EXIST
$routes->get('/rider/dashboard', 'Rider::dashboard');
$routes->get('/rider/acceptOrder/(:num)', 'Rider::acceptOrder/$1');
$routes->get('/rider/deliverOrder/(:num)', 'Rider::deliverOrder/$1');
$routes->post('/rider/processDelivery', 'Rider::processDelivery');
$routes->get('/rider/order/(:num)', 'Rider::viewOrder/$1');
$routes->get('/rider/logout', 'Rider::logout');

// ============================================
// ADMIN PROTECTED ROUTES
// ============================================
$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('/dashboard', 'Dashboard::index');
    $routes->get('/pos', 'Pos::index');
    $routes->post('/pos/processOrder', 'Pos::processOrder');
    $routes->get('/products', 'Product::index');
    $routes->get('/product/add', 'Product::create');
    $routes->post('/product/save', 'Product::store');
    $routes->get('/product/edit/(:num)', 'Product::edit/$1');
    $routes->post('/product/update/(:num)', 'Product::update/$1');
    $routes->get('/product/delete/(:num)', 'Product::delete/$1');
    $routes->get('/categories', 'Category::index');
    $routes->get('/category/add', 'Category::create');
    $routes->post('/category/save', 'Category::store');
    $routes->get('/category/edit/(:num)', 'Category::edit/$1');
    $routes->post('/category/update/(:num)', 'Category::update/$1');
    $routes->get('/category/delete/(:num)', 'Category::delete/$1');
    $routes->get('/orders', 'Order::index');
    $routes->get('/order/create', 'Order::create');
    $routes->post('/order/store', 'Order::store');
    $routes->get('/order/view/(:num)', 'Order::view/$1');
    $routes->get('/order/delete/(:num)', 'Order::delete/$1');
    
    // Order Confirmation Routes
    $routes->get('/order-confirmation/pending', 'OrderConfirmation::pending');
    $routes->get('/order-confirmation/preparing', 'OrderConfirmation::preparing');
    $routes->get('/order-confirmation/ready', 'OrderConfirmation::ready');
    $routes->get('/order-confirmation/completed', 'OrderConfirmation::completed');
    $routes->get('/order-confirmation/confirm/(:num)', 'OrderConfirmation::confirm/$1');
    $routes->get('/order-confirmation/markReady/(:num)', 'OrderConfirmation::markReady/$1');
    $routes->get('/order-confirmation/markReadyForRider/(:num)', 'OrderConfirmation::markReadyForRider/$1');
    $routes->get('/order-confirmation/markCompleted/(:num)', 'OrderConfirmation::markCompleted/$1');
    $routes->get('/order-confirmation/cancel/(:num)', 'OrderConfirmation::cancel/$1');
    $routes->get('/order-confirmation/view/(:num)', 'OrderConfirmation::view/$1');
    
    // Notification Routes
    $routes->get('/notifications', 'Notification::index');
    $routes->get('/notifications/markRead/(:num)', 'Notification::markRead/$1');
    $routes->get('/notifications/markAllRead', 'Notification::markAllRead');
    $routes->get('/notifications/getUnreadCount', 'Notification::getUnreadCount');
});