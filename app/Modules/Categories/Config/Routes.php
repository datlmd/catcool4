<?php

if(!isset($routes))
{
    $routes = \Config\Services::routes(true);
}

$routes->group('categories', ['namespace' => 'App\Modules\Categories\Controllers'], function($subroutes){
    $subroutes->add('manage', 'Manage::index');
    $subroutes->add('manage/add', 'Manage::add');
    $subroutes->add('manage/edit/(:num)', 'Manage::edit/$1');
    $subroutes->add('manage/delete', 'Manage::delete');
    $subroutes->add('manage/publish', 'Manage::publish');
    $subroutes->add('manage/update_sort', 'Manage::updateSort');
});
