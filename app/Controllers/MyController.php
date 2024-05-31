<?php

namespace App\Controllers;

use App\Libraries\Themes;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

defined('IS_ADMIN') || define('IS_ADMIN', false);

class MyController extends Controller
{
    /**
     * @var string|null
     */
    protected $site_lang = null;

    protected $language_id;

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
     * set model parent module.
     *
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
    protected $helpers = ['html', 'url', 'themes', 'catcool', 'form', 'inflector', 'cookie', 'setting'];

    protected $validator;

    protected $is_mobile;

    /**
     * Constructor.
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

        \Config\Services::language()->setLocale(language_code());

        $agent = $this->request->getUserAgent();
        if ($agent->isMobile() && !$agent->isMobile('ipad')) {
            $this->is_mobile = true;
            $this->smarty->assign('is_mobile', $agent->isMobile());
        }
    }

    public function __construct()
    {
        helper($this->helpers);

        //set time zone
        if (!empty(config_item('app_timezone'))) {
            date_default_timezone_set(config_item('app_timezone')); //'Asia/Saigon'
        } else {
            date_default_timezone_set('Asia/Saigon');
        }

        \Config\Services::language()->setLocale(language_code());

        $this->site_lang = \Config\Services::language()->getLocale();
        $this->language_id = language_id();

        $this->themes = Themes::init();
        $this->breadcrumb = service('breadcrumb');
        $this->smarty = service('smartyEngine');

        $this->validator = \Config\Services::validation();
        $this->smarty->assign('validator', $this->validator);

        $this->smarty->assign('request', \Config\Services::request());

        //check clear cache
        $this->clearCacheAuto();

        //load event
        $this->_getEvents();
    }

    private function _getEvents()
    {
        $event_model = new \App\Modules\Events\Models\EventModel();
        $event_list = $event_model->getEvents();
        if (!empty($event_list)) {
            foreach ($event_list as $event) {
                if (empty($event['code']) || empty($event['action'])) {
                    continue;
                }
                
                $priority = ($event['priority'] && $event['priority'] > 0) ? $event['priority'] : \CodeIgniter\Events\Events::PRIORITY_NORMAL;
                //Call on a static method
                \CodeIgniter\Events\Events::on($event['code'], $event['action'], $priority);
            }
        }
    } 

    /**
     * Ghi log mọi action trên website của tài khoản admin, nếu tài khoàn user thường thì tuỳ function sẽ gắn hàm.
     *
     * @param bool|false $is_admin
     *
     * @return bool
     */
    public function trackingLogAccess($is_admin = false)
    {
        try {
            if (empty(config_item('is_tracking_log_access'))) {
                return false;
            }

            $user_id = $is_admin ? service('user')->getId() : service('customer')->getId();
            if (empty($user_id)) {
                return false;
            }

            helper('filesystem');

            $router = service('router');

            $file_name = 'log-access-'.date('Y-m-d').'.log';
            if ($is_admin) {
                $file_name = "admin-$file_name";
            }

            $controller = $router->controllerName();
            $controller = str_ireplace('\\App\\Modules\\', '', $controller);

            $username = $is_admin ? service('user')->getUsername() : service('customer')->getEmail();

            $data_log = [
                'user_id' => $user_id,
                'username' => $username,
                'module' => $controller,
                'action' => $router->methodName(),
                'post_params' => $_POST,
                'get_params' => $_GET,
                'ip' => service('request')->getIPAddress(),
            ];

            $directory = WRITEPATH.'logs/access/';
            if (!is_dir($directory)) {
                mkdir($directory, 0777, true);
            }

            $message = json_encode($data_log);
            $message = date('Y-m-d H:i:s').":\t$message".'>>>>>'."\n";
            write_file($directory.$file_name, $message, 'a');

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
     * Xoa data cache cua cac file detail sau 1 thoi gian luu cache, giam dung luong thu muc cache/html.
     *
     * @return bool
     */
    public function clearCacheAuto()
    {
        try {
            $day_clear = config_item('day_clear_cache_auto');
            if (empty($day_clear)) {
                return false;
            }

            $day_clear = explode(',', $day_clear);

            $day = date('d', time());
            if (!in_array($day, $day_clear)) {
                return false;
            }

            $result = cache()->get('clear_cache_file_html_auto');
            if (!empty($result)) {
                return false;
            }

            foreach (cache()->getCacheInfo() as $value) {
                switch (true) {
                    case strpos($value['name'], 'detail') !== false:
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
