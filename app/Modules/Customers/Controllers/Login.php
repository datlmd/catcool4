<?php namespace App\Modules\Customers\Controllers;

use App\Controllers\MyController;

class Login extends MyController
{
    public function __construct()
    {
        parent::__construct();

    }

    public function index()
    {
        //set theme
        $this->themes->setTheme(config_item('theme_frontend'));

        $this->themes->addPartial('header_top')
            ->addPartial('header_bottom')
            ->addPartial('content_left')
            ->addPartial('content_right')
            ->addPartial('footer_top')
            ->addPartial('footer_bottom');

        $data = [];

        $return_url = $this->request->getGet('return_url');
        if (empty($return_url)) {
            $return_url = site_url('account/profile');
        }

        if (service('customer')->isLogged()) {
            //return redirect()->to($return_url);
        } else {
            //neu da logout thi check auto login
            $recheck = service('customer')->loginRememberedCustomer();
            if ($recheck) {
               // return redirect()->to($return_url);
            }
        }

        $data['return_url'] = $return_url;

        $this->breadcrumb->add(lang('General.text_home'), base_url());
        $this->breadcrumb->add(lang('Customer.text_account_login'), base_url('account/login'));
        breadcrumb($this->breadcrumb, $this->themes, lang("Customer.text_account_login"));

        add_meta(['title' => lang("Customer.text_account_login")], $this->themes);

        theme_load('login', $data);
    }

    public function login()
    {
        $this->validator->setRule('login_identity', lang('Customer.text_login_identity'), 'required');
        $this->validator->setRule('login_password', lang('Customer.text_password'), 'required');

        if (!$this->validator->withRequest($this->request)->run()) {
            $errors = $this->validator->getErrors();

            json_output([
                'error' => $errors,
                'alert' => print_alert($errors, 'danger')
            ]);
        }

        $remember = (bool)$this->request->getPost('remember');
        if (!service('customer')->login($this->request->getPost('login_identity'), $this->request->getPost('login_password'), $remember)) {
            $errors = empty(service('customer')->getErrors()) ? lang('Customer.text_login_unsuccessful') : service('customer')->getErrors();

            json_output([
                'error' => $errors,
                'alert' => print_alert($errors, 'danger')
            ]);
        }

        $success = lang('Customer.text_login_successful');

        set_alert($success, ALERT_SUCCESS);

        json_output([
            'success' => $success,
            'alert' => print_alert($success),
            'redirect' => site_url('account/profile')
        ]);
    }
}
