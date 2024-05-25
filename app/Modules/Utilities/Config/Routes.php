<?php

if(!isset($routes))
{
    $routes = \Config\Services::routes(true);
}

$routes->group('manage', ['namespace' => 'App\Modules\Utilities\Controllers\Admin'], function($subroutes){
    $subroutes->add('utilities', 'Utilities::index');
    $subroutes->add('utility_php_info', 'Utilities::phpInfo');
    $subroutes->add('utility_list_file', 'Utilities::listFile');
    $subroutes->add('utility_load_fba', 'Utilities::loadFba');
    $subroutes->add('utility_logs', 'Utilities::logs');
    $subroutes->add('utility_email', 'Utilities::email');
});
