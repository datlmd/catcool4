<?php namespace App\Modules\News\Controllers;

use App\Controllers\BaseController;
use App\Modules\News\Models\NewsModel;

class News extends BaseController
{
    protected $model;

    public function __construct()
    {
        parent::__construct();

        //set theme
        $this->themes->setTheme(config_item('theme_frontend'));

        $this->themes->addPartial('header_top')
            ->addPartial('header_bottom')
            ->addPartial('footer_top')
            ->addPartial('footer_bottom');

        $this->model = new NewsModel();
    }

    public function index()
    {
        $data = [
            'category_list' => $this->model->getListHome(),
            'slide_list' => $this->model->getListHome(NewsModel::HOME_TYPE_SLIDE),
        ];

        //cc_debug($data['category_list']);

        add_meta(['title' => lang("News.heading_title")], $this->themes);

        theme_load('index', $data);
    }
}
