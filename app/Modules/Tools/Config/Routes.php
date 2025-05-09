<?php

if (!isset($routes)) {
    $routes = \Config\Services::routes(true);
}

$routes->group('tools', ['namespace' => 'App\Modules\Tools\Controllers'], function ($subroutes) {
    $subroutes->add('youtube', 'Youtube::index');
    $subroutes->add('youtube/api_youtube_video', 'Youtube::apiYoutubeVideo');
    $subroutes->add('youtube/huong-dan-tai', 'Youtube::download');

});

$routes->add('huong-dan-tai-video-youtube.html', 'Youtube::index', ['namespace' => 'App\Modules\Tools\Controllers']);
