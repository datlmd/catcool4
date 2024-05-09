<?php namespace App\Modules\Pages\Controllers;

use App\Controllers\MyController;
use App\Modules\Pages\Models\PageModel;

class Pages extends MyController
{
    private $mode;

    public function __construct()
    {
        parent::__construct();
    }

    public function detail($id = null)
    {
         //set theme
         $this->themes->setTheme(config_item('theme_frontend'));
        
         $this->mode = new PageModel();

        $detail = $this->mode->getPageInfo($id);
        if (empty($detail)) {
            page_not_found();
        }

        $data = [
            'detail' => $detail,
        ];

        //breadcrumb
        $this->breadcrumb->add(lang('General.text_home'), base_url());
        $this->breadcrumb->add($detail['name'], site_url($detail['slug']));

        $data['params'] = [
            'breadcrumb' => $this->breadcrumb->render(),
        ];
        
        $this->themes->addPartial('header_top', $data)
             ->addPartial('header_bottom', $data)
             ->addPartial('content_left', $data)
             ->addPartial('content_top', $data)
             ->addPartial('content_bottom', $data)
             ->addPartial('content_right', $data)
             ->addPartial('footer_top', $data)
             ->addPartial('footer_bottom', $data);

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
