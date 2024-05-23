<?php

if(!isset($routes))
{
    $routes = \Config\Services::routes(true);
}

$routes->group('manage', ['namespace' => 'App\Modules\Filters\Controllers\Admin'], function($subroutes){
    $subroutes->add('filters', 'Filters::index');
    $subroutes->add('filters/add', 'Filters::add');
    $subroutes->add('filters/save', 'Filters::save');
    $subroutes->add('filters/edit/(:num)', 'Filters::edit/$1');
    $subroutes->add('filters/delete', 'Filters::delete');
});
