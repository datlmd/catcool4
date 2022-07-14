<?php

if(!isset($routes))
{
    $routes = \Config\Services::routes(true);
}

$routes->group('subscriptions', ['namespace' => 'App\Modules\Subscriptions\Controllers'], function($subroutes){
    $subroutes->add('manage', 'Manage::index');
    $subroutes->add('manage/add', 'Manage::add');
    $subroutes->add('manage/edit/(:num)', 'Manage::edit/$1');
    $subroutes->add('manage/delete', 'Manage::delete');
    $subroutes->add('manage/publish', 'Manage::publish');

    $subroutes->add('statuses_manage', 'StatusesManage::index');
    $subroutes->add('statuses_manage/add', 'StatusesManage::add');
    $subroutes->add('statuses_manage/edit/(:num)', 'StatusesManage::edit/$1');
    $subroutes->add('statuses_manage/delete', 'StatusesManage::delete');
    $subroutes->add('statuses_manage/publish', 'StatusesManage::publish');
});
