<?php namespace App\Modules\Customers\Controllers;

use App\Controllers\MyController;

class Logout extends MyController
{
    public function index(): void {

        if (service('customer')->isLogged()) {
			service('customer')->logout();

            session()->remove(['customer']);
            session()->remove(['shipping_address']);
            session()->remove(['shipping_method']);
            session()->remove(['shipping_methods']);
            session()->remove(['payment_address']);
            session()->remove(['payment_method']);
            session()->remove(['payment_methods']);
            session()->remove(['comment']);
            session()->remove(['order_id']);
            session()->remove(['coupon']);
            session()->remove(['reward']);
            session()->remove(['voucher']);
            session()->remove(['vouchers']);
            session()->remove(['customer_token']);

            redirect()->to(site_url('account/logout'));
		}

        //set theme
        $this->themes->setTheme(config_item('theme_frontend'));

        $this->themes->addPartial('header_top')
            ->addPartial('header_bottom')
            ->addPartial('content_left')
            ->addPartial('content_top')
            ->addPartial('content_bottom')
            ->addPartial('content_right')
            ->addPartial('footer_top')
            ->addPartial('footer_bottom');

        $data = [];

        $this->breadcrumb->add(lang('General.text_home'), base_url());
        $this->breadcrumb->add(lang('General.text_logout'), base_url('account/logout'));
        breadcrumb($this->breadcrumb, $this->themes, lang("General.text_logout"));

        add_meta(['title' => lang("Customer.text_account_logout")], $this->themes);

        theme_load('logout', $data);
    }
}

