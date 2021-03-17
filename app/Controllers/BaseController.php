<?php
namespace App\Controllers;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package CodeIgniter
 */

use CodeIgniter\Controller;
use App\Libraries\Themes;

class BaseController extends Controller
{
    /**
     * @var string|null
     */
    protected $site_lang = null;

    /**
     * @var |null
     */
    protected $themes = null;

    /**
     * @var mixed|null
     */
    protected $breadcrumb = null;

    /**
     * @var mixed|null
     */
    protected $smarty = null;

    /**
     * set model parent module
     * @var null
     */
    protected $model = null;

	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = ['html', 'url', 'themes', 'catcool', 'form', 'inflector', 'cookie'];

	/**
	 * Constructor.
	 */
	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.:
		// $this->session = \Config\Services::session();

        session();

        if (!$this->request->isSecure())
        {
            force_https();
        }

        \Config\Services::language()->setLocale(get_lang());
	}

    public function __construct()
    {
        $this->loadHelpers();

        //set time zone
        if (!empty(config_item('app_timezone'))) {
            date_default_timezone_set(config_item('app_timezone'));//'Asia/Saigon'
        } else {
            date_default_timezone_set('Asia/Saigon');
        }

        $this->site_lang  =  \Config\Services::language()->getLocale();
        $this->themes     = Themes::init();
        $this->breadcrumb = service('Breadcrumb');
        $this->smarty     = service('SmartyEngine');
    }
}
