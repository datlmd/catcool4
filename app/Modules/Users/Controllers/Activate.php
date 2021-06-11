<?php namespace App\Modules\Users\Controllers;

use App\Controllers\UserController;
use App\Modules\Users\Models\UserModel;

class Activate extends UserController
{
    public $config_form = [];

    public function __construct()
    {
        parent::__construct();


        $this->model = new UserModel();
    }

    public function index($id = null, $activation = null)
    {
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

        $result = $this->model->activate($id, $activation);

        $data = [
            'result' => $result,
            'errors' => $this->model->getErrors(),
        ];

        $this->breadcrumb->add(lang('General.text_account'), base_url('users/profile'));

        $data_breadcrumb['breadcrumb']       = $this->breadcrumb->render();
        $data_breadcrumb['breadcrumb_title'] = lang("User.heading_activate");
        $this->themes->addPartial('breadcumb', $data_breadcrumb);

        add_meta(['title' => lang("User.heading_activate")], $this->themes);

        theme_load('activate', $data);
    }
}
