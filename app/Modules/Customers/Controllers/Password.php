<?php

namespace App\Modules\Customers\Controllers;

use App\Controllers\UserController;

class Password extends UserController
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
        if (!service('customer')->isLogged() || (empty($this->request->getGet('customer_token')) || empty(session('customer_token')) || ($this->request->getGet('customer_token') != session('customer_token')))) {
            if (service('customer')->loginRememberedCustomer()) {
                return redirect()->to(current_url() . '?customer_token=' . session('customer_token'));
            }

            return redirect()->to(site_url("account/login?return_url=" . current_url()));
        }

        $customer_model = new \App\Modules\Customers\Models\CustomerModel();

        $customer_info = $customer_model->getCustomerInfo(service('customer')->getId());
        $data['customer_info'] = $customer_info;

        $data['back'] = site_url('account/profile') . '?customer_token=' . session('customer_token');
        $data['save'] = site_url('account/password/save') . '?customer_token=' . session('customer_token');

        //breadcrumb
        $this->breadcrumb->add(lang('General.text_home'), base_url());
        $this->breadcrumb->add(lang('Customer.text_account'), site_url('account/profile') . '?customer_token=' . session('customer_token'));
        $this->breadcrumb->add(lang('Customer.text_change_password_title'), site_url('account/password') . '?customer_token=' . session('customer_token'));

        //set params khi call cell
        $params['params'] = [
            'breadcrumb' => $this->breadcrumb->render(),
            'breadcrumb_title' => lang('Customer.text_change_password_title'),
        ];

        $this->themes->addPartial('header_top', $params)
            ->addPartial('header_bottom', $params)
            ->addPartial('content_left', $params)
            ->addPartial('content_top', $params)
            ->addPartial('content_bottom', $params)
            ->addPartial('content_right', $params)
            ->addPartial('footer_top', $params)
            ->addPartial('footer_bottom', $params);

        add_meta(['title' => lang("Customer.text_change_password_title")], $this->themes);

        theme_load('password', $data);
    }

    public function save()
    {
        if (!service('customer')->isLogged() || (empty($this->request->getGet('customer_token')) || empty(session('customer_token')) || (session('customer_token') != $this->request->getGet('customer_token')))) {
            set_alert(lang('General.error_token'), ALERT_ERROR);
            json_output([
                'redirect' => site_url('account/password' . '?customer_token=' . session('customer_token')),
            ]);
        }

        $this->validator->setRule('password_old', lang('Customer.text_password_old'), 'required|min_length['.config_item('min_password_length').']|max_length[40]');
        $this->validator->setRule('password_new', lang('Customer.text_password_new'), 'required|min_length['.config_item('min_password_length').']|max_length[40]|matches[confirm]');
        $this->validator->setRule('confirm', lang('Customer.text_password_confirm'), 'required');

        if (!$this->validator->withRequest($this->request)->run()) {
            $errors = $this->validator->getErrors();

            json_output([
                'error' => $errors,
                'alert' => print_alert($errors, 'danger'),
            ]);
        }


        $customer_model = new \App\Modules\Customers\Models\CustomerModel();

        $password_old = html_entity_decode($this->request->getPost('password_old'), ENT_QUOTES, 'UTF-8');
        $password_new = html_entity_decode($this->request->getPost('password_new'), ENT_QUOTES, 'UTF-8');

        if (!$customer_model->changePassword(service('customer')->getId(), $password_old, $password_new)) {
            $errors = $customer_model->getErrors() ?? lang('Customer.error_change_password');
            json_output([
                'error' => $errors,
                'alert' => print_alert($errors, 'danger'),
            ]);
        }

        $success = lang('Customer.text_change_password_success');
        set_alert($success, ALERT_SUCCESS);
        json_output([
            'redirect' => site_url('account/profile' . '?customer_token=' . session('customer_token')),
        ]);
    }
}
