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

    $subroutes->add('statuses_manage', 'StatusesManage::index');
    $subroutes->add('statuses_manage/add', 'StatusesManage::add');
    $subroutes->add('statuses_manage/edit/(:num)', 'StatusesManage::edit/$1');
    $subroutes->add('statuses_manage/delete', 'StatusesManage::delete');
    $subroutes->add('statuses_manage/publish', 'StatusesManage::publish');

    $subroutes->add('reasons_manage', 'ReasonsManage::index');
    $subroutes->add('reasons_manage/add', 'ReasonsManage::add');
    $subroutes->add('reasons_manage/edit/(:num)', 'ReasonsManage::edit/$1');
    $subroutes->add('reasons_manage/delete', 'ReasonsManage::delete');
    $subroutes->add('reasons_manage/publish', 'ReasonsManage::publish');
});
