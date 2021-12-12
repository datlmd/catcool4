<?php namespace App\Modules\Manage\Controllers;

use App\Controllers\AdminController;

class RunSeeder extends AdminController
{
    protected $errors = [];

    CONST MANAGE_ROOT = 'manage/run_seeder';
    CONST MANAGE_URL  = 'manage/run_seeder';

    public function __construct()
    {
        parent::__construct();

        $this->themes->setTheme(config_item('theme_admin'))
            ->addPartial('header')
            ->addPartial('footer')
            ->addPartial('sidebar');

        //create url manage
        $this->smarty->assign('manage_url', self::MANAGE_URL);
        $this->smarty->assign('manage_root', self::MANAGE_ROOT);

        //add breadcrumb
        $this->breadcrumb->add(lang('Admin.catcool_dashboard'), site_url(CATCOOL_DASHBOARD));
        $this->breadcrumb->add("Run Seeder", site_url(self::MANAGE_URL));
    }

    public function index()
    {
        try {

            $seeder = \Config\Database::seeder();

            // add language
            $seeder->call('LanguageSeeder');

            // add config
            //$seeder->call('ConfigSeeder');

            $message = "Added successfully!";
        } catch (\Exception $ex) {
            $message = $ex->getMessage();
        }

        $data = [
            'breadcrumb' => $this->breadcrumb->render(),
            'message' => $message,
        ];

        add_meta(['title' => lang("Run Seeder")], $this->themes);
        $this->themes::load('run_seeder', $data);
    }

}
