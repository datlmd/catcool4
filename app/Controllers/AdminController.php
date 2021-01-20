<?php
namespace App\Controllers;

use App\Controllers\UserController;

class AdminController extends UserController
{
    public function __construct()
    {
        parent::__construct();

        \Config\Services::language()->setLocale(get_lang(true));


//        $this->load->model("menus/Menu", 'Menu');
//        $menu_admin = $this->Menu->get_menu_active(['is_admin' => STATUS_ON]);
//        $menu_admin = format_tree(['data' => $menu_admin, 'key_id' => 'menu_id']);
        $menu_admin = [];
        $this->smarty->assign('menu_admin', $menu_admin);

        $this->smarty->assign('validator', \Config\Services::validation());

    }
}
