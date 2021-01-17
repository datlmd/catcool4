<?php namespace Config;

use CodeIgniter\Config\BaseConfig;

class Themes extends BaseConfig
{
    /**
	 * Default Theme name
	 *
	 * This can be overide on run-time
	 */
	public $theme = 'default';

    /**
	 * Theme Path - Respect to FCPATH
	 */
	public $theme_path = 'themes';

    /**
     * Them master @var string
     */
    public $master = 'default';

    /**
     * Theme layout @var string
     */
    public $layout = 'default';

    public $compress = false;

	/**
	 * CSS path inside theme path
	 */
	public $css_path = 'css';

	/**
	 * JS path inside theme path
	 */
	public $js_path = 'js';

	/**
	 * Image path inside theme path
	 */
    public $image_path = 'images';
    
	/**
	 * Header template name
	 */
	public $header = 'header';

	/**
	 * Main template name
	 */
	public $template = 'default';

	/**
	 * Footer template name
	 */
	public $footer = 'footer';

	/**
	 * Wether use only one full template (skip header & footer template)
	 */
	public $use_full_template = FALSE;

	/**
	 * Plugins path inside theme path
	 */
	public $plugin_path = 'plugins';

	/**
	 * Registered Plugins
	 * Format: 
	 * [ 
	 * 	 'plugin_key_name' => [
	 * 		'js'  => [...js_array]
	 * 		'css'  => [...css_array]
	 *   ]
	 * ]
	 * 
	 */
	public $plugins = [
		'bootbox' => [
			'js' => [
				//'bootbox/bootbox-en.min.js'
			]
		]
	];

}