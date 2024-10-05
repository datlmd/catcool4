<?php

namespace App\Modules\Customers\Controllers;

use App\Controllers\UserController;

class Newsletter extends UserController
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
        $data['save'] = site_url('account/newsletter/save') . '?customer_token=' . session('customer_token');

        //breadcrumb
        $this->breadcrumb->add(lang('General.text_home'), base_url());
        $this->breadcrumb->add(lang('Customer.text_account'), site_url('account/profile') . '?customer_token=' . session('customer_token'));
        $this->breadcrumb->add(lang('Customer.text_newsletter'), site_url('account/newsletter') . '?customer_token=' . session('customer_token'));

        //set params khi call cell
        $params['params'] = [
            'breadcrumb' => $this->breadcrumb->render(),
            'breadcrumb_title' => lang('Customer.text_newsletter'),
        ];

        $this->themes->addPartial('header_top', $params)
            ->addPartial('header_bottom', $params)
            ->addPartial('content_left', $params)
            ->addPartial('content_top', $params)
            ->addPartial('content_bottom', $params)
            ->addPartial('content_right', $params)
            ->addPartial('footer_top', $params)
            ->addPartial('footer_bottom', $params);


        add_meta(['title' => lang("Customer.text_newsletter_title")], $this->themes);

        theme_load('newsletter', $data);
    }

    public function save()
    {
        if (!service('customer')->isLogged() || (empty($this->request->getGet('customer_token')) || empty(session('customer_token')) || (session('customer_token') != $this->request->getGet('customer_token')))) {
            set_alert(lang('General.error_token'), ALERT_ERROR);
            json_output([
                'redirect' => site_url('account/edit' . '?customer_token=' . session('customer_token')),
            ]);
        }

        $customer_model = new \App\Modules\Customers\Models\CustomerModel();

        $newsletter = !empty($this->request->getPost('newsletter')) ? STATUS_ON : STATUS_OFF;
        $customer_model->editNewsletter(service('customer')->getId(), $newsletter);

        $success = lang('Customer.text_newsletter_success');
        json_output([
            'success' => $success,
            'alert' => print_alert($success),
        ]);
    }
}
