<?php

if (!isset($routes)) {
    $routes = \Config\Services::routes(true);
}

$routes->group('manage', ['namespace' => 'App\Modules\Routes\Controllers\Admin', 'filter' => 'auth_admin'], function ($subroutes) {
    $subroutes->add('routes', 'Routes::index');
    $subroutes->add('routes/add', 'Routes::add');
    $subroutes->add('routes/edit/(:any)/(:num)', 'Routes::edit/$1/$2');
    $subroutes->add('routes/delete', 'Routes::delete');
    $subroutes->add('routes/publish', 'Routes::publish');
    $subroutes->add('routes/write', 'Routes::write');
});
