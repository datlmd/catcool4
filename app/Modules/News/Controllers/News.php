<?php namespace App\Modules\News\Controllers;

use App\Controllers\BaseController;
use App\Modules\News\Models\NewsModel;
use App\Modules\News\Models\CategoryModel;

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
            'category_list'        => $this->model->getListHome(),
            'slide_list'           => $this->model->getSlideHome(4),
            'counter_list'         => $this->model->getListCounter(10),
            'hot_list'             => $this->model->getListHot(4),
            'new_list'             => $this->model->getListNew(5),
            'script_google_search' => $this->_scriptGoogleSearch(),
            'bg_color'             => [
                'bg-primary',
                'bg-secondary',
                'bg-tertiary',
                'bg-quaternary',
                'bg-success',
                'bg-info',
                'bg-warning',
                'bg-danger'
            ],
        ];

        add_meta(['title' => lang("News.heading_title")], $this->themes);

        theme_load('index', $data);
    }

    private function _scriptGoogleSearch()
    {
        $category_model = new CategoryModel();
        $category_list = $category_model->getListPublished();

        //GOOGLE BREADCRUMB STRUCTURED DATA
        $script_breadcrumb  = [];
        if (!empty($category_list)) {
            foreach ($category_list as $category) {
                $script_breadcrumb[] = [
                    'name' => $category['name'],
                    'url'  => sprintf('%s/%s.html',  base_url(), $category['slug'])
                ];
            }
        }
        $script_detail = null;
        $script_google_search = script_google_search($script_detail, $script_breadcrumb);

        return $script_google_search;
    }
}
