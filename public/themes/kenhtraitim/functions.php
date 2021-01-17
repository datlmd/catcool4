<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * This class is here to demonstrate the use of 
 * Events library with Theme library.
 */
class Theme_class
{
	public function __construct()
	{
		/**
		 * With this event registered, theme can independently enqueue
		 * all needed StyleSheets without adding them in controllers.
		 */
		Events::register('enqueue_styles', array($this, 'styles'));

		/**
		 * With this event registered, theme can independently enqueue
		 * all needed JS files without adding them in controllers.
		 */
		Events::register('enqueue_scripts', array($this, 'scripts'));

		/**
		 * With this event registered, theme can independently enqueue
		 * all needed meta tags without adding them in controllers.
		 */
		Events::register('enqueue_metadata', array($this, 'metadata'));

		// Manipulating <html> class.
		Events::register('html_class', array($this, 'html_class'));

		// Manipulating <body> class.
		Events::register('body_class', array($this, 'body_class'));

        Events::register('div_body_class', array($this, 'div_body_class'));
	}


    public function styles()
    {
		// Vendor CSS
        add_style(css_url('vendor/fonts/fontawesome/css/fontawesome-all', 'common'));
		add_style(css_url('vendor/animate/animate.min', 'common'));
		add_style(css_url('vendor/simple-line-icons/css/simple-line-icons.min', 'common'));
		add_style(css_url('vendor/owl.carousel/assets/owl.carousel.min', 'common'));
		add_style(css_url('vendor/owl.carousel/assets/owl.theme.default.min', 'common'));
		add_style(css_url('vendor/magnific-popup/magnific-popup', 'common'));

		// Theme CSS
		add_style('assets/css/theme');
		add_style('assets/css/theme-elements');
		add_style('assets/css/theme-blog');
		add_style('assets/css/theme-shop');

        add_style(css_url('vendor/rs-plugin/css/settings', 'common'));
        add_style(css_url('vendor/rs-plugin/css/layers', 'common'));
        add_style(css_url('vendor/rs-plugin/css/navigation', 'common'));

		// Skin CSS
		add_style('assets/css/skins/default');

		//Theme Custom CS
		add_style('assets/css/custom');
    }

    public function scripts()
    {
		add_script(js_url('vendor/jquery.appear/jquery.appear.min', 'common'));
		add_script(js_url('vendor/jquery.easing/jquery.easing.min', 'common'));
		add_script(js_url('vendor/jquery.cookie/jquery.cookie.min', 'common'));
        add_script(js_url('vendor/popper/umd/popper.min', 'common'));
		add_script('assets/js/common/common.min');
		add_script(js_url('vendor/jquery.validation/jquery.validate.min', 'common'));
		add_script(js_url('vendor/jquery.easy-pie-chart/jquery.easypiechart.min', 'common'));
		add_script(js_url('vendor/jquery.gmap/jquery.gmap.min', 'common'));
		add_script(js_url('vendor/jquery.lazyload/jquery.lazyload.min', 'common'));
		add_script(js_url('vendor/isotope/jquery.isotope.min', 'common'));
		add_script(js_url('vendor/owl.carousel/owl.carousel.min', 'common'));
		add_script(js_url('vendor/magnific-popup/jquery.magnific-popup.min', 'common'));
		add_script(js_url('vendor/vide/jquery.vide.min', 'common'));
		add_script(js_url('vendor/vivus/vivus.min', 'common'));
        add_script(js_url('vendor/instafeed/instafeed.min', 'common'));

		add_script('assets/js/theme');
		add_script('assets/js/custom');
		add_script('assets/js/theme.init');
	}


	public function metadata()
	{
        //set meta seo
        //set_meta_seo();

		// And why not more!
		//add_meta('manifest', base_url('site.webmanifest'), 'rel');
	}

	// ------------------------------------------------------------------------


	public function html_class($class)
	{
		// You can add class for a specific module!
		// if (is_module('module_name')) {}
		// if (is_module('mod_1, mod_2'))

		// Or set class for a specific controller.
		if (is_controller('news'))
		{
			return 'history svg video supports boxshadow csstransforms3d csstransitions backgroundcliptext webkit chrome mac js sticky-header-enabled';
		}

		if (is_controller('admin'))
		{
			return '';
		}

		// You can as well set if for a specific method.
		// if (is_method(...)) {}

		// And you can chain all.
		// if (is_controller('example') && is_method('index')) {}

		return $class;
	}

	// ------------------------------------------------------------------------

	/**
	 * Manipulating <body> class.
	 * @access 	public
	 * @param 	string 	$class
	 * @return 	string
	 */
	public function body_class($class)
	{
        if (!empty($class)) {
            return $class;
        }

		return '';
	}

    public function div_body_class($class)
    {
        if (!empty($class)) {
            return $class;
        }

        return '';
    }

}

// Always instantiate the class so trigger get registered.
$theme_class = new Theme_class;

// ------------------------------------------------------------------------

if ( ! function_exists('bs_alert'))
{
	function bs_alert($message = '', $type = 'info')
	{
		if (empty($message))
		{
			return;
		}

		// Turn 'error' into 'danger' because it does not exist on bootstrap.
		$type == 'error' && $type = 'danger';

		$alert =<<<END
<div class="alert alert-{type}">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	{message}
</div>
END;
		return str_replace(
			array('{type}', '{message}'),
			array($type, $message),
			$alert
		);
	}
}
