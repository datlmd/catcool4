<?php

if (!isset($routes)) {
    $routes = \Config\Services::routes(true);
}

$routes->group('manage', ['namespace' => 'App\Modules\News\Controllers\Admin', 'filter' => 'auth_admin'], function ($subroutes) {
    $subroutes->add('news', 'News::index');
    $subroutes->add('news/add', 'News::add');
    $subroutes->add('news/edit/(:any)', 'News::edit/$1');
    $subroutes->add('news/delete', 'News::delete');
    $subroutes->add('news/publish', 'News::publish');
    $subroutes->add('news/robot', 'News::robot');
    $subroutes->add('news/status', 'News::status');
    $subroutes->add('news/related', 'News::related');
    $subroutes->add('news/fix', 'News::fix');
    $subroutes->add('news/restore/(:any)', 'News::restore/$1');
    $subroutes->add('news/empty_trash', 'News::emptyTrash');

    $subroutes->add('news_categories', 'Categories::index');
    $subroutes->add('news_categories/add', 'Categories::add');
    $subroutes->add('news_categories/edit/(:num)', 'Categories::edit/$1');
    $subroutes->add('news_categories/delete', 'Categories::delete');
    $subroutes->add('news_categories/publish', 'Categories::publish');
    $subroutes->add('news_categories/update_sort', 'Categories::updateSort');
});

$routes->group('news', ['namespace' => 'App\Modules\News\Controllers'], function ($subroutes) {
    $subroutes->add('test/(:any)', 'News::test/$1');
    $subroutes->add('test', 'News::test');
});

$routes->add('tin-tuc', 'News::index', ['namespace' => 'App\Modules\News\Controllers']);

$routes->add('(:any)-post(:num)c(:num).html', 'Detail::index/$1/$2/$3', ['namespace' => 'App\Modules\News\Controllers']);
$routes->add('(:any)-post(:num)C(:num).html', 'Detail::index/$1/$2/$3', ['namespace' => 'App\Modules\News\Controllers']);
$routes->add('(:any)-post(:num)c(:num).preview', 'Detail::index/$1/$2/$3/preview', ['namespace' => 'App\Modules\News\Controllers']);

$routes->add('tag/(:any).html', 'Tag::index/$1', ['namespace' => 'App\Modules\News\Controllers']);

//Quet tin
$routes->add('robot/(:segment)/(:segment)', 'Robot::index/$1/$2', ['namespace' => 'App\Modules\News\Controllers']);

//$routes->add('sitemap.xml', 'Sitemap::index', ['namespace' => 'App\Modules\News\Controllers']);
//$routes->add('sitemap-category.xml', 'Sitemap::category', ['namespace' => 'App\Modules\News\Controllers']);
//$routes->add('sitemap-news.xml', 'Sitemap::news', ['namespace' => 'App\Modules\News\Controllers']);
//$routes->add('sitemap-news-(:any).xml', 'Sitemap::news/$1', ['namespace' => 'App\Modules\News\Controllers']);
//
//$routes->add('sitemap-post-(:any).xml', 'Sitemap::post/$1', ['namespace' => 'App\Modules\News\Controllers']);

$routes->add('fb-news', 'Facebook::index', ['namespace' => 'App\Modules\News\Controllers']);
