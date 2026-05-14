<?php

namespace Config;

$routes = Services::routes();

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Auth');
$routes->setDefaultMethod('index');

// ============================================
// ADMIN AUTH ROUTES (Public)
// ============================================
$routes->get('/', 'Auth::index');
$routes->get('/login', 'Auth::login');
$routes->post('/auth/doLogin', 'Auth::doLogin');
$routes->get('/register', 'Auth::register');
$routes->post('/auth/doRegister', 'Auth::doRegister');
$routes->get('/logout', 'Auth::logout');
// Make sure these routes exist
$routes->get('/register', 'Auth::register');
$routes->post('/auth/doRegister', 'Auth::doRegister');

// ============================================
// CUSTOMER AUTH ROUTES (Public)
// ============================================
$routes->get('/customer', 'CustomerAuth::index');
$routes->get('/customer/login', 'CustomerAuth::login');
$routes->get('/customer/register', 'CustomerAuth::register');
$routes->post('/customer/auth/doLogin', 'CustomerAuth::doLogin');
$routes->post('/customer/auth/doRegister', 'CustomerAuth::doRegister');
$routes->get('/customer/logout', 'CustomerAuth::logout');

// ============================================
// CUSTOMER STORE ROUTES
// ============================================
$routes->get('/customer/store', 'CustomerStore::index');
$routes->get('/customer/products', 'CustomerStore::products');
$routes->get('/customer/productDetail/(:num)', 'CustomerStore::productDetail/$1');
$routes->get('/customer/category/(:num)', 'CustomerStore::category/$1');
$routes->get('/customer/track-order', 'CustomerStore::trackOrder');
$routes->get('/customer/order/(:any)', 'CustomerStore::viewOrder/$1');
$routes->post('/customer/placeOrder', 'CustomerStore::placeOrder');
$routes->get('/customer/dashboard', 'CustomerAuth::dashboard');
$routes->get('/customer/account', 'CustomerAuth::myAccount');

// ============================================
// ADMIN PROTECTED ROUTES (Requires Admin Login)
// ============================================
$routes->group('', ['filter' => 'auth'], function($routes) {
    
    // Dashboard
    $routes->get('/dashboard', 'Dashboard::index');
    
    // POS
    $routes->get('/pos', 'Pos::index');
    $routes->post('/pos/processOrder', 'Pos::processOrder');
    
    // ============================================
    // PRODUCT ROUTES - FIXED
    // ============================================
    $routes->get('/products', 'Product::index');
    $routes->get('/product/create', 'Product::create');        // THIS MUST EXIST
    $routes->post('/product/store', 'Product::store');
    $routes->get('/product/edit/(:num)', 'Product::edit/$1');
    $routes->post('/product/update/(:num)', 'Product::update/$1');
    $routes->get('/product/delete/(:num)', 'Product::delete/$1');
    
    // ============================================
    // CATEGORY ROUTES
    // ============================================
    $routes->get('/categories', 'Category::index');
    $routes->get('/category/create', 'Category::create');
    $routes->post('/category/store', 'Category::store');
    $routes->get('/category/edit/(:num)', 'Category::edit/$1');
    $routes->post('/category/update/(:num)', 'Category::update/$1');
    $routes->get('/category/delete/(:num)', 'Category::delete/$1');
    
    // ============================================
    // ORDER ROUTES
    // ============================================
    $routes->get('/orders', 'Order::index');
    $routes->get('/order/create', 'Order::create');
    $routes->post('/order/store', 'Order::store');
    $routes->get('/order/view/(:num)', 'Order::view/$1');
    $routes->get('/order/delete/(:num)', 'Order::delete/$1');
    
    // ============================================
    // ORDER CONFIRMATION ROUTES
    // ============================================
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
    
    // ============================================
    // NOTIFICATION ROUTES
    // ============================================
    $routes->get('/notifications', 'Notification::index');
    $routes->get('/notifications/markRead/(:num)', 'Notification::markRead/$1');
    $routes->get('/notifications/markAllRead', 'Notification::markAllRead');
    $routes->get('/notifications/getUnreadCount', 'Notification::getUnreadCount');
});

// ============================================
// RIDER ROUTES
// ============================================
$routes->get('/rider', 'Rider::login');
$routes->get('/rider/login', 'Rider::login');
$routes->post('/rider/doLogin', 'Rider::doLogin');
$routes->get('/rider/register', 'Rider::register');
$routes->post('/rider/doRegister', 'Rider::doRegister');
$routes->get('/rider/logout', 'Rider::logout');

// Rider Dashboard Pages (Split)
$routes->get('/rider/dashboard', 'Rider::dashboard');
$routes->get('/rider/ready', 'Rider::readyOrders');
$routes->get('/rider/assigned', 'Rider::assignedOrders');
$routes->get('/rider/completed', 'Rider::completedOrders');
$routes->get('/rider/order/(:num)', 'Rider::viewOrder/$1');

// Rider Actions
$routes->get('/rider/acceptOrder/(:num)', 'Rider::acceptOrder/$1');
$routes->get('/rider/deliverOrder/(:num)', 'Rider::deliverOrder/$1');
$routes->post('/rider/processDelivery', 'Rider::processDelivery');

// Report Routes
$routes->get('/reports', 'Reports::index');
$routes->get('/reports/sales', 'Reports::salesReport');
$routes->get('/reports/products', 'Reports::productReport');
$routes->get('/reports/customers', 'Reports::customerReport');
$routes->get('/reports/riders', 'Reports::riderReport');

// Auth Routes
$routes->get('/', 'Auth::index');
$routes->get('/login', 'Auth::login');
$routes->post('/auth/doLogin', 'Auth::doLogin');
$routes->get('/register', 'Auth::register');
$routes->post('/auth/doRegister', 'Auth::doRegister');
$routes->get('/logout', 'Auth::logout');

// Add these routes for AJAX requests
$routes->get('/api/dashboard', 'Dashboard::index');
$routes->get('/api/products', 'Product::index');
$routes->get('/api/orders', 'Order::index');
$routes->get('/api/categories', 'Category::index');