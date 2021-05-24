<?php namespace App\Modules\Customers\Controllers;

use App\Controllers\BaseController;

class Customers extends BaseController
{



    public function __construct()
    {
        parent::__construct();

        //set theme
        $this->themes->setTheme(config_item('theme_frontend'))
            ->addPartial('header_top')
            ->addPartial('header_bottom')
            ->addPartial('breadcumb')
            ->addPartial('footer_bottom');

        $this->breadcrumb->add(lang('Customer.frontend_heading'), site_url());
    }

    public function index()
    {
        $data = [];

        add_meta(['title' => lang("Customer.heading_title")], $this->themes);

        theme_load('index', $data);
    }

    public function login()
    {
        $data = [];

        // validate form input
        $this->validator->setRule('username', lang('Customer.text_username'), 'required');
        $this->validator->setRule('password', lang('Customer.text_password'), 'required');

        if (!empty($this->request->getPost()) && $this->validator->withRequest($this->request)->run())
        {
            /*
            if(!check_captcha($this->request->post('captcha'))) {
                $data['errors'] = lang('error_captcha');
            } else {
                $remember = (bool)$this->request->post('remember');
                if ($this->Customer->login($this->request->post('username'), $this->request->post('password'), $remember, true)) {
                    set_alert(lang('text_login_successful'), ALERT_SUCCESS);
                    redirect(self::MANAGE_URL);
                }

                $data['errors'] = empty($this->Member->errors()) ? lang('text_login_unsuccessful') : $this->Member->errors();
            }
            */
        }

        $this->themes->addJS('common/js/customer/login');

        if ($this->validator->getErrors()) {
            $data['errors'] = $this->validator->getErrors();
        }

        add_meta(['title' => lang("Customer.heading_title")], $this->themes);

        theme_load('login', $data);
    }

    public function socialLogin()
    {
        //check login

        $auth_url  = '';
        $user_data = [];

        if (isset($_REQUEST) && !empty($_REQUEST['type'])) {

            switch ($this->request->getPostGet('type')) {
                case 'fb':
                    // Load facebook oauth library
//                    $this->load->library('facebook');
//
//                    // Authenticate user with facebook
//                    $access_token = $this->facebook->is_authenticated();
//                    if (!empty($access_token)) {
//                        // Get user info from facebook
//                        $fb_user   = $this->facebook->request('get', '/me?fields=id,name,first_name,last_name,email,link,gender,picture.type(large), birthday');
//                        $user_data = [
//                            'id'         => !empty($fb_user['id']) ? $fb_user['id'] : '',
//                            'first_name' => !empty($fb_user['first_name']) ? $fb_user['first_name'] : '',
//                            'last_name'  => !empty($fb_user['last_name']) ? $fb_user['last_name'] : '',
//                            'email'      => !empty($fb_user['email']) ? $fb_user['email'] : '',
//                            'phone'      => !empty($fb_user['phone']) ? $fb_user['phone'] : '',
//                            'gender'     => !empty($fb_user['gender']) ? $fb_user['gender'] : '',
//                            'image'      => !empty($fb_user['picture']['data']['url']) ? $fb_user['picture']['data']['url'] : '',
//                        ];
//                    } else {
//                        $auth_url =  $this->facebook->login_url();
//                    }

                    break;
                case 'gg':

                    // Load zalo oauth library
                    $google = service('google');
                    if(isset($_GET['code'])) {
                        // Authenticate user with google
                        if($google->getAuthenticate($_GET['code'])) {

                            // Get user info from google
                            $gg_user = $google->getUserInfo();

                            $user_data = [
                                'id'         => !empty($gg_user['id']) ? $gg_user['id'] : '',
                                'first_name' => !empty($gg_user['given_name']) ? $gg_user['given_name'] : '',
                                'last_name'  => !empty($gg_user['family_name']) ? $gg_user['family_name'] : '',
                                'email'      => !empty($gg_user['email']) ? $gg_user['email'] : '',
                                'phone'      => !empty($gg_user['phone']) ? $gg_user['phone'] : '',
                                'gender'     => !empty($gg_user['gender']) ? $gg_user['gender'] : '',
                                'image'      => !empty($gg_user['picture']) ? $gg_user['picture'] : '',
                            ];
                        } else {
                            $auth_url = $google->loginUrl();
                        }
                    } else {
                        $auth_url = $google->loginUrl();
                    }
                    break;
                case 'zalo':
                    // Load zalo oauth library
//                    $this->load->library('zalo_lib');
//
//                    // Authenticate user with zalo
//                    $access_token = $this->zalo_lib->is_authenticated();
//                    if (!empty($access_token)) {
//                        $zalo_user = $this->zalo_lib->get_user($access_token);
//                        $user_data = [
//                            'id'         => !empty($zalo_user['id']) ? $zalo_user['id'] : '',
//                            'first_name' => !empty($zalo_user['name']) ? $zalo_user['name'] : '',
//                            'last_name'  => !empty($zalo_user['last_name']) ? $zalo_user['last_name'] : '',
//                            'dob'        => !empty($zalo_user['birthday']) ? $zalo_user['birthday'] : '',
//                            'email'      => !empty($zalo_user['email']) ? $zalo_user['email'] : '',
//                            'phone'      => !empty($zalo_user['phone']) ? $zalo_user['phone'] : '',
//                            'gender'     => !empty($zalo_user['gender']) ? $zalo_user['gender'] : '',
//                            'image'      => !empty($zalo_user['picture']['data']['url']) ? $zalo_user['picture']['data']['url'] : '',
//                        ];
//                    } else {
//                        $auth_url =  $this->zalo_lib->login_url();
//                    }

                    break;
                case 'tt':
                default:
                    break;
            }
        }

        //login false
        if (empty($auth_url) && empty($user_data)) {
            json_output(['status' => 'ng', 'msg' => 'No result!']);
        }

        //check token login
        if (!empty($auth_url)) {
            json_output(['status' => 'ok', 'auth_url' => $auth_url]);
        }

        //check user $user_data, login thanh cong


        if ($this->request->isAJAX()) {
            json_output(['status' => 'redirect', 'url' => previous_url()]);
        }

        return redirect()->to(site_url('customers/login') . 'returnUrl');
    }
}