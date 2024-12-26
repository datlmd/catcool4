<?php

namespace App\Modules\Customers\Controllers;

use App\Controllers\MyController;

class Login extends MyController
{
    public function __construct()
    {
        parent::__construct();

        //set theme
        $this->themes->setTheme(config_item('theme_frontend'));
    }

    public function index()
    {
        $data = [];

        $return_url = $this->request->getGet('return_url');
        if (empty($return_url)) {
            $return_url = site_url('account/profile');
        }

        if (service('customer')->isLogged() && !empty(session('customer_token'))) {
            return redirect()->to($return_url . '?customer_token=' . session('customer_token'));
        } else if (service('customer')->loginRememberedCustomer()) {
            //neu da logout thi check auto login
            return redirect()->to($return_url . '?customer_token=' . session('customer_token'));
        }

        $data['return_url'] = $return_url;

        //breadcrumb
        $this->breadcrumb->add(lang('General.text_home'), base_url());
        $this->breadcrumb->add(lang('Customer.text_account_login'), base_url('account/login'));

        $params['params'] = [
            'breadcrumb' => $this->breadcrumb->render(),
            'breadcrumb_title' => lang('Customer.text_account_login'),
        ];

        add_meta(['title' => lang("Customer.text_account_login")], $this->themes);

        if (IS_REACT) {
            $data = [
                'page_title' => lang("Customer.text_account_login"),
                'page' => [
                    'component' => 'Account/Login',
                    'props' => [
                        'message' => 'Hello from Inertia.js and React!',
                        'layouts' => [
                            'header_top' => view_cell('Common::headerTop', $params),
                        ],
                        'lang' => [
                            'forgotten' => site_url('account/forgotten'),
                            'login' => site_url('account/login'),
                    
                            'text_login' => lang('General.text_login'),
                            'text_login_identity' => lang('General.text_login_identity'),
                            'text_password' => lang('General.text_password'),
                            'text_remember' => lang('General.text_remember'),
                            'button_login' => lang('General.button_login'),
                            'text_or' => lang('General.text_or')
                        ],
                        'crsf_token' => [
                            'name' => csrf_token(),
                            'value' => csrf_hash(),
                        ]
                    ],
                    'url' => site_url('account/login'),
                    'status' => 200
                ]
            ];
            return theme_load('react', $data);
        }

        $this->themes->addPartial('header_top', $params)
            ->addPartial('header_bottom', $params)
            ->addPartial('content_left', $params)
            ->addPartial('content_top', $params)
            ->addPartial('content_bottom', $params)
            ->addPartial('content_right', $params)
            ->addPartial('footer_top', $params)
            ->addPartial('footer_bottom', $params);

        theme_load('login', $data);
    }

    public function login()
    {
        $this->validator->setRule('login_identity', lang('Customer.text_login_identity'), 'required');
        $this->validator->setRule('login_password', lang('Customer.text_password'), 'required');

        if (!$this->validator->withRequest($this->request)->run()) {
            $errors = $this->validator->getErrors();

            if (IS_REACT) {
                $data = [
                    'page_title' => lang("Customer.text_account_login"),
                    'page' => [
                        'component' => 'Account/Login',
                        'errors' => $errors
                        // 'url' => site_url('account/login'),
                        // 'status' => 200
                    ]
                ];
                //return theme_load('react', $data);
            }
            //return redirect()->back()->with('errors', $errors);
            json_output([
                'errors' => $errors,
                'alert' => print_alert($errors, ALERT_ERROR)
            ]);
        }

        $remember = (bool)$this->request->getPost('remember');
        if (!service('customer')->login($this->request->getPost('login_identity'), html_entity_decode($this->request->getPost('login_password'), ENT_QUOTES, 'UTF-8'), $remember)) {
            $errors = empty(service('customer')->getErrors()) ? lang('Customer.text_login_unsuccessful') : service('customer')->getErrors();

            json_output([
                'error' => $errors,
                'alert' => print_alert($errors, ALERT_ERROR)
            ]);
        }

        $return_url = $this->request->getPost('return_url');
        if (empty($return_url)) {
            $return_url = site_url('account/profile');
        }

        session()->remove(['order_id']);
        session()->remove(['shipping_method']);
        session()->remove(['shipping_methods']);
        session()->remove(['payment_method']);
        session()->remove(['payment_methods']);

        // Wishlist
        if (!empty(session('wishlist')) && is_array(session('wishlist'))) {
            $customer_wishlist_model = new \App\Modules\Customers\Models\WishlistModel();
            $customer_wishlist_model->addLogin(service('customer')->getId());

            foreach (session('wishlist') as $key => $product_id) {
                $customer_wishlist_model->addWishlist(service('customer')->getId(), $product_id);

                unset(session('wishlist')[$key]);
            }
        }

        $customer_ip_model = new \App\Modules\Customers\Models\IpModel();
        $customer_ip_model->addLogin(service('customer')->getId());

        $success = lang('Customer.text_login_successful');
        set_alert($success, ALERT_SUCCESS);

        json_output([
            'success' => $success,
            'alert' => print_alert($success, ALERT_SUCCESS),
            'redirect' => urldecode($return_url) . '?customer_token=' . session('customer_token')
        ]);
    }

    public function socialLogin()
    {
        //check login
        if (!empty(service('customer')->isLogged())) {
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
                    $access_token = $this->request->getPost('access_token'); //$facebook->isAuthenticated();
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
                    if (!empty($this->request->getGet('code'))) {

                        // Authenticate user with google
                        $access_token = $google->getAuthenticate($this->request->getGet('code'));
                        if ($access_token) {

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
            json_output([
                'status' => 'ng',
                'msg' => lang('Customer.text_login_social_unsuccessful')
            ]);
        }

        //check token login
        if (!empty($auth_url)) {
            json_output([
                'status' => 'ok',
                'auth_url' => $auth_url
            ]);
        }

        //check user $user_data, login thanh cong
        $is_login = $this->model->loginSocial($login_type, $user_data);
        if (empty($is_login)) {
            json_output([
                'status' => 'ng',
                'msg' => lang('Customer.text_login_social_unsuccessful')
            ]);
        }

        $return_url = $this->request->getPostGet('returnUrl');
        if (empty($return_url)) {
            $return_url = site_url();
        }

        if ($this->request->isAJAX()) {
            json_output(['status' => 'logged_in', 'url' => $return_url . '?customer_token=' . session('customer_token')]);
        }

        return redirect()->to(site_url('account/social_login') . "?logged_in=$login_type");
    }
}
