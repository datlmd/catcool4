<?php namespace App\Modules\Pages\Controllers;

use App\Controllers\BaseController;
use App\Modules\Pages\Models\PageModel;

class Pages extends BaseController
{
    private $mode;

    public function __construct()
    {
        parent::__construct();

        //set theme
        $this->themes->setTheme(config_item('theme_frontend'));

        $this->themes->addPartial('header_top')
            ->addPartial('header_bottom')
            ->addPartial('content_left')
            ->addPartial('content_right')
            ->addPartial('footer_top')
            ->addPartial('footer_bottom');

        $this->mode = new PageModel();
    }

    public function detail($id = null)
    {

        $detail = $this->mode->getPageInfo($id);
        if (empty($detail)) {
            page_not_found();
        }

        //cc_debug($detail);

        $data = [
            'detail' => $detail,
        ];

        $this->breadcrumb->add(lang('General.text_home'), base_url());
        $this->breadcrumb->add($detail['name'], site_url($detail['slug']));
        breadcrumb($this->breadcrumb, $this->themes, $detail['name']);

        $meta = [
            'url'         => site_url($detail['slug']),
            'title'       => $detail['meta_title'] ?? $detail['name'],
            'description' => $detail['meta_description'],
            'keywords'    => $detail['meta_keyword'],
        ];
        add_meta($meta, $this->themes);

        theme_load('detail', $data);
    }
}
