<?php namespace App\Modules\Languages\Controllers;

use App\Controllers\BaseController;

class Languages extends BaseController
{
    public $config_form = [];
    public $data        = [];

    public function __construct()
    {
        parent::__construct();

        //set theme
    }

    public function switch($code)
    {
        set_lang($code);

        $menu_model = new  \App\Modules\Menus\Models\MenuModel();
        $menu_model->deleteCache();

        return redirect()->back();
    }
}
