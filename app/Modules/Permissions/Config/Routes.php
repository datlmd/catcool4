<?php

if(!isset($routes))
{
    $routes = \Config\Services::routes(true);
}

$routes->group('manage', ['namespace' => 'App\Modules\Permissions\Controllers\Admin', 'filter' => 'auth_admin'], function($subroutes){
    $subroutes->add('permissions', 'Permissions::index');
    $subroutes->add('permissions/add', 'Permissions::add');
    $subroutes->add('permissions/edit/(:num)', 'Permissions::edit/$1');
    $subroutes->add('permissions/delete', 'Permissions::delete');
    $subroutes->add('permissions/publish', 'Permissions::publish');
    $subroutes->add('permissions/not_allowed', 'Permissions::notAllowed');
    $subroutes->add('permissions/check_module', 'Permissions::checkModule');
});

