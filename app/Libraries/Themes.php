<?php namespace App\Libraries;

/**
 * Themes Library for CodeIgniter 4
 *
 * This is an open source themes management for CodeIgniter 4
 *
 * @author    Arif Rahman Hakim
 * @copyright Copyright (c) 2020, Arif Rahman Hakim  (http://github.com/arif-rh)
 * @license   BSD - http://www.opensource.org/licenses/BSD-3-Clause
 * @link      https://github.com/arif-rh/ci4-themes
 * @version   0.0.1
 */

use App\Exceptions\ThemesException;

/**
 * Class Themes
 *
 * @package 
 */
class Themes 
{
	/**
	 * Constant of key for css themes
	 */
	const CSS_THEME = 'css_themes';

	/**
	 * Constant of key for external css
	 */
	const EXTERNAL_CSS = 'external_css';

	/**
	 * Constant of key for js themes
	 */
	const JS_THEME = 'js_themes';

	/**
	 * Constant of key for external js
	 */
	const EXTERNAL_JS = 'external_js';

	/**
	 * Constant of key for inline js
	 */
	const INLINE_JS = 'inline_js';

	/**
	 * Constant of key for loaded plugin
	 */
	const LOADED_PLUGIN = 'loaded_plugins';

	/**
	 * Constant of variable that will be used as page title inside template
	 */
	const PAGE_TITLE = 'page_title';

	/**
	 * Constant of variable that will be used as content inside template
	 */
	const CONTENT = 'content';
	
	/**
	 * Themes instance 
	 *
	 * @var    object||null
	 * @access private
	 */
	private static $instance = null;

	/**
	 * Theme variables - store variables to be used in template file
	 *
	 * @var    array
	 * @access protected
	 */
	protected static $themeVars = [];

	/**
	 * Themes Configuration - Used from \Catcool\Config\Themes but can be overiden in the run-time
	 *
	 * @var    array
	 * @access protected
	 */
	protected static $config = [];

    public $module = null;
    public $controller = null;
    public $method = null;
    protected static $metadata = [];
    protected static $partials = [];

	/**
	 * Intantiate Themes with default config 
	 *
	 * @param  \Config\Themes    $config
	 * 
	 * @return void
	 */
	public static function init($config = null)
	{
		if (self::$instance === null)
		{
			self::$instance = new self;
		}

		if (is_null($config))
		{
			$config = config('Themes');
		}

		self::$instance::$themeVars = null;

		self::$config = (array) $config;

		// define constant for config reference key var
		foreach($config as $theme_key => $theme_value)
		{
			$constant = strtoupper($theme_key);

			if (!defined($constant))
			{
				define($constant, $theme_key);
			}
		}

		self::$instance->setTheme(self::$config[THEME]);

        $router          = service('router');
        $controller_full = $router->controllerName();//\App\Modules\Dummy\Controllers\Manage
        $controller_full = explode('\\', $controller_full);

        self::$instance->module     = !empty($controller_full[3]) ? $controller_full[3] : null;
        self::$instance->controller = !empty($controller_full[5]) ? $controller_full[5] : self::$instance->module;
        self::$instance->method     = $router->methodName();

		return self::$instance;
	}

	/**
	 * add css file(s) to be loaded inside template
	 *
	 * @param   string||array   $css_files
	 * 
	 *@return $this \Themes
	 */	
	public function addCSS($css_files = [])
	{
		$css_files = is_array($css_files) ? $css_files : explode(',', $css_files);

		foreach ($css_files as $css)
		{
			$css = trim($css);

			if (!empty($css))
			{
				// set unique key-index to prevent duplicate css being included
				self::$themeVars[self::CSS_THEME][sha1($css)] = $css;
			}			
		}

		return $this;
	}

	/**
	 * add js file(s) to be loaded inside template
	 *
	 * @param   string||array   $js_files
	 * 
	 *@return $this \Themes
	 */
	public function addJS($js_files)
	{
		$js_files = is_array($js_files) ? $js_files : explode(',', $js_files);

		foreach ($js_files as $js)
		{
			$js = trim($js);

			if (!empty($js))
			{
				// set unique key-index to prevent duplicate js being included
				self::$themeVars[self::JS_THEME][sha1($js)] = $js;
			}
		}

		return $this;
	}

