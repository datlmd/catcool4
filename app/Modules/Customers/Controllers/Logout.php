<?php namespace App\Modules\Customers\Controllers;

use App\Controllers\MyController;

class Logout extends MyController
{
    public function index(): void {

        if (service('customer')->isLogged()) {
			service('customer')->logout();

            session()->remove([
                'customer',
                'shipping_address',
                'shipping_method',
                'shipping_methods',
                'payment_address',
                'payment_method',
                'payment_methods',
                'comment',
                'order_id',
                'coupon',
                'reward',
                'voucher',
                'vouchers',
                'customer_token',
            ]);

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

