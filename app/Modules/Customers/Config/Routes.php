<?php

if(!isset($routes))
{
    $routes = \Config\Services::routes(true);
}

$routes->group('customers', ['namespace' => 'App\Modules\Customers\Controllers'], function($subroutes){
    $subroutes->add('', 'Customers::index');
    $subroutes->add('login', 'Login::index');
    $subroutes->add('profile', 'Profile::index');

    $subroutes->add('groups_manage', 'GroupsManage::index');
    $subroutes->add('groups_manage/add', 'GroupsManage::add');
    $subroutes->add('groups_manage/edit/(:num)', 'GroupsManage::edit/$1');
    $subroutes->add('groups_manage/delete', 'GroupsManage::delete');
    $subroutes->add('groups_manage/save', 'GroupsManage::save');
});
