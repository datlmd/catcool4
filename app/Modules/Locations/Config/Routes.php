<?php

if(!isset($routes))
{
    $routes = \Config\Services::routes(true);
}

$routes->group('manage', ['namespace' => 'App\Modules\Locations\Controllers\Admin'], function($subroutes){

    $subroutes->add('locations', 'Locations::index');
    $subroutes->add('locations/add', 'Locations::add');
    $subroutes->add('locations/edit/(:num)', 'Locations::edit/$1');
    $subroutes->add('locations/delete', 'Locations::delete');
    $subroutes->add('locations/save', 'Locations::save');
});
