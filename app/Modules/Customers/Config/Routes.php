<?php

if(!isset($routes))
{
    $routes = \Config\Services::routes(true);
}

$routes->group('customers', ['namespace' => 'App\Modules\Customers\Controllers'], function($subroutes){
    $subroutes->add('', 'Customers::index');
    $subroutes->add('login', 'Login::index');
    $subroutes->add('profile', 'Profile::index');

    $subroutes->add('manage', 'Manage::index');
    $subroutes->add('manage/add', 'Manage::add');
    $subroutes->add('manage/edit/(:num)', 'Manage::edit/$1');
    $subroutes->add('manage/delete', 'Manage::delete');
    $subroutes->add('manage/publish', 'Manage::publish');
    $subroutes->add('manage/save', 'Manage::save');

    $subroutes->add('groups_manage', 'GroupsManage::index');
    $subroutes->add('groups_manage/add', 'GroupsManage::add');
    $subroutes->add('groups_manage/edit/(:num)', 'GroupsManage::edit/$1');
    $subroutes->add('groups_manage/delete', 'GroupsManage::delete');
    $subroutes->add('groups_manage/save', 'GroupsManage::save');
});
