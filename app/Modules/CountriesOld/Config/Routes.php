<?php

if(!isset($routes))
{
    $routes = \Config\Services::routes(true);
}

$routes->group('manage/old', ['namespace' => 'App\Modules\CountriesOld\Controllers\Admin', 'filter' => 'auth_admin'], function($subroutes){
    
    $subroutes->add('countries', 'Countries::index');
    $subroutes->add('countries/add', 'Countries::add');
    $subroutes->add('countries/edit/(:num)', 'Countries::edit/$1');
    $subroutes->add('countries/delete', 'Countries::delete');
    $subroutes->add('countries/publish', 'Countries::publish');

    $subroutes->add('country_provinces', 'Provinces::index');
    $subroutes->add('country_provinces/add', 'Provinces::add');
    $subroutes->add('country_provinces/edit/(:num)', 'Provinces::edit/$1');
    $subroutes->add('country_provinces/delete', 'Provinces::delete');
    $subroutes->add('country_provinces/publish', 'Provinces::publish');

    $subroutes->add('country_districts', 'Districts::index');
    $subroutes->add('country_districts/add', 'Districts::add');
    $subroutes->add('country_districts/edit/(:num)', 'Districts::edit/$1');
    $subroutes->add('country_districts/delete', 'Districts::delete');
    $subroutes->add('country_districts/publish', 'Districts::publish');

    $subroutes->add('country_wards', 'Wards::index');
    $subroutes->add('country_wards/add', 'Wards::add');
    $subroutes->add('country_wards/edit/(:num)', 'Wards::edit/$1');
    $subroutes->add('country_wards/delete', 'Wards::delete');
    $subroutes->add('country_wards/publish', 'Wards::publish');
});

$routes->group('countries', ['namespace' => 'App\Modules\Countries\Controllers'], function($subroutes){
    $subroutes->add('provinces', 'Countries::provinces');
    $subroutes->add('districts', 'Countries::districts');
    $subroutes->add('wards', 'Countries::wards');
});