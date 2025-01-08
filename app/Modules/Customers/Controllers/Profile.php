<?php

namespace App\Modules\Customers\Controllers;

use App\Controllers\UserController;

class Profile extends UserController
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

            return redirect()->to(site_url('account/login?return_url=' . current_url()));
        }

        add_meta(['title' => lang('Customer.text_profile')], $this->themes);

        //breadcrumb
        $this->breadcrumb->add(lang('General.text_home'), base_url());
        $this->breadcrumb->add(lang('Customer.text_profile'), site_url('account/profile') . '?customer_token=' . session('customer_token'));

        //set params khi call cell
        $params['params'] = [
            'breadcrumb' => $this->breadcrumb->render(),
            'breadcrumb_title' => lang('Customer.text_profile'),
        ];

        $data = [];

        if (IS_REACT) {
            
            $data['params'] = $params['params'];
            // [
            //     'breadcrumbs' => service('breadcrumb')->get(),
            //     'breadcrumb_title' => lang('Contact.text_profile'),
            //     'module' => 'frontend/account',// su dung de load template layout cho trang
            // ];

            $data['contents'] = [
                'customer_name' => full_name(service('Customer')->getFirstName(), service('Customer')->getLastName()),
                'customer_avatar' => image_url(service('Customer')->getImage(), 45, 45),
                
                'edit' => site_url('account/edit') . (!empty(session('customer_token')) ? '?customer_token=' . session('customer_token') : ''),
                'password' => site_url('account/password') . (!empty(session('customer_token')) ? '?customer_token=' . session('customer_token') : ''),
                'address' => site_url('account/address') . (!empty(session('customer_token')) ? '?customer_token=' . session('customer_token') : ''),
                'wishlist' => site_url('account/wishlist') . (!empty(session('customer_token')) ? '?customer_token=' . session('customer_token') : ''),
                'order' => site_url('account/order') . (!empty(session('customer_token')) ? '?customer_token=' . session('customer_token') : ''),
                'download' => site_url('account/download') . (!empty(session('customer_token')) ? '?customer_token=' . session('customer_token') : ''),
                'reward' => site_url('account/reward') . (!empty(session('customer_token')) ? '?customer_token=' . session('customer_token') : ''),
                'return' => site_url('account/return') . (!empty(session('customer_token')) ? '?customer_token=' . session('customer_token') : ''),
                'transaction' => site_url('account/transaction') . (!empty(session('customer_token')) ? '?customer_token=' . session('customer_token') : ''),
                'newsletter' => site_url('account/newsletter') . (!empty(session('customer_token')) ? '?customer_token=' . session('customer_token') : ''),
                'subscription' => site_url('account/subscription') . (!empty(session('customer_token')) ? '?customer_token=' . session('customer_token') : ''),

                'text_profile' => lang('Customer.text_profile'),
                'text_my_account' => lang('Customer.text_my_account'),
                'text_profile_edit' => lang('Customer.text_profile_edit'),
                'text_profile_password' => lang('Customer.text_profile_password'),
                'text_profile_address' => lang('Customer.text_profile_address'),
                'text_profile_wishlist' => lang('Customer.text_profile_wishlist'),
                'text_my_orders' => lang('Customer.text_my_orders'),
                'text_profile_order' => lang('Customer.text_profile_order'),
                'text_profile_subscription' => lang('Customer.text_profile_subscription'),
                'text_profile_download' => lang('Customer.text_profile_download'),
                'text_profile_reward' => lang('Customer.text_profile_reward'),
                'text_profile_return' => lang('Customer.text_profile_return'),
                'text_profile_transaction' => lang('Customer.text_profile_transaction'),
                'text_newsletter' => lang('Customer.text_newsletter'),
                'text_profile_newsletter' => lang('Customer.text_profile_newsletter'),
            ];

            $data = array_merge($data, theme_var());
            $data = inertia_data($data);

            return inertia('Account/Profile', $data);
        }

        $this->themes->addPartial('header_top', $params)
            ->addPartial('header_bottom', $params)
            ->addPartial('content_left', $params)
            ->addPartial('content_top', $params)
            ->addPartial('content_bottom', $params)
            ->addPartial('content_right', $params)
            ->addPartial('footer_top', $params)
            ->addPartial('footer_bottom', $params);

        theme_load('profile', $data['contents'] ?? []);
    }
}
