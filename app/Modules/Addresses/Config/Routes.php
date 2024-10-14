<?php

if(!isset($routes))
{
    $routes = \Config\Services::routes(true);
}

$routes->group('manage', ['namespace' => 'App\Modules\Addresses\Controllers\Admin', 'filter' => 'auth_admin'], function($subroutes) {
    $subroutes->add('addresses_format', 'Format::index');
    $subroutes->add('addresses_format/add', 'Format::add');
    $subroutes->add('addresses_format/edit/(:num)', 'Format::edit/$1');
    $subroutes->add('addresses_format/delete', 'Format::delete');
});
