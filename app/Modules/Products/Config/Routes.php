<?php

if(!isset($routes))
{
    $routes = \Config\Services::routes(true);
}

$routes->group('products', ['namespace' => 'App\Modules\Products\Controllers'], function($subroutes){
    $subroutes->add('manage', 'Manage::index');
    $subroutes->add('manage/add', 'Manage::add');
    $subroutes->add('manage/edit/(:num)', 'Manage::edit/$1');
    $subroutes->add('manage/delete', 'Manage::delete');
    $subroutes->add('manage/publish', 'Manage::publish');

    $subroutes->add('weight_class_manage', 'WeightClassManage::index');
    $subroutes->add('weight_class_manage/add', 'WeightClassManage::add');
    $subroutes->add('weight_class_manage/edit/(:num)', 'WeightClassManage::edit/$1');
    $subroutes->add('weight_class_manage/delete', 'WeightClassManage::delete');

    $subroutes->add('length_class_manage', 'LengthClassManage::index');
    $subroutes->add('length_class_manage/add', 'LengthClassManage::add');
    $subroutes->add('length_class_manage/edit/(:num)', 'LengthClassManage::edit/$1');
    $subroutes->add('length_class_manage/delete', 'LengthClassManage::delete');
});
