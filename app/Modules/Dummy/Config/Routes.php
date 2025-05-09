<?php

if (!isset($routes)) {
    $routes = \Config\Services::routes(true);
}

$routes->group('manage', ['namespace' => 'App\Modules\Dummy\Controllers', 'filter' => 'auth_admin'], function ($subroutes) {
    $subroutes->add('dummy', 'Dummy::index');
    $subroutes->add('dummy/add', 'Dummy::add');
    $subroutes->add('dummy/edit/(:num)', 'Dummy::edit/$1');
    $subroutes->add('dummy/delete', 'Dummy::delete');
    $subroutes->add('dummy/publish', 'Dummy::publish');

    $subroutes->add('dummy_groups', 'Groups::index');
    $subroutes->add('dummy_groups/add', 'Groups::add');
    $subroutes->add('dummy_groups/edit/(:num)', 'Groups::edit/$1');
    $subroutes->add('dummy_groups/delete', 'Groups::delete');
});
