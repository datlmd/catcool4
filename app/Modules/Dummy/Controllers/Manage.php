<?php namespace App\Modules\Dummy\Controllers;

use App\Controllers\AdminController;
use App\Libraries\Themes;

class Manage extends AdminController
{
    protected $themes = null;
    protected $model = null;

    CONST MANAGE_ROOT = 'dummy/manage';
    CONST MANAGE_URL  = 'dummy/manage';

    public function __construct()
    {
        parent::__construct();

        $this->themes = Themes::init()->setTheme('admin')
            ->addPartial('header')
            ->addPartial('footer')
            ->addPartial('sidebar');


        $this->model = new \App\Modules\Dummy\Models\DummyModel();

        //create url manage
        service('SmartyEngine')->assign('manage_url', self::MANAGE_URL);
        service('SmartyEngine')->assign('manage_root', self::MANAGE_ROOT);

        //add breadcrumb
        service('Breadcrumb')->add("Home", "url");
    }

	public function index()
	{

	    $data = [
	        'manage_url' => self::MANAGE_URL,
        ];
        $data['filter_active'] = false;
        $data['filter'] = [
            'name' => !empty($this->request->getGetPost('filter[name]')) ? $this->request->getGetPost('filter[name]') : '',
            'id' => !empty($this->request->getGetPost('filter[id]')) ? $this->request->getGetPost('filter[id]') : '',
            'filter_limit' => !empty($this->request->getGetPost('filter[filter_limit]')) ? $this->request->getGetPost('filter[filter_limit]') : '',

        ];
        //$data['list'] = $this->model->get_all_by_filter();
        $this->themes::load('manage/list', $data);
        //theme_load('Manage/list', $data);
        //return service('SmartyEngine')->view('Modules/Dummy/Views/index', $data);
        //return view('App\Modules\Dummy\Views\index');




	}

	//--------------------------------------------------------------------

}
