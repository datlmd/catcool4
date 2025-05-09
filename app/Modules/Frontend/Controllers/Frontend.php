<?php

namespace App\Modules\Frontend\Controllers;

use App\Controllers\MyController;

class Frontend extends MyController
{
    public function __construct()
    {
        parent::__construct();

        //set theme
        $this->themes->setTheme(config_item('theme_frontend'));
    }

    public function index()
    {
        $data = [];


        $this->breadcrumb->add(lang('General.text_home'), base_url());

        $params['params'] = [
            'breadcrumb' => $this->breadcrumb->render(),
            'breadcrumb_title' => lang('General.text_home'),
        ];

        $this->themes->addPartial('header_top', $params)
             ->addPartial('header_bottom', $params)
             ->addPartial('content_left', $params)
             ->addPartial('content_top', $params)
             ->addPartial('content_bottom', $params)
             ->addPartial('content_right', $params)
             ->addPartial('footer_top', $params)
             ->addPartial('footer_bottom', $params);

        add_meta(['title' => lang("Frontend.heading_title")], $this->themes);

        theme_load('index', $data);
    }
}
