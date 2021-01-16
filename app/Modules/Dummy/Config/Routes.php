<?php

if(!isset($routes))
{
    $routes = \Config\Services::routes(true);
}

$routes->group('dummy', ['namespace' => 'App\Modules\Dummy\Controllers'], function($subroutes){


    $subroutes->add('manage', 'Manage::index');

});