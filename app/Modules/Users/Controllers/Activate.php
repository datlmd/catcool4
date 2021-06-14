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



        $result = $this->model->activate($id, $activation);

        $data = [
            'result' => $result,
            'errors' => $this->model->getErrors(),
        ];

        $this->breadcrumb->add(lang('General.text_home'), base_url());
        $this->breadcrumb->add(lang('General.text_account'), base_url('users/profile'));
        breadcrumb($this->breadcrumb, $this->themes, lang("User.heading_activate"));

        add_meta(['title' => lang("User.heading_activate")], $this->themes);

        theme_load('activate', $data);
    }
}
