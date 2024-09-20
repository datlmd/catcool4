<?php

if(!isset($routes))
{
    $routes = \Config\Services::routes(true);
}

$routes->group('manage', ['namespace' => 'App\Modules\Scan\Controllers\Admin'], function($subroutes){
    $subroutes->add('scan', 'Scan::index');
    $subroutes->add('scan/get_content', 'Scan::getContent');
    $subroutes->add('manage/edit/(:num)', 'Manage::edit/$1');
    $subroutes->add('manage/delete', 'Manage::delete');
    $subroutes->add('manage/publish', 'Manage::publish');
});
