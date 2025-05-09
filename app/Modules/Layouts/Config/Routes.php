<?php

if (!isset($routes)) {
    $routes = \Config\Services::routes(true);
}

$routes->group('manage', ['namespace' => 'App\Modules\Layouts\Controllers\Admin', 'filter' => 'auth_admin'], function ($subroutes) {
    $subroutes->add('layouts', 'Layouts::index');
    $subroutes->add('layouts/add', 'Layouts::add');
    $subroutes->add('layouts/edit/(:num)', 'Layouts::edit/$1');
    $subroutes->add('layouts/delete', 'Layouts::delete');
    $subroutes->add('layouts/publish', 'Layouts::publish');

    $subroutes->add('layout_actions', 'Actions::index');
    $subroutes->add('layout_actions/add', 'Actions::add');
    $subroutes->add('layout_actions/edit/(:num)', 'Actions::edit/$1');
    $subroutes->add('layout_actions/delete', 'Actions::delete');
});
