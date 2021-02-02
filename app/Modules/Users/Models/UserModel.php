<?php namespace App\Modules\Users\Models;

use App\Models\MyModel;

class UserModel extends MyModel
{
    protected $table      = 'user';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id',
        'username',
        'password',
        'email',
        'first_name',
        'last_name',
        'company',
        'phone',
        'address',
        'dob',
        'gender',
        'image',
        'super_admin',
        'status',
        'activation_selector',
        'activation_code',
        'forgotten_password_selector',
        'forgotten_password_code',
        'forgotten_password_time',
        'last_login',
        'active',
        'is_deleted',
        'language',
        'user_ip',
        'ctime',
        'mtime'
    ];

    protected $with = ['user_groups', 'user_permissions'];

    protected $auth_model;

    //protected $errors;

    function __construct()
    {
        parent::__construct();

        $this->auth_model = new AuthModel();
    }

    public function getAllByFilter($filter = null, $sort = null, $order = null)
    {
        $sort  = empty($sort) ? 'id' : $sort;
        $order = empty($order) ? 'DESC' : $order;

        $where = "is_deleted=" . STATUS_OFF;
        if (!empty($filter["is_deleted"])) {
            $where = "is_deleted=" . $filter["is_deleted"];
        }

        if (!empty($filter["id"])) {
            $where .= " AND id IN(" . (is_array($filter["id"]) ? implode(',', $filter["id"]) : $filter["id"]) . ")";
        }

        if (!empty($filter["name"])) {
            $where .= "AND (";
            $where .= "username LIKE '%" . $filter["name"] . "%'";
            $where .= " OR first_name LIKE '%" . $filter["name"] . "%'";
            $where .= " OR email LIKE '%" . $filter["name"] . "%'";
            $where .= " OR phone LIKE '%" . $filter["name"] . "%'";
            $where .= ")";
        }

        if (!empty($where)) {
            $this->where($where);
        }

        $this->orderBy($sort, $order);

        return $this;
    }

