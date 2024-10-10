<?php

namespace App\Modules\Articles\Controllers;

use App\Controllers\MyController;
use App\Modules\Articles\Models\CategoryModel;
use App\Modules\Articles\Models\ArticleModel;

class Articles extends MyController
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
        $category_list = $category_model->getArticleCategories($this->language_id);
        foreach ($category_list as $key => $value) {
            $category_list[$key]['href'] = $category_model->getUrl($value);
        }

        $article_model = new ArticleModel();

        if (!empty($category_id)) {
            list($article_list, $page_list) = $article_model->getArticlesByCategoryId($category_id, $this->language_id, $limit);
        } else {
            list($article_list, $page_list) = $article_model->getArticles($this->language_id, $limit);
        }

        foreach ($article_list as $key => $value) {
            $article_list[$key]['image'] = image_thumb_url($value['images'], config_item('article_image_thumb_width'), config_item('article_image_thumb_height'));
            $article_list[$key]['category_ids'] = json_decode($value['category_ids'], true);
            $article_list[$key]['href'] = $article_model->getUrl($value);
        }

        $data = [
            'article_list' => $article_list,
            'page_list' => $page_list,
            'category_list' => $category_list,
            'category_id' => $category_id
        ];

        //breadcrumb
        $this->breadcrumb->add(lang('General.text_home'), base_url());
        $this->breadcrumb->add(lang('Article.heading_title'), site_url('article'));

        //set params khi call cell
        $params['params'] = [
            'breadcrumb' => $this->breadcrumb->render(),
            'breadcrumb_title' => lang('Article.heading_title'),
        ];

        $this->themes->addPartial('header_top', $params)
            ->addPartial('header_bottom', $params)
            ->addPartial('content_left', $params)
            ->addPartial('content_top', $params)
            ->addPartial('content_bottom', $params)
            ->addPartial('content_right', $params)
            ->addPartial('footer_top', $params)
            ->addPartial('footer_bottom', $params);

        add_meta(['title' => lang("Article.text_article_list")], $this->themes);

        theme_load('list', $data);
    }
}
