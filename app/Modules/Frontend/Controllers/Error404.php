<?php namespace App\Modules\Frontend\Controllers;

use App\Controllers\MyController;

class Error404 extends MyController
{

    public function __construct()
    {
        parent::__construct();

        //set theme
        $this->themes->setTheme(config_item('theme_frontend'));

        $this->themes->addPartial('header_top')
             ->addPartial('header_bottom')
             ->addPartial('content_left')
             ->addPartial('content_top')
             ->addPartial('content_bottom')
             ->addPartial('content_right')
             ->addPartial('footer_top')
             ->addPartial('footer_bottom');
    }

    public function index()
    {
        $data = [];

        add_meta(['title' => lang("General.heading_page404")], $this->themes);

        theme_load('frontend/show404', $data);
    }
}
