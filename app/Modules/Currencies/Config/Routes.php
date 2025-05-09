<?php

if (!isset($routes)) {
    $routes = \Config\Services::routes(true);
}

$routes->group('manage', ['namespace' => 'App\Modules\Currencies\Controllers\Admin', 'filter' => 'auth_admin'], function ($subroutes) {
    $subroutes->add('currencies', 'Currencies::index');
    $subroutes->add('currencies/add', 'Currencies::add');
    $subroutes->add('currencies/edit/(:num)', 'Currencies::edit/$1');
    $subroutes->add('currencies/delete', 'Currencies::delete');
    $subroutes->add('currencies/publish', 'Currencies::publish');
    $subroutes->add('currencies/refresh', 'Currencies::refresh');
});
