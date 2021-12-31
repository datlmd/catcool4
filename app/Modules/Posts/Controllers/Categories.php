<?php namespace App\Modules\Posts\Controllers;

use App\Controllers\MyController;
use App\Modules\Posts\Models\PostModel;
use App\Modules\Posts\Models\CategoryModel;

class Categories extends MyController
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
        $this->post_model = new PostModel();
    }

    public function detail($id = null)
    {
        $post_category_list = $this->model->getListPublished();
        $detail = $post_category_list[$id] ?? null;
        if (empty($detail)) {
            $this->pageNotFound();
        }

        list($list, $pager) = $this->post_model->getListByCategory($id);

        $news_model = new \App\Modules\News\Models\NewsModel();
        $news_category_model = new \App\Modules\News\Models\CategoryModel();

        $data = [
            'detail'             => $detail,
            'list'               => $list,
            'pager'              => $pager,
            'post_category_list' => $post_category_list,
            'post_category_tree' => get_list_tree_selected($post_category_list, $id, 'category_id'),
            'post_latest_list'   => $this->post_model->getListPostLatest(6),
            'post_counter_list'  => $this->post_model->getListCounter(5),
            'news_category_list' => $news_category_model->getListPublished(),
            'news_counter_list'  => $news_model->getListCounter(6),
        ];

        $this->_setMeta($detail);

        $tpl_name = 'category';
        if (!empty($this->is_mobile)) {
            $tpl_name = 'mobile/category';
        }

        theme_load($tpl_name, $data);
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
