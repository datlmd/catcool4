<?php

if(!isset($routes))
{
    $routes = \Config\Services::routes(true);
}

$routes->group('countries', ['namespace' => 'App\Modules\Countries\Controllers'], function($subroutes){
    $subroutes->add('manage', 'Manage::index');
    $subroutes->add('manage/add', 'Manage::add');
    $subroutes->add('manage/edit/(:num)', 'Manage::edit/$1');
    $subroutes->add('manage/delete', 'Manage::delete');
    $subroutes->add('manage/publish', 'Manage::publish');

    $subroutes->add('provinces_manage', 'ProvincesManage::index');
    $subroutes->add('provinces_manage/add', 'ProvincesManage::add');
    $subroutes->add('provinces_manage/edit/(:num)', 'ProvincesManage::edit/$1');
    $subroutes->add('provinces_manage/delete', 'ProvincesManage::delete');
    $subroutes->add('provinces_manage/publish', 'ProvincesManage::publish');

    $subroutes->add('districts_manage', 'DistrictsManage::index');
    $subroutes->add('districts_manage/add', 'DistrictsManage::add');
    $subroutes->add('districts_manage/edit/(:num)', 'DistrictsManage::edit/$1');
    $subroutes->add('districts_manage/delete', 'DistrictsManage::delete');
    $subroutes->add('districts_manage/publish', 'DistrictsManage::publish');
});
