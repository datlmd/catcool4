<?php

if(!isset($routes))
{
    $routes = \Config\Services::routes(true);
}

$routes->group('frontend', ['namespace' => 'App\Modules\Frontend\Controllers'], function($subroutes){
    $subroutes->add('', 'Frontend::index');
});
