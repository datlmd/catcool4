<?php

if(!isset($routes))
{
    $routes = \Config\Services::routes(true);
}

$routes->group('frontend', ['namespace' => 'App\Modules\Frontend\Controllers'], function($subroutes){
    $subroutes->add('', 'Frontend::index');
});

$routes->add('frontend_react', 'React::index', ['namespace' => 'App\Modules\Frontend\Controllers']);
$routes->get('about', 'Contact::index', ['namespace' => 'App\Modules\Frontend\Controllers']);

$routes->get('contact', 'Contact::index', ['namespace' => 'App\Modules\Frontend\Controllers']);
$routes->post('contact/send', 'Contact::send', ['namespace' => 'App\Modules\Frontend\Controllers']);
