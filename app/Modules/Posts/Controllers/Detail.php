<?php namespace App\Modules\Posts\Controllers;

use App\Controllers\MyController;
use App\Modules\Posts\Models\PostModel;
use App\Modules\Posts\Models\CategoryModel;

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

        $this->model = new PostModel();
    }

    public function index($slug, $post_id, $type = null)
    {
        try {
            if (!empty($type) && $type !== 'preview') {
                page_not_found();
            }

            $is_preview = false;
            if (!empty($type) && $type === 'preview') {
                $is_preview = true;
            }

            $post_category_model = new CategoryModel();
            $post_category_list  = $post_category_model->getPostCategories($this->language_id);
            
            if ($is_preview) {
                $detail = $this->model->getPostInfo($post_id, $is_preview, false);
            } else {
                $detail = $this->model->getPostInfo($post_id);
            }

            if (empty($detail)) {
                page_not_found();
            }

            //count detail
            $this->model->updateView($post_id);

            //get the same category
            $post_same_category_list = $this->model->getListTheSameCategory($detail['category_ids'], $detail['post_id'], 6);


            $this->_setMeta($detail);

            $data = [
                'detail'                  => $detail,
                'related_list'            => $this->model->getListByRelatedIds($detail['related_ids'], 5),
                'post_same_category_list' => $post_same_category_list,
                'post_category_tree'      => get_list_tree_selected($post_category_list, $detail['category_ids'], 'category_id'),
                'post_category_list'      => $post_category_list,
                'script_google_search'    => $this->_scriptGoogleSearch($detail, $post_category_list),
                'post_latest_list'        => $this->model->getListPostLatest(6),
                'post_counter_list'       => $this->model->getListCounter(5),
                'post_hot_list'           => $this->model->getListHot(6),
            ];

            $tpl_name = 'detail';
            if (!empty($this->is_mobile)) {
                $tpl_name = 'mobile/detail';
            }

            $this->themes->addCSS('common/plugin/fancybox/fancybox');
            $this->themes->addJS('common/plugin/fancybox/fancybox');

            theme_load($tpl_name, $data);
        } catch (\Exception $ex) {
            log_message('error', $ex->getMessage() . "[ID: $post_id, $slug]");
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
