<?php
namespace Config;

use CodeIgniter\Config\BaseConfig;

class Theme extends BaseConfig
{
    public $theme = [
        'theme'            => 'default',
        'master'           => 'default',
        'layout'           => 'default',
        'title_sep'        => '&#150;',
        'compress'         => (ENVIRONMENT == 'production'),
        'cache_lifetime'   => 0,
        'cdn_enabled'      => (ENVIRONMENT == 'production'),
        'cdn_server'       => '', // i.e: 'http://static.myhost.com/';
        'site_name'        => '',
        'site_description' => '',
        'site_keywords'    => '',
    ];
}

