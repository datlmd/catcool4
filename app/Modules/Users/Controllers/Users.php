<?php namespace App\Modules\Users\Controllers;

use App\Controllers\BaseController;
use App\Modules\Users\Models\UserModel;
use App\Modules\Users\Models\AuthModel;

class Users extends BaseController
{
    public $config_form = [];
    public $data        = [];

    CONST MANAGE_ROOT = 'users/auth';
    CONST MANAGE_URL  = 'users/auth';

    public function __construct()
    {
        parent::__construct();

//        $this->themes->setTheme(config_item('theme_admin'))
//            ->addPartial('header')
//            ->addPartial('footer')
//            ->addPartial('sidebar');

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

        $this->validator->setRule('email', lang('Frontend.text_email'), 'required|valid_email|is_unique[user.email]');
        $this->validator->setRule('first_name', lang('Frontend.text_first_name'), 'required');
        $this->validator->setRule('password', lang('Frontend.text_password'), 'required|min_length[' . config_item('min_password_length') . ']|matches[password_confirm]');
        $this->validator->setRule('password_confirm', lang('Frontend.text_password_confirm'), 'required');
        $this->validator->setRule('policy', lang('Frontend.text_policy'), 'required');

        if (!$this->validator->withRequest($this->request)->run()) {
            return redirect()->back()->withInput();
        }

        $add_data       = $this->request->getPost();
        $add_data['ip'] = $this->request->getIPAddress();

        $user_info = $this->model->register($add_data);
        if (empty($user_info)) {
            set_alert(lang('Alert.error_register'), ALERT_ERROR);
            return redirect()->back()->withInput();
        }

        $email_activation = config_item('email_activation');
        if (!empty($email_activation)) {

            $deactivate = $this->model->deactivate($user_info['id']);
            if (empty($deactivate)) {
                set_alert(lang('User.deactivate_unsuccessful'), ALERT_ERROR);
                return redirect()->back()->withInput();
            }

            $activation_code = $this->activation_code;

            $data = [
                'full_name'  => sprintf('%s %s', $user_info['first_name'], $user_info['last_name']),
                'id'         => $user_info['id'],
                'email'      => $user_info['email'],
                'activation' => $activation_code,
            ];

            $message       = $this->themes::view('email/activate', $data);
            $subject_title = config_item('email_subject_title');
            $subject       = lang('UserAdmin.email_forgotten_password_subject');

            $send_email = send_email($user_info['email'], config_item('email_from'), $subject_title, $subject, $message);
            if (!$send_email) {
                set_alert(lang('User.activation_email_unsuccessful'), ALERT_ERROR);
                return redirect()->back()->withInput();
            }

            set_alert(lang('User.activation_email_successful'), ALERT_SUCCESS);
            return redirect()->to(site_url(self::MANAGE_URL));
        }


        set_alert(lang('User.activation_email_successful'), ALERT_SUCCESS);
        return redirect()->to(site_url(self::MANAGE_URL));
    }
}
