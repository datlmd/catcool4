<?php
namespace App\Controllers;

use App\Controllers\UserController;

class AdminController extends UserController
{
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        \Config\Services::language()->setLocale(get_lang(true));
    }

    public function __construct()
    {
        parent::__construct();

        \Config\Services::language()->setLocale(get_lang(true));

        //get menu
        $menu_model = new \App\Modules\Menus\Models\MenuModel();
        $menu_admin = $menu_model->getMenuActive(['is_admin' => STATUS_ON]);
        $menu_admin = format_tree(['data' => $menu_admin, 'key_id' => 'menu_id']);
        $this->smarty->assign('menu_admin', $menu_admin);
        $this->smarty->assign('menu_current', service('uri')->getSegment(1));

        //tracking log access
        $this->trackingLogAccess(true);

        $error_token = session()->getFlashdata('error_token');
        if (!empty($error_token)) {
            set_alert(lang('Admin.error_token'), ALERT_ERROR, ALERT_POPUP);
        }
    }
}
