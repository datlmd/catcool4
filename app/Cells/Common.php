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
}

