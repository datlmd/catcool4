<?php namespace App\Modules\Users\Controllers;

use App\Controllers\UserController;
use App\Modules\Users\Models\UserModel;

class Login extends UserController
{
    public $config_form = [];

    public function __construct()
    {
        parent::__construct();

        $this->model = new UserModel();
    }

    public function index()
    {

        $this->themes->setTheme(config_item('theme_frontend'));
        $this->themes->addPartial('header_top')
            ->addPartial('header_bottom')
            ->addPartial('content_left')
            ->addPartial('content_right')
            ->addPartial('footer_top')
            ->addPartial('footer_bottom');


        $this->breadcrumb->openTag(config_item('breadcrumb_open'));
        $this->breadcrumb->closeTag(config_item('breadcrumb_close'));
        $this->breadcrumb->add(lang('General.text_home'), base_url());

        $data = [];

        theme_load('login', $data);
    }

    public function postLogin()
    {
        if (empty($this->request->getPost())) {
            set_alert(lang('Alert.error'), ALERT_ERROR);
            return redirect()->back()->withInput();
        }

        $this->validator->setRule('login_identity', lang('General.text_login_identity'), 'required');
        $this->validator->setRule('login_password', lang('General.text_password'), 'required');

        if (!$this->validator->withRequest($this->request)->run()) {
            return redirect()->back()->withInput();
        }

        $remember = (bool)$this->request->getPost('remember');
        if (!$this->model->login($this->request->getPost('login_identity'), $this->request->getPost('login_password'), $remember)) {
            $errors = empty($this->model->getErrors()) ? lang('User.text_login_unsuccessful') : $this->model->getErrors()[0];
            set_alert($errors, ALERT_ERROR);
            return redirect()->back()->withInput();
        }


        set_alert(lang('User.text_login_successful'), ALERT_SUCCESS);
        return redirect()->to(site_url('customers/profile'));
    }

    public function socialLogin()
    {
        //check login
        if (!empty(session('user.user_id'))) {
            json_output(['status' => 'logged_in']);
        }

        $auth_url  = '';
        $user_data = [];

        $login_type = $this->request->getGetPost('type');

        if (!empty($login_type)) {
            switch ($login_type) {
                case LOGIN_SOCIAL_TYPE_FACEBOOK:
                    // Load facebook oauth library
                    $facebook = service('facebook');

                    // Authenticate user with facebook
                    $access_token = $this->request->getPost('access_token');//$facebook->isAuthenticated();
                    if (!empty($access_token)) {
                        // Get user info from facebook
                        //$fb_user   = $facebook->getUserInfor($user_id, $access_token);
                        $fb_user = $facebook->request('get', '/me?fields=id,name,first_name,last_name,email,link,gender,picture.type(large), birthday', $access_token);
                        $user_data = [
                            'id'           => !empty($fb_user['id']) ? $fb_user['id'] : '',
                            'first_name'   => !empty($fb_user['first_name']) ? $fb_user['first_name'] : '',
                            'last_name'    => !empty($fb_user['last_name']) ? $fb_user['last_name'] : '',
                            'email'        => !empty($fb_user['email']) ? $fb_user['email'] : '',
                            'phone'        => !empty($fb_user['phone']) ? $fb_user['phone'] : '',
                            'gender'       => !empty($fb_user['gender']) ? $fb_user['gender'] : '',
                            'image'        => !empty($fb_user['picture']['data']['url']) ? $fb_user['picture']['data']['url'] : '',
                            'access_token' => $access_token,
                        ];
                    } else {
                        $auth_url = $facebook->loginUrl();
                    }

                    break;
                case LOGIN_SOCIAL_TYPE_GOOGLE:

                    // Load zalo oauth library
                    $google = service('google');
                    if(!empty($this->request->getGet('code'))) {

                        // Authenticate user with google
                        $access_token = $google->getAuthenticate($this->request->getGet('code'));
                        if($access_token) {

                            // Get user info from google
                            $gg_user = $google->getUserInfo();

                            $user_data = [
                                'id'           => !empty($gg_user['id']) ? $gg_user['id'] : '',
                                'first_name'   => !empty($gg_user['given_name']) ? $gg_user['given_name'] : '',
                                'last_name'    => !empty($gg_user['family_name']) ? $gg_user['family_name'] : '',
                                'email'        => !empty($gg_user['email']) ? $gg_user['email'] : '',
                                'phone'        => !empty($gg_user['phone']) ? $gg_user['phone'] : '',
                                'gender'       => !empty($gg_user['gender']) ? $gg_user['gender'] : '',
                                'image'        => !empty($gg_user['picture']) ? $gg_user['picture'] : '',
                                'access_token' => $access_token['access_token'],
                            ];
                        } else {
                            $auth_url = $google->loginUrl();
                        }
                    } else {
                        $auth_url = $google->loginUrl();
                    }
                    break;
                case LOGIN_SOCIAL_TYPE_ZALO:
                    // Load zalo oauth library
                    $zalo = service('zaloApi');

                    // Authenticate user with zalo
                    $access_token = $zalo->isAuthenticated();
                    if (!empty($access_token)) {
                        $zalo_user = $zalo->getUser($access_token);
                        $user_data = [
                            'id'           => !empty($zalo_user['id']) ? $zalo_user['id'] : '',
                            'first_name'   => !empty($zalo_user['name']) ? $zalo_user['name'] : '',
                            'last_name'    => !empty($zalo_user['last_name']) ? $zalo_user['last_name'] : '',
                            'dob'          => !empty($zalo_user['birthday']) ? $zalo_user['birthday'] : '',
                            'email'        => !empty($zalo_user['email']) ? $zalo_user['email'] : '',
                            'phone'        => !empty($zalo_user['phone']) ? $zalo_user['phone'] : '',
                            'gender'       => !empty($zalo_user['gender']) ? $zalo_user['gender'] : '',
                            'image'        => !empty($zalo_user['picture']['data']['url']) ? $zalo_user['picture']['data']['url'] : '',
                            'access_token' => $access_token->getValue(),
                        ];
                    } else {
                        $auth_url =  $zalo->loginUrl();
                    }

                    break;
                case LOGIN_SOCIAL_TYPE_TWITTER:
                default:
                    break;
            }
        }

        //login false
        if (empty($auth_url) && empty($user_data)) {
            json_output(['status' => 'ng', 'msg' => lang('User.text_login_social_unsuccessful')]);
        }

        //check token login
        if (!empty($auth_url)) {
            json_output(['status' => 'ok', 'auth_url' => $auth_url]);
        }

        //check user $user_data, login thanh cong
        $is_login = $this->model->loginSocial($login_type, $user_data);
        if (empty($is_login)) {
            json_output(['status' => 'ng', 'msg' => lang('User.text_login_social_unsuccessful')]);
        }

        $return_url = $this->request->getPostGet('returnUrl');
        if (empty($return_url)) {
            $return_url = site_url();
        }

        if ($this->request->isAJAX()) {
            json_output(['status' => 'logged_in', 'url' => $return_url]);
        }

        return redirect()->to(site_url('users/social_login') . "?logged_in=$login_type");
    }
}
