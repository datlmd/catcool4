<?php namespace App\Modules\Frontend\Controllers;

use App\Controllers\BaseController;

class Frontend extends BaseController
{

    public function __construct()
    {
        parent::__construct();

        //set theme
        $this->themes->setTheme(config_item('theme_frontend'))
            ->addPartial('header_top')
            ->addPartial('header_bottom')
            ->addPartial('breadcumb')
            ->addPartial('footer_bottom');

        $this->breadcrumb->add(lang('Frontend.frontend_heading'), site_url());
    }

    public function index()
    {
        $data = [];

        add_meta(['title' => lang("Frontend.heading_title")], $this->themes);

        theme_load('index', $data);
    }
}
