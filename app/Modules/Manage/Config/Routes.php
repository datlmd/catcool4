<?php

if(!isset($routes))
{
    $routes = \Config\Services::routes(true);
}

$routes->group('manage', ['namespace' => 'App\Modules\Manage\Controllers'], function($subroutes) {
    $subroutes->add('index', 'Manage::index');
    $subroutes->add('builder', 'Builder::index');
    $subroutes->add('run_seeder', 'RunSeeder::index');
    $subroutes->add('backup', 'Backup::index');
    $subroutes->add('backup/export', 'Backup::export');
    $subroutes->add('backup/history', 'Backup::history');
    $subroutes->add('backup/delete', 'Backup::delete');
});
