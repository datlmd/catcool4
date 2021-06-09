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

        $this->validator->setRule('identity', lang('Frontend.text_identity'), 'required');
        $this->validator->setRule('first_name', lang('Frontend.text_first_name'), 'required');
        $this->validator->setRule('password', lang('Frontend.text_password'), 'required|min_length[' . config_item('min_password_length') . ']');
        $this->validator->setRule('policy', lang('Frontend.text_policy'), 'required');
        $this->validator->setRule('gender', lang('Frontend.text_gender'), 'required');
        $this->validator->setRule('dob_day', lang('Frontend.text_day'), 'required|is_natural_no_zero');
        $this->validator->setRule('dob_month', lang('Frontend.text_month'), 'required|is_natural_no_zero');
        $this->validator->setRule('dob_year', lang('Frontend.text_year'), 'required|is_natural_no_zero');

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
            $subject       = lang('User.email_activation_subject');

            $send_email = send_email($user_info['email'], config_item('email_from'), $subject_title, $subject, $message);
            if (!$send_email) {
                set_alert(lang('User.activation_email_unsuccessful'), ALERT_ERROR);
                return redirect()->back()->withInput();
            }

            set_alert(lang('User.activation_email_successful'), ALERT_SUCCESS);
            return redirect()->back()->withInput();
        }


        set_alert(lang('User.activation_email_successful'), ALERT_SUCCESS);
        return redirect()->to(site_url('customers/profile'));
    }

    public function activate($id = null, $activation = null)
    {
        $this->themes->setTheme(config_item('theme_frontend'))
            ->addPartial('header_top')
            ->addPartial('header_bottom')
            ->addPartial('content_left')
            ->addPartial('content_right')
            ->addPartial('footer_top')
            ->addPartial('footer_top')
            ->addPartial('footer_bottom');

        $result = $this->model->activate($id, $activation);

        $data = [
            'result' => $result,
            'errors' => $this->model->getErrors(),
        ];

        add_meta(['title' => lang("User.heading_activate")], $this->themes);

        theme_load('activate', $data);
    }
}
