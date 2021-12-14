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

    $subroutes->add('weight_classes_manage', 'WeightClassesManage::index');
    $subroutes->add('weight_classes_manage/add', 'WeightClassesManage::add');
    $subroutes->add('weight_classes_manage/edit/(:num)', 'WeightClassesManage::edit/$1');
    $subroutes->add('weight_classes_manage/delete', 'WeightClassesManage::delete');

    $subroutes->add('length_classes_manage', 'LengthClassesManage::index');
    $subroutes->add('length_classes_manage/add', 'LengthClassesManage::add');
    $subroutes->add('length_classes_manage/edit/(:num)', 'LengthClassesManage::edit/$1');
    $subroutes->add('length_classes_manage/delete', 'LengthClassesManage::delete');
});
