<?php

if (!isset($routes)) {
    $routes = \Config\Services::routes(true);
}

$routes->group('manage', ['namespace' => 'App\Modules\Articles\Controllers\Admin'], function ($subroutes) {
    $subroutes->add('articles', 'Articles::index');
    $subroutes->add('articles/add', 'Articles::add');
    $subroutes->add('articles/edit/(:num)', 'Articles::edit/$1');
    $subroutes->add('articles/delete', 'Articles::delete');
    $subroutes->add('articles/publish', 'Articles::publish');

    $subroutes->add('article_categories', 'Categories::index');
    $subroutes->add('article_categories/add', 'Categories::add');
    $subroutes->add('article_categories/edit/(:num)', 'Categories::edit/$1');
    $subroutes->add('article_categories/delete', 'Categories::delete');
    $subroutes->add('article_categories/publish', 'Categories::publish');
    $subroutes->add('article_categories/update_sort', 'Categories::updateSort');
});
