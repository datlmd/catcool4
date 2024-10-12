<?php

if(!isset($routes))
{
    $routes = \Config\Services::routes(true);
}

$routes->group('manage', ['namespace' => 'App\Modules\Options\Controllers\Admin', 'filter' => 'auth_admin'], function($subroutes){
    $subroutes->add('options', 'Options::index');
    $subroutes->add('options/add', 'Options::add');
    $subroutes->add('options/save', 'Options::save');
    $subroutes->add('options/edit/(:num)', 'Options::edit/$1');
    $subroutes->add('options/delete', 'Options::delete');
    $subroutes->add('options/get_list', 'Options::getList');
});
