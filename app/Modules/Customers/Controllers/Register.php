<?php

namespace App\Modules\Customers\Controllers;

use App\Controllers\MyController;

class Register extends MyController
{
    public function __construct()
    {
        parent::__construct();

        //set theme
        $this->themes->setTheme(config_item('theme_frontend'));
    }

    public function index()
    {
        if (service('customer')->isLogged()) {
            return redirect()->to(site_url('account/profile').'?customer_token='.session('customer_token'));
        }

        session()->set('register_token', substr(bin2hex(openssl_random_pseudo_bytes(26)), 0, 26));

        $data['customer_group_list'] = [];
        if (!empty(config_item('customer_group_display'))) {
            $customer_group_display = explode(',', config_item('customer_group_display'));

            $customer_group_model = new \App\Modules\Customers\Models\GroupModel();
            $customer_group_list = $customer_group_model->getCustomerGroups($this->language_id);

            foreach ($customer_group_list as $customer_group) {
                if (in_array($customer_group['customer_group_id'], $customer_group_display)) {
                    $data['customer_group_list'][] = $customer_group;
                }
            }
        }

        $data['customer_group_id'] = config_item('customer_group_id');
        $data['register'] = site_url('account/register').'?register_token='.session('register_token');

        if (!empty(config_item('account_terms'))) {
            $page_model = new \App\Modules\Pages\Models\PageModel();
            $page_info = $page_model->getPageInfo(config_item('account_terms'), $this->language_id);
            if ($page_info) {
                $page_info['link'] = site_url('information/'.$page_info['page_id']);
            }
            $data['page_info'] = $page_info;
        }

        //breadcrumb
        $this->breadcrumb->add(lang('General.text_home'), base_url());
        $this->breadcrumb->add(lang('Customer.title_register'), base_url('account/register'));

        //set params khi call cell
        $params['params'] = [
            'breadcrumb' => $this->breadcrumb->render(),
            'breadcrumb_title' => lang('Customer.title_register'),
        ];

        $this->themes->addPartial('header_top', $params)
             ->addPartial('header_bottom', $params)
             ->addPartial('content_left', $params)
             ->addPartial('content_top', $params)
             ->addPartial('content_bottom', $params)
             ->addPartial('content_right', $params)
             ->addPartial('footer_top', $params)
             ->addPartial('footer_bottom', $params);

        add_meta(['title' => lang('Customer.text_register')], $this->themes);

        theme_load('register', $data);
    }

