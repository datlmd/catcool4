<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
//$routes->get('/', 'Home::index'); //datlm

//datlm
$routes->get('install', 'Install::index');

$routes->set404Override('App\Modules\Frontend\Controllers\Error404::index'); //datlm

$routes->get('/', 'Posts::index', ['namespace' => 'App\Modules\Posts\Controllers']);

$routes->add('sitemap.xml', 'Sitemap::index');
$routes->add('sitemap-category.xml', 'Sitemap::category');
$routes->add('sitemap-post-(:any).xml', 'Sitemap::post/$1');

foreach(glob(APPPATH . 'Modules/*', GLOB_ONLYDIR) as $item_dir) {
    if (file_exists($item_dir . '/Config/Routes.php')) {
        require_once($item_dir . '/Config/Routes.php');
    }
}

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}

/*
 * Additional Routing More - Database datlm
 */
if (is_file(WRITEPATH . 'config/Routes.php')) {
    require WRITEPATH . 'config/Routes.php';
}

