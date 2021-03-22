<?php namespace App\Modules\Images\Controllers;

use App\Controllers\AdminController;

class Editor extends AdminController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        add_meta(['title' => "Photo Editor"], $this->themes);

        $this->themes->setTheme(config_item('theme_admin'))
            ->addPartial('header')
            ->addPartial('footer')
            ->addPartial('sidebar')
            ::load('editor');
    }
}
