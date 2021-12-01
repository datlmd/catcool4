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
        if (empty($detail)) {
            $this->pageNotFound();
        }

        $news_category_list = [];
        $data_category_list = $this->model->getListHome();
        if (!empty($data_category_list) && !empty($detail['category_ids'])) {
            foreach ($detail['category_ids'] as $category_id) {
                if (isset($data_category_list[$category_id])) {
                    $news_category_list = array_merge($news_category_list, $data_category_list[$category_id]['list']);
                }
            }
        }
        shuffle($news_category_list);

        //count detail
        $this->model->updateView($news_id, $ctime);

        $this->_setMeta($detail);

        $data = [
            'detail'               => $detail,
            'news_category_list'   => $news_category_list,
            'category_list'        => $category_list,
            'hot_list'             => $this->model->getListHot(4),
            'new_list'             => $this->model->getListNew(5),
            'counter_list'         => $this->model->getListCounter(6),
            'script_google_search' => $this->_scriptGoogleSearch($detail, $category_list),
        ];

        theme_load('detail', $data);
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
                        'url'  => sprintf('%s/%s.html',  base_url(), $category_list[$category_id]['slug'])
                    ];
                }
            }
        }
        $detail_url = !empty($detail['detail_url']) ? $detail['detail_url'] : "";
        $script_detail = [
            'name'           => !empty($detail['meta_title']) ? $detail['meta_title'] : $detail['name'],
            'description'    => !empty($detail['meta_description']) ? $detail['meta_description'] : $detail['description'],
            'url'            => base_url($detail_url),
            'image'          => !empty($detail['images']['root']) ? $detail['images']['root'] : $detail['images']['robot'],
            'published_time' => date('c', strtotime($detail['publish_date'])),
            'modified_time'  => date('c', strtotime($detail['mtime'])),
            'author'         => !empty($detail['author']) ? $detail['author'] : "Ryan Lee",
        ];
        $script_google_search = script_google_search($script_detail, $script_breadcrumb);

        return $script_google_search;
    }

    private function _setMeta($detail)
    {
        $detail_url = !empty($detail['detail_url']) ? $detail['detail_url'] : "";
        //META
        $data_meta = [
            'title'          => !empty($detail['meta_title']) ? $detail['meta_title'] : $detail['name'],
            'description'    => !empty($detail['meta_description']) ? $detail['meta_description'] : $detail['description'],
            'keywords'       => !empty($detail['meta_keyword']) ? $detail['meta_keyword'] : null,
            'url'            => base_url($detail_url),
            'image'          => !empty($detail['images']['root']) ? $detail['images']['root'] : $detail['images']['robot'],
            'image_fb'       => !empty($detail['images']['fb']) ? $detail['images']['fb'] : $detail['images']['robot_fb'],
            'published_time' => date('c', strtotime($detail['publish_date'])),
            'modified_time'  => date('c', strtotime($detail['mtime'])),
        ];
        add_meta($data_meta, $this->themes);
    }
}
