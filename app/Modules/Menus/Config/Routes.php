<?php

if(!isset($routes))
{
    $routes = \Config\Services::routes(true);
}

$routes->group('manage', ['namespace' => 'App\Modules\Menus\Controllers\Admin'], function($subroutes){
    $subroutes->add('menus', 'Menus::index');
    $subroutes->add('menus/add', 'Menus::add');
    $subroutes->add('menus/edit/(:num)', 'Menus::edit/$1');
    $subroutes->add('menus/delete', 'Menus::delete');
    $subroutes->add('menus/publish', 'Menus::publish');
    $subroutes->add('menus/update_sort', 'Menus::updateSort');
});