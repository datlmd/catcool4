<?php

namespace App\Cells;

use Psr\Log\NullLogger;

class Template
{
    public function account(array $params): string
    {
        $data['logged'] = service('customer')->isLogged();
        $data['register'] = site_url('account/register');
        $data['login'] = site_url('account/login');
        $data['logout'] = site_url('account/logout');
        $data['forgotten'] = site_url('account/forgotten');

        $data['profile'] = site_url('account/profile') . (!empty(session('customer_token')) ? '?customer_token=' . session('customer_token') : "");
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

        return \App\Libraries\Themes::init()::view('cells/account', $data);
    }

    public function footer(array $params): string
    {
        $footer_bottom = \App\Libraries\Themes::init()::partial('cells/footer', [], true);

        return $footer_bottom;
    }

    public function header(array $params): string
    {
        $data = [];

        $data['wishlist'] = site_url('account/wishlist') . (!empty(session('customer_token')) ? '?customer_token=' . session('customer_token') : '');
		$data['logged'] = service('Customer')->isLogged();

        if (!service('Customer')->isLogged()) {
			$data['register'] = site_url('account/register');
			$data['login'] = site_url('account/login');
		} else {
			$data['account'] = site_url('account/profile' . '?customer_token=' . session('customer_token'));
			$data['order'] = site_url('account/order' . '?customer_token=' . session('customer_token'));
			$data['transaction'] = site_url('account/transaction' . '?customer_token=' . session('customer_token'));
			$data['download'] = site_url('account/download' . '?customer_token=' . session('customer_token'));
			$data['logout'] = site_url('account/logout' . '?customer_token=' . session('customer_token'));

            $data['customer_name'] = full_name(service('Customer')->getFirstName(), service('Customer')->getLastName());
            $data['customer_avatar'] = image_url(service('Customer')->getImage(), 45, 45);
 		}



        $data['shopping_cart'] = site_url('checkout/cart');
		$data['checkout'] = site_url('checkout/checkout');

        $header_top = \App\Libraries\Themes::init()::partial('cells/header', $data, true);

        return $header_top;
    }

    public function breadcrumb(array $params): string
    {
        $data['breadcrumb']       = $params['breadcrumb'];
        // cc_debug(service('Breadcrumb'));
        // //$data['breadcrumb_title'] = $title;

        $footer_bottom = \App\Libraries\Themes::init()::partial('cells/breadcrumb', $data, true);

        return $footer_bottom;
    }
}

