<?php

if(!isset($routes))
{
    $routes = \Config\Services::routes(true);
}

$routes->group('users_admin', ['namespace' => 'App\Modules\UsersAdmin\Controllers'], function($subroutes){
    $subroutes->add('manage', 'Manage::index');
    $subroutes->add('manage/add', 'Manage::add');
    $subroutes->add('manage/edit/(:num)', 'Manage::edit/$1');
    $subroutes->add('manage/delete', 'Manage::delete');
    $subroutes->add('manage/publish', 'Manage::publish');
    $subroutes->add('manage/login', 'Manage::login');
    $subroutes->add('manage/logout', 'Manage::logout');
    $subroutes->add('manage/permission/(:num)', 'Manage::permission/$1');
    $subroutes->add('manage/change_password/(:num)', 'Manage::changePassword/$1');
    $subroutes->add('manage/forgot_password', 'Manage::forgotPassword');
    $subroutes->add('manage/reset_password/(:any)', 'Manage::resetPassword/$1');

    $subroutes->add('groups_manage', 'GroupsManage::index');
    $subroutes->add('groups_manage/add', 'GroupsManage::add');
    $subroutes->add('groups_manage/edit/(:num)', 'GroupsManage::edit/$1');
    $subroutes->add('groups_manage/delete', 'GroupsManage::delete');
    $subroutes->add('groups_manage/publish', 'GroupsManage::publish');
});

$routes->add('manage/login', 'Manage::login', ['namespace' => 'App\Modules\UsersAdmin\Controllers']);
$routes->add('root', 'Manage::login', ['namespace' => 'App\Modules\UsersAdmin\Controllers']);
