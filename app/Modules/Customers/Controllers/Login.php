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

        // validate form input
        $this->validator->setRule('username', lang('Customer.text_username'), 'required');
        $this->validator->setRule('password', lang('Customer.text_password'), 'required');

        if (!empty($this->request->getPost()) && $this->validator->withRequest($this->request)->run()) {
            /*
            if(!check_captcha($this->request->post('captcha'))) {
                $data['errors'] = lang('error_captcha');
            } else {
                $remember = (bool)$this->request->post('remember');
                if ($this->Customer->login($this->request->post('username'), $this->request->post('password'), $remember, true)) {
                    set_alert(lang('text_login_successful'), ALERT_SUCCESS);
                    redirect(self::MANAGE_URL);
                }

                $data['errors'] = empty($this->Member->errors()) ? lang('text_login_unsuccessful') : $this->Member->errors();
            }
            */
        }

        if ($this->validator->getErrors()) {
            $data['errors'] = $this->validator->getErrors();
        }

        $this->breadcrumb->add(lang('General.text_account'), base_url('users/profile'));

        $data_breadcrumb['breadcrumb']       = $this->breadcrumb->render();
        $data_breadcrumb['breadcrumb_title'] = lang("General.heading_register");
        $this->themes->addPartial('breadcumb', $data_breadcrumb);

        add_meta(['title' => lang("General.heading_register")], $this->themes);

        theme_load('login', $data);
    }
}
