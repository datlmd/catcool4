<?php namespace App\Modules\Users\Controllers;

use App\Controllers\UserController;
use App\Modules\Users\Models\UserModel;

class Users extends UserController
{
    public $config_form = [];

    public function __construct()
    {
        parent::__construct();


        $this->model      = new UserModel();

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

        theme_load('list', $data);
    }
}
