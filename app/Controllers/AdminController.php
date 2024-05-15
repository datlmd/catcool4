<?php
namespace App\Controllers;

use App\Controllers\UserController;

defined('IS_ADMIN') || define('IS_ADMIN', true);

class AdminController extends UserController
{
    /**
     * @var mixed|null
     */
    protected $user = null;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        \Config\Services::language()->setLocale(get_language_admin());
    }

    public function __construct()
    {
        parent::__construct();

        helper('admin');
        
        \Config\Services::language()->setLocale(get_language_admin());

        $method_name =  service('router')->methodName();
        if (!in_array($method_name, ['login', 'logout', 'forgotPassword', 'resetPassword'])) {
            //get menu
            $menu_model = new \App\Modules\Menus\Models\MenuModel();
            $menu_admin = $menu_model->getMenuActive(['is_admin' => STATUS_ON]);
            $menu_admin = format_tree(['data' => $menu_admin, 'key_id' => 'menu_id']);
            $this->smarty->assign('menu_admin', $menu_admin);
            $this->smarty->assign('menu_current', service('uri')->getSegment(1));
        }

        //tracking log access
        $this->trackingLogAccess(true);

        $this->user = service('user');

        $error_token = session()->getFlashdata('error_token');
        if (!empty($error_token)) {
            set_alert(lang('Admin.error_token'), ALERT_ERROR, ALERT_POPUP);
        }
    }

    public function getUrlFilter($params = [], $is_post = false)
    {
        $url = "";

        $param_list =  $is_post ? $this->request->getPost($params) : $this->request->getGet();
        if (empty($param_list)) {
            return $url;
        }

        foreach ($param_list as $key => $value) {
            if (empty($value)) {
                continue;
            }

            if (!empty($params) && !in_array($key, $params)) {
                continue;
            }

            $value = trim($value);
            $value = is_string($value) ? urlencode(html_entity_decode($value, ENT_QUOTES, 'UTF-8')) : $value;
            $url .= "&$key=" . $value;
        }

        return $url;
    }
}
