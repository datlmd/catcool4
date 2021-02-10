<?php

if(!isset($routes))
{
    $routes = \Config\Services::routes(true);
}

$routes->group('img', ['namespace' => 'App\Modules\Images\Controllers'], function($subroutes){
    $subroutes->add('(:any)', 'Img::index/$1');
});

$routes->group('image', ['namespace' => 'App\Modules\Images\Controllers'], function($subroutes){
    $subroutes->add('crop', 'Tool::crop');
    $subroutes->add('alt/(:any)', 'Tool::alt/$1');
    $subroutes->add('editor', 'Tool::editor');
    $subroutes->add('upload', 'Upload::index');
});