	/**
	 * Adding inline JS to the template
	 *  
	 * @param string $js_scripts
	 * 
	 * @return $this \Themes
	 */ 
	public function addInlineJS($js_scripts)
	{
		$js = trim($js_scripts);

		if (!empty($js))
		{
			self::$themeVars[self::INLINE_JS][sha1($js)] = $js;
		}

		return $this;
	}

	/**
	 * Adding i18n JS to the template
	 *  
	 * @param string  $js_scripts
	 * @param mixed[] $langs
	 * 
	 * @return $this \Themes
	 */ 
	public function addI18nJS(string $js_scripts, array $langs = [])
	{
		helper('themes');

		$js = trim($js_scripts);

		if (!empty($js))
		{
			if (pathinfo($js, PATHINFO_EXTENSION) == 'js')
			{
				$js = FCPATH . self::$config[THEME_PATH] . '/' . self::$config[THEME] . '/' . self::$config[JS_PATH] . '/' . $js;
			}

			self::$themeVars[self::INLINE_JS][sha1($js)] = translate($js, $langs);
		}

		return $this;
	}

	/**
	 * Add CSS from external source (fully css url)
	 * 
	 * @param string||array $full_css_path
	 * 
	 * @return $this \Themes
	 */
	public function addExternalCSS($full_css_path = null)
	{
		$full_css_path = is_array($full_css_path) ? $full_css_path : explode(',', $full_css_path);

		foreach ($full_css_path as $css)
		{
			$css = trim($css);

			if (!empty( $css ))
			{
				self::$themeVars[self::EXTERNAL_CSS][sha1($css)] = $css;
			}
		}

		return $this;
	}

	/**
	 * Add JS from external source (fully js url)
	 * 
	 * @param string||array $full_js_path
	 * 
	 * @return $this \Themes
	 */
	public function addExternalJS($full_js_path = null)
	{
		$full_js_path = is_array($full_js_path) ? $full_js_path : explode(',', $full_js_path);

		foreach ($full_js_path as $js)
		{
			$js = trim($js);

			if (!empty($js))
			{
				self::$themeVars[self::EXTERNAL_JS][sha1($js)] = $js;
			}
		}

		return $this;
	}

	/**
	 * Load Registered Plugins
	 * 
	 * @param string||array $plugins
	 * 
	 * @return $this \Themes
	 */
	public function loadPlugins($plugins)
	{
		$plugins = is_array($plugins) ? $plugins : explode(',', $plugins);

		foreach ($plugins as $plugin)
		{
			$plugin = trim($plugin);

			if (!empty($plugin))
			{
				if (!array_key_exists($plugin, self::$config['plugins']))
				{
					throw ThemesException::forPluginNotRegistered($plugin);
				}

				$this->loadPlugin($plugin);
			}
		}

		return $this;
	}

	/**
	 * Load Each Plugin
	 * 
	 * @param string $plugin key of plugin
	 */
	protected function loadPlugin($plugin)
	{
		$plugin_url = self::$themeVars['plugin_url'];

		foreach(self::$config['plugins'][$plugin] as $type => $plugin_files)
		{
			foreach($plugin_files as $plugin_file)
			{
				$plugin_path = str_replace(base_url(), FCPATH, $plugin_url);

				if (!is_file($plugin_path . $plugin_file))
				{
					throw ThemesException::forPluginNotFound($plugin_file);
				}

				self::$themeVars[self::LOADED_PLUGIN][$type][] = $plugin_url . $plugin_file;
			}
		}
	}

	/**
	 * Wether themes used full template or not
	 * 
	 * @param boolean $use_full_template
	 * 
	 * @return $this \Themes
	 */
	public function useFullTemplate($use_full_template = true)
	{
		self::$config['use_full_template'] = $use_full_template;

		return $this;
	}

