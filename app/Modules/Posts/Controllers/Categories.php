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
    }

    public function detail($id = null)
    {
        $category_model = new CategoryModel();
        $post_model = new PostModel();

        $post_category_list = $category_model->getPostCategories();

        $detail = $post_category_list[$id] ?? null;
        if (empty($detail)) {
            $this->pageNotFound();
        }

        list($list, $pager) = $post_model->getListByCategory($id);

        $data = [
            'detail'             => $detail,
            'list'               => $list,
            'pager'              => $pager,
            'post_category_list' => $post_category_list,
            'post_category_tree' => get_list_tree_selected($post_category_list, $id, 'category_id'),
            'post_latest_list'   => $post_model->getListPostLatest(6),
            'post_hot_list'      => $post_model->getListHot(6),
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
