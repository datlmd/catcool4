<?php namespace App\Modules\News\Controllers;

use App\Controllers\BaseController;
use App\Modules\News\Models\NewsModel;
use App\Modules\News\Models\CategoryModel;

class Categories extends BaseController
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

        $this->model = new CategoryModel();
        $this->news_model = new NewsModel();
    }

    public function detail($id = null)
    {
        $category_list = $this->model->getListPublished();
        $detail = $category_list[$id] ?? null;

        list($list, $pager) = $this->news_model->getListByCategory($id);

        $data = [
            'detail'       => $detail,
            'list'         => $list,
            'pager'        => $pager,
            'hot_list'     => $this->news_model->getListHot(4),
            'new_list'     => $this->news_model->getListNew(5),
            'counter_list' => $this->news_model->getListCounter(6),
            'category_list' => $category_list
        ];

        $this->_setMeta($detail);

        theme_load('categories/list', $data);
    }

    private function _setMeta($detail)
    {
        //META
        $data_meta = [
            'title'       => !empty($detail['meta_title']) ? $detail['meta_title'] : $detail['name'],
            'description' => !empty($detail['meta_description']) ? $detail['meta_description'] : $detail['description'],
            'keywords'    => !empty($detail['meta_keyword']) ? $detail['meta_keyword'] : null,
            'url'         => base_url($detail['slug']),
        ];

        add_meta($data_meta, $this->themes);
    }
}
