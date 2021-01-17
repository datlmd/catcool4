<?php namespace App\Modules\Dummy\Controllers;

use App\Controllers\AdminController;
use App\Libraries\Themes;

class Manage extends AdminController
{
    protected $themes = null;

    CONST MANAGE_ROOT = 'dummy/manage';
    CONST MANAGE_URL  = 'dummy/manage';

    public function __construct()
    {
        parent::__construct();

        $this->themes = Themes::init()->setTheme('admin')
            ->addPartial('header')
            ->addPartial('footer')
            ->addPartial('sidebar');



        //create url manage
        service('SmartyEngine')->assign('manage_url', self::MANAGE_URL);
        service('SmartyEngine')->assign('manage_root', self::MANAGE_ROOT);

        //add breadcrumb
        service('Breadcrumb')->add("Home", "url");
    }

	public function index()
	{
        //$this->theme->title(lang("heading_title"));


	    $data = [
	        'manage_url' => self::MANAGE_URL,
        ];
        $data['filter_active'] = false;
        $data['filter'] = [
            'name' => !empty($this->request->getGetPost('filter[name]')) ? $this->request->getGetPost('filter[name]') : '',
            'id' => !empty($this->request->getGetPost('filter[id]')) ? $this->request->getGetPost('filter[id]') : '',
            'filter_limit' => !empty($this->request->getGetPost('filter[filter_limit]')) ? $this->request->getGetPost('filter[filter_limit]') : '',
        ];

        $this->themes::load('manage/list', $data);
        //theme_load('Manage/list', $data);
        //return service('SmartyEngine')->view('Modules/Dummy/Views/index', $data);
        //return view('App\Modules\Dummy\Views\index');




	}

	//--------------------------------------------------------------------

}
