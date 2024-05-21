<?php

if (!isset($routes)) {
    $routes = \Config\Services::routes(true);
}

$routes->group('events', ['namespace' => 'App\Modules\Events\Controllers\Admin'], function ($subroutes) {
    $subroutes->add('manage', 'Events::index');
    $subroutes->add('manage/add', 'Events::add');
    $subroutes->add('manage/edit/(:num)', 'Events::edit/$1');
    $subroutes->add('manage/delete', 'Events::delete');
    $subroutes->add('manage/save', 'Events::save');
    $subroutes->add('manage/publish', 'Events::publish');
});
