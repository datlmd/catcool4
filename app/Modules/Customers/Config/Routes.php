<?php

if(!isset($routes))
{
    $routes = \Config\Services::routes(true);
}

$routes->group('manage', ['namespace' => 'App\Modules\Customers\Controllers\Admin', 'filter' => 'auth_admin'], function($subroutes) {
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
    $subroutes->get('forgotten', 'Forgotten::index');
    $subroutes->post('forgotten', 'Forgotten::confirm');
    $subroutes->get('forgotten/reset/(:any)', 'Forgotten::reset/$1');
    $subroutes->post('forgotten/password/(:any)', 'Forgotten::password/$1');
    $subroutes->get('logout', 'Logout::index');
    $subroutes->add('social_login', 'Login::socialLogin');
    $subroutes->get('register', 'Register::index');
    $subroutes->post('register', 'Register::register');
    $subroutes->get('profile', 'Profile::index');
    $subroutes->get('activate/(:num)/(:any)', 'Activate::index/$1/$2');
    $subroutes->get('alert', 'Alert::index');
    $subroutes->get('edit', 'Edit::index');
    $subroutes->post('edit/save', 'Edit::save');
    $subroutes->get('newsletter', 'Newsletter::index');
    $subroutes->post('newsletter/save', 'Newsletter::save');
    $subroutes->get('password', 'Password::index');
    $subroutes->post('password/save', 'Password::save');
});

$routes->group('account/api', ['namespace' => 'App\Modules\Customers\Controllers\Api'], function($subroutes) {
    $subroutes->get('login', 'Login::index');
    $subroutes->post('login', 'Login::login');
    $subroutes->get('profile', 'Profile::index');
});
