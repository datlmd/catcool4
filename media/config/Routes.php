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
$routes->add('ten-333', 'Detail/11', ['namespace' => 'App\Modules\Categories\Controllers']);
$routes->add('dien-thoai', 'Detail/11', ['namespace' => 'App\Modules\Categories\Controllers']);
$routes->add('ten', 'Detail/11', ['namespace' => 'App\Modules\Categories\Controllers']);
$routes->add('gfdgfdggdffgfdgfd', 'Categories/detail/13', ['namespace' => 'App\Modules\Articles\Controllers']);
$routes->add('-dfggdfgdfgdfg-', 'Categories/detail/21', ['namespace' => 'App\Modules\Articles\Controllers']);
$routes->add('dat-le', 'Detail/3', ['namespace' => 'App\Modules\Articles\Controllers']);
$routes->add('dat-le', 'Detail/3', ['namespace' => 'App\Modules\Articles\Controllers']);
$routes->add('gioi-thieu', 'Pages::Detail/1', ['namespace' => 'App\Modules\Pages\Controllers']);
$routes->add('about-us', 'Pages::Detail/1', ['namespace' => 'App\Modules\Pages\Controllers']);
