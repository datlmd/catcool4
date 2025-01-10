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

        //load datepicker
        $this->themes->addJS('common/plugin/datepicker/moment.min');
        $this->themes->addCSS('common/plugin/datepicker/tempusdominus-bootstrap-4.min');
        $this->themes->addJS('common/plugin/datepicker/tempusdominus-bootstrap-4.min');
        if (language_code() == 'vi') {
            $this->themes->addJS('common/plugin/datepicker/locale/vi');
        }

        //breadcrumb
        $this->breadcrumb->add(lang('General.text_home'), base_url());
        $this->breadcrumb->add(lang('Customer.text_account'), site_url('account/profile') . '?customer_token=' . session('customer_token'));
        $this->breadcrumb->add(lang('Customer.text_account_edit'), site_url('account/edit') . '?customer_token=' . session('customer_token'));

        //set params khi call cell
        $data['params'] = [
            'breadcrumb' => $this->breadcrumb->render(),
            'breadcrumb_title' => lang('Customer.text_account_edit'),
        ];

        $customer_model = new \App\Modules\Customers\Models\CustomerModel();

        $customer_group_list = [];
        if (!empty(config_item('customer_group_display'))) {
            $customer_group_display = explode(',', config_item('customer_group_display'));

            $customer_group_model = new \App\Modules\Customers\Models\GroupModel();
            $customer_group_list = $customer_group_model->getCustomerGroups($this->language_id);
            
            foreach ($customer_group_list ?? [] as $customer_group) {
                if (in_array($customer_group['customer_group_id'], $customer_group_display)) {
                    $customer_group_list[] = $customer_group;
                }
            }
        }

        $data['contents'] = [
            'back' => site_url('account/profile') . '?customer_token=' . session('customer_token'),
            'save' => site_url('account/edit/save') . '?customer_token=' . session('customer_token'),
            
            'customer_info' => $customer_model->getCustomerInfo(service('customer')->getId()),
            'customer_group_id' => config_item('customer_group_id'),
            'customer_group_list' => $customer_group_list,

            'text_account_edit_title' => lang('Customer.text_account_edit_title'),
            'text_your_details' => lang('Customer.text_your_details'),
            'text_first_name' => lang('Customer.text_first_name'),
            'help_first_name' => lang('Customer.help_first_name'),
            'text_last_name' => lang('Customer.text_last_name'),
            'help_last_name' => lang('Customer.help_last_name'),
            'text_gender' => lang('General.text_gender'),
            'text_male' => lang('General.text_male'),
            'text_female' => lang('General.text_female'),
            'text_other' => lang('General.text_other'),
            'text_dob' => lang('General.text_dob'),
            'text_email' => lang('Customer.text_email'),
            'text_username' => lang('Customer.text_username'),
            'text_phone' => lang('Customer.text_phone'),
            'text_customer_group' => lang('Customer.text_customer_group'),
            'button_back' => lang('General.button_back'),
            'button_save' => lang('General.button_save'),
        ];

        $data = array_merge($data, theme_var());
        $data = inertia_data($data);

        add_meta(['title' => lang("Customer.text_account_edit_title")], $this->themes);
        
        return inertia('Account/Edit', $data);
        
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

        if (!empty($this->request->getPost('username'))) {
            $this->validator->setRule('username', lang('Customer.text_username'), "required|min_length[3]|max_length[32]|is_unique[customer.username,customer_id,$customer_id]");
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
                'alert' => print_alert($errors, ALERT_ERROR),
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
                'alert' => print_alert($errors, ALERT_ERROR),
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
            'alert' => print_alert($success, ALERT_SUCCESS),
        ]);
    }
}
