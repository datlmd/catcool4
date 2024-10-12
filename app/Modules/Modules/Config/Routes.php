<?php

if(!isset($routes))
{
    $routes = \Config\Services::routes(true);
}

$routes->group('manage', ['namespace' => 'App\Modules\Modules\Controllers\Admin', 'filter' => 'auth_admin'], function($subroutes){
    $subroutes->add('modules', 'Modules::index');
    $subroutes->add('modules/add', 'Modules::add');
    $subroutes->add('modules/edit/(:num)', 'Modules::edit/$1');
    $subroutes->add('modules/delete', 'Modules::delete');
    $subroutes->add('modules/publish', 'Modules::publish');
});
