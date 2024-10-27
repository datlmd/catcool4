<?php

namespace App\Libraries;

class DataTemplate
{
    public function dataHeader(): array
    {
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

        return $data;
    }
}
