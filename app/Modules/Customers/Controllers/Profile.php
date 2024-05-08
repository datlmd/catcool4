<?php namespace App\Modules\Customers\Controllers;

use App\Controllers\UserController;

class Profile extends UserController
{
    public $config_form = [];

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if (!service('customer')->isLogged() || (empty($this->request->getGet('customer_token')) || empty(session('customer_token')) || ($this->request->getGet('customer_token') != session('customer_token')))) {            
            if (service('customer')->loginRememberedCustomer()) {
                return redirect()->to(current_url() . '?customer_token=' . session('customer_token'));
            }
        
            return redirect()->to(site_url("account/login?return_url=" . current_url()));
		}

        $this->themes->setTheme(config_item('theme_frontend'));
        $this->themes->addPartial('header_top')
            ->addPartial('header_bottom')
            ->addPartial('content_left')
            ->addPartial('content_top')
            ->addPartial('content_bottom')
            ->addPartial('content_right')
            ->addPartial('footer_top')
            ->addPartial('footer_bottom');


        
        $data['edit'] = site_url('account/edit') . (!empty(session('customer_token')) ? '?customer_token=' . session('customer_token') : "");
        $data['password'] = site_url('account/password') . (!empty(session('customer_token')) ? '?customer_token=' . session('customer_token') : "");
        $data['address'] = site_url('account/address') . (!empty(session('customer_token')) ? '?customer_token=' . session('customer_token') : "");
        $data['wishlist'] = site_url('account/wishlist') . (!empty(session('customer_token')) ? '?customer_token=' . session('customer_token') : "");
        
        $data['order'] = site_url('account/order') . (!empty(session('customer_token')) ? '?customer_token=' . session('customer_token') : "");
        $data['download'] = site_url('account/download') . (!empty(session('customer_token')) ? '?customer_token=' . session('customer_token') : "");
        $data['reward'] = site_url('account/reward') . (!empty(session('customer_token')) ? '?customer_token=' . session('customer_token') : "");
        $data['return'] = site_url('account/return') . (!empty(session('customer_token')) ? '?customer_token=' . session('customer_token') : "");
        $data['transaction'] = site_url('account/transaction') . (!empty(session('customer_token')) ? '?customer_token=' . session('customer_token') : "");
        $data['newsletter'] = site_url('account/newsletter') . (!empty(session('customer_token')) ? '?customer_token=' . session('customer_token') : "");
        $data['subscription'] = site_url('account/subscription') . (!empty(session('customer_token')) ? '?customer_token=' . session('customer_token') : "");

        $this->breadcrumb->add(lang('General.text_home'), base_url());
        $this->breadcrumb->add(lang('Customer.text_profile'), site_url('account/profile') . '?customer_token=' . session('customer_token'));
        breadcrumb($this->breadcrumb, $this->themes, lang("Customer.text_profile"));

        add_meta(['title' => lang("Customer.text_profile")], $this->themes);

        theme_load('profile', $data);
    }
}
