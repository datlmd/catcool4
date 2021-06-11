<?php namespace App\Modules\Users\Controllers;

use App\Controllers\UserController;
use App\Modules\Users\Models\UserModel;

class Login extends UserController
{
    public $config_form = [];

    public function __construct()
    {
        parent::__construct();

        $this->model = new UserModel();
    }

    public function index()
    {

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

        $data = [];

        theme_load('login', $data);
    }

    public function postLogin()
    {
        if (empty($this->request->getPost())) {
            set_alert(lang('Alert.error'), ALERT_ERROR);
            return redirect()->back()->withInput();
        }

        $this->validator->setRule('identity', lang('General.text_login_identity'), 'required');
        $this->validator->setRule('password', lang('General.text_password'), 'required');

        if (!$this->validator->withRequest($this->request)->run()) {
            return redirect()->back()->withInput();
        }

        $remember = (bool)$this->request->getPost('remember');
        if (!$this->model->login($this->request->getPost('identity'), $this->request->getPost('password'), $remember)) {
            $errors = empty($this->model->getErrors()) ? lang('User.text_login_unsuccessful') : $this->model->getErrors()[0];
            set_alert($errors, ALERT_ERROR);
            return redirect()->back()->withInput();
        }


        set_alert(lang('User.text_login_successful'), ALERT_SUCCESS);
        return redirect()->to(site_url('customers/profile'));
    }
}
