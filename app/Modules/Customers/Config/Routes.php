<?php

if(!isset($routes))
{
    $routes = \Config\Services::routes(true);
}

$routes->group('customers', ['namespace' => 'App\Modules\Customers\Controllers'], function($subroutes){
    $subroutes->add('', 'Customers::index');
    $subroutes->add('login', 'Login::index');
    $subroutes->add('profile', 'Profile::index');
});
