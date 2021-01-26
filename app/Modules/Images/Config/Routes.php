<?php

if(!isset($routes))
{
    $routes = \Config\Services::routes(true);
}

$routes->group('img', ['namespace' => 'App\Modules\Images\Controllers'], function($subroutes){
    $subroutes->add('(:any)', 'Images::index/$1');
});