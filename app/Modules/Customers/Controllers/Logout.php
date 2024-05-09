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

        $data = [];

        //breadcrumb
        $this->breadcrumb->add(lang('General.text_home'), base_url());
        $this->breadcrumb->add(lang('General.text_logout'), base_url('account/logout'));

        //set params khi call cell
        $params['params'] = [
            'breadcrumb' => $this->breadcrumb->render(),
            'breadcrumb_title' => lang('General.text_logout'),
        ];
        
        $this->themes->addPartial('header_top', $params)
             ->addPartial('header_bottom', $params)
             ->addPartial('content_left', $params)
             ->addPartial('content_top', $params)
             ->addPartial('content_bottom', $params)
             ->addPartial('content_right', $params)
             ->addPartial('footer_top', $params)
             ->addPartial('footer_bottom', $params);

        add_meta(['title' => lang("Customer.text_account_logout")], $this->themes);

        theme_load('logout', $data);
    }
}