	/**
	 * Set Header Template in the run-time
	 * 
	 * @param string $header_name
	 * 
	 * @return $this \Themes
	 */
	public function setHeader($header_name = null)
	{
		if (is_string($header_name))
		{
			self::$config[HEADER] = $header_name;
		}

		return $this;
	}

	/**
	 * Set Main Template in the run-time
	 * 
	 * @param string $template_name
	 * 
	 * @return $this \Themes
	 */
	public function setTemplate($template_name = null)
	{
		if (is_string($template_name))
		{
			self::$config[TEMPLATE] = $template_name;
		}

		return $this;
	}

	/**
	 * Set Footer Template in the run-time
	 * 
	 * @param string $footer_name
	 * 
	 * @return $this \Themes
	 */
	public function setFooter($footer_name = null)
	{
		if (is_string($footer_name))
		{
			self::$config[FOOTER] = $footer_name;
		}

		return $this;
	}

	/**
	 * Set Theme in the run-time
	 * 
	 * @param string $theme_name
	 * 
	 * @return $this \Themes
	 */
	public function setTheme($theme_name = null)
	{
		if (is_string($theme_name))
		{
			self::$config[THEME] = $theme_name;
		}

		self::$instance->setVar([
			'theme_url'  => base_url(self::$config[THEME_PATH] . '/' . self::$config[THEME]) . '/',
			'image_url'  => base_url(self::$config[THEME_PATH] . '/' . self::$config[THEME] . '/' . self::$config[IMAGE_PATH]) . '/',
			'plugin_url' => base_url(self::$config[THEME_PATH] . '/' . self::$config[THEME] . '/' . self::$config[PLUGIN_PATH]) . '/',
            'theme_path' => FCPATH . self::$config[THEME_PATH] . '/' . self::$config[THEME] . '/',
		]);

		return $this;
	}

    public function setMaster($theme_master = null)
    {
        if (is_string($theme_master))
        {
            self::$config[MASTER] = $theme_master;
        }

        return $this;
    }

    public function setLayout ($theme_layout = null)
    {
        if (is_string($theme_layout))
        {
            self::$config[LAYOUT] = $theme_layout;
        }

        return $this;
    }

	static function load($viewPath = null, $data = [])
	{
		if (is_null(self::$instance))
		{
			self::init();
		}
		$objTheme = self::$instance;

        $data_master['title']       = !empty($data['title']) ? $data['title'] : (!empty(self::$metadata['title']) ? self::$metadata['title'] : "");
        $data_master['description'] = !empty($data['description']) ? $data['description'] : (!empty(self::$metadata['description']) ? self::$metadata['description'] : "");
        $data_master['keywords']    = !empty($data['keywords']) ? $data['keywords'] : (!empty(self::$metadata['keywords']) ? self::$metadata['keywords'] : "");
        $data_master['metadata']    = $objTheme->_output_meta();

        $objTheme->setVar($data_master);

        $layout = [];
        // Add partial views only if requested
        if ( ! empty(self::$partials))
        {
            foreach (self::$partials as $key => $value)
            {
                $layout[$key] = $value;
            }
            unset($key, $value);
        }

        \Config\Services::timer()->start('render_view');

        // Prepare view content
        $layout['content'] = $objTheme->_loadFile('view', $viewPath, $data);
        // Prepare layout content
        $objTheme->setVar('layout', $objTheme->_loadFile('layout', self::$config[LAYOUT], $layout, true));

        //cc_debug($objTheme::getData());
        // Prepare the output
        $output = $objTheme->_loadFile('default', self::$config[MASTER], $objTheme::getData(), true);

        \Config\Services::timer()->stop('render_view');

        $totalTime = \Config\Services::timer()->getElapsedTime('render_view');

        $output =  str_replace('___theme_time___', $totalTime, $output);

        // Minify HTML output if set to TRE
        if (self::$config[COMPRESS] === true)
        {
            $output = $objTheme->_compress_output($output);
        }

        echo \Config\Services::renderer()->renderString($output);
	}

