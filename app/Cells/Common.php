<?php

namespace App\Cells;

class Common
{
    public function language($type = null): string
    {
        if (empty($type)) {
            $type = "dropdown";
        }

        return \App\Libraries\Themes::init()::view('common/language', ['type' => $type]);
    }

    public function currency($type = null): string
    {
        $currency_model = new \App\Modules\Currencies\Models\CurrencyModel();

        if (empty($type)) {
            $type = "dropdown";
        }

        return \App\Libraries\Themes::init()::view('common/currency', ['currency_list' => $currency_model->getListPublished(), 'type' => $type]);
    }

    public function menuFooter(): string
    {
        return \App\Libraries\Themes::init()::view('common/menu_footer');
    }

    public function menuMain(): string
    {
        return \App\Libraries\Themes::init()::view('common/menu_main');
    }

    public function headerTop(): string
    {
      
        $data = [];

        if (!service('Customer')->isLogged()) {

        }

        $data['wishlist'] = site_url('account/wishlist') . (!empty(session('customer_token')) ? '?customer_token=' . session('customer_token') : '');
		$data['logged'] = service('Customer')->isLogged();

        if (!service('Customer')->isLogged()) {
			$data['register'] = site_url('account/register');
			$data['login'] = site_url('account/login');
		} else {
			$data['account'] = site_url('account/account' . '?customer_token=' . session('customer_token'));
			$data['order'] = site_url('account/order' . '?customer_token=' . session('customer_token'));
			$data['transaction'] = site_url('account/transaction' . '?customer_token=' . session('customer_token'));
			$data['download'] = site_url('account/download' . '?customer_token=' . session('customer_token'));
			$data['logout'] = site_url('account/logout' . '?customer_token=' . session('customer_token'));
		}

        $data['shopping_cart'] = site_url('checkout/cart');
		$data['checkout'] = site_url('checkout/checkout');
        
        return \App\Libraries\Themes::init()::partial('cells/header_top', $data);
    }

    public function headerBottom(): string
    {
        $content_html = "";
        
        return $content_html;
    }

    public function footerTop(): string
    {
        $content_html = "";
        return $content_html;
    }

    public function footerBottom(): string
    {
        $content_html = "";

        $footer_bottom = \App\Libraries\Themes::init()::partial('cells/footer_bottom', [], true);

        $content_html = $footer_bottom;
        
        return $content_html;
    }
}

