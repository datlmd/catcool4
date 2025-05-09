<?php

namespace App\Modules\Scan\Controllers\Admin;

use App\Controllers\AdminController;
use App\Modules\Scan\Models\ScanModel;

class Scan extends AdminController
{
    protected $errors = [];

    protected $model_lang;

    public const MANAGE_ROOT = 'manage/scan';
    public const MANAGE_URL  = 'manage/scan';

    public function __construct()
    {
        parent::__construct();

        $this->themes->setTheme(config_item('theme_admin'));

        $this->model = new ScanModel();

        //create url manage
        $this->smarty->assign('manage_url', self::MANAGE_URL);
        $this->smarty->assign('manage_root', self::MANAGE_ROOT);

        //add breadcrumb
        $this->breadcrumb->add(lang('Admin.catcool_dashboard'), site_url(CATCOOL_DASHBOARD));
        $this->breadcrumb->add(lang('Scan.heading_title'), site_url(self::MANAGE_URL));
    }

    public function index()
    {
        add_meta(['title' => lang('Scan.heading_title')], $this->themes);



        $list = [];

        $data = [
            'breadcrumb'    => $this->breadcrumb->render(),
            'list'          => $list,
        ];

        $this->themes
            ->addPartial('header')
            ->addPartial('footer')
            ->addPartial('sidebar')::load('scan', $data);
    }

    public function getContent()
    {
        if (!$this->request->isAJAX()) {
            page_not_found();
        }

        $token = csrf_hash();

        $url = $this->request->getPost('url');
        if (empty($url)) {
            json_output(['token' => $token, 'status' => 'ng', 'msg' => lang('Admin.error_empty')]);
        }

        $content = $this->model->scanUrl($url);

        $data['content'] = $content;

        json_output(['token' => $token, 'data' => $this->themes::view('content', $data)]);
    }
}
