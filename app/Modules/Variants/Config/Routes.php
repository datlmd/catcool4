<?php

if (!isset($routes)) {
    $routes = \Config\Services::routes(true);
}

$routes->group('manage', ['namespace' => 'App\Modules\Variants\Controllers\Admin'], function ($subroutes) {
    $subroutes->add('variants', 'Variants::index');
    $subroutes->add('variants/add', 'Variants::add');
    $subroutes->add('variants/save', 'Variants::save');
    $subroutes->add('variants/edit/(:num)', 'Variants::edit/$1');
    $subroutes->add('variants/delete', 'Variants::delete');
    $subroutes->add('variants/get_list', 'Variants::getList');
});
