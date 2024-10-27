<?php

namespace App\Modules\Frontend\Controllers;

use App\Controllers\MyController;

class React extends MyController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        //set theme
        //$this->themes->setTheme(config_item('theme_frontend'));
        $this->themes->setTheme('default_react');
      
        $layout_model = new \App\Modules\Layouts\Models\LayoutModel();
        $layout_list = $layout_model->getLayoutsByPostion(get_module(), 'header_top');

        // cc_debug($layout_list);

        $data = [
            'template' => service("react")->getTemplate(),
        ];


        $this->breadcrumb->add(lang('General.text_home'), base_url());
        $this->breadcrumb->add(lang('Contact.text_title'), base_url('contact'));

        $params['params'] = [
            'breadcrumb' => $this->breadcrumb->render(),
            'breadcrumb_title' => lang('Contact.text_title'),
        ];

         $this->themes;
        //     ->addPartial('header_top', $params)
        //      ->addPartial('header_bottom', $params)
        //      ->addPartial('content_left', $params)
        //      ->addPartial('content_top', $params)
        //      ->addPartial('content_bottom', $params)
        //      ->addPartial('content_right', $params)
        //      ->addPartial('footer_top', $params)
        //      ->addPartial('footer_bottom', $params);

        add_meta(['title' => lang('Contact.text_title')], $this->themes);

        theme_load('react', ['data' => json_encode($data)]);
    }
}
