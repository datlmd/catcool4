<?php

if(!isset($routes))
{
    $routes = \Config\Services::routes(true);
}

$routes->group('news', ['namespace' => 'App\Modules\News\Controllers'], function($subroutes){
    $subroutes->add('manage', 'Manage::index');
    $subroutes->add('manage/add', 'Manage::add');
    $subroutes->add('manage/edit/(:any)', 'Manage::edit/$1');
    $subroutes->add('manage/delete', 'Manage::delete');
    $subroutes->add('manage/publish', 'Manage::publish');
    $subroutes->add('manage/robot', 'Manage::robot');
    $subroutes->add('manage/status', 'Manage::status');
    $subroutes->add('manage/related', 'Manage::related');
    $subroutes->add('manage/fix', 'Manage::fix');
    $subroutes->add('manage/restore/(:any)', 'Manage::restore/$1');
    $subroutes->add('manage/empty_trash', 'Manage::emptyTrash');

    $subroutes->add('categories_manage', 'CategoriesManage::index');
    $subroutes->add('categories_manage/add', 'CategoriesManage::add');
    $subroutes->add('categories_manage/edit/(:num)', 'CategoriesManage::edit/$1');
    $subroutes->add('categories_manage/delete', 'CategoriesManage::delete');
    $subroutes->add('categories_manage/publish', 'CategoriesManage::publish');
    $subroutes->add('categories_manage/update_sort', 'CategoriesManage::updateSort');

    $subroutes->add('test/(:any)', 'News::test/$1');
    $subroutes->add('test', 'News::test');
});

$routes->add('tin-tuc', 'News::index', ['namespace' => 'App\Modules\News\Controllers']);

$routes->add('(:any)-post(:num)c(:num).html', 'Detail::index/$1/$2/$3', ['namespace' => 'App\Modules\News\Controllers']);
$routes->add('(:any)-post(:num)C(:num).html', 'Detail::index/$1/$2/$3', ['namespace' => 'App\Modules\News\Controllers']);
$routes->add('(:any)-post(:num)c(:num).preview', 'Detail::index/$1/$2/$3/preview', ['namespace' => 'App\Modules\News\Controllers']);

$routes->add('tag/(:any).html', 'Tag::index/$1', ['namespace' => 'App\Modules\News\Controllers']);

$routes->add('robot/(:segment)/(:segment)', 'Robot::index/$1/$2', ['namespace' => 'App\Modules\News\Controllers']);

$routes->add('sitemap.xml', 'Sitemap::index', ['namespace' => 'App\Modules\News\Controllers']);
$routes->add('sitemap-category.xml', 'Sitemap::category', ['namespace' => 'App\Modules\News\Controllers']);
$routes->add('sitemap-news.xml', 'Sitemap::news', ['namespace' => 'App\Modules\News\Controllers']);
$routes->add('sitemap-news-(:any).xml', 'Sitemap::news/$1', ['namespace' => 'App\Modules\News\Controllers']);

$routes->add('fb-news', 'Facebook::index', ['namespace' => 'App\Modules\News\Controllers']);
