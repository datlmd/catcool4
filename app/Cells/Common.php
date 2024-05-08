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
        $content_html = "";

        $data = [];

        if (!service('Customer')->isLogged()) {

        }

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

        $content_html .= \App\Libraries\Themes::init()::partial('cells/header_top', $data, true);
    
        $layout_model = new \App\Modules\Layouts\Models\LayoutModel();
        $layout_list = $layout_model->getLayoutsByPostion(get_module(), 'header_top');
        
        if (!empty($layout_list)) {
            foreach ($layout_list as $layout) {
                $cell_name = sprintf("%s::%s", $layout['controller'], $layout['action']);
                $content_html .= view_cell("$cell_name");
            }
        }
        
        return $content_html;
    }

    public function headerBottom(): string
    {
        $content_html = "";

        $layout_model = new \App\Modules\Layouts\Models\LayoutModel();
        $layout_list = $layout_model->getLayoutsByPostion(get_module(), 'header_bottom');
        
        if (!empty($layout_list)) {
            foreach ($layout_list as $layout) {
                $cell_name = sprintf("%s::%s", $layout['controller'], $layout['action']);
                $content_html .= view_cell("$cell_name");
            }
        }
        
        return $content_html;
    }

    public function footerTop(): string
    {
        $content_html = "";

        $layout_model = new \App\Modules\Layouts\Models\LayoutModel();
        $layout_list = $layout_model->getLayoutsByPostion(get_module(), 'footer_top');
        
        if (!empty($layout_list)) {
            foreach ($layout_list as $layout) {
                $cell_name = sprintf("%s::%s", $layout['controller'], $layout['action']);
                $content_html .= view_cell("$cell_name");
            }
        }

        return $content_html;
    }

    public function footerBottom(): string
    {
        $content_html = "";

        $layout_model = new \App\Modules\Layouts\Models\LayoutModel();
        $layout_list = $layout_model->getLayoutsByPostion(get_module(), 'footer_bottom');
        
        if (!empty($layout_list)) {
            foreach ($layout_list as $layout) {
                $cell_name = sprintf("%s::%s", $layout['controller'], $layout['action']);
                $content_html .= view_cell("$cell_name");
            }
        }

        $footer_bottom = \App\Libraries\Themes::init()::partial('cells/footer_bottom', [], true);

        $content_html .= $footer_bottom;
        
        return $content_html;
    }

    public function contentTop(): string
    {
        $content_html = "";

        $layout_model = new \App\Modules\Layouts\Models\LayoutModel();
        $layout_list = $layout_model->getLayoutsByPostion(get_module(), 'content_top');
        
        if (!empty($layout_list)) {
            foreach ($layout_list as $layout) {
                $cell_name = sprintf("%s::%s", $layout['controller'], $layout['action']);
                $content_html .= view_cell("$cell_name");
            }
        }

        return $content_html;
    }

    public function contentBottom(): string
    {
        $content_html = "";

        $layout_model = new \App\Modules\Layouts\Models\LayoutModel();
        $layout_list = $layout_model->getLayoutsByPostion(get_module(), 'content_bottom');
        
        if (!empty($layout_list)) {
            foreach ($layout_list as $layout) {
                $cell_name = sprintf("%s::%s", $layout['controller'], $layout['action']);
                $content_html .= view_cell("$cell_name");
            }
        }

        return $content_html;
    }

    public function contentLeft(): string
    {
        $content_html = "";

        $layout_model = new \App\Modules\Layouts\Models\LayoutModel();
        $layout_list = $layout_model->getLayoutsByPostion(get_module(), 'column_left');
        
        if (!empty($layout_list)) {
            foreach ($layout_list as $layout) {
                $cell_name = sprintf("%s::%s", $layout['controller'], $layout['action']);
                $content_html .= view_cell("$cell_name");
            }
        }

        return $content_html;
    }

    public function contentRight(): string
    {
        $content_html = "";

        $layout_model = new \App\Modules\Layouts\Models\LayoutModel();
        $layout_list = $layout_model->getLayoutsByPostion(get_module(), 'column_right');
        
        if (!empty($layout_list)) {
            foreach ($layout_list as $layout) {
                $cell_name = sprintf("%s::%s", $layout['controller'], $layout['action']);
                $content_html .= view_cell("$cell_name");
            }
        }

        return $content_html;
    }
}

