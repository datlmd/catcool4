<?php

namespace App\Modules\Languages\Controllers;

use App\Controllers\MyController;

class Languages extends MyController
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
        set_language($code);

        return redirect()->back();
    }
}
