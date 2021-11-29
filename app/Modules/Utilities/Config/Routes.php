<?php

if(!isset($routes))
{
    $routes = \Config\Services::routes(true);
}

$routes->group('utilities', ['namespace' => 'App\Modules\Utilities\Controllers'], function($subroutes){
    $subroutes->add('manage', 'Manage::index');
    $subroutes->add('manage/php_info', 'Manage::phpInfo');
    $subroutes->add('manage/list_file', 'Manage::listFile');
    $subroutes->add('manage/load_fba', 'Manage::loadFba');
    $subroutes->add('manage/logs', 'Manage::logs');
});
