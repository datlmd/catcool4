<?php

if (!isset($routes)) {
    $routes = \Config\Services::routes(true);
}

$routes->group('manage', ['namespace' => 'App\Modules\Attributes\Controllers\Admin', 'filter' => 'auth_admin'], function ($subroutes) {
    $subroutes->add('attributes', 'Attributes::index');
    $subroutes->add('attributes/add', 'Attributes::add');
    $subroutes->add('attributes/edit/(:num)', 'Attributes::edit/$1');
    $subroutes->add('attributes/delete', 'Attributes::delete');

    $subroutes->add('attribute_groups', 'Groups::index');
    $subroutes->add('attribute_groups/add', 'Groups::add');
    $subroutes->add('attribute_groups/edit/(:num)', 'Groups::edit/$1');
    $subroutes->add('attribute_groups/delete', 'Groups::delete');
});
