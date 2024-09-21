<?php

if(!isset($routes))
{
    $routes = \Config\Services::routes(true);
}

$routes->group('common', ['namespace' => 'App\Modules\Common\Controllers'], function($subroutes){
    $subroutes->add('filemanager', 'FileManager::index');
    $subroutes->add('filemanager/upload', 'FileManager::upload');
    $subroutes->add('filemanager/upload_url', 'FileManager::uploadUrl');
    $subroutes->add('filemanager/folder', 'FileManager::folder');
    $subroutes->add('filemanager/delete', 'FileManager::delete');
    $subroutes->add('filemanager/rotation/(:any)', 'FileManager::rotation/$1');
    $subroutes->add('filemanager/clear_cache', 'FileManager::clearCache');
});
