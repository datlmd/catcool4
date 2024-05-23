<?php

if(!isset($routes))
{
    $routes = \Config\Services::routes(true);
}

$routes->group('manage', ['namespace' => 'App\Modules\Configs\Controllers\Admin'], function($subroutes){
    $subroutes->add('configs', 'Configs::index');
    $subroutes->add('configs/add', 'Configs::add');
    $subroutes->add('configs/edit/(:num)', 'Configs::edit/$1');
    $subroutes->add('configs/delete', 'Configs::delete');
    $subroutes->add('configs/publish', 'Configs::publish');
    $subroutes->add('configs/write', 'Configs::write');
    $subroutes->add('configs/settings/(:any)', 'Configs::settings/$1');
    $subroutes->add('configs/settings', 'Configs::settings');
    $subroutes->add('configs/config', 'Configs::config');

    $subroutes->add('config_groups', 'Groups::index');
    $subroutes->add('config_groups/add', 'Groups::add');
    $subroutes->add('config_groups/edit/(:num)', 'Groups::edit/$1');
    $subroutes->add('config_groups/delete', 'Groups::delete');
    $subroutes->add('config_groups/publish', 'Groups::publish');
});