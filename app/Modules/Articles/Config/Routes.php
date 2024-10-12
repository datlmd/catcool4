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
    $subroutes->add('articles/restore/(:any)', 'Articles::restore/$1');
    $subroutes->add('articles/empty_trash', 'Articles::emptyTrash');

    $subroutes->add('article_categories', 'Categories::index');
    $subroutes->add('article_categories/add', 'Categories::add');
    $subroutes->add('article_categories/edit/(:num)', 'Categories::edit/$1');
    $subroutes->add('article_categories/delete', 'Categories::delete');
    $subroutes->add('article_categories/publish', 'Categories::publish');
    $subroutes->add('article_categories/update_sort', 'Categories::updateSort');
});

$routes->group('article', ['namespace' => 'App\Modules\Articles\Controllers'], function ($subroutes) {
    $subroutes->add('/', 'Articles::index');
    $subroutes->add('list', 'Articles::index');
    $subroutes->add('(:num)', 'Detail::index/$1');
    $subroutes->add('category/(:num)', 'Articles::index/$1');
});

$routes->add('(:any)-' . SEO_ARTICLE_ID . '(:num).' . SEO_EXTENSION, 'Detail::index/$1/$2', ['namespace' => 'App\Modules\Articles\Controllers']);
$routes->add('(:any)-' . SEO_ARTICLE_ID . '(:num)', 'Detail::index/$1/$2', ['namespace' => 'App\Modules\Articles\Controllers']);

//Set route category
$routes->add('(:any)-' . '(:num)' . SEO_ARTICLE_CATEGORY_ID . '.' . SEO_EXTENSION, 'Articles::index/$1/$2', ['namespace' => 'App\Modules\Articles\Controllers']);
$routes->add('(:any)-' . '(:num)' . SEO_ARTICLE_CATEGORY_ID, 'Articles::index/$1/$2', ['namespace' => 'App\Modules\Articles\Controllers']);
