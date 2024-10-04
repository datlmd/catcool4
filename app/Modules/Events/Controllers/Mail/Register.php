<?php

namespace App\Modules\Events\Controllers\Mail;

use Codeigniter\Controller;

class Register extends Controller
{
    public static function index($customer_info): void
    {
        $store_name = config_item('store_name');
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

    public static function alert($customer_info): void
    {
        if (in_array('account', explode(',', (string) config_item('mail_alert')))) {
            $store_name = config_item('store_name');
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
            $email_from = config_item('email_from');
            $message = \App\Libraries\Themes::init()::view('email/register_alert', $data);

            // Send to additional alert emails if new account email is enabled
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

            $email_tos[] = config_item('email_from');
            if (!empty(config_item('mail_alert_email'))) {
                $email_tos = array_merge($email_tos, explode(',', (string) config_item('mail_alert_email')));
            }

            foreach ($email_tos as $email_to) {
                if (mb_strlen($email_to) > 0 && filter_var($email_to, FILTER_VALIDATE_EMAIL)) {
                    $mail->clear();
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
    }
}
