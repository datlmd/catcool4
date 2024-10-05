<?php

namespace App\Modules\Customers\Controllers;

use App\Controllers\UserController;

class Edit extends UserController
{
    public $config_form = [];

    public function __construct()
    {
        parent::__construct();

        //set theme
        $this->themes->setTheme(config_item('theme_frontend'));
    }

    public function index()
    {
        if (!service('customer')->isLogged() || (empty($this->request->getGet('customer_token')) || empty(session('customer_token')) || ($this->request->getGet('customer_token') != session('customer_token')))) {
            if (service('customer')->loginRememberedCustomer()) {
                return redirect()->to(current_url() . '?customer_token=' . session('customer_token'));
            }

            return redirect()->to(site_url("account/login?return_url=" . current_url()));
        }

        $customer_model = new \App\Modules\Customers\Models\CustomerModel();

        $customer_info = $customer_model->getCustomerInfo(service('customer')->getId());
        $data['customer_info'] = $customer_info;

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

        $data['back'] = site_url('account/profile') . '?customer_token=' . session('customer_token');
        $data['save'] = site_url('account/edit/save') . '?customer_token=' . session('customer_token');

        //breadcrumb
        $this->breadcrumb->add(lang('General.text_home'), base_url());
        $this->breadcrumb->add(lang('Customer.text_account'), site_url('account/profile') . '?customer_token=' . session('customer_token'));
        $this->breadcrumb->add(lang('Customer.text_account_edit'), site_url('account/edit') . '?customer_token=' . session('customer_token'));

        //set params khi call cell
        $params['params'] = [
            'breadcrumb' => $this->breadcrumb->render(),
            'breadcrumb_title' => lang('Customer.text_account_edit'),
        ];

        $this->themes->addPartial('header_top', $params)
            ->addPartial('header_bottom', $params)
            ->addPartial('content_left', $params)
            ->addPartial('content_top', $params)
            ->addPartial('content_bottom', $params)
            ->addPartial('content_right', $params)
            ->addPartial('footer_top', $params)
            ->addPartial('footer_bottom', $params);

        //load datepicker
        $this->themes->addJS('common/plugin/datepicker/moment.min');
        $this->themes->addCSS('common/plugin/datepicker/tempusdominus-bootstrap-4.min');
        $this->themes->addJS('common/plugin/datepicker/tempusdominus-bootstrap-4.min');
        if (language_code() == 'vi') {
            $this->themes->addJS('common/plugin/datepicker/locale/vi');
        }

        add_meta(['title' => lang("Customer.text_account_edit_title")], $this->themes);

        theme_load('edit', $data);
    }

    public function save()
    {
        if (!service('customer')->isLogged() || (empty($this->request->getGet('customer_token')) || empty(session('customer_token')) || (session('customer_token') != $this->request->getGet('customer_token')))) {
            set_alert(lang('Customer.error_edit_token'), ALERT_ERROR);
            json_output([
                'redirect' => site_url('account/edit' . '?customer_token=' . session('customer_token')),
            ]);
        }

        $customer_id = service('customer')->getId();

        $this->validator->setRule('first_name', lang('Customer.text_first_name'), 'required|min_length[2]|max_length[40]');
        $this->validator->setRule('last_name', lang('Customer.text_last_name'), 'required|min_length[2]|max_length[40]');
        $this->validator->setRule('email', lang('Customer.text_email'), "required|valid_email|is_unique[customer.email,customer_id,$customer_id]");
        $this->validator->setRule('gender', lang('General.text_gender'), 'required');
        $this->validator->setRule('dob', lang('General.text_dob'), 'required|valid_date[d/m/Y]');

        if (!empty($this->request->getPost('phone'))) {
            $this->validator->setRule('phone', lang('Customer.text_phone'), "required|min_length[3]|max_length[32]|is_unique[customer.phone,customer_id,$customer_id]");
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

            $this->validator->setRule('customer_group_id', lang('Customer.text_customer_group'), 'required|in_list[' . implode(',', $customer_group_ids) . ']');
        }

        if (!$this->validator->withRequest($this->request)->run()) {
            $errors = $this->validator->getErrors();
            json_output([
                'error' => $errors,
                'alert' => print_alert($errors, 'danger'),
            ]);
        }

        $customer_model = new \App\Modules\Customers\Models\CustomerModel();

        $edit_data = $this->request->getPost();
        $edit_data['dob'] = $this->request->getPost('dob');
        $edit_data['customer_group_id'] = $this->request->getPost('customer_group_id');

        if (!$customer_model->editCustomer($customer_id, $edit_data)) {
            $errors = lang('Customer.error_account_edit');
            json_output([
                'error' => $errors,
                'alert' => print_alert($errors, 'danger'),
            ]);
        }

        // Update customer session details
        $session_data = session('customer');
        $session_data['email'] = $edit_data['email'];
        $session_data['phone'] = $edit_data['phone'];
        $session_data['gender'] = $edit_data['gender'];
        $session_data['full_name'] = full_name($edit_data['first_name'], $edit_data['last_name']);
        $session_data['first_name'] = $edit_data['first_name'];
        $session_data['last_name'] = $edit_data['last_name'];

        session()->set('customer', $session_data);

        session()->remove([
            'shipping_method',
            'shipping_methods',
            'payment_method',
            'payment_methods',
        ]);

        $success = lang('Customer.text_account_edit_success');
        json_output([
            'success' => $success,
            'alert' => print_alert($success),
        ]);
    }
}
