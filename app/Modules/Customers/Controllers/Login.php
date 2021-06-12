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

        $this->breadcrumb->openTag(config_item('breadcrumb_open'));
        $this->breadcrumb->closeTag(config_item('breadcrumb_close'));
        $this->breadcrumb->add(lang('General.text_home'), base_url());
    }

    public function index()
    {
        $data = [];

        if ($this->validator->getErrors()) {
            $data['errors'] = $this->validator->getErrors();
        }

        $return_url = $this->request->getGet('return_url');
        if (empty($return_url)) {
            $return_url = site_url();
        }

        $data['return_url'] = $return_url;

        $this->breadcrumb->add(lang('General.text_account'), base_url('users/profile'));

        $data_breadcrumb['breadcrumb']       = $this->breadcrumb->render();
        $data_breadcrumb['breadcrumb_title'] = lang("General.heading_register");
        $this->themes->addPartial('breadcumb', $data_breadcrumb);

        add_meta(['title' => lang("General.heading_register")], $this->themes);

        theme_load('login', $data);
    }
}
