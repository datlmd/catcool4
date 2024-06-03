<?php

namespace App\Modules\Events\Controllers;

use App\Controllers\BaseController;

class Mail extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public static function register($customer_info): void
    {
        $store_name = config_item("store_name");
        $data = [
            'store_name' => $store_name,
            'store_url' => site_url(),
            'login' => site_url('account/login'),
            'approval' => $customer_info['approval'],
        ];

        $email_title = config_item('email_subject_title');
        $subject = lang('Email.text_register_subject', [$store_name]);
        $email_to = $customer_info['email'];
        $email_from = config_item('email_from');
        $message = \App\Libraries\Themes::init()::view('email/register', $data);

        if (!empty($customer_info['email'])) {
            send_email($email_to, $email_from, $subject, $message, $email_title);
        }
    }

    public static function registerAlert($customer_info): void
    {
        if (in_array('account', explode(',', (string)config_item('mail_alert')))) {
            $store_name = config_item("store_name");
            $data = [
                'store_name' => $store_name,
                'store_url' => site_url(),
                'first_name' => $customer_info['first_name'],
                'last_name' => $customer_info['last_name'],
                'email' => $customer_info['email'],
                'phone' => $customer_info['phone'],
                'customer_group' => $customer_info['customer_group'],
            ];
    
            $email_title = config_item('email_subject_title');
            $subject = lang('Email.text_register_new_customer');
            $email_to = config_item('email_from');
            $email_from = config_item('email_from');
            $message = \App\Libraries\Themes::init()::view('email/register_alert', $data);
            
            send_email($email_to, $email_from, $subject, $message, $email_title);

            // Send to additional alert emails if new account email is enabled
            $emails = explode(',', (string)config_item('mail_alert_email'));
            foreach ($emails as $email) {
                if (mb_strlen($email) > 0 && filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    send_email(trim($email), $email_from, $subject, $message, $email_title);
                }
            }
        }
    }
}
