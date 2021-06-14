<?php namespace App\Modules\Customers\Controllers;

use App\Controllers\BaseController;

class Login extends BaseController
{



    public function __construct()
    {
        parent::__construct();

        //set theme
        $this->themes->setTheme(config_item('theme_frontend'));

        $this->themes->addPartial('header_top')
            ->addPartial('header_bottom')
            ->addPartial('content_left')
            ->addPartial('content_right')
            ->addPartial('footer_top')
            ->addPartial('footer_bottom');

    }

    public function index()
    {
        $data = [];

        $return_url = $this->request->getGet('return_url');
        if (empty($return_url)) {
            $return_url = site_url();
        }

        if (!empty(session('user.user_id'))) {
            return redirect()->to($return_url);
        }

        $data['return_url'] = $return_url;

        $this->breadcrumb->add(lang('General.text_home'), base_url());
        $this->breadcrumb->add(lang('General.text_account'), base_url('users/profile'));
        breadcrumb($this->breadcrumb, $this->themes, lang("General.heading_register"));

        add_meta(['title' => lang("General.heading_register")], $this->themes);

        theme_load('login', $data);
    }
}
