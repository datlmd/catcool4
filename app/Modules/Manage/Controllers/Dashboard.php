<?php

namespace App\Modules\Manage\Controllers;

use App\Controllers\AdminController;

class Dashboard extends AdminController
{
    protected $errors = [];

    public const MANAGE_ROOT = 'manage/dashboard';
    public const MANAGE_URL  = 'manage/dashboard';

    public function __construct()
    {
        parent::__construct();

        $this->themes->setTheme(config_item('theme_admin'))
            ->addPartial('header')
            ->addPartial('footer')
            ->addPartial('sidebar');

        //create url manage
        $this->smarty->assign('manage_url', self::MANAGE_URL);
        $this->smarty->assign('manage_root', self::MANAGE_ROOT);

        //add breadcrumb
        $this->breadcrumb->add(lang('Admin.catcool_dashboard'), site_url(CATCOOL_DASHBOARD));
        $this->breadcrumb->add(lang('Admin.dashboard_heading'), site_url(self::MANAGE_URL));
    }

    public function index()
    {
        $data = [
            'breadcrumb' => $this->breadcrumb->render(),
        ];

        add_meta(['title' => lang("LanguageAdmin.heading_title")], $this->themes);
        $this->themes::load('dashboard', $data);
    }

}
