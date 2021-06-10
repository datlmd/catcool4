<?php namespace App\Modules\Users\Controllers;

use App\Controllers\UserController;
use App\Modules\Users\Models\UserModel;
use App\Modules\Users\Models\AuthModel;

class Users extends UserController
{
    public $config_form = [];

    public function __construct()
    {
        parent::__construct();


        $this->model      = new UserModel();
        $this->auth_model = new AuthModel();

        $this->themes->setTheme(config_item('theme_frontend'));

        $this->breadcrumb->openTag(config_item('breadcrumb_open'));
        $this->breadcrumb->closeTag(config_item('breadcrumb_close'));
        $this->breadcrumb->add(lang('General.text_home'), base_url());
    }

    public function index()
    {
        //tat ca xu ly auth

        return null;
    }

    public function postRegister()
    {
        if (empty($this->request->getPost())) {
            set_alert(lang('Alert.error'), ALERT_ERROR);
            return redirect()->back()->withInput();
        }

        $this->validator->setRule('identity', lang('General.text_identity'), 'required');
        $this->validator->setRule('first_name', lang('General.text_first_name'), 'required');
        $this->validator->setRule('password', lang('General.text_password'), 'required|min_length[' . config_item('min_password_length') . ']');
        $this->validator->setRule('policy', lang('General.text_policy'), 'required');
        $this->validator->setRule('gender', lang('General.text_gender'), 'required');
        $this->validator->setRule('dob_day', lang('General.text_day'), 'required|is_natural_no_zero');
        $this->validator->setRule('dob_month', lang('General.text_month'), 'required|is_natural_no_zero');
        $this->validator->setRule('dob_year', lang('General.text_year'), 'required|is_natural_no_zero');

        if (!$this->validator->withRequest($this->request)->run()) {
            return redirect()->back()->withInput();
        }

        $add_data        = $this->request->getPost();
        $add_data['ip']  = $this->request->getIPAddress();
        $add_data['dob'] = sprintf("%s/%s/%s", $this->request->getPost('dob_day'), $this->request->getPost('dob_month'), $this->request->getPost('dob_year'));

        $user_info = $this->model->register($add_data);
        if (empty($user_info)) {
            $errors = empty($this->model->getErrors()) ? lang('Alert.error_register') : $this->model->getErrors()[0];
            set_alert($errors, ALERT_ERROR);
            return redirect()->back()->withInput();
        }

        $email_activation = config_item('email_activation');
        if (!empty($email_activation)) {

            $deactivate = $this->model->deactivate($user_info['id']);
            if (empty($deactivate)) {
                $errors = empty($this->model->getErrors()) ? lang('User.deactivate_unsuccessful') : $this->model->getErrors()[0];
                set_alert($errors, ALERT_ERROR);
                return redirect()->back()->withInput();
            }

            $activation_code = $this->model->activation_code;

            $data = [
                'full_name'  => sprintf('%s %s', $user_info['first_name'], $user_info['last_name']),
                'id'         => $user_info['id'],
                'email'      => $user_info['email'],
                'activation' => $activation_code,
            ];

            $message       = $this->themes::view('email/activate', $data);
            $subject_title = config_item('email_subject_title');
            $subject       = lang('Email.activation_subject');

            $send_email = send_email($user_info['email'], config_item('email_from'), $subject_title, $subject, $message);
            if (!$send_email) {
                set_alert(lang('User.activation_email_unsuccessful'), ALERT_ERROR);
                return redirect()->back()->withInput();
            }

            set_alert(lang('User.activation_email_successful'), ALERT_SUCCESS);
            return redirect()->back()->withInput();
        }


        set_alert(lang('User.account_creation_successful'), ALERT_SUCCESS);
        return redirect()->to(site_url('customers/profile'));
    }

    public function postLogin()
    {
        if (empty($this->request->getPost())) {
            set_alert(lang('Alert.error'), ALERT_ERROR);
            return redirect()->back()->withInput();
        }

        $this->validator->setRule('identity', lang('General.text_login_identity'), 'required');
        $this->validator->setRule('password', lang('General.text_password'), 'required');

        if (!$this->validator->withRequest($this->request)->run()) {
            return redirect()->back()->withInput();
        }

        $remember = (bool)$this->request->getPost('remember');
        if ($this->model->login($this->request->getPost('identity'), $this->request->getPost('password'), $remember)) {
            cc_debug(55);
            set_alert(lang('Admin.text_login_successful'), ALERT_SUCCESS);
            return redirect()->to();
        }

cc_debug($this->model->getErrors());
        set_alert(lang('User.account_creation_successful'), ALERT_SUCCESS);
        return redirect()->to(site_url('customers/profile'));
    }

    public function activate($id = null, $activation = null)
    {

        $result = $this->model->activate($id, $activation);

        $data = [
            'result' => $result,
            'errors' => $this->model->getErrors(),
        ];

        $this->breadcrumb->add(lang('General.text_account'), base_url('users/profile'));

        $data_breadcrumb['breadcrumb']       = $this->breadcrumb->render();
        $data_breadcrumb['breadcrumb_title'] = lang("User.heading_activate");
        $this->themes->addPartial('breadcumb', $data_breadcrumb);

        add_meta(['title' => lang("User.heading_activate")], $this->themes);

        $this->themes->addPartial('header_top')
            ->addPartial('header_bottom')
            ->addPartial('content_left')
            ->addPartial('content_right')
            ->addPartial('footer_top')
            ->addPartial('footer_bottom');

        theme_load('activate', $data);
    }
}
