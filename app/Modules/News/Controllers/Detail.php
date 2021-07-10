<?php namespace App\Modules\News\Controllers;

use App\Controllers\BaseController;
use App\Modules\News\Models\NewsModel;
use App\Modules\News\Models\CategoryModel;

class Detail extends BaseController
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

    public function index($slug, $news_id, $ctime)
    {
        $category_model = new CategoryModel();
        $category_list = $category_model->getListPublished();

        $detail = $this->model->getNewsInfo($news_id, $ctime);

        $news_category_list = [];
        $category_list = $this->model->getListHome();
        if (!empty($category_list) && !empty($news['category_ids'])) {
            foreach ($news['category_ids'] as $category_id) {
                if (isset($category_list[$category_id])) {
                    $news_category_list = array_merge($news_category_list, $category_list[$category_id]['list']);
                }
            }
        }
        shuffle($news_category_list);

        $data = [
            'detail' => $detail,
            'news_category_list' => $news_category_list,
            'category_list' => $category_list,
        ];


        //cc_debug($data['category_list']);

        add_meta(['title' => lang("News.heading_title")], $this->themes);

        theme_load('detail', $data);
    }
}
