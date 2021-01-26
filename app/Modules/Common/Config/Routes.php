<?php

if(!isset($routes))
{
    $routes = \Config\Services::routes(true);
}

$routes->group('common', ['namespace' => 'App\Modules\Common\Controllers'], function($subroutes){
    $subroutes->add('filemanager', 'FileManager::index');
    $subroutes->add('filemanager/upload', 'FileManager::upload');
    $subroutes->add('filemanager/folder', 'FileManager::folder');
    $subroutes->add('filemanager/delete', 'FileManager::delete');
    $subroutes->add('filemanager/rotation', 'FileManager::rotation');
});