<?php

if (!isset($routes)) {
    $routes = \Config\Services::routes(true);
}

$routes->group('manage', ['namespace' => 'App\Modules\GeoZones\Controllers\Admin', 'filter' => 'auth_admin'], function ($subroutes) {
    $subroutes->add('geo_zones', 'GeoZones::index');
    $subroutes->add('geo_zones/add', 'GeoZones::add');
    $subroutes->add('geo_zones/save', 'GeoZones::save');
    $subroutes->add('geo_zones/edit/(:num)', 'GeoZones::edit/$1');
    $subroutes->add('geo_zones/delete', 'GeoZones::delete');
    $subroutes->add('geo_zones/get_list', 'GeoZones::getList');
});
