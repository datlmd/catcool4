<?php

namespace App\Modules\Posts\Controllers;

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
            $post_category_list  = $post_category_model->getPostCategories();

            if ($is_preview) {
                $detail = $this->model->getPostInfo($post_id, $is_preview, false);
            } else {
                $detail = $this->model->getPostInfo($post_id);
            }

            if (empty($detail)) {
                page_not_found();
            }

            //Tao muc luc table_of_contents
            list($detail['table_of_contents'], $detail['content']) = auto_table_of_contents($detail['content']);

            //count detail
            $this->model->updateView($post_id);

            //get the same category
            $post_same_category_list = $this->model->getListTheSameCategory($detail['category_ids'], $detail['post_id'], 6);

            $post_category_tree = get_list_tree_selected($post_category_list, $detail['category_ids'], 'category_id');

            //neu post format la huong dan thi load layout learning
            $lesson_categories = [];
            if ($detail['post_format'] && $detail['post_format'] == $this->model::POST_FORMAT_LESSON) {
                $lesson_parent_id = array_key_first($post_category_tree);
                $lesson_categories = format_tree(['data' => $post_category_list, 'key_id' => 'category_id']);
                $learning_list = $this->model->getLessons($lesson_parent_id);

                if (!empty($learning_list) && !empty($lesson_categories[$lesson_parent_id])) {
                    $lesson_categories[$lesson_parent_id]['lessons'] = $learning_list[$lesson_parent_id] ?? [];
                    if (!empty($lesson_categories[$lesson_parent_id]['subs'])) {
                        foreach ($lesson_categories[$lesson_parent_id]['subs'] as $value) {
                            if (empty($learning_list[$value['category_id']])) {
                                continue;
                            }
                            $lesson_categories[$lesson_parent_id]['subs'][$value['category_id']]['lessons'] = $learning_list[$value['category_id']];
                        }
                    }
                }
                $lesson_categories = $lesson_categories[$lesson_parent_id];
            } 

            $this->_setMeta($detail);

            $data = [
                'detail'                  => $detail,
                'related_list'            => $this->model->getListByRelatedIds($detail['related_ids'], 5),
                'post_same_category_list' => $post_same_category_list,
                'post_category_tree'      => $post_category_tree,
                'post_category_list'      => $post_category_list,
                'script_google_search'    => $this->_scriptGoogleSearch($detail, $post_category_list),
                'post_latest_list'        => $this->model->getListPostLatest(6),
                'post_counter_list'       => $this->model->getListCounter(5),
                'post_hot_list'           => $this->model->getListHot(6),
                'lesson_categories'       => $lesson_categories,
            ];

            $this->themes->addCSS('common/plugin/fancybox/fancybox');
            $this->themes->addJS('common/plugin/fancybox/fancybox');

            $this->themes->addCSS('common/js/prismjs/prism');
            $this->themes->addJS('common/js/prismjs/prism');

            $tpl_name = 'detail';
            if (!empty($this->is_mobile)) {
                $tpl_name = 'mobile/detail';
            }

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
        $detail['title']          = !empty($detail['meta_title']) ? $detail['meta_title'] : $detail['name'];
        $detail['description']    = !empty($detail['meta_description']) ? $detail['meta_description'] : $detail['description'];
        $detail['keywords']       = !empty($detail['meta_keyword']) ? $detail['meta_keyword'] : null;
        $detail['url']            = base_url($detail['detail_url']);
        $detail['image']          = !empty($detail['images']['thumb']) ? $detail['images']['thumb'] : $detail['images']['robot'];
        $detail['image_fb']       = !empty($detail['images']['fb']) ? $detail['images']['fb'] : $detail['images']['robot_fb'];
        $detail['published_time'] = date('c', strtotime($detail['publish_date']));
        $detail['modified_time']  = date('c', strtotime($detail['updated_at']));

        add_meta($detail, $this->themes);
    }
}
