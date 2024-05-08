<?php namespace App\Modules\Customers\Controllers;

use App\Controllers\MyController;

class Register extends MyController
{
    public $config_form = [];

    public function __construct()
    {
        parent::__construct();

    }

    public function index()
    {
        if (service('customer')->isLogged()) {
            return redirect()->to(site_url('account/profile') . '?customer_token=' . session('customer_token'));
        }

        //set theme
        $this->themes->setTheme(config_item('theme_frontend'));

        $this->themes->addPartial('header_top')
            ->addPartial('header_bottom')
            ->addPartial('content_left')
            ->addPartial('content_top')
            ->addPartial('content_bottom')
            ->addPartial('content_right')
            ->addPartial('footer_top')
            ->addPartial('footer_bottom');

        session()->set('register_token', substr(bin2hex(openssl_random_pseudo_bytes(26)), 0, 26));

        $data = [
            'register' => site_url('account/register') . "?register_token=" . session('register_token'),
        ];

        $this->breadcrumb->add(lang('General.text_home'), base_url());
        $this->breadcrumb->add(lang('Customer.title_register'), base_url('account/login'));
        breadcrumb($this->breadcrumb, $this->themes, lang("Customer.title_register"));

        add_meta(['title' => lang("Customer.text_register")], $this->themes);

        theme_load('register', $data);
    }

    public function register()
    {
        if (empty($this->request->getGet('register_token')) || empty(session('register_token')) || (session('register_token') != $this->request->getGet('register_token'))) {
            json_output([
                'redirect' => site_url('account/register')
            ]);
		}

        $this->validator->setRule('first_name', lang('Customer.text_first_name'), 'required|min_length[3]|max_length[40]');
        $this->validator->setRule('last_name', lang('Customer.text_last_name'), 'required|min_length[3]|max_length[40]');
        $this->validator->setRule('email', lang('Customer.text_email'), 'required|valid_email|is_unique[customer.email]');
        
        $this->validator->setRule('password', lang('Customer.text_password'), 'required|min_length[' . config_item('min_password_length') . ']');
        $this->validator->setRule('agree', lang('Customer.text_policy'), 'required');
        $this->validator->setRule('gender', lang('Customer.text_gender'), 'required');
        $this->validator->setRule('dob_day', lang('Customer.text_day'), 'required|is_natural_no_zero');
        $this->validator->setRule('dob_month', lang('Customer.text_month'), 'required|is_natural_no_zero');
        $this->validator->setRule('dob_year', lang('Customer.text_year'), 'required|is_natural_no_zero');

        if (!empty($this->request->getPost('phone'))) {
            $this->validator->setRule('phone', lang('Customer.text_phone'), 'required|min_length[3]|max_length[32]|is_unique[customer.phone]');
        }

        if (!$this->validator->withRequest($this->request)->run()) {
            $errors = $this->validator->getErrors();

            json_output([
                'error' => $errors,
                'alert' => print_alert($errors, 'danger')
            ]);
        }

        $customer_model = new \App\Modules\Customers\Models\CustomerModel();

        $add_data        = $this->request->getPost();
        $add_data['ip']  = $this->request->getIPAddress();
        $add_data['dob'] = sprintf("%s/%s/%s", $this->request->getPost('dob_day'), $this->request->getPost('dob_month'), $this->request->getPost('dob_year'));
        $add_data['password'] = html_entity_decode($this->request->getPost('password'), ENT_QUOTES, 'UTF-8');
        $add_data['newsletter'] = !empty($this->request->getPost('newsletter')) ? STATUS_ON : STATUS_OFF;

        $customer_info = $customer_model->addCustomer($add_data);
        if (empty($customer_info)) {
            $errors = $customer_model->getErrors() ?? lang('Customer.error_register');
            json_output([
                'error' => $errors,
                'alert' => print_alert($errors, 'danger')
            ]);
        }

        $email_activation = config_item('email_activation');
        if (!empty($email_activation)) {

            $deactivate = $customer_model->deactivate($customer_info['customer_id']);
            
            if (empty($deactivate)) {
                $errors = $customer_model->getErrors() ?? lang('Customer.deactivate_unsuccessful');
                json_output([
                    'error' => $errors,
                    'alert' => print_alert($errors, 'danger')
                ]);
            }

            $activation_code = $customer_model->activation_code;

            $data = [
                'full_name'  => full_name($customer_info['first_name'], $customer_info['last_name']),
                'id'         => $customer_info['customer_id'],
                'email'      => $customer_info['email'],
                'activation' => $activation_code,
            ];

            $message       = $this->themes::view('email/activate', $data);
            $subject_title = config_item('email_subject_title');
            $subject       = lang('Email.activation_subject');

            $send_email = send_email($customer_info['email'], config_item('email_from'), $subject, $message, $subject_title);
            if (!$send_email) {
                $errors = $customer_model->getErrors() ?? lang('Customer.activation_email_unsuccessful');
                json_output([
                    'error' => $errors,
                    'alert' => print_alert($errors, 'danger')
                ]);
            }

            $success = lang('Customer.activation_email_successful');
        }

        session()->remove([
            'guest',
            'register_token',
            'shipping_method',
            'shipping_methods',
            'payment_method',
            'payment_methods',
        ]);

        if (!empty($success)) {
            json_output([
                'success' => $success,
                'alert' => print_alert($success),
            ]);
        }

        $success = lang('Customer.account_creation_successful');
        set_alert($success, ALERT_SUCCESS);

        json_output([
            'success' => $success,
            'alert' => print_alert($success),
            'redirect' => site_url('account/profile') . '?customer_token=' . session('customer_token')
        ]);
    }
}
