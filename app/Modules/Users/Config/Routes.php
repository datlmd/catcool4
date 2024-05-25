<?php

if(!isset($routes))
{
    $routes = \Config\Services::routes(true);
}

$routes->group('manage', ['namespace' => 'App\Modules\Users\Controllers\Admin'], function($subroutes){
    $subroutes->add('users', 'Users::index');
    $subroutes->add('users/add', 'Users::add');
    $subroutes->add('users/edit/(:num)', 'Users::edit/$1');
    $subroutes->add('users/delete', 'Users::delete');
    $subroutes->add('users/publish', 'Users::publish');
    $subroutes->add('users/login', 'Users::login');
    $subroutes->post('users/api_login', 'Users::apiLogin');
    $subroutes->add('users/logout', 'Users::logout');
    $subroutes->add('users/permission/(:num)', 'Users::permission/$1');
    $subroutes->add('users/change_password/(:num)', 'Users::changePassword/$1');
    $subroutes->add('users/forgot_password', 'Users::forgotPassword');
    $subroutes->add('users/reset_password/(:any)', 'Users::resetPassword/$1');
    $subroutes->get('users/user_ip_list/(:num)', 'Users::userIpList/$1');
    $subroutes->get('users/token_list/(:num)', 'Users::tokenList/$1');
    $subroutes->post('users/delete_token', 'Users::deleteToken');

    $subroutes->add('user_groups', 'Groups::index');
    $subroutes->add('user_groups/add', 'Groups::add');
    $subroutes->add('user_groups/edit/(:num)', 'Groups::edit/$1');
    $subroutes->add('user_groups/delete', 'Groups::delete');
    $subroutes->add('user_groups/publish', 'Groups::publish');
});

$routes->add('manage/login', 'Manage::login', ['namespace' => 'App\Modules\Users\Controllers']);
$routes->add('root', 'Manage::login', ['namespace' => 'App\Modules\Users\Controllers']);

$routes->get('users/login', 'Login::index', ['namespace' => 'App\Modules\Users\Controllers']);
$routes->post('users/post_login', 'Login::postLogin', ['namespace' => 'App\Modules\Users\Controllers']);
$routes->get('users/social_login', 'Login::socialLogin', ['namespace' => 'App\Modules\Users\Controllers']);