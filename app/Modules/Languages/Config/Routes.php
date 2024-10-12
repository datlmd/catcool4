<?php

if(!isset($routes))
{
    $routes = \Config\Services::routes(true);
}

$routes->group('manage', ['namespace' => 'App\Modules\Languages\Controllers\Admin', 'filter' => 'auth_admin'], function($subroutes){
    $subroutes->add('languages', 'Languages::index');
    $subroutes->add('languages/add', 'Languages::add');
    $subroutes->add('languages/edit/(:num)', 'Languages::edit/$1');
    $subroutes->add('languages/delete', 'Languages::delete');
    $subroutes->add('languages/publish', 'Languages::publish');
    $subroutes->add('languages/switch/(:any)', 'Languages::switch/$1');
});

$routes->get('languages/switch/(:any)', 'Languages::switch/$1', ['namespace' => 'App\Modules\Languages\Controllers']);