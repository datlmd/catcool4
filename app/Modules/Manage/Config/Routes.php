<?php

if (!isset($routes)) {
    $routes = \Config\Services::routes(true);
}

$routes->group('manage', ['namespace' => 'App\Modules\Manage\Controllers', 'filter' => 'auth_admin'], function ($subroutes) {
    $subroutes->add('index', 'Manage::index');
    $subroutes->add('builder', 'Builder::index');
    $subroutes->add('run_seeder', 'RunSeeder::index');
    $subroutes->add('backup', 'Backup::index');
    $subroutes->add('backup/export', 'Backup::export');
    $subroutes->add('backup/history', 'Backup::history');
    $subroutes->add('backup/delete', 'Backup::delete');
    $subroutes->add('backup/download', 'Backup::download');
    $subroutes->add('backup/restore', 'Backup::restore');
    $subroutes->add('backup/upload', 'Backup::upload');

    $subroutes->add('dashboard', 'Dashboard::index');
});
