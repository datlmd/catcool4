<?php

if(!isset($routes))
{
    $routes = \Config\Services::routes(true);
}

$routes->group('articles', ['namespace' => 'App\Modules\Articles\Controllers'], function($subroutes){
    $subroutes->add('categories_manage', 'CategoriesManage::index');
    $subroutes->add('categories_manage/add', 'CategoriesManage::add');
    $subroutes->add('categories_manage/edit/(:num)', 'CategoriesManage::edit/$1');
    $subroutes->add('categories_manage/delete', 'CategoriesManage::delete');
    $subroutes->add('categories_manage/publish', 'CategoriesManage::publish');
    $subroutes->add('categories_manage/update_sort', 'CategoriesManage::updateSort');
});
