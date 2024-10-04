<?php

namespace App\Modules\Events\Controllers\Mail;

use Codeigniter\Controller;

class Forgotten extends Controller
{
    public static function index($customer_info): void
    {
        $store_name = config_item('store_name');
        $data = [
            'store_name' => html_entity_decode($store_name, ENT_QUOTES, 'UTF-8'),
            'store_url' => site_url(),
            'reset' => site_url('account/forgotten/reset/' . $customer_info['user_code']),
            'ip' => service('request')->getIPAddress(),
        ];

        $email_title = config_item('email_subject_title');
        $subject = lang('Email.text_forgotten_subject', [$store_name]);
        $email_to = $customer_info['email'];
        $email_from = config_item('email_from');
        $message = \App\Libraries\Themes::init()::view('email/forgotten', $data);

        if (!empty($customer_info['email'])) {
            $config_mail = [
                'userAgent' => config_item('email_user_agent'),
                'protocol' => config_item('email_engine'),
                'SMTPTimeout' => config_item('email_smtp_timeout'),
                'newline' => "\r\n",
                'mailType' => 'html',
                'validate' => true,
                'SMTPHost' => config_item('email_host'),
                'SMTPPort' => config_item('email_port'),
                'SMTPCrypto' => config_item('email_smtp_crypto') ?? 'tls',
                'SMTPUser' => config_item('email_smtp_user'),
                'SMTPPass' => config_item('email_smtp_pass'),
            ];

            $mail = \Config\Services::email();
            $mail->initialize($config_mail);

            $mail->setFrom($email_from, $email_title);
            $mail->setTo($email_to);
            $mail->setSubject($subject);
            $mail->setMessage($message);

            if (!$mail->send()) {
                if (ENVIRONMENT == 'development') {
                    die($mail->printDebugger());
                }

                log_message('error', $mail->printDebugger(['subject']));
            }
        }
    }
}
