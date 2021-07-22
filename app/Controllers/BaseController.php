<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use App\Libraries\Themes;


/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */

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
     * Instance of the main Request object.
     *
     * @var IncomingRequest|CLIRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['html', 'url', 'themes', 'catcool', 'form', 'inflector', 'cookie'];

    protected $validator;


    /**
     * Constructor.
     *
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @param LoggerInterface $logger
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        //--------------------------------------------------------------------
        // Preload any models, libraries, etc, here.
        //--------------------------------------------------------------------
        // E.g.: $this->session = \Config\Services::session();

        session();

        if (!$this->request->isSecure()) {
            force_https();
        }

        \Config\Services::language()->setLocale(get_lang());

        $agent = $this->request->getUserAgent();
        $this->smarty->assign('is_mobile', $agent->isMobile());
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

        $this->site_lang = \Config\Services::language()->getLocale();
        $this->themes = Themes::init();
        $this->breadcrumb = service('Breadcrumb');
        $this->smarty = service('SmartyEngine');

        $this->validator = \Config\Services::validation();
        $this->smarty->assign('validator', $this->validator);
    }
}
