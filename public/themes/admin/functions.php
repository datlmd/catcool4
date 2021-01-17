    <?php
    /**
    * CI-Theme Library
    */
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
    }

    // ------------------------------------------------------------------------

    /**
     * Enqueue all theme's StyleSheets.
     * @access 	public
     * @return 	void
     */
    public function styles()
    {
        // Let's add bootstrap css file.
        add_style(css_url('vendor/bootstrap/css/bootstrap.min', 'common'));
        add_style(css_url('vendor/fonts/circular-std/style', 'common'));
        add_style('assets/css/style?' . CACHE_TIME_CSS);
        add_style(css_url('vendor/fonts/fontawesome/css/fontawesome-all', 'common'));
        add_style(css_url('vendor/fonts/flag-icon-css/flag-icon.min', 'common'));
        add_style(css_url('js/confirm/jquery-confirm.min', 'common'));

        // Now we add the the default StyleSheet.
        add_style('assets/css/catcool?' . CACHE_TIME_CSS);

        if (!empty(config_item('enable_dark_mode'))) {
            add_style('assets/css/catcool_dark?' . CACHE_TIME_CSS);
        }

        add_style(css_url('vendor/animate/animate.min', 'common'));

        add_style(css_url('js/lightbox/lightbox', 'common'));

        //rcrop
        //add_style(css_url('vendor/cropper/dist/cropper.min', 'common'));
        add_style(css_url('js/rcrop/rcrop', 'common'));
    }

    // ------------------------------------------------------------------------

    /**
     * Enqueue all theme's JavaScripts.
     * @access 	public
     * @return 	void
     */
    public function scripts()
    {
        //<!-- slimscroll js -->
        add_script(js_url('vendor/slimscroll/jquery.slimscroll', 'common'));

        add_script(js_url('js/confirm/jquery-confirm.min', 'common'));

        add_script(js_url('js/lightbox/lightbox', 'common'));

        //rcrop
        //add_script(js_url('vendor/cropper/dist/cropper.min', 'common'));
        add_script(js_url('js/rcrop/rcrop.min', 'common'));
    }

    // ------------------------------------------------------------------------

    /**
     * Enqueue all theme's Meta tags.
     * @access 	public
     * @return 	void
     */
    public function metadata()
    {
        add_meta('generator', 'Admin | Cat Coool');
        add_meta('author', 'Dat Le');
        //add_meta('author', 'https://github.com/bkader', 'rel');

        // Let's add some extra tags.
    //		add_meta('twitter:card', 'summary');
    //		add_meta('twitter:site', '@KaderBouyakoub');
    //		add_meta('twitter:creator', '@KaderBouyakoub');

        add_meta('og:url', current_url());

        if (!empty(config_item('site_name'))) {
            add_meta('og:title', config_item('site_name'));
        }
        if (!empty(config_item('site_description'))) {
            add_meta('og:description', config_item('site_description'));
        }
        //add_meta('og:image', get_theme_url('screenshot.png'));

        // And why not more!

        //add_meta('manifest', base_url('site.webmanifest'), 'rel');
        if (!empty(config_item('image_icon_url'))) {
            add_meta('icon', image_url(config_item('image_icon_url')), 'rel');
        }
    }

    // ------------------------------------------------------------------------

    /**
     * Let's manipulate html class.
     * @access 	public
     * @param 	string 	$class
     * @return 	string
     */
    public function html_class($class)
    {
        // You can add class for a specific module!
        // if (is_module('module_name')) {}
        // if (is_module('mod_1, mod_2'))

        // Or set class for a specific controller.
        if (is_controller('example'))
        {
            return '';
        }

        if (is_controller('manage'))
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

        return ''; //body-class-admin-theme
    }

    }

    // Always instantiate the class so trigger get registered.
    $theme_class = new Theme_class;

    // ------------------------------------------------------------------------

    if ( ! function_exists('bs_alert'))
    {
    /**
     * Returns a Bootstrap alert.
     *
     * @param 	string 	$message 	the message to be displayed.
     * @return 	string 	Bootstrap full alert.
     */
    function bs_alert($message = '', $type = 'info')
    {
        if (empty($message))
        {
            return;
        }

        // Turn 'error' into 'danger' because it does not exist on bootstrap.
        $type == 'error' && $type = 'danger';

        $alert =<<<END
    <div class="alert alert-{type} alert-dismissible fade show">
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
