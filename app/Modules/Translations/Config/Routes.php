<?php

if (!isset($routes)) {
    $routes = \Config\Services::routes(true);
}

$routes->group('manage', ['namespace' => 'App\Modules\Translations\Controllers\Admin', 'filter' => 'auth_admin'], function ($subroutes) {
    $subroutes->add('translations', 'Translations::index');
    $subroutes->add('translations/add', 'Translations::add');
    $subroutes->add('translations/edit', 'Translations::edit');
    $subroutes->add('translations/save', 'Translations::save');
    $subroutes->add('translations/delete', 'Translations::delete');
    $subroutes->add('translations/publish', 'Translations::publish');
    $subroutes->add('translations/write', 'Translations::write');
});