    protected function _loadFile($type = 'view', $view = '', $data = [], $return = false)
    {
        if (is_null(self::$instance))
        {
            self::init();
        }
        $objTheme = self::$instance;

        if (!empty($data))
        {
            foreach ($data AS $key => $val)
            {
                service('SmartyEngine')->assign($key, $val);
            }
        }

        // If no file extension dot has been found default to defined extension for view extensions
        $template = $view;
        if ( !stripos($view, '.'))
        {
            $template = $view.".".service('SmartyEngine')->template_ext;
        }

        $output = '';

        switch ($type) {
            // In case of a view file
            case 'view':
            case 'views':
                // prepare all path
                $paths = [
                    build_path(FCPATH, self::$config[THEME_PATH], self::$config[THEME], 'views', 'modules', strtolower($objTheme->module)),
                    build_path(APPPATH, 'Modules', $objTheme->module, 'Views'),
                ];
                // remove uneccessary paths if $this->module is null
                if (empty($objTheme->module))
                {
                    unset($paths[1]);
                }
                if ( ! empty($paths))
                {
                    $found  = false;
                    $output = '';
                    foreach (array_unique($paths) as $path)
                    {
                        if (file_exists($path . $template))
                        {
                            $found  = true;
                            $output = service('SmartyEngine')->fetch($path . $template);
                            break;
                        }
                    }
                    if ($found !== true)
                    {
                        throw ThemesException::forMissingTemplateView(" (".$template.") ".implode("<br/>", array_unique($paths)));
                    }
                    return $output;
                }
                break;
            // In case of a partial view
            case 'partial':
            case 'partials':
                // prepare all path
                $paths = [
                    build_path(FCPATH, self::$config[THEME_PATH], self::$config[THEME], 'views', 'partials'),
                    build_path(FCPATH, self::$config[THEME_PATH], self::$config[THEME], 'views', 'modules', strtolower($objTheme->module), 'partials'),
                    build_path(APPPATH, 'Modules', $objTheme->module, 'Views', "partials"),
                ];
                // remove uneccessary paths if $this->module is null
                if (empty($objTheme->module))
                {
                    unset($paths[1], $paths[2]);
                }
                if ( ! empty($paths))
                {
                    $found  = false;
                    $output = '';
                    foreach (array_unique($paths) as $path)
                    {
                        if (file_exists($path . $template))
                        {
                            $found  = true;
                            $output = service('SmartyEngine')->fetch($path . $template);
                            break;
                        }
                    }
                    if ($found !== true)
                    {
                        throw ThemesException::forMissingTemplateView(" (".$template.") ".implode("<br/>", array_unique($paths)));
                    }
                    return $output;
                }

                break;
            // In case of a layout view
            case 'layout':
            case 'layouts':
                // prepare all path
                $paths = [
                    build_path(FCPATH, self::$config[THEME_PATH], self::$config[THEME], 'views', 'layouts'),
                    build_path(FCPATH, self::$config[THEME_PATH], self::$config[THEME], 'views', 'modules', strtolower($objTheme->module), 'layouts'),
                    //build_path(APPPATH, 'modules', $this->module, 'views', '_layouts'),
                ];
                // remove uneccessary paths if $this->module is null
                if (empty($objTheme->module))
                {
                    unset($paths[1]);
                }
                if ( ! empty($paths))
                {
                    $found  = false;
                    $output = '';
                    foreach (array_unique($paths) as $path)
                    {
                        if (file_exists($path . $template))
                        {
                            $found  = true;
                            $output = service('SmartyEngine')->fetch($path . $template);
                            break;
                        }
                    }
                    if ($found !== true)
                    {
                        throw ThemesException::forMissingTemplateView(" (".$template.") ".implode("<br/>", array_unique($paths)));
                    }
                    return $output;
                }

                break;
            // Load main theme file
            case 'main':
            case 'theme':
            case 'master':
            case 'template':
            default:
                // prepare all path
                $paths = [
                    build_path(FCPATH, self::$config[THEME_PATH], self::$config[THEME], 'views', 'master'),
                    build_path(FCPATH, self::$config[THEME_PATH], self::$config[THEME], 'views', 'modules', strtolower($objTheme->module), 'master'),
                    //build_path(APPPATH, 'modules', $this->module, 'views', '_master'),
                ];
                // remove uneccessary paths if $this->module is null
                if (empty($objTheme->module))
                {
                    unset($paths[1]);
                }
                if ( ! empty($paths))
                {
                    $found  = false;
                    $output = '';
                    foreach (array_unique($paths) as $path)
                    {
                        if (file_exists($path . $template))
                        {
                            $found  = true;
                            $output = service('SmartyEngine')->fetch($path . $template);
                            break;
                        }
                    }
                    if ($found !== true)
                    {
                        throw ThemesException::forMissingTemplateView(" (".$template.") ".implode("<br/>", array_unique($paths)));
                    }
                    return $output;
                }
                break;
        }

        return $output;
    }

