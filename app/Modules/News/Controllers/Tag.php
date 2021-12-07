<?php namespace App\Modules\News\Controllers;

use App\Controllers\MyController;
use App\Modules\News\Models\NewsModel;
use App\Modules\News\Models\CategoryModel;

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

        $this->model = new NewsModel();
        $this->category_model = new CategoryModel();
    }

    public function index($tag = null)
    {
        $category_list = $this->category_model->getListPublished();

        $tag = str_ireplace('-', ' ', $tag);

        list($list, $pager) = $this->model->getListByTag($tag);

        $data = [
            'tag'           => $tag,
            'list'          => $list,
            'pager'         => $pager,
            'hot_list'      => $this->model->getListHot(4),
            'new_list'      => $this->model->getListNew(5),
            'counter_list'  => $this->model->getListCounter(6),
            'category_list' => $category_list
        ];

        add_meta(['title' => $tag, 'url' => current_url()], $this->themes);

        theme_load('tag', $data);
    }

}
