<?php namespace App\Modules\Dummy\Controllers;

use App\Controllers\AdminController;
use App\Modules\Dummy\Models\DummyModel;

class Manage extends AdminController
{

    CONST MANAGE_ROOT = 'dummy/manage';
    CONST MANAGE_URL  = 'dummy/manage';

    public function __construct()
    {
        parent::__construct();

        $this->themes->setTheme(config_item('theme_admin'))
            ->addPartial('header')
            ->addPartial('footer')
            ->addPartial('sidebar');

        $this->model = new DummyModel();

        //create url manage
        $this->smarty->assign('manage_url', self::MANAGE_URL);
        $this->smarty->assign('manage_root', self::MANAGE_ROOT);

        //add breadcrumb
        $this->breadcrumb->add(lang('GeneralManage.catcool_dashboard'), base_url(CATCOOL_DASHBOARD));
        $this->breadcrumb->add(lang('Dummy.heading_title'), base_url(self::MANAGE_URL));
    }

	public function index()
	{

        $list = $this->model->getAllByFilter();

	    $data['breadcrumb'] = $this->breadcrumb->render();

        $data['list'] = $list->paginate(3, 'dummy');
        $data['pager'] = $list->pager;


        $this->themes::load('manage/list', $data);
        //theme_load('Manage/list', $data);
        //return service('SmartyEngine')->view('Modules/Dummy/Views/index', $data);
        //return view('App\Modules\Dummy\Views\index');




	}

	//--------------------------------------------------------------------

}
