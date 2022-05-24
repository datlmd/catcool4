<?php

if(!isset($routes))
{
    $routes = \Config\Services::routes(true);
}

$routes->group('returns', ['namespace' => 'App\Modules\Returns\Controllers'], function($subroutes){
    $subroutes->add('manage', 'Manage::index');
    $subroutes->add('manage/add', 'Manage::add');
    $subroutes->add('manage/edit/(:num)', 'Manage::edit/$1');
    $subroutes->add('manage/delete', 'Manage::delete');
    $subroutes->add('manage/publish', 'Manage::publish');

    $subroutes->add('actions_manage', 'ActionsManage::index');
    $subroutes->add('actions_manage/add', 'ActionsManage::add');
    $subroutes->add('actions_manage/edit/(:num)', 'ActionsManage::edit/$1');
    $subroutes->add('actions_manage/delete', 'ActionsManage::delete');
    $subroutes->add('actions_manage/publish', 'ActionsManage::publish');
});
