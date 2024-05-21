<?php

if(!isset($routes))
{
    $routes = \Config\Services::routes(true);
}

$routes->group('manage', ['namespace' => 'App\Modules\Categories\Controllers\Admin'], function($subroutes){
    $subroutes->add('categories', 'Categories::index');
    $subroutes->add('categories/add', 'Categories::add');
    $subroutes->add('categories/edit/(:num)', 'Categories::edit/$1');
    $subroutes->add('categories/delete', 'Categories::delete');
    $subroutes->add('categories/publish', 'Categories::publish');
    $subroutes->add('categories/update_sort', 'Categories::updateSort');
});
