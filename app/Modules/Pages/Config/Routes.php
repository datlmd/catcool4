<?php

if (!isset($routes)) {
    $routes = \Config\Services::routes(true);
}

$routes->group('manage', ['namespace' => 'App\Modules\Pages\Controllers\Admin', 'filter' => 'auth_admin'], function ($subroutes) {
    $subroutes->add('pages', 'Pages::index');
    $subroutes->add('pages/add', 'Pages::add');
    $subroutes->add('pages/edit/(:num)', 'Pages::edit/$1');
    $subroutes->add('pages/delete', 'Pages::delete');
    $subroutes->add('pages/publish', 'Pages::publish');
});

$routes->get('pages/detail/(:num)', 'Pages::detail/$1', ['namespace' => 'App\Modules\Pages\Controllers']);

$routes->get('information/(:num)', 'Pages::detail/$1', ['namespace' => 'App\Modules\Pages\Controllers']);
