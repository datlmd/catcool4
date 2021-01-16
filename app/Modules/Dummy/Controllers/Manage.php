<?php namespace App\Modules\Dummy\Controllers;
use App\Controllers\BaseController;



class Manage extends BaseController
{
    protected $theme;

    CONST MANAGE_ROOT = 'dummy/manage';
    CONST MANAGE_URL  = 'dummy/manage';

    public function __construct()
    {
        helper(['theme','catcool', 'html', 'form']);

        //create url manage
        service('SmartyEngine')->assign('manage_url', self::MANAGE_URL);
        service('SmartyEngine')->assign('manage_root', self::MANAGE_ROOT);

        $this->theme = service('Theme');


        //set theme
        $this->theme->theme('admin')
            ->add_partial('header')
            ->add_partial('footer')
            ->add_partial('sidebar');
    }

	public function index()
	{
        $this->theme->title(lang("heading_title"));


	    $data = [
	        'manage_url' => self::MANAGE_URL,
        ];
        $data['filter_active'] = false;
        $data['filter'] = [
            'name' => !empty($this->request->getGetPost('filter[name]')) ? $this->request->getGetPost('filter[name]') : '',
            'id' => !empty($this->request->getGetPost('filter[id]')) ? $this->request->getGetPost('filter[id]') : '',
            'filter_limit' => !empty($this->request->getGetPost('filter[filter_limit]')) ? $this->request->getGetPost('filter[filter_limit]') : '',
        ];

        theme_load('Manage/list', $data);
        //return service('SmartyEngine')->view('Modules/Dummy/Views/index', $data);
        //return view('App\Modules\Dummy\Views\index');




	}

	//--------------------------------------------------------------------

}
