<?php

namespace App\Modules\Customers\Controllers;

use App\Controllers\UserController;

class Forgotten extends UserController
{
    public $config_form = [];

    public function __construct()
    {
        parent::__construct();

        //set theme
        $this->themes->setTheme(config_item('theme_frontend'));
    }

    public function index()
    {
        if (service('customer')->isLogged()) {
            return redirect()->to(site_url('account/profile') . '?customer_token=' . session('customer_token'));
        }

        $data['edit'] = site_url('account/edit') . (!empty(session('customer_token')) ? '?customer_token=' . session('customer_token') : "");
        $data['forgotten'] = site_url('account/forgotten');


        //breadcrumb
        $this->breadcrumb->add(lang('General.text_home'), base_url());
        $this->breadcrumb->add(lang('Customer.text_account'), site_url('account/profile'));
        $this->breadcrumb->add(lang('Customer.text_account_forgotten'), site_url('account/forgotten'));

        //set params khi call cell
        $params['params'] = [
            'breadcrumb' => $this->breadcrumb->render(),
            'breadcrumb_title' => lang('Customer.text_account_forgotten'),
        ];

        $this->themes->addPartial('header_top', $params)
            ->addPartial('header_bottom', $params)
            ->addPartial('content_left', $params)
            ->addPartial('content_top', $params)
            ->addPartial('content_bottom', $params)
            ->addPartial('content_right', $params)
            ->addPartial('footer_top', $params)
            ->addPartial('footer_bottom', $params);

        add_meta(['title' => lang("Customer.text_account_forgotten")], $this->themes);

        theme_load('forgotten', $data);
    }

    public function confirm()
    {
        if (service('customer')->isLogged()) {
            json_output([
                'redirect' => site_url('account/profile' . '?customer_token=' . session('customer_token')),
            ]);
        }

        $this->validator->setRule('email', lang('Customer.text_email'), 'required|valid_email');
        if (!$this->validator->withRequest($this->request)->run()) {
            $errors = $this->validator->getErrors();

            json_output([
                'error' => $errors,
                'alert' => print_alert($errors, ALERT_ERROR),
            ]);
        }

        $customer_model = new \App\Modules\Customers\Models\CustomerModel();
        $customer_info = $customer_model->forgotPassword($this->request->getPost('email'));
        if (empty($customer_info)) {
            $errors = $customer_model->getErrors() ?? lang('Customer.error_forgotten_not_found');
            json_output([
                'error' => $errors,
                'alert' => print_alert($errors, ALERT_ERROR),
            ]);
        }

        set_alert(lang('Customer.text_forgotten_success'), ALERT_SUCCESS);
        json_output([
            'redirect' => site_url('account/login'),
        ]);
    }

    public function reset($code = null)
    {
        if (service('customer')->isLogged()) {
            return redirect()->to(site_url('account/profile') . '?customer_token=' . session('customer_token'));
        }

        $customer_model = new \App\Modules\Customers\Models\CustomerModel();

        $code = html_entity_decode($code, ENT_QUOTES, 'UTF-8');

        $customer_info = $customer_model->checkForgottenPassword($code);
        if (empty($customer_info)) {
            set_alert(lang('Customer.error_forgotten_code'), ALERT_ERROR);
            return redirect()->to(site_url('account/login'));
        }

        session()->set('reset_token', substr(bin2hex(openssl_random_pseudo_bytes(26)), 0, 26));

        $data['save'] = site_url('account/forgotten/password/' . $code . '?reset_token=' . session('reset_token'));

        //breadcrumb
        $this->breadcrumb->add(lang('General.text_home'), base_url());
        $this->breadcrumb->add(lang('Customer.text_account'), site_url('account/profile'));
        $this->breadcrumb->add(lang('Customer.text_account_forgotten_reset'), site_url('account/forgotten/reset/' . $code));

        //set params khi call cell
        $params['params'] = [
            'breadcrumb' => $this->breadcrumb->render(),
            'breadcrumb_title' => lang('Customer.text_account_forgotten_reset'),
        ];

        $this->themes->addPartial('header_top', $params)
            ->addPartial('header_bottom', $params)
            ->addPartial('content_left', $params)
            ->addPartial('content_top', $params)
            ->addPartial('content_bottom', $params)
            ->addPartial('content_right', $params)
            ->addPartial('footer_top', $params)
            ->addPartial('footer_bottom', $params);

        add_meta(['title' => lang("Customer.text_account_forgotten_reset")], $this->themes);

        theme_load('forgotten_reset', $data);
    }

    public function password($code = null)
    {
        if (service('customer')->isLogged()) {
            json_output([
                'redirect' => site_url('account/profile' . '?customer_token=' . session('customer_token')),
            ]);
        }

        if (empty($this->request->getGet('reset_token')) || empty(session('reset_token')) || (session('reset_token') != $this->request->getGet('reset_token'))) {
            set_alert(lang('Customer.error_forgotten_token'), ALERT_ERROR);
            json_output([
                'redirect' => site_url('account/forgotten'),
            ]);
        }

        $customer_model = new \App\Modules\Customers\Models\CustomerModel();

        $code = html_entity_decode($code, ENT_QUOTES, 'UTF-8');

        $customer_info = $customer_model->checkForgottenPassword($code);
        if (empty($customer_info)) {
            set_alert(lang('Customer.error_forgotten_code'), ALERT_ERROR);
            json_output([
                'redirect' => site_url('account/login'),
            ]);
        }

        $this->validator->setRules([
            'password' => ['label' => lang('Customer.text_password'), 'rules' => 'required|min_length[' . config_item('minPasswordLength') . ']|matches[confirm]'],
            'confirm' => ['label' => lang('Customer.text_password_confirm'), 'rules' => 'required'],
        ]);

        if (!$this->validator->withRequest($this->request)->run()) {
            $errors = $this->validator->getErrors();
            json_output([
                'error' => $errors,
                'alert' => print_alert($errors, ALERT_ERROR),
            ]);
        }

        $customer_model->editPasswordForgotten($customer_info['customer_id'], html_entity_decode($this->request->getPost('password'), ENT_QUOTES, 'UTF-8'));

        session()->remove('reset_token');

        set_alert(lang('Customer.text_forgotten_success'), ALERT_SUCCESS);
        json_output([
            'redirect' => site_url('account/login'),
        ]);
    }
}
