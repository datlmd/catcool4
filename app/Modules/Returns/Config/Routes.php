<?php

if(!isset($routes))
{
    $routes = \Config\Services::routes(true);
}

$routes->group('manage', ['namespace' => 'App\Modules\Returns\Controllers\Admin'], function($subroutes){

    $subroutes->add('return_actions', 'Actions::index');
    $subroutes->add('return_actions/add', 'Actions::add');
    $subroutes->add('return_actions/edit/(:num)', 'Actions::edit/$1');
    $subroutes->add('return_actions/delete', 'Actions::delete');
    $subroutes->add('return_actions/publish', 'Actions::publish');

    $subroutes->add('return_statuses', 'Statuses::index');
    $subroutes->add('return_statuses/add', 'Statuses::add');
    $subroutes->add('return_statuses/edit/(:num)', 'Statuses::edit/$1');
    $subroutes->add('return_statuses/delete', 'Statuses::delete');
    $subroutes->add('return_statuses/publish', 'Statuses::publish');

    $subroutes->add('return_reasons', 'Reasons::index');
    $subroutes->add('return_reasons/add', 'Reasons::add');
    $subroutes->add('return_reasons/edit/(:num)', 'Reasons::edit/$1');
    $subroutes->add('return_reasons/delete', 'Reasons::delete');
    $subroutes->add('return_reasons/publish', 'Reasons::publish');
});
