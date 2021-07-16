<?php 

if(!isset($routes))
{
	$routes = \Config\Services::routes(true);
}

$routes->add('sao-html-html.html', 'Categories::Detail/1', ['namespace' => 'App\Modules\News\Controllers']);
$routes->add('am-nhac.html', 'Categories::Detail/3', ['namespace' => 'App\Modules\News\Controllers']);
$routes->add('thoi-trang.html', 'Categories::Detail/4', ['namespace' => 'App\Modules\News\Controllers']);
$routes->add('phim-anh.html', 'Categories::Detail/2', ['namespace' => 'App\Modules\News\Controllers']);
$routes->add('gioi-tinh.html', 'Categories::Detail/5', ['namespace' => 'App\Modules\News\Controllers']);
$routes->add('xa-hoi.html', 'Categories::Detail/7', ['namespace' => 'App\Modules\News\Controllers']);
$routes->add('the-gioi.html', 'Categories::Detail/8', ['namespace' => 'App\Modules\News\Controllers']);
$routes->add('the-thao.html', 'Categories::Detail/6', ['namespace' => 'App\Modules\News\Controllers']);
$routes->add('hoc-duong.html', 'Categories::Detail/10', ['namespace' => 'App\Modules\News\Controllers']);
$routes->add('cong-nghe.html', 'Categories::Detail/9', ['namespace' => 'App\Modules\News\Controllers']);
