<?php

namespace App\Modules\Articles\Controllers;

use App\Controllers\MyController;
use App\Modules\Articles\Models\ArticleModel;
use App\Modules\Articles\Models\CategoryModel;

class Detail extends MyController
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

        $this->model = new ArticleModel();
    }

    public function index($slug = null, $article_id = null)
    {
        try {
            $article_model = new ArticleModel();

            if (is_null($slug) && is_null($article_id)) {
                page_not_found();
            }

            if (is_numeric($slug) && empty($article_id)) {
                $article_id = (int) $slug;
            }
           
            if (empty($article_id)) {
                page_not_found();
            }

            $article_info = $article_model->getArticleInfo($article_id, $this->language_id);
            if (empty($article_info)) {
                page_not_found();
            }

            $article_info['image'] = image_thumb_url($article_info['images'], config_item('article_image_thumb_width'), config_item('article_image_thumb_height'));
            $article_info['image_fb'] = image_thumb_url($article_info['images'], RESIZE_IMAGE_FB_WIDTH, RESIZE_IMAGE_FB_HEIGHT);
            $article_info['category_ids'] = json_decode($article_info['category_ids'], true);
            $article_info['href'] = $article_model->getUrl($article_info);

            //Tao muc luc table_of_contents
            if (!empty($article_info['is_toc'])) {
                list($article_info['table_of_contents'], $article_info['content']) = auto_table_of_contents($article_info['content']);
            }
           
            //get cate
            $article_category_model = new CategoryModel();
            $article_category_list  = $article_category_model->getArticleCategories($this->language_id);
            foreach ($article_category_list as $key => $value) {
                $article_category_list[$key]['href'] = $article_category_model->getUrl($value);
            }

            $data = [
                'article_info'          => $article_info,
                'article_category_list' => $article_category_list,
                'script_google_search'  => $this->_scriptGoogleSearch($article_info, $article_category_list),
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

            $this->_setMeta($article_info);

            $this->themes->addCSS('common/plugin/fancybox/fancybox');
            $this->themes->addJS('common/plugin/fancybox/fancybox');

            theme_load('detail', $data);

        } catch (\Exception $ex) {
            log_message('error', $ex->getMessage() . "[Article ID: $article_id, $slug]");
            page_not_found();
        }
    }

    private function _scriptGoogleSearch($detail, $category_list)
    {
        //GOOGLE BREADCRUMB STRUCTURED DATA
        $script_breadcrumb  = [];
        if (!empty($category_list) && !empty($detail['category_ids'])) {
            foreach ($detail['category_ids'] as $category_id) {
                if (isset($category_list[$category_id])) {
                    $script_breadcrumb[] = [
                        'name' => $category_list[$category_id]['name'],
                        'url'  => $category_list[$category_id]['href'],
                    ];
                }
            }
        }

        $script_detail = [
            'name'           => !empty($detail['meta_title']) ? $detail['meta_title'] : $detail['name'],
            'description'    => !empty($detail['meta_description']) ? $detail['meta_description'] : $detail['description'],
            'url'            => $detail['href'],
            'image'          => $detail['images'],//google lay hinh root
            'published_time' => date('c', strtotime($detail['publish_date'])),
            'modified_time'  => date('c', strtotime($detail['updated_at'])),
            'author'         => !empty($detail['author']) ? $detail['author'] : config_item('store_name'),
        ];
        $script_google_search = script_google_search($script_detail, $script_breadcrumb);

        return $script_google_search;
    }

    private function _setMeta($detail)
    {
        //META
        $detail['title']          = !empty($detail['meta_title']) ? $detail['meta_title'] : $detail['name'];
        $detail['description']    = !empty($detail['meta_description']) ? $detail['meta_description'] : $detail['description'];
        $detail['keywords']       = !empty($detail['meta_keyword']) ? $detail['meta_keyword'] : "";
        $detail['url']            = $detail['href'];
        $detail['image']          = $detail['image'];
        $detail['image_fb']       = $detail['image_fb'];
        $detail['published_time'] = date('c', strtotime($detail['publish_date']));
        $detail['modified_time']  = date('c', strtotime($detail['updated_at']));

        add_meta($detail, $this->themes);
    }
}
