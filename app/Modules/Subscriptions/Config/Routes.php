<?php

if(!isset($routes))
{
    $routes = \Config\Services::routes(true);
}

$routes->group('manage', ['namespace' => 'App\Modules\Subscriptions\Controllers\Admin'], function($subroutes){
    $subroutes->add('subscriptions', 'Manage::index');
    $subroutes->add('manage/add', 'Manage::add');
    $subroutes->add('manage/edit/(:num)', 'Manage::edit/$1');
    $subroutes->add('manage/delete', 'Manage::delete');
    $subroutes->add('manage/publish', 'Manage::publish');

    $subroutes->add('subscription_statuses', 'Statuses::index');
    $subroutes->add('subscription_statuses/add', 'Statuses::add');
    $subroutes->add('subscription_statuses/edit/(:num)', 'Statuses::edit/$1');
    $subroutes->add('subscription_statuses/delete', 'Statuses::delete');
    $subroutes->add('subscription_statuses/publish', 'Statuses::publish');

    $subroutes->add('subscription_plans', 'Plans::index');
    $subroutes->add('subscription_plans/add', 'Plans::add');
    $subroutes->add('subscription_plans/save', 'Plans::save');
    $subroutes->add('subscription_plans/edit/(:num)', 'Plans::edit/$1');
    $subroutes->add('subscription_plans/delete', 'Plans::delete');
    $subroutes->add('subscription_plans/publish', 'Plans::publish');
});
