<?php namespace App\Modules\Users\Controllers;

use App\Controllers\AdminController;
use App\Modules\Users\Models\UserModel;

class Auth extends AdminController
{
    public $config_form = [];
    public $data        = [];

    CONST MANAGE_ROOT       = 'users/auth';
    CONST MANAGE_URL        = 'users/auth';

    public function __construct()
    {
        parent::__construct();

        $this->themes->setTheme(config_item('theme_admin'))
            ->addPartial('header')
            ->addPartial('footer')
            ->addPartial('sidebar');

        $this->model = new UserModel();

        //create url manage
        $this->smarty->assign('manage_url', self::MANAGE_URL);
        $this->smarty->assign('manage_root', self::MANAGE_ROOT);
    }

    public function index()
    {
        //tat ca xu ly auth

        return null;
    }

    public function recaptcha()
    {
        if (!$this->request->isAJAX()) {
            show_404();
        }

        json_output(['captcha' => print_re_captcha()]);
    }
}
