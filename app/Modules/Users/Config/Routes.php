<?php

if(!isset($routes))
{
    $routes = \Config\Services::routes(true);
}

$routes->group('users', ['namespace' => 'App\Modules\Users\Controllers'], function($subroutes){
    $subroutes->add('manage', 'Manage::index');
    $subroutes->add('manage/add', 'Manage::add');
    $subroutes->add('manage/edit/(:num)', 'Manage::edit/$1');
    $subroutes->add('manage/delete', 'Manage::delete');
    $subroutes->add('manage/publish', 'Manage::publish');
    $subroutes->add('manage/login', 'Manage::login');
    $subroutes->post('manage/api_login', 'Manage::apiLogin');
    $subroutes->add('manage/logout', 'Manage::logout');
    $subroutes->add('manage/permission/(:num)', 'Manage::permission/$1');
    $subroutes->add('manage/change_password/(:num)', 'Manage::changePassword/$1');
    $subroutes->add('manage/forgot_password', 'Manage::forgotPassword');
    $subroutes->add('manage/reset_password/(:any)', 'Manage::resetPassword/$1');
    $subroutes->get('manage/user_ip_list/(:num)', 'Manage::userIpList/$1');
    $subroutes->get('manage/token_list/(:num)', 'Manage::tokenList/$1');
    $subroutes->post('manage/delete_token', 'Manage::deleteToken');

    $subroutes->add('groups_manage', 'GroupsManage::index');
    $subroutes->add('groups_manage/add', 'GroupsManage::add');
    $subroutes->add('groups_manage/edit/(:num)', 'GroupsManage::edit/$1');
    $subroutes->add('groups_manage/delete', 'GroupsManage::delete');
    $subroutes->add('groups_manage/publish', 'GroupsManage::publish');

    $subroutes->add('post_register', 'Register::postRegister');
    $subroutes->add('register', 'Register::index');

    $subroutes->get('login', 'Login::index');
    $subroutes->post('post_login', 'Login::postLogin');
    $subroutes->add('social_login', 'Login::socialLogin');

    $subroutes->add('profile', 'Profile::index');
    $subroutes->add('activate/(:num)/(:any)', 'Activate::index/$1/$2');
});

$routes->add('manage/login', 'Manage::login', ['namespace' => 'App\Modules\Users\Controllers']);
$routes->add('root', 'Manage::login', ['namespace' => 'App\Modules\Users\Controllers']);
