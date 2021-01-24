<?php namespace App\Modules\Permissions\Controllers;

use App\Controllers\AdminController;

class Permissions extends AdminController
{
    public $data        = [];

    CONST MANAGE_ROOT       = 'permissions';
    CONST MANAGE_URL        = 'permissions';

    public function __construct()
    {
        parent::__construct();

        $this->themes->setTheme(config_item('theme_admin'))
            ->addPartial('header')
            ->addPartial('footer')
            ->addPartial('sidebar');


        //add breadcrumb
        $this->breadcrumb->add(lang('GeneralManage.catcool_dashboard'), base_url(CATCOOL_DASHBOARD));
    }

    public function index()
    {

    }

    public function not_allowed()
    {
        $this->data['title'] = $this->lang->line('not_permission_heading');

        theme_load('not_allowed', $this->data);
    }
}
