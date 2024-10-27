<?php

namespace App\Cells;

use App\Libraries\DataTemplate;

class Template extends DataTemplate
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
        $footer_bottom = "";
        try {
            $footer_bottom = \App\Libraries\Themes::init()::partial('cells/footer', [], true);
        } catch (\Exception $ex) {}

        return $footer_bottom;
    }

    public function header(array $params): string
    {
        $data = [];

        //is_no_account = true: khong can check login vaf account cua khach hang
        if (empty($params['is_no_account'])) {
            $data = $this->dataHeader();
        }

        $header_top = "";

        try {
            $header_top = \App\Libraries\Themes::init()::partial('cells/header', $data, true);
        } catch (\Exception $ex) {}

        return $header_top;
    }

    public function breadcrumb(array $params): string
    {
        try {
            return \App\Libraries\Themes::init()::partial('cells/breadcrumb', $params, true);
        } catch (\Exception $ex) {
            return "";
        }
    }
}

