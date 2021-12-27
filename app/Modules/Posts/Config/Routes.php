<?php

if(!isset($routes))
{
    $routes = \Config\Services::routes(true);
}

$routes->group('posts', ['namespace' => 'App\Modules\Posts\Controllers'], function($subroutes){
    $subroutes->add('manage', 'Manage::index');
    $subroutes->add('manage/add', 'Manage::add');
    $subroutes->add('manage/edit/(:any)', 'Manage::edit/$1');
    $subroutes->add('manage/delete', 'Manage::delete');
    $subroutes->add('manage/publish', 'Manage::publish');
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
});

$routes->add('(:any)-post(:num).html', 'Detail::index/$1/$2', ['namespace' => 'App\Modules\Posts\Controllers']);
$routes->add('(:any)-post(:num).preview', 'Detail::index/$1/$2/preview', ['namespace' => 'App\Modules\Posts\Controllers']);

$routes->add('post-tag/(:any).html', 'Tag::index/$1', ['namespace' => 'App\Modules\Posts\Controllers']);
