<?php

if(!isset($routes))
{
    $routes = \Config\Services::routes(true);
}

$routes->group('manage', ['namespace' => 'App\Modules\Customers\Controllers\Admin'], function($subroutes) {
    $subroutes->add('customers', 'Customers::index');
    $subroutes->add('customers/add', 'Customers::add');
    $subroutes->add('customers/edit/(:num)', 'Customers::edit/$1');
    $subroutes->add('customers/delete', 'Customers::delete');
    $subroutes->add('customers/publish', 'Customers::publish');
    $subroutes->add('customers/save', 'Customers::save');

    $subroutes->add('customer_groups', 'Groups::index');
    $subroutes->add('customer_groups/add', 'Groups::add');
    $subroutes->add('customer_groups/edit/(:num)', 'Groups::edit/$1');
    $subroutes->add('customer_groups/delete', 'Groups::delete');
    $subroutes->add('customer_groups/save', 'Groups::save');
});

$routes->group('account', ['namespace' => 'App\Modules\Customers\Controllers'], function($subroutes) {
    $subroutes->get('login', 'Login::index');
    $subroutes->post('login', 'Login::login');
    $subroutes->get('logout', 'Logout::index');
    $subroutes->add('social_login', 'Login::socialLogin');
    $subroutes->get('register', 'Register::index');
    $subroutes->post('register', 'Register::register');
    $subroutes->get('profile', 'Profile::index');
    $subroutes->get('activate/(:num)/(:any)', 'Activate::index/$1/$2');
    $subroutes->get('alert', 'Alert::index');
});

