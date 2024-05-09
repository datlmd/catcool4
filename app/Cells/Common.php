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

    public function menuFooter(array $params): string
    {
        return \App\Libraries\Themes::init()::view('common/menu_footer');
    }

    public function menuMain(array $params): string
    {
        return \App\Libraries\Themes::init()::view('common/menu_main');
    }

    public function headerTop(array $params): string
    {
        $content_html = "";

        $layout_model = new \App\Modules\Layouts\Models\LayoutModel();
        $layout_list = $layout_model->getLayoutsByPostion(get_module(), 'header_top');
        
        
        if (!empty($layout_list)) {
            foreach ($layout_list as $layout) {
                $cell_name = sprintf("%s::%s", $layout['controller'], $layout['action']);
                $content_html .= view_cell("$cell_name", $params);
            }
        }

        return $content_html;
    }

    public function headerBottom(array $params): string
    {
        $content_html = "";

        $layout_model = new \App\Modules\Layouts\Models\LayoutModel();
        $layout_list = $layout_model->getLayoutsByPostion(get_module(), 'header_bottom');
        
        if (!empty($layout_list)) {
            foreach ($layout_list as $layout) {
                $cell_name = sprintf("%s::%s", $layout['controller'], $layout['action']);
                $content_html .= view_cell("$cell_name", $params);
            }
        }
        
        return $content_html;
    }

    public function footerTop(array $params): string
    {
        $content_html = "";

        $layout_model = new \App\Modules\Layouts\Models\LayoutModel();
        $layout_list = $layout_model->getLayoutsByPostion(get_module(), 'footer_top');
        
        if (!empty($layout_list)) {
            foreach ($layout_list as $layout) {
                $cell_name = sprintf("%s::%s", $layout['controller'], $layout['action']);
                $content_html .= view_cell("$cell_name", $params);
            }
        }

        return $content_html;
    }

    public function footerBottom(array $params): string
    {
        $content_html = "";

        $layout_model = new \App\Modules\Layouts\Models\LayoutModel();
        $layout_list = $layout_model->getLayoutsByPostion(get_module(), 'footer_bottom');
        
        if (!empty($layout_list)) {
            foreach ($layout_list as $layout) {
                $cell_name = sprintf("%s::%s", $layout['controller'], $layout['action']);
                $content_html .= view_cell("$cell_name", $params);
            }
        }
        
        return $content_html;
    }

    public function contentTop(array $params): string
    {
        $content_html = "";

        $layout_model = new \App\Modules\Layouts\Models\LayoutModel();
        $layout_list = $layout_model->getLayoutsByPostion(get_module(), 'content_top');

        if (!empty($layout_list)) {
            foreach ($layout_list as $layout) {
                $cell_name = sprintf("%s::%s", $layout['controller'], $layout['action']);
                $content_html .= view_cell("$cell_name", $params);
            }
        }

        return $content_html;
    }

    public function contentBottom(array $params): string
    {
        $content_html = "";

        $layout_model = new \App\Modules\Layouts\Models\LayoutModel();
        $layout_list = $layout_model->getLayoutsByPostion(get_module(), 'content_bottom');
        
        if (!empty($layout_list)) {
            foreach ($layout_list as $layout) {
                $cell_name = sprintf("%s::%s", $layout['controller'], $layout['action']);
                $content_html .= view_cell("$cell_name", $params);
            }
        }

        return $content_html;
    }

    public function contentLeft(array $params): string
    {
        $content_html = "";

        $layout_model = new \App\Modules\Layouts\Models\LayoutModel();
        $layout_list = $layout_model->getLayoutsByPostion(get_module(), 'column_left');
        
        if (!empty($layout_list)) {
            foreach ($layout_list as $layout) {
                $cell_name = sprintf("%s::%s", $layout['controller'], $layout['action']);
                $content_html .= view_cell("$cell_name", $params);
            }
        }

        return $content_html;
    }

    public function contentRight(array $params): string
    {
        $content_html = "";

        $layout_model = new \App\Modules\Layouts\Models\LayoutModel();
        $layout_list = $layout_model->getLayoutsByPostion(get_module(), 'column_right');
        
        if (!empty($layout_list)) {
            foreach ($layout_list as $layout) {
                $cell_name = sprintf("%s::%s", $layout['controller'], $layout['action']);
                $content_html .= view_cell("$cell_name", $params);
            }
        }

        return $content_html;
    }
}

