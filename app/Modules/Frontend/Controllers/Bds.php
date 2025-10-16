<?php

namespace App\Modules\Frontend\Controllers;

use App\Controllers\MyController;
use App\Modules\Pages\Models\PageModel;

class Bds extends MyController
{
    public function __construct()
    {
        parent::__construct();

        //set theme
        $this->themes->setTheme(config_item('theme_frontend'));
    }

    public function index()
    {
        $data = [];

        $this->breadcrumb->add(lang('General.text_home'), base_url());

        $page_model = new PageModel();
        $pages = $page_model->getPages($this->language_id);

        foreach ($pages as $page) {
            if (in_array($page['layout'], ['vitri', 'tienich', 'matbang', 'phaply'])) {
                $data[$page['layout']] = $page;
            }
        }

        $params['params'] = [
            // 'breadcrumb' => $this->breadcrumb->render(),
            // 'breadcrumb_title' => lang('General.text_home'),
        ];

        $data['tienich_images'] = [
            img_url('cangio/tienich/tien-ich-vinhomes-green-paradise-can-gio-14-1.jpg'),
            img_url('cangio/tienich/vinhomes-green-paradise-can-gio-36-2.jpg'),
            img_url('cangio/tienich/vinhomes-green-paradise-can-gio-43-3.jpg'),
            img_url('cangio/tienich/vinhomes-green-paradise-can-gio-4.jpg'),
            img_url('cangio/tienich/vinhomes-green-paradise-can-gio-5.jpg'),
            img_url('cangio/tienich/vinhomes-green-paradise-can-gio-6.jpg'),
            img_url('cangio/tienich/vinhomes-green-paradise-can-gio-7.jpg'),
            img_url('cangio/tienich/vinhomes-green-paradise-can-gio-8.jpg'),
            img_url('cangio/tienich/vinhomes-green-paradise-can-gio-9.jpg'),
            img_url('cangio/tienich/vinhomes-green-paradise-can-gio-10.jpg'),
            img_url('cangio/tienich/vinhomes-green-paradise-can-gio-11.jpg'),
            img_url('cangio/tienich/vinhomes-green-paradise-can-gio-12.jpg'),
            img_url('cangio/tienich/vinhomes-green-paradise-can-gio-13.jpg'),
            img_url('cangio/tienich/vinhomes-green-paradise-can-gio-14.jpg'),
            img_url('cangio/tienich/vinhomes-green-paradise-can-gio-15.webp'),
            img_url('cangio/tienich/vinhomes-green-paradise-can-gio-16.jpg'),
            img_url('cangio/tienich/vinhomes-green-paradise-can-gio-17.jpg'),
            img_url('cangio/tienich/vinhomes-green-paradise-can-gio-18.jpg'),
            img_url('cangio/tienich/vinhomes-green-paradise-can-gio-19.jpg'),
            img_url('cangio/tienich/vinhomes-green-paradise-can-gio-20.jpg'),
        ];

        $data['matbang_images'] = [
            img_url('cangio/matbang/vinhomes-green-paradise-can-gio-matbang-1.jpg'),
            img_url('cangio/matbang/vinhomes-green-paradise-can-gio-matbang-2.jpg'),
            img_url('cangio/matbang/vinhomes-green-paradise-can-gio-matbang-3.jpg'),
            img_url('cangio/matbang/vinhomes-green-paradise-can-gio-matbang-4.jpg'),
            img_url('cangio/matbang/vinhomes-green-paradise-can-gio-matbang-5.jpg'),
            img_url('cangio/matbang/vinhomes-green-paradise-can-gio-matbang-6.jpg'),
        ];

        $this->themes->addPartial('header_top', $params)
             //->addPartial('header_bottom', $params)
             ->addPartial('content_left', $params)
             ->addPartial('content_top', $params)
             ->addPartial('content_bottom', $params)
             ->addPartial('content_right', $params)
             ->addPartial('footer_top', $params)
             ->addPartial('footer_bottom', $params);

        add_meta(['title' => lang('FrontendBd.heading_title')], $this->themes);

        theme_load('index', $data);
    }

    public function send(): void
    {
        $this->validator->setRule('name', lang('Contact.text_name'), 'required|min_length[3]|max_length[40]');
        $this->validator->setRule('email', lang('Contact.text_email'), 'permit_empty|valid_email');
        $this->validator->setRule('phone', lang('Contact.text_phone'), 'required|min_length[10]');

        if (!$this->validator->withRequest($this->request)->run()) {
            $errors = $this->validator->getErrors();

            json_output([
                'error' => $errors,
                'alert' => print_alert($errors, 'danger'),
            ]);
        }

        $email_to = config_item('email_from');
        $email_from = config_item('email_from'); //$this->request->getPost('email');
        $message = $this->request->getPost('message');
        $subject = lang('FrontendBd.text_email_subject', [$this->request->getPost('name')]);
        $subject_title = config_item('email_subject_title');

        $data_email = [
            'name' => $this->request->getPost('name'),
            'phone' => $this->request->getPost('phone'),
            'email' => $this->request->getPost('email'),
            'message' => $this->request->getPost('message'),
        ];
        $content = $this->themes::view('email/contact', $data_email);

        $send_email = send_email($email_to, $email_from, $subject, $content, $subject_title);
        if (!$send_email) {
            $unsuccess = lang('Email.error_sent_unsuccessful');
            json_output([
                'error' => $unsuccess,
                'alert' => print_alert($unsuccess, 'danger'),
            ]);
        }
        $email_tos = [];
        if (!empty(config_item('mail_alert_email'))) {
            $email_tos = array_merge($email_tos, explode(',', (string) config_item('mail_alert_email')));

            foreach ($email_tos as $email_to) {
                if (mb_strlen($email_to) > 0 && filter_var($email_to, FILTER_VALIDATE_EMAIL)) {
                    $send_email = send_email($email_to, $email_from, $subject, $content, $subject_title);
                    if (!$send_email) {
                        $unsuccess = lang('Email.error_sent_unsuccessful');
                        json_output([
                            'error' => $unsuccess,
                            'alert' => print_alert($unsuccess, 'danger'),
                        ]);
                    }
                }
            }
        }

        $success = lang('FrontendBd.text_email_success');

        json_output([
            'success' => $success,
            'alert' => print_alert($success),
            'message' => '',
        ]);
    }
}
