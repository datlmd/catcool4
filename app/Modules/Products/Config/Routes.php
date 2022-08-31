<?php

if(!isset($routes))
{
    $routes = \Config\Services::routes(true);
}

$routes->group('products', ['namespace' => 'App\Modules\Products\Controllers'], function($subroutes){
    $subroutes->add('manage', 'Manage::index');
    $subroutes->add('manage/add', 'Manage::add');
    $subroutes->add('manage/save', 'Manage::save');
    $subroutes->add('manage/edit/(:num)', 'Manage::edit/$1');
    $subroutes->add('manage/delete', 'Manage::delete');
    $subroutes->add('manage/publish', 'Manage::publish');
    $subroutes->add('manage/related', 'Manage::related');

    $subroutes->add('weight_classes_manage', 'WeightClassesManage::index');
    $subroutes->add('weight_classes_manage/add', 'WeightClassesManage::add');
    $subroutes->add('weight_classes_manage/edit/(:num)', 'WeightClassesManage::edit/$1');
    $subroutes->add('weight_classes_manage/delete', 'WeightClassesManage::delete');

    $subroutes->add('length_classes_manage', 'LengthClassesManage::index');
    $subroutes->add('length_classes_manage/add', 'LengthClassesManage::add');
    $subroutes->add('length_classes_manage/edit/(:num)', 'LengthClassesManage::edit/$1');
    $subroutes->add('length_classes_manage/delete', 'LengthClassesManage::delete');

    $subroutes->add('stock_statuses_manage', 'StockStatusesManage::index');
    $subroutes->add('stock_statuses_manage/add', 'StockStatusesManage::add');
    $subroutes->add('stock_statuses_manage/edit/(:num)', 'StockStatusesManage::edit/$1');
    $subroutes->add('stock_statuses_manage/delete', 'StockStatusesManage::delete');
    $subroutes->add('stock_statuses_manage/publish', 'StockStatusesManage::publish');

    $subroutes->add('order_statuses_manage', 'OrderStatusesManage::index');
    $subroutes->add('order_statuses_manage/add', 'OrderStatusesManage::add');
    $subroutes->add('order_statuses_manage/edit/(:num)', 'OrderStatusesManage::edit/$1');
    $subroutes->add('order_statuses_manage/delete', 'OrderStatusesManage::delete');
    $subroutes->add('order_statuses_manage/publish', 'OrderStatusesManage::publish');

    $subroutes->add('categories_manage', 'CategoriesManage::index');
    $subroutes->add('categories_manage/add', 'CategoriesManage::add');
    $subroutes->add('categories_manage/edit/(:num)', 'CategoriesManage::edit/$1');
    $subroutes->add('categories_manage/delete', 'CategoriesManage::delete');
    $subroutes->add('categories_manage/publish', 'CategoriesManage::publish');
    $subroutes->add('categories_manage/update_sort', 'CategoriesManage::updateSort');
});