//    public function remove($id, $is_trash = false)
//    {
//        if (empty($id)) {
//            return false;
//        }
//
//        if ($is_trash == true) {
//            $return = $this->delete($id);
//        } else {
//            $return = $this->update(['is_delete' => STATUS_ON], $id);
//        }
//
//        if (empty($return)) {
//            return false;
//        }
//
//        return $return;
//    }
//
//    public function update_acitve($id, $active)
//    {
//        if (empty($id)) {
//            return false;
//        }
//
//        $return = $this->update(['active' => $active], $id);
//        if (empty($return)) {
//            return false;
//        }
//
//        return $return;
//    }
//
//    public function login($username, $password, $remember = FALSE)
//    {
//        $this->errors = [];
//
//        if (empty($username) || empty($password)) {
//            $this->errors[] = lang('text_login_unsuccessful');
//            return FALSE;
//        }
//
//        $user_info = $this->get([['username',$username], ['is_delete', 0]]);
//        if (empty($user_info)) {
//            $this->errors[] = lang('text_login_unsuccessful');
//
//            return FALSE;
//        }
//
//        if (empty($user_info['active'])) {
//            $this->errors[] = lang('text_login_unsuccessful_not_active');
//            return FALSE;
//        }
//
//        if ($this->Auth->check_password($password, $user_info['password']) === FALSE) {
//            $this->errors[] = lang('text_login_unsuccessful');
//            return FALSE;
//        }
//
//        $this->Auth->set_session($user_info, true);
//
//        $data_login = [];
//        //check remember login
//        if ($remember) {
//            // Generate random tokens
//            $token = $this->Auth->generate_selector_validator_couple();
//            if (!empty($token['validator_hashed'])) {
//                $this->Auth->set_cookie($token);
//
//                $this->load->model("users/User_token", 'User_token');
//                $this->User_token->add_token($user_info['id'], $token);
//            }
//        }
//
//        //xoa forgotten pass neu login thanh cong
//        $data_login['forgotten_password_selector'] = NULL;
//        $data_login['forgotten_password_code']     = NULL;
//        $data_login['forgotten_password_time']     = NULL;
//        $data_login['last_login']                  = time(); // last login
//
//        $this->update($data_login, $user_info['id']);
//
//        return TRUE;
//    }
//
//    public function login_remembered_user()
//    {
//        $this->errors = [];
//
//        $this->load->model("users/User_token", 'User_token');
//
//        $remember_cookie = $this->Auth->get_cookie();
//        $token           = $this->Auth->retrieve_selector_validator_couple($remember_cookie);
//        if ($token === FALSE) {
//            $this->errors[] = lang('text_login_unsuccessful');
//            return FALSE;
//        }
//
//        $user_token = $this->User_token->get(['remember_selector' => $token['selector']]);
//        if (empty($user_token)) {
//            $this->errors[] = lang('text_login_unsuccessful');
//            return FALSE;
//        }
//
//        $user_info = $this->get([['id', $user_token['user_id']], ['is_delete', 0]]);
//        if (empty($user_info)) {
//            $this->errors[] = lang('text_login_unsuccessful');
//            return FALSE;
//        }
//
//        if (empty($user_info['active'])) {
//            $this->errors[] = lang('text_login_unsuccessful_not_active');
//            return FALSE;
//        }
//
//        if ($this->Auth->check_password($token['validator'], $user_token['remember_code']) === FALSE) {
//            $this->errors[] = lang('text_login_unsuccessful');
//            return FALSE;
//        }
//
//        $this->Auth->set_session($user_info, true);
//
//        //xoa forgotten pass neu login thanh cong
//        $data_login = [
//            'forgotten_password_selector' => NULL,
//            'forgotten_password_code'     => NULL,
//            'forgotten_password_time'     => NULL,
//            'last_login'                  => time(), // last login
//        ];
//        $this->update($data_login, $user_info['id']);
//
//        return TRUE;
//    }
//
//    public function logout()
//    {
//        $user_id = $this->Auth->get_user_id();
//        if (empty($user_id)) {
//            return FALSE;
//        }
//
//        $remember_cookie = $this->Auth->get_cookie();
//        $token           = $this->Auth->retrieve_selector_validator_couple($remember_cookie);
//
//        $this->load->model("users/User_token", 'User_token');
//        $this->User_token->delete_token($token);
//
//        $this->Auth->clear_session();
//        $this->Auth->delete_cookie();
//
//        // Clear all codes
//        $data_logout = [
//            'forgotten_password_selector' => NULL,
//            'forgotten_password_code'     => NULL,
//            'forgotten_password_time'     => NULL,
//        ];
//
//        $this->update($data_logout, $user_id);
//
//        return TRUE;
//    }
//
//    public function errors()
//    {
//        return $this->errors;
//    }
//
//    public function forgot_password($email)
//    {
//        if (empty($email)) {
//            return FALSE;
//        }
//
//        $this->errors = [];
//
//        $user_info = $this->where([['email', $email], ['username', '=', $email, true]] )->get();
//        if (empty($user_info) || !empty($user_info['is_delete'])) {
//            $this->errors[] = lang('text_email_not_found');
//            return false;
//        }
//
//        if (empty($user_info['active'])) {
//            $this->errors[] = lang('text_login_unsuccessful_not_active');
//            return false;
//        }
//
//        // Generate random token: smaller size because it will be in the URL
//        $token = $this->Auth->generate_selector_validator_couple(20, 80);
//        if (empty($token)) {
//            $this->errors[] = lang('error_generate_code');
//            return false;
//        }
//
//        $update = [
//            'forgotten_password_selector' => $token['selector'],
//            'forgotten_password_code'     => $token['validator_hashed'],
//            'forgotten_password_time'     => time()
//        ];
//        $id = $this->update($update, $user_info['id']);
//        if (empty($id)) {
//            return false;
//        }
//
//        $user_info['user_code'] = $token['user_code'];
//
//        return $user_info;
//    }
//
//    public function forgotten_password_check($code)
//    {
//        $this->errors = [];
//
//        if (empty($code)) {
//            $this->errors[] = '[001] ' . lang('error_password_change_unsuccessful');
//            return false;
//        }
//
//        // Retrieve the token object from the code
//        $token = $this->Auth->retrieve_selector_validator_couple($code);
//        if (empty($token)) {
//            $this->errors[] = '[002] ' . lang('error_password_code');
//            return false;
//        }
//
//        // Retrieve the user according to this selector
//        $user = $this->where('forgotten_password_selector', $token['selector'])->get();
//        if (empty($user)) {
//            $this->errors[] = '[003] ' . lang('error_password_code');
//            return FALSE;
//        }
//
//        // Check the hash against the validator
//        if (!$this->Auth->check_password($token['validator'], $user['forgotten_password_code'])) {
//            $this->errors[] = '[004] ' . lang('error_password_change_unsuccessful');
//            return false;
//        }
//
//        if (config_item('forgot_password_expiration') > 0) {
//            //Make sure it isn't expired
//            $expiration = config_item('forgot_password_expiration');
//            if (time() - $user['forgotten_password_time'] > $expiration) {
//                //it has expired, clear_forgotten_password_code
//                $this->clear_forgotten_password_code($user['username']);
//                $this->errors[] = '[005] ' . lang('error_password_code');
//                return FALSE;
//            }
//        }
//
//        return $user;
//    }
//
//    public function clear_forgotten_password_code($username)
//    {
//        if (empty($username)) {
//            return FALSE;
//        }
//
//        $data = [
//            'forgotten_password_selector' => NULL,
//            'forgotten_password_code' => NULL,
//            'forgotten_password_time' => NULL
//        ];
//
//        $this->update($data, ['username' => $username]);
//
//        return TRUE;
//    }
}