    public function addPartial($view, $data = [], $name = null)
    {
        if (is_null(self::$instance))
        {
            self::init();
        }
        $objTheme = self::$instance;

        // If $name is not set, we take the last string.
        empty($name) && $name = basename($view);
        self::$partials[$name] = $objTheme->_loadFile('partial', rtrim($view, '/'), $data);

        return $this;
    }

    public static function partial($view, $data = [], $return = false)
    {
        if (is_null(self::$instance))
        {
            self::init();
        }
        $objTheme = self::$instance;

        return $objTheme->_loadFile('partial', $view, $data, $return);
    }

    public function addMeta($name, $content = null, $type = 'meta', $attrs = [])
    {
        if (is_null(self::$instance))
        {
            self::init();
        }
        $objTheme = self::$instance;

        // In case of multiple elements
        if (is_array($name))
        {
            foreach ($name as $key => $val)
            {
                $objTheme->addMeta($key, $val, $type, $attrs);
            }
            return $this;
        }
        self::$metadata[$type.'::'.$name] = [
            'content' => $content,
            'attrs'   => $attrs,
        ];
        return $this;
    }

    public function meta($name, $content = null, $type = 'meta', $attrs = [])
    {
        if (is_null(self::$instance))
        {
            self::init();
        }
        $objTheme = self::$instance;

        // Loop through multiple meta tags
        if (is_array($name))
        {
            $meta = [];
            foreach ($name as $key => $val)
            {
                $meta[] = $objTheme->meta($key, $val, $type, $attrs);
            }
            return implode("\t", $meta);
        }
        $attributes = [];
        switch ($type)
        {
            case 'rel':
                $tag = 'link';
                $attributes['rel']  = $name;
                $attributes['href'] = $content;
                break;
            // In case of a meta tag.
            case 'meta':
            default:
                if ($name == 'charset')
                {
                    return "<meta charset=\"{$content}\">\n\t";
                }
                if ($name == 'base')
                {
                    return "<base href=\"{$content}\">\n\t";
                }
                // The tag by default is "meta"
                $tag = 'meta';

                // In case of using Open Graph tags,
                // we user 'property' instead of 'name'.
                $type = (strpos($name, 'og:') !== false)? 'property': 'name';
                if ($content === null)
                {
                    $attributes[$type] = $name;
                }
                else
                {
                    $attributes[$type] = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
                    $attributes['content'] = htmlspecialchars($content, ENT_QUOTES, 'UTF-8');
                }
                break;
        }
        if (is_array($attrs))
        {
            $attributes = _stringify_attributes(array_merge($attributes, $attrs));
        }
        else
        {
            $attributes = _stringify_attributes($attributes).' '.$attrs;
        }
        return "<{$tag}{$attributes}>\n\t";
    }

    protected function _output_meta()
    {
        if (is_null(self::$instance))
        {
            self::init();
        }
        $objTheme = self::$instance;

        $output = '';

        if ( ! empty(self::$metadata))
        {
            foreach(self::$metadata as $key => $val)
            {
                list($type, $name) = explode('::', $key);
                $content = isset($val['content'])? $val['content']: null;
                $attrs   = isset($val['attrs'])? $val['attrs']: null;
                $output .= $objTheme->meta($name, $content, $type, $attrs);
            }
        }
        return $output;
    }

