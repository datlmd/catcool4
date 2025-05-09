<?php

if (!isset($routes)) {
    $routes = \Config\Services::routes(true);
}

$routes->group('manage', ['namespace' => 'App\Modules\Posts\Controllers\Admin', 'filter' => 'auth_admin'], function ($subroutes) {
    $subroutes->add('posts', 'Posts::index');
    $subroutes->add('posts/add', 'Posts::add');
    $subroutes->add('posts/edit/(:any)', 'Posts::edit/$1');
    $subroutes->add('posts/delete', 'Posts::delete');
    $subroutes->add('posts/publish', 'Posts::publish');
    $subroutes->add('posts/status', 'Posts::status');
    $subroutes->add('posts/related', 'Posts::related');
    $subroutes->add('posts/fix', 'Posts::fix');
    $subroutes->add('posts/restore/(:any)', 'Posts::restore/$1');
    $subroutes->add('posts/empty_trash', 'Posts::emptyTrash');
    $subroutes->add('posts/robot', 'Posts::robot');

    $subroutes->add('post_categories', 'Categories::index');
    $subroutes->add('post_categories/add', 'Categories::add');
    $subroutes->add('post_categories/edit/(:num)', 'Categories::edit/$1');
    $subroutes->add('post_categories/delete', 'Categories::delete');
    $subroutes->add('post_categories/publish', 'Categories::publish');
    $subroutes->add('post_categories/update_sort', 'Categories::updateSort');
});

$routes->add('posts', 'Posts::index', ['namespace' => 'App\Modules\Posts\Controllers']);

$routes->add('(:any)-post(:num).html', 'Detail::index/$1/$2', ['namespace' => 'App\Modules\Posts\Controllers']);
$routes->add('(:any)-post(:num).preview', 'Detail::index/$1/$2/preview', ['namespace' => 'App\Modules\Posts\Controllers']);

$routes->add('post-tag/(:any).html', 'Tag::index/$1', ['namespace' => 'App\Modules\Posts\Controllers']);
