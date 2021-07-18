<?php

if(!isset($routes))
{
    $routes = \Config\Services::routes(true);
}

$routes->group('news', ['namespace' => 'App\Modules\News\Controllers'], function($subroutes){
    $subroutes->add('manage', 'Manage::index');
    $subroutes->add('manage/add', 'Manage::add');
    $subroutes->add('manage/edit/(:num)', 'Manage::edit/$1');
    $subroutes->add('manage/delete', 'Manage::delete');
    $subroutes->add('manage/publish', 'Manage::publish');
    $subroutes->add('manage/robot', 'Manage::Robot');

    $subroutes->add('categories_manage', 'CategoriesManage::index');
    $subroutes->add('categories_manage/add', 'CategoriesManage::add');
    $subroutes->add('categories_manage/edit/(:num)', 'CategoriesManage::edit/$1');
    $subroutes->add('categories_manage/delete', 'CategoriesManage::delete');
    $subroutes->add('categories_manage/publish', 'CategoriesManage::publish');
    $subroutes->add('categories_manage/update_sort', 'CategoriesManage::updateSort');
});

$routes->add('tin-tuc', 'News::index', ['namespace' => 'App\Modules\News\Controllers']);
$routes->add('(:any)-post(:num)C(:num).html', 'Detail::index/$1/$2/$3', ['namespace' => 'App\Modules\News\Controllers']);
$routes->add('tag/(:any).html', 'Tag::index/$1', ['namespace' => 'App\Modules\News\Controllers']);