    /**
     * Compresses the HTML output
     * @access 	protected
     * @param 	string 	$output 	the html output to compress
     * @return 	string 	the minified version of $output
     */
    protected function _compress_output($output)
    {
        // Make sure $output is always a string
        is_string($output) or $output = (string) $output;
        // In orders, we are searching for
        // 1. White-spaces after tags, except space.
        // 2. White-spaces before tags, except space.
        // 3. Multiple white-spaces sequences.
        // 4. HTML comments
        // 5. CDATA
        // We return the minified $output
        return preg_replace([
            '/\>[^\S ]+/s',
            '/[^\S ]+\</s',
            '/(\s)+/s',
            '/<!--(?!<!)[^\[>].*?-->/s',
            '#(?://)?<!\[CDATA\[(.*?)(?://)?\]\]>#s',
        ], [
            '>',
            '<',
            '\\1',
            '',
            "//&lt;![CDATA[\n".'\1'."\n//]]>"
        ], $output);
    }

    /**
     * Render view or plain text or html into template theme
     *
     * @param string $viewPath
     * @param array  $data
     */
    static function render($viewPath = null, $data = [])
    {
        if (is_null(self::$instance))
        {
            self::init();
        }

        $objTheme = self::$instance;
        $objTheme->setvar($data);

        if (!$objTheme->templateExist(self::$config[TEMPLATE]))
        {
            throw ThemesException::forMissingTemplateView(self::$config[TEMPLATE]);
        }

        $objTheme->setContent($viewPath, $objTheme::getData());

        // use custom view using theme path
        $view_config = Config('View');

        $view = new \CodeIgniter\View\View($view_config, FCPATH . self::$config[THEME_PATH] . '/' . self::$config[THEME] . '/');

        $view->setData($objTheme::getData());

        if (self::$config['use_full_template'])
        {
            echo $view->render(self::$config[TEMPLATE]);
        }
        else
        {
            if ($objTheme->templateExist(self::$config[HEADER]))
            {
                echo $view->render(self::$config[HEADER]);
            }

            echo $view->render(self::$config[TEMPLATE]);

            if ($objTheme->templateExist(self::$config[FOOTER]))
            {
                echo $view->render(self::$config[FOOTER]);
            }
        }
    }

	/**
	 * render CSS themes
	 */
	public static function renderCSS()
	{
		helper('themes');

		// proceed external css, if exist
		if (array_key_exists(self::EXTERNAL_CSS, self::$themeVars))
		{
			foreach(self::$themeVars[self::EXTERNAL_CSS] as $css)
			{
				echo link_tag($css);
			}
		}

		// proceed plugin css, if exist
		if (array_key_exists(self::LOADED_PLUGIN, self::$themeVars) && array_key_exists('css', self::$themeVars[self::LOADED_PLUGIN]))
		{
			foreach(self::$themeVars[self::LOADED_PLUGIN]['css'] as $css)
			{
				echo link_tag($css);
			}
		}

		// proceed css themes, if exist
		if (array_key_exists(self::CSS_THEME, self::$themeVars))
		{
			foreach(self::$themeVars[self::CSS_THEME] as $css)
			{
				$css_file = FCPATH . self::$config[THEME_PATH] . '/' . self::$config[THEME] . '/' . self::$config['css_path'] . '/' . validate_ext($css, '.css');

				if (is_file($css_file))
				{
					$latest_version = filemtime($css_file);

					$css_file   = str_replace(FCPATH, '', $css_file);
					$latest_css = base_url($css_file . '?v=' . $latest_version);

					echo link_tag($latest_css);
				}
			}
		}
	}

