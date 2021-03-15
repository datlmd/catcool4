<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Languages extends My_Controller
{
    public $config_form = [];
    public $data        = [];

    public function __construct()
    {
        parent::__construct();

        //set theme
    }

    public function switch_lang($code)
    {
        set_lang($code);

//        $this->load->model("menus/Menu", 'Menu');
//        $this->Menu->delete_cache();

        redirect(previous_url());
    }
}
