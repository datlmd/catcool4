<?php

if(!isset($routes))
{
    $routes = \Config\Services::routes(true);
}

$routes->group('frontend', ['namespace' => 'App\Modules\Frontend\Controllers'], function($subroutes){
    $subroutes->add('', 'Frontend::index');
});

$routes->get('contact', 'Contact::index', ['namespace' => 'App\Modules\Frontend\Controllers']);
$routes->post('contact/send', 'Contact::send', ['namespace' => 'App\Modules\Frontend\Controllers']);