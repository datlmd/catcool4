<?php

if(!isset($routes))
{
    $routes = \Config\Services::routes(true);
}

$routes->group('manage', ['namespace' => 'App\Modules\Products\Controllers\Admin', 'filter' => 'auth_admin'], function($subroutes){
    $subroutes->add('products', 'Products::index');
    $subroutes->add('products/add', 'Products::add');
    $subroutes->add('products/save', 'Products::save');
    $subroutes->add('products/edit/(:num)', 'Products::edit/$1');
    $subroutes->add('products/delete', 'Products::delete');
    $subroutes->add('products/publish', 'Products::publish');
    $subroutes->add('products/related', 'Products::related');
    $subroutes->add('products/edit_sku', 'Products::editSku');
    $subroutes->add('products/get_sku_list', 'Products::getSkuList');

    $subroutes->add('product_weight_classes', 'WeightClasses::index');
    $subroutes->add('product_weight_classes/add', 'WeightClasses::add');
    $subroutes->add('product_weight_classes/edit/(:num)', 'WeightClasses::edit/$1');
    $subroutes->add('product_weight_classes/delete', 'WeightClasses::delete');

    $subroutes->add('product_length_classes', 'LengthClasses::index');
    $subroutes->add('product_length_classes/add', 'LengthClasses::add');
    $subroutes->add('product_length_classes/edit/(:num)', 'LengthClasses::edit/$1');
    $subroutes->add('product_length_classes/delete', 'LengthClasses::delete');

    $subroutes->add('product_stock_statuses', 'StockStatuses::index');
    $subroutes->add('product_stock_statuses/add', 'StockStatuses::add');
    $subroutes->add('product_stock_statuses/edit/(:num)', 'StockStatuses::edit/$1');
    $subroutes->add('product_stock_statuses/delete', 'StockStatuses::delete');
    $subroutes->add('product_stock_statuses/publish', 'StockStatuses::publish');

    $subroutes->add('product_order_statuses', 'OrderStatuses::index');
    $subroutes->add('product_order_statuses/add', 'OrderStatuses::add');
    $subroutes->add('product_order_statuses/edit/(:num)', 'OrderStatuses::edit/$1');
    $subroutes->add('product_order_statuses/delete', 'OrderStatuses::delete');
    $subroutes->add('product_order_statuses/publish', 'OrderStatuses::publish');

    $subroutes->add('product_categories', 'Categories::index');
    $subroutes->add('product_categories/add', 'Categories::add');
    $subroutes->add('product_categories/edit/(:num)', 'Categories::edit/$1');
    $subroutes->add('product_categories/delete', 'Categories::delete');
    $subroutes->add('product_categories/publish', 'Categories::publish');
    $subroutes->add('product_categories/update_sort', 'Categories::updateSort');
});

$routes->group('product', ['namespace' => 'App\Modules\Products\Controllers'], function ($subroutes) {
    $subroutes->add('/', 'Articles::index');
    $subroutes->add('list', 'Articles::index');
    $subroutes->add('(:num)', 'Detail::index/$1');

    $subroutes->add('category/(:num)', 'Category::index/$1');
});

//Set route category
$routes->add('(:any)-' . '(:num)' . SEO_PRODUCT_CATEGORY_ID . '.' . SEO_EXTENSION, 'Category::index/$1/$2', ['namespace' => 'App\Modules\Products\Controllers']);
$routes->add('(:any)-' . '(:num)' . SEO_PRODUCT_CATEGORY_ID, 'Category::index/$1/$2', ['namespace' => 'App\Modules\Products\Controllers']);


