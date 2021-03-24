<?php 

if(!isset($routes))
{
	$routes = \Config\Services::routes(true);
}

$routes->add('iphone-12', 'Detail/4', ['namespace' => 'App\Modules\Products\Controllers']);
$routes->add('iphone-12', 'Detail/4', ['namespace' => 'App\Modules\Products\Controllers']);
$routes->add('product-1', 'Fds', ['namespace' => 'App\Modules\Fds\Controllers']);
$routes->add('tk-admin', 'Manage::Edit/1', ['namespace' => 'App\Modules\Users\Controllers']);
$routes->add('bai-viet-moi', 'Detail/19', ['namespace' => 'App\Modules\Articles\Controllers']);
$routes->add('hello-all', 'Detail/19', ['namespace' => 'App\Modules\Articles\Controllers']);
$routes->add('dien-thoai', 'Detail/10', ['namespace' => 'App\Modules\Categories\Controllers']);
$routes->add('type-phone', 'Detail/10', ['namespace' => 'App\Modules\Categories\Controllers']);
$routes->add('(:any).(:num)C(:num)', 'News/detail/$1/$2/$3', ['namespace' => 'App\Modules\News\Controllers']);
$routes->add('iphone-123', 'Dfdsf', ['namespace' => 'App\Modules\Sdf\Controllers']);