	/**
	 * render JS themes
	 */
	public static function renderJS()
	{
		helper('themes');
	
		self::renderExtraJs();

		// proceed main js theme, if exist
		if (array_key_exists(self::JS_THEME, self::$themeVars))
		{
			foreach(self::$themeVars[self::JS_THEME] as $js)
			{
				$js_file = FCPATH . self::$config[THEME_PATH] . '/' . self::$config[THEME] . '/' . self::$config[JS_PATH] . '/' . validate_ext($js, '.js');

				if (is_file($js_file))
				{
					$latest_version = filemtime($js_file);
					
					$js_file   = str_replace(FCPATH, '', $js_file);
					$latest_js = base_url($js_file . '?v=' . $latest_version);

					echo script_tag($latest_js);
				}
			}
		}

		// proceed inline js, if exist
		if (array_key_exists(self::INLINE_JS, self::$themeVars))
		{
			$inline_js = '<script type="text/javascript">' . PHP_EOL; 
			
			foreach(self::$themeVars[self::INLINE_JS] as $js)
			{
				$inline_js .= $js . PHP_EOL;
			}

			$inline_js .= '</script>' . PHP_EOL;

			echo $inline_js;
		}
	}

	/**
	 * Render Inline JS
	 */
	protected static function renderExtraJs()
	{
		// proceed external js, if exist
		if (array_key_exists(self::EXTERNAL_JS, self::$themeVars))
		{
			foreach(self::$themeVars[self::EXTERNAL_JS] as $js)
			{
				echo script_tag($js);
			}
		}

		// proceed plugin js, if exist
		if (array_key_exists(self::LOADED_PLUGIN, self::$themeVars) && array_key_exists('js', self::$themeVars[self::LOADED_PLUGIN]))
		{
			foreach(self::$themeVars[self::LOADED_PLUGIN]['js'] as $js)
			{
				echo script_tag($js);
			}
		}
	}

	/**
 	* Check does template exist 
 	* 
 	* @param string $template
 	* 
 	* @return boolean
 	*/
	protected function templateExist($template = null)
	{
		helper('themes');

		return is_file(FCPATH . self::$config[THEME_PATH] . '/' . self::$config[THEME] . '/' . validate_ext($template));
	}

	/**
	 * Set Main Content
	 * 
	 * @param string $viewPath
	 * @param array  $data
	 */
	protected function setContent($viewPath = null, $data = [], $viewDir = 'Views')
	{
		$content = "";

		if (is_string($viewPath))
		{
			$content = $viewPath; 
		}

		if (!empty($viewPath))
		{
			$fileExt = pathinfo($viewPath, PATHINFO_EXTENSION);

			$locator = \Config\Services::locator();
			$view    = $locator->locateFile($viewPath, $viewDir, empty($fileExt) ? 'php' : $fileExt);

			if (!empty($view))
			{
				$content = view($viewPath, $data);
			}
		}

		$this->setVar(self::CONTENT, $content);
		$this->setPageTitle($data);
	}

	/**
	 * Set Page Title - used in <title> tags
	 * 
	 * @param string $page_title
	 */
	public function setPageTitle($page_title = null)
	{
		$_page_title = '';

		if (is_string($page_title))
		{
			$_page_title = $page_title;
		}
		elseif (is_array($page_title) && array_key_exists(self::PAGE_TITLE, $page_title))
		{
			$_page_title = $page_title[self::PAGE_TITLE];
		}
		elseif (!array_key_exists(self::PAGE_TITLE, self::$themeVars) && !is_cli()) 
		{
			// page_title is not defined, so detect current controller/method as page title
			$router = service('router');
		
			$controllers = explode('\\', $router->controllerName());
			$controller  = $controllers[count($controllers)-1];

			$_page_title = ($controller . ' | ' . ucfirst($router->methodName()));
		}

		$this->setVar(self::PAGE_TITLE, $_page_title);

		return $this;
	}

	/**
	 * Set Variable to be passed into template
	 * 
	 * @param string||array $key
	 * @param mixed         $value
	 * 
	 * @return $this \Themes
	 */
	public function setVar($key, $value = false)
	{
		if (is_array($key))
		{
			foreach ($key as $_key => $_value)
			{
				self::$themeVars[$_key] = $_value;
			}
		}
		else
		{
			self::$themeVars[$key] = $value;
		}

		return $this;
	}

	/**
	 * Get All Themes Variables
	 * 
	 * @return array
	 */
	public static function getData(): array
	{
		return self::$themeVars;
	}

	/**
	 * Get All Themes Configs
	 * 
	 * @return array
	 */
	public static function getConfig(): array
	{
		return self::$config;
	}
}
