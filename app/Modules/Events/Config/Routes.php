<?php

if (!isset($routes)) {
    $routes = \Config\Services::routes(true);
}

$routes->group('manage', ['namespace' => 'App\Modules\Events\Controllers\Admin'], function ($subroutes) {
    $subroutes->add('events', 'Events::index');
    $subroutes->add('events/add', 'Events::add');
    $subroutes->add('events/edit/(:num)', 'Events::edit/$1');
    $subroutes->add('events/delete', 'Events::delete');
    $subroutes->add('events/save', 'Events::save');
    $subroutes->add('events/publish', 'Events::publish');
});
