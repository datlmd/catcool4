<?php

if(!isset($routes))
{
    $routes = \Config\Services::routes(true);
}

$routes->group('variants', ['namespace' => 'App\Modules\Variants\Controllers'], function($subroutes){
    $subroutes->add('manage', 'Manage::index');
    $subroutes->add('manage/add', 'Manage::add');
    $subroutes->add('manage/save', 'Manage::save');
    $subroutes->add('manage/edit/(:num)', 'Manage::edit/$1');
    $subroutes->add('manage/delete', 'Manage::delete');
    $subroutes->add('manage/get_list', 'Manage::getList');
});
