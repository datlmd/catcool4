<?php namespace App\Modules\Frontend\Controllers;

use App\Controllers\BaseController;

class Frontend extends BaseController
{

    public function __construct()
    {
        parent::__construct();

        //set theme
        $this->themes->setTheme(config_item('theme_frontend'));

        $this->themes->addPartial('header_top')
            ->addPartial('header_bottom')
            ->addPartial('content_left')
            ->addPartial('content_right')
            ->addPartial('footer_top')
            ->addPartial('footer_bottom');

        $this->breadcrumb->openTag(config_item('breadcrumb_open'));
        $this->breadcrumb->closeTag(config_item('breadcrumb_close'));
        $this->breadcrumb->add(lang('General.text_home'), base_url());
    }

    public function index()
    {
        $data = [];

        add_meta(['title' => lang("Frontend.heading_title")], $this->themes);

        theme_load('index', $data);
    }
}
