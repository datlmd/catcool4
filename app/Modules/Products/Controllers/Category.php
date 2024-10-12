<?php

namespace App\Modules\Products\Controllers;

use App\Controllers\MyController;
use App\Modules\Products\Models\CategoryModel;
use App\Modules\Products\Models\ProductModel;

class Category extends MyController
{
    public $config_form = [];

    public function index($slug = null, $category_id = null)
    {
        //set theme
        $this->themes->setTheme(config_item('theme_frontend'));

        $limit = PAGINATION_DEFAULF_LIMIT;

        if (is_numeric($slug) && empty($category_id)) {
            $category_id = (int) $slug;
        }

        $category_model = new CategoryModel();
        $category_list = $category_model->getProductCategories($this->language_id);
        if (empty($category_list[$category_id])) {
            page_not_found();
        }

        foreach ($category_list as $key => $value) {
            unset($category_list[$key]['lang']);
            $category_list[$key]['href'] = $category_model->getUrl($value);
            $category_list[$key]['thumb'] = image_thumb_url($value['image'], config_item('product_category_image_thumb_width'), config_item('product_category_image_thumb_height'));
        }

        $parent_list = get_list_tree_selected($category_list, $category_id, 'category_id');
        $parent_id = key($parent_list);
        if (empty($category_list[$parent_id])) {
            page_not_found();
        }
        
        $category_tree = format_tree([$category_list, 'category_id']);        
        $category_list = $category_model->getChildrenQuantity($category_list, $category_tree);

        // $product_model = new ProductModel();

        // if (!empty($category_id)) {
        //     list($article_list, $page_list) = $product_model->getArticlesByCategoryId($category_id, $this->language_id, $limit);
        // } else {
        //     list($article_list, $page_list) = $product_model->getArticles($this->language_id, $limit);
        // }

        // foreach ($article_list as $key => $value) {
        //     $article_list[$key]['image'] = image_thumb_url($value['images'], config_item('article_image_thumb_width'), config_item('article_image_thumb_height'));
        //     $article_list[$key]['category_ids'] = json_decode($value['category_ids'], true);
        //     $article_list[$key]['href'] = $product_model->getUrl($value);
        // }

        $data = [
            // 'article_list' => $article_list,
            // 'page_list' => $page_list,
            'category_list' => $category_list,
            'category' => $category_list[$parent_id],
            'category_id' => $category_id
        ];

        //breadcrumb
        $this->breadcrumb->add(lang('General.text_home'), base_url());
        $this->_addBreadcrumb($parent_list[$parent_id]);

        //set params khi call cell
        $params['params'] = [
            'breadcrumb' => $this->breadcrumb->render(),
            'breadcrumb_title' => $category_list[$category_id]['name'],
        ];

        $this->themes->addPartial('header_top', $params)
            ->addPartial('header_bottom', $params)
            ->addPartial('content_left', $params)
            ->addPartial('content_top', $params)
            ->addPartial('content_bottom', $params)
            ->addPartial('content_right', $params)
            ->addPartial('footer_top', $params)
            ->addPartial('footer_bottom', $params);

        $this->_setMeta($category_list[$category_id]);

        theme_load('category', $data);
    }

    private function _setMeta($detail)
    {
        //META
        $data_meta = [
            'title'       => !empty($detail['meta_title']) ? $detail['meta_title'] : $detail['name'],
            'description' => !empty($detail['meta_description']) ? $detail['meta_description'] : $detail['description'],
            'keywords'    => !empty($detail['meta_keyword']) ? $detail['meta_keyword'] : "",
            'url'         => $detail['href'],
        ];

        add_meta($data_meta, $this->themes);
    }

    private function _addBreadcrumb($data)
    {
        $this->breadcrumb->add($data['name'], $data['href']);
        if (!empty($data['subs'])) {
            foreach ($data['subs'] as $value) {
                $this->_addBreadcrumb($value);
            }
        }
    }
}
