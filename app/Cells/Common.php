<?php

namespace App\Cells;

class Common
{
    public function language(): string
    {
        return \App\Libraries\Themes::init()::view('common/language');
    }

    public function currency(): string
    {
        $currency_model = new \App\Modules\Currencies\Models\CurrencyModel();

        return \App\Libraries\Themes::init()::view('common/currency', ['currency_list' => $currency_model->getListPublished()]);
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

