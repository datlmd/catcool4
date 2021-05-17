<?php

if(!isset($routes))
{
    $routes = \Config\Services::routes(true);
}

$routes->add('img/(:any)', 'Img::Index', ['namespace' => 'App\Modules\Images\Controllers']);
$routes->add('img', 'Img::Index', ['namespace' => 'App\Modules\Images\Controllers']);

$routes->group('file', ['namespace' => 'App\Modules\Images\Controllers'], function($subroutes){
    $subroutes->add('(:any)', 'File::index');
});

$routes->group('image', ['namespace' => 'App\Modules\Images\Controllers'], function($subroutes){
    $subroutes->add('crop', 'Tool::crop');
    $subroutes->add('alt/(:any)', 'Tool::alt/$1');
    $subroutes->add('editor', 'Editor::index');
    $subroutes->add('upload', 'Upload::index');
});
