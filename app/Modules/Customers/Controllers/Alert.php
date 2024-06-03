<?php

namespace App\Modules\Customers\Controllers;

use App\Controllers\MyController;

class Alert extends MyController
{
    public function index()
    {
        //set theme
        $this->themes->setTheme(config_item('theme_frontend'));

        $heading_title = lang('Customer.title_alert');

        //breadcrumb
        $this->breadcrumb->add(lang('General.text_home'), base_url());

        $data = [];

        $type = $this->request->getGet('type');
        switch ($type) {
            case 'register':
                $heading_title = lang('Customer.title_register');
                $this->breadcrumb->add(lang('Customer.text_profile'), base_url('account/profile') . (!empty(session('customer_token')) ? '?customer_token=' . session('customer_token') : ''));

                if (service('customer')->isLogged()) {
                    $data['success'] = sprintf(lang('Customer.text_register_success'), site_url('contact'));
                } else {
                    $data['success'] = sprintf(lang('Customer.text_register_approval'), config_item('store_name'), site_url('contact'));
                }
                break;
            case 'register_active':
            case 'activate':
                $heading_title = lang('Customer.heading_activate');
                $this->breadcrumb->add(lang('Customer.text_profile'), base_url('account/profile') . (!empty(session('customer_token')) ? '?customer_token=' . session('customer_token') : ''));
                break;
            default:
                break;
        }

        //set params khi call cell
        $params['params'] = [
            'breadcrumb' => $this->breadcrumb->render(),
            'breadcrumb_title' => $heading_title,
        ];

        $this->themes->addPartial('header_top', $params)
             ->addPartial('header_bottom', $params)
             ->addPartial('content_left', $params)
             ->addPartial('content_top', $params)
             ->addPartial('content_bottom', $params)
             ->addPartial('content_right', $params)
             ->addPartial('footer_top', $params)
             ->addPartial('footer_bottom', $params);

        add_meta(['title' => $heading_title], $this->themes);

        theme_load('alert', $data);
    }
}
