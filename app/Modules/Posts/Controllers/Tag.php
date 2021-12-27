<?php namespace App\Modules\Posts\Controllers;

use App\Controllers\MyController;
use App\Modules\Posts\Models\CategoryModel;
use App\Modules\Posts\Models\PostModel;

class Tag extends MyController
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
        $this->category_model = new CategoryModel();
    }

    public function index($tag = null)
    {
        $post_category_list = $this->category_model->getListPublished();

        $tag = str_ireplace('-', ' ', $tag);

        list($list, $pager) = $this->model->getListByTag($tag);

        $news_model = new \App\Modules\News\Models\NewsModel();
        $news_category_model = new \App\Modules\News\Models\CategoryModel();

        $data = [
            'tag'                => $tag,
            'list'               => $list,
            'pager'              => $pager,
            'post_category_list' => $post_category_list,
            'news_category_list' => $news_category_model->getListPublished(),
            'slide_list'         => $news_model->getSlideHome(5),
            'new_list'           => $news_model->getListNew(5),
            'counter_list'       => $news_model->getListCounter(6),
        ];

        add_meta(['title' => $tag, 'url' => current_url()], $this->themes);

        $tpl_name = 'tag';
        if (!empty($this->is_mobile)) {
            $tpl_name = 'mobile/tag';
        }

        theme_load($tpl_name, $data);
    }

}
