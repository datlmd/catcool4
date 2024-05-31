<?php

if (!isset($routes)) {
    $routes = \Config\Services::routes(true);
}

$routes->group('manage', ['namespace' => 'App\Modules\Manufacturers\Controllers\Admin'], function ($subroutes) {
    $subroutes->add('manufacturers', 'Manufacturers::index');
    $subroutes->add('manufacturers/add', 'Manufacturers::add');
    $subroutes->add('manufacturers/edit/(:num)', 'Manufacturers::edit/$1');
    $subroutes->add('manufacturers/delete', 'Manufacturers::delete');
    $subroutes->add('manufacturers/publish', 'Manufacturers::publish');
});
