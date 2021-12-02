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
        if ($agent->isMobile() && !$agent->isMobile('ipad')) {
            $this->smarty->assign('is_mobile', $agent->isMobile());
        }
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

        //check clear cache
        $this->clearCacheAuto();
    }

    /**
     * Ghi log mọi action trên website của tài khoản admin, nếu tài khoàn user thường thì tuỳ function sẽ gắn hàm
     *
     * @param bool|false $is_admin
     * @return bool
     */
    public function trackingLogAccess($is_admin = false)
    {
        try {
            if (empty(config_item('is_tracking_log_access'))) {
                return false;
            }

            $user_id = $is_admin ? $this->getUserIdAdmin() : $this->getUserId();
            if (empty($user_id)) {
                return false;
            }

            helper('filesystem');

            $router = service('router');

            $file_name = 'log-access-' . date('Y-m-d') . '.log';
            if ($is_admin) {
                $file_name = "admin-$file_name";
            }

            $controller = $router->controllerName();
            $controller = str_ireplace("\\App\\Modules\\", "", $controller);

            $data_log = [
                'user_id' => $user_id,
                'username' => session('admin.username'),
                'module' => $controller,
                'action' => $router->methodName(),
                'post_params' => $_POST,
                'get_params' => $_GET,
                'ip' => get_client_ip()
            ];

            $directory = WRITEPATH . "logs/access/";
            if (!is_dir($directory)) {
                mkdir($directory, 0777, TRUE);
            }

            $message = json_encode($data_log);
            $message = date('Y-m-d H:i:s') . ":\t$message" . ">>>>>" . "\n";
            write_file($directory . $file_name, $message, 'a');

            //TODO save data to DB

            return true;
        } catch (\Exception $ex) {
            log_message('error', $ex->getMessage());
            return false;
        }
    }

    public function pageNotFound()
    {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }

    /**
     * Xoa data cache cua cac file detail sau 1 thoi gian luu cache, giam dung luong thu muc cache/html
     *
     * @return bool
     */
    public function clearCacheAuto()
    {
        try {
            $day = date("d", time());
            if ($day != 2) {
                return false;
            }

            $result = cache()->get('clear_cache_file_html_auto');
            if (!empty($result)) {
                return false;
            }

            foreach (cache()->getCacheInfo() as $value) {
                switch (true) {
                    case strpos($value['name'], "detail") !== false:
                        cache()->delete($value['name']);
                        break;
                    default:
                        break;
                }
            }

            cache()->save('clear_cache_file_html_auto', true, 2 * DAY);

            log_message('info', "Da xoa cache auto ngay $day");
            return true;
        } catch (\Exception $ex) {
            log_message('error', $ex->getMessage());
            return false;
        }
    }
}
