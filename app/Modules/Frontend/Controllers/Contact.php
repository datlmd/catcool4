<?php namespace App\Modules\Frontend\Controllers;

use App\Controllers\MyController;

class Contact extends MyController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        //set theme
        $this->themes->setTheme(config_item('theme_frontend'));

        if (!empty(config_item('store_location'))) {
            $store_location = explode(',', config_item('store_location'));

            $location_model = new \App\Modules\Locations\Models\LocationModel();
            $location_list = $location_model->getLocations();

            foreach ($location_list as $location_key => $location) {
                if (!in_array($location['location_id'], $store_location)) {
                    unset($location_list[$location_key]);
                }
            }

        }

        $data = [
            'location_list' => $location_list,
        ];


        $this->themes->addPartial('header_top')
            ->addPartial('header_bottom')
            ->addPartial('content_left')
            ->addPartial('content_right')
            ->addPartial('footer_top')
            ->addPartial('footer_bottom');

        $this->breadcrumb->add(lang('General.text_home'), base_url());
        $this->breadcrumb->add(lang('Contact.text_title'), base_url('contact'));
        breadcrumb($this->breadcrumb, $this->themes, lang('Contact.text_title'));

        add_meta(['title' => lang("Contact.text_title")], $this->themes);

        theme_load('contact', $data);
    }

    public function send(): void
    {
        $this->validator->setRule('name', lang('Contact.text_name'), 'required|min_length[3]|max_length[40]');
        $this->validator->setRule('email', lang('Contact.text_email'), 'required|valid_emails');
        $this->validator->setRule('message', lang('Contact.text_message'), 'required|min_length[10]|max_length[3000]');

        if (!$this->validator->withRequest($this->request)->run()) {

            $errors = $this->validator->getErrors();

            json_output([
                'error' => $errors,
                'alert' => print_alert($errors, 'danger')
            ]);
        }

        $email_to      = config_item('email_from');
        $email_from    = $this->request->getPost('email');
        $message       = $this->request->getPost('message');
        $subject       = lang('Contact.email_subject', [$this->request->getPost('name')]);
        $subject_title = config_item('email_subject_title');

        $send_email = send_email($email_to, $email_from, $subject, $message, $subject_title);
        if (!$send_email) {
            $unsuccess = lang('Email.error_sent_unsuccessful');
            json_output([
                'error' => $unsuccess,
                'alert' => print_alert($unsuccess, 'danger')
            ]);
        }

        $success = lang('Contact.text_success');

        json_output([
            'success' => $success,
            'alert' => print_alert($success),
            'message' => ""
        ]);
    }
}
