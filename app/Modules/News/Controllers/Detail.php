<?php namespace App\Modules\News\Controllers;

use App\Controllers\MyController;
use App\Modules\News\Models\NewsModel;
use App\Modules\News\Models\CategoryModel;

class Detail extends MyController
{
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

    public function index($slug, $news_id, $created_at, $type = null)
    {
        $news_model = new NewsModel();

        //try {
            if (!empty($type) && $type !== 'preview') {
                page_not_found();
            }

            $is_preview = false;
            if (!empty($type) && $type === 'preview') {
                $is_preview = true;
            }

            $category_model = new CategoryModel();
            $category_list = $category_model->getNewsCategories($this->language_id);

            if ($is_preview) {
                $detail = $news_model->getNewsInfo($news_id, $created_at, $is_preview, false);
            } else {
                $detail = $news_model->getNewsInfo($news_id, $created_at);
            }

            if (empty($detail)) {
                page_not_found();
            }

            $news_the_same_list = [];
            $data_category_list = $news_model->getListHome();

            if (!empty($data_category_list) && !empty($detail['category_ids'])) {
                foreach ($detail['category_ids'] as $category_id) {
                    if (!empty($data_category_list[$category_id]['list'])) {

                        $news_the_same_list = array_merge($news_the_same_list, $data_category_list[$category_id]['list']);
                    }
                }
            }
            shuffle($news_the_same_list);

            //count detail
            $news_model->updateView($news_id, $created_at);

            $this->_setMeta($detail);

            $data = [
                'detail'               => $detail,
                'related_list'         => $news_model->getListByRelatedIds($detail['related_ids'], 3),
                'news_the_same_list'   => $news_the_same_list,
                'news_category_list'   => $category_list,
                'news_category_tree'   => get_list_tree_selected($category_list, $detail['category_ids'], 'category_id'),
                'slide_list'           => $news_model->getSlideHome(5),
                'new_list'             => $news_model->getListNew(5),
                'counter_list'         => $news_model->getListCounter(6),
                'script_google_search' => $this->_scriptGoogleSearch($detail, $category_list),
            ];

            $tpl_name = 'detail';
            if (!empty($this->is_mobile)) {
                $tpl_name = 'mobile/detail';
            }

            $this->themes->addCSS('common/plugin/fancybox/fancybox');
            $this->themes->addJS('common/plugin/fancybox/fancybox');

            //@todo Chan index tam thoi trang news
            $this->themes->addMeta('robots', 'noindex,nofollow');
            $this->themes->addMeta('googlebot', 'noindex,nofollow,');

            theme_load($tpl_name, $data);
        // } catch (\Exception $ex) {
        //     log_message('error', $ex->getMessage() . "[ID: $news_id, $created_at, $slug]");
        //     page_not_found();
        // }
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
                        'url'  => sprintf('%s/%s',  base_url(), $category_list[$category_id]['slug'])
                    ];
                }
            }
        }

        $script_detail = [
            'name'           => !empty($detail['meta_title']) ? $detail['meta_title'] : $detail['name'],
            'description'    => !empty($detail['meta_description']) ? $detail['meta_description'] : $detail['description'],
            'url'            => base_url($detail['detail_url']),
            'image'          => !empty($detail['images']['thumb']) ? $detail['images']['thumb'] : $detail['images']['robot'],
            'published_time' => date('c', strtotime($detail['publish_date'])),
            'modified_time'  => date('c', strtotime($detail['updated_at'])),
            'author'         => !empty($detail['author']) ? $detail['author'] : "Ryan Lee",
        ];
        $script_google_search = script_google_search($script_detail, $script_breadcrumb);

        return $script_google_search;
    }

    private function _setMeta($detail)
    {
        //META
        $data_meta = [
            'title'          => !empty($detail['meta_title']) ? $detail['meta_title'] : $detail['name'],
            'description'    => !empty($detail['meta_description']) ? $detail['meta_description'] : $detail['description'],
            'keywords'       => !empty($detail['meta_keyword']) ? $detail['meta_keyword'] : null,
            'url'            => base_url($detail['detail_url']),
            'image'          => !empty($detail['images']['thumb']) ? $detail['images']['thumb'] : $detail['images']['robot'],
            'image_fb'       => !empty($detail['images']['fb']) ? $detail['images']['fb'] : $detail['images']['robot_fb'],
            'published_time' => date('c', strtotime($detail['publish_date'])),
            'modified_time'  => date('c', strtotime($detail['updated_at'])),
        ];
        add_meta($data_meta, $this->themes);
    }
}
