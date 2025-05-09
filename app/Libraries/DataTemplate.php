<?php

namespace App\Libraries;

use CodeIgniter\Config\Factories;

class DataTemplate
{
    public function dataHeader(?array $params = []): array
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

        $data['text_menu'] = lang('Frontend.text_menu');
        $data['text_search_title'] = lang('Frontend.text_search_title');

        $data['logo'] = image_url(config_item('image_logo_url'), 120, 100);

        $data['menu_top'] = get_menu_by_position(MENU_POSITION_TOP);
        $data['menu_main'] = get_menu_by_position();

        $data['currency'] = $this->_getCurrency();
        $data['language'] = $this->_getLanguages();

        $data['is_multi_language'] = is_multi_language();

        return $data;
    }

    /**
     * Get Languages
     *
     * @return array
     */
    private function _getLanguages(): array
    {
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
    private function _getCurrency(): array
    {
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

    public function dataBreadcrumb(?array $params = []): array
    {

        $data = $params;

        return $data;
    }

    public function dataFooter(?array $params = []): array
    {

        $data = [];

        $data['store_open'] = config_item('store_open');

        $data['text_business_hours'] = lang('Frontend.text_business_hours');
        $data['text_copyright'] = lang('Frontend.text_copyright');
        $data['text_newsletter'] = lang('Frontend.text_newsletter');
        $data['text_newsletter_description'] = lang('Frontend.text_newsletter_description');
        $data['text_follow'] = lang('Frontend.text_follow');
        $data['social_facebook_link'] = lang('Frontend.social_facebook_link');
        $data['social_twitter_link'] = lang('Frontend.social_twitter_link');
        $data['social_tiktok_link'] = lang('Frontend.social_tiktok_link');
        $data['social_linkedin_link'] = lang('Frontend.social_linkedin_link');
        $data['social_instagram_link'] = lang('Frontend.social_instagram_link');
        $data['social_pinterest_link'] = lang('Frontend.social_pinterest_link');

        $data['text_subscribe_email'] = lang('General.text_subscribe_email');
        $data['button_subscribe'] = lang('General.button_subscribe');

        $data['payment_icon'] = img_url('payment-icon.png');

        $data['menu_footer'] = get_menu_by_position(MENU_POSITION_FOOTER);

        return $data;
    }

    public function dataAccount(?array $params = []): array
    {

        $data = [];

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

        $data['text_login'] = lang('Customer.text_login');
        $data['text_register'] = lang('Customer.text_register');
        $data['text_forgotten'] = lang('Customer.text_forgotten');
        $data['text_profile'] = lang('Customer.text_profile');
        $data['text_account_edit'] = lang('Customer.text_account_edit');
        $data['text_password'] = lang('Customer.text_password');
        $data['text_address'] = lang('Customer.text_address');
        $data['text_wishlist'] = lang('Customer.text_wishlist');
        $data['text_order'] = lang('Customer.text_order');
        $data['text_download'] = lang('Customer.text_download');
        $data['text_reward'] = lang('Customer.text_reward');
        $data['text_return'] = lang('Customer.text_return');
        $data['text_transaction'] = lang('Customer.text_transaction');
        $data['text_newsletter'] = lang('Customer.text_newsletter');
        $data['text_subscription'] = lang('Customer.text_subscription');
        $data['text_logout'] = lang('Customer.text_logout');

        return $data;
    }
}
