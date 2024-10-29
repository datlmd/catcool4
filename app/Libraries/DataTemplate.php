<?php

namespace App\Libraries;

use CodeIgniter\Config\Factories;

class DataTemplate
{
    public function dataHeader(): array {
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

        //Load React
        $data['store_address'] = config_item('store_address');
        $data['store_phone'] = config_item('store_phone');
        $data['store_email'] = config_item('store_email');
        $data['site_name'] = config_item('site_name');

        $data['text_wishlist'] = lang('General.text_wishlist');
        $data['text_shopping_cart'] = lang('General.text_shopping_cart');
        $data['text_my_account'] = lang('General.text_my_account');
        $data['text_account'] = lang('General.text_account');
        $data['text_order'] = lang('General.text_order');
        $data['text_transaction'] = lang('General.text_transaction');
        $data['text_logout'] = lang('General.text_logout');
        $data['text_login'] = lang('General.text_login');
        $data['text_register'] = lang('General.text_register');

        $data['logo'] = image_url(config_item('image_logo_url'), 120, 100);

        $data['menu_top'] = get_menu_by_position(MENU_POSITION_TOP);
        $data['menu_main'] = get_menu_by_position();

        $data['currency'] = $this->getCurrency();
        $data['language'] = $this->getLanguages();
        
        $data['is_multi_language'] = is_multi_language();

        return $data;
    }

    /**
     * Get Languages
     *
     * @return array
     */
    public function getLanguages(): array {
        $language = [];
        $code = language_code();

        $result = json_decode(config_item('list_language_cache'), 1);
        foreach ($result as $value) {
            $value['href'] = site_url("languages/switch/" . $value['code']);
            $value['text_language'] = lang("General.{$value['code']}");

            $language['list'][] = $value;

            if ($code == $value['code']) {
                $language['info'] = $value;
            }
        }

        return $language;
    }

    /**
     * Get currency
     *
     * @return array
     */
    public function getCurrency(): array {
        $currency = [];
        $code = config_item('currency');

        $result = Factories::models('\App\Modules\Currencies\Models\CurrencyModel')->getListPublished();
        foreach ($result as $value) {
            $value['href'] = "contact";
            $currency['list'][] = $value;

            if ($code == $value['code']) {
                $currency['info'] = $value;
            }
        }

        return $currency;
    }
}
