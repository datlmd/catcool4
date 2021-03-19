<?php

if(!isset($routes))
{
    $routes = \Config\Services::routes(true);
}

$routes->group('translations', ['namespace' => 'App\Modules\Translations\Controllers'], function($subroutes){
    $subroutes->add('manage', 'Manage::index');
    $subroutes->add('manage/add', 'Manage::add');
    $subroutes->add('manage/edit', 'Manage::edit');
    $subroutes->add('manage/delete', 'Manage::delete');
    $subroutes->add('manage/publish', 'Manage::publish');
    $subroutes->add('manage/write', 'Manage::write');
});