    public function register()
    {
        if (empty($this->request->getGet('register_token')) || empty(session('register_token')) || (session('register_token') != $this->request->getGet('register_token'))) {
            set_alert(lang('Customer.error_token'), ALERT_ERROR);
            json_output([
                'redirect' => site_url('account/register'),
            ]);
        }

        $this->validator->setRule('first_name', lang('Customer.text_first_name'), 'required|min_length[2]|max_length[40]');
        $this->validator->setRule('last_name', lang('Customer.text_last_name'), 'required|min_length[2]|max_length[40]');
        $this->validator->setRule('email', lang('Customer.text_email'), 'required|valid_email|is_unique[customer.email]');

        $this->validator->setRule('password', lang('Customer.text_password'), 'required|min_length['.config_item('min_password_length').']|max_length[40]');
        $this->validator->setRule('agree', lang('Customer.text_policy'), 'required');
        $this->validator->setRule('gender', lang('Customer.text_gender'), 'required');
        $this->validator->setRule('dob_day', lang('Customer.text_day'), 'required|is_natural_no_zero');
        $this->validator->setRule('dob_month', lang('Customer.text_month'), 'required|is_natural_no_zero');
        $this->validator->setRule('dob_year', lang('Customer.text_year'), 'required|is_natural_no_zero');

        if (!empty($this->request->getPost('phone'))) {
            $this->validator->setRule('phone', lang('Customer.text_phone'), 'required|min_length[3]|max_length[32]|is_unique[customer.phone]');
        }

        $customer_group_model = new \App\Modules\Customers\Models\GroupModel();
        $customer_group_list = $customer_group_model->getCustomerGroups($this->language_id);

        if (!empty($this->request->getPost('customer_group_id'))) {
            $customer_group_ids = [];
            $customer_group_display = explode(',', config_item('customer_group_display'));

            foreach ($customer_group_list as $customer_group) {
                if (in_array($customer_group['customer_group_id'], $customer_group_display)) {
                    $customer_group_ids[] = $customer_group['customer_group_id'];
                }
            }

            $this->validator->setRule('customer_group_id', lang('Customer.text_customer_group'), 'required|in_list['.implode(',', $customer_group_ids).']');
        }

        if (!$this->validator->withRequest($this->request)->run()) {
            $errors = $this->validator->getErrors();

            json_output([
                'error' => $errors,
                'alert' => print_alert($errors, 'danger'),
            ]);
        }

        $customer_model = new \App\Modules\Customers\Models\CustomerModel();

        $add_data = $this->request->getPost();
        $add_data['ip'] = $this->request->getIPAddress();
        $add_data['dob'] = sprintf('%s/%s/%s', $this->request->getPost('dob_day'), $this->request->getPost('dob_month'), $this->request->getPost('dob_year'));
        $add_data['password'] = html_entity_decode($this->request->getPost('password'), ENT_QUOTES, 'UTF-8');
        $add_data['newsletter'] = !empty($this->request->getPost('newsletter')) ? STATUS_ON : STATUS_OFF;
        $add_data['customer_group_id'] = $this->request->getPost('customer_group_id');

        $customer_info = $customer_model->addCustomer($add_data);
        if (empty($customer_info)) {
            $errors = $customer_model->getErrors() ?? lang('Customer.error_register');
            json_output([
                'error' => $errors,
                'alert' => print_alert($errors, 'danger'),
            ]);
        }

        $email_activation = config_item('email_activation');
        if (!empty($email_activation) && !$customer_group_list[$customer_info['customer_group_id']]['approval']) {
            $deactivate = $customer_model->deactivate($customer_info['customer_id']);

            if (empty($deactivate)) {
                $errors = $customer_model->getErrors() ?? lang('Customer.deactivate_unsuccessful');
                json_output([
                    'error' => $errors,
                    'alert' => print_alert($errors, 'danger'),
                ]);
            }

            $activation_code = $customer_model->activation_code;

            $data = [
                'full_name' => full_name($customer_info['first_name'], $customer_info['last_name']),
                'id' => $customer_info['customer_id'],
                'email' => $customer_info['email'],
                'activation' => $activation_code,
                'active_link' => site_url('account/activate/'.$customer_info['customer_id'].'/'.$activation_code),
            ];

            $message = $this->themes::view('email/activate', $data);
            $subject_title = config_item('email_subject_title');
            $subject = lang('Email.activation_subject');

            $send_email = send_email($customer_info['email'], config_item('email_from'), $subject, $message, $subject_title);
            if (!$send_email) {
                $errors = $customer_model->getErrors() ?? lang('Customer.activation_email_unsuccessful');
                json_output([
                    'error' => $errors,
                    'alert' => print_alert($errors, 'danger'),
                ]);
            }

            $success = lang('Customer.activation_email_successful');
        } elseif ($customer_group_list[$customer_info['customer_group_id']]['approval']) {
            service('customer')->login($customer_info['email'], $customer_info['password'], false);

            $customer_ip_model = new \App\Modules\Customers\Models\IpModel();
            $customer_ip_model->addLogin(service('customer')->getId());

            $success = lang('Customer.activation_email_successful');
        } else {
            $success = lang('Customer.text_creation_approval');
        }

        session()->remove([
            'guest',
            'register_token',
            'shipping_method',
            'shipping_methods',
            'payment_method',
            'payment_methods',
        ]);

        set_alert($success, ALERT_SUCCESS);

        json_output([
            'success' => $success,
            'alert' => print_alert($success),
            'redirect' => site_url('account/alert?type=register').(!empty(session('customer_token')) ? '&customer_token='.session('customer_token') : ''),
        ]);
    }
}
