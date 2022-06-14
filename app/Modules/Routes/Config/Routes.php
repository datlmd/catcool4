<?php

if(!isset($routes))
{
    $routes = \Config\Services::routes(true);
}

$routes->group('routes', ['namespace' => 'App\Modules\Routes\Controllers'], function($subroutes){
    $subroutes->add('manage', 'Manage::index');
    $subroutes->add('manage/add', 'Manage::add');
    $subroutes->add('manage/edit/(:any)/(:num)', 'Manage::edit/$1/$2');
    $subroutes->add('manage/delete', 'Manage::delete');
    $subroutes->add('manage/publish', 'Manage::publish');
    $subroutes->add('manage/write', 'Manage::write');
});