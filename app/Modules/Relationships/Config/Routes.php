<?php

if(!isset($routes))
{
    $routes = \Config\Services::routes(true);
}

$routes->group('manage', ['namespace' => 'App\Modules\Relationships\Controllers\Admin', 'filter' => 'auth_admin'], function($subroutes){
    $subroutes->add('relationships', 'Relationships::index');
    $subroutes->add('relationships/add', 'Relationships::add');
    $subroutes->add('relationships/edit/(:num)', 'Relationships::edit/$1');
    $subroutes->add('relationships/delete', 'Relationships::delete');
    $subroutes->add('relationships/publish', 'Relationships::publish');
});
