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
        'deleted',
        'language',
        'user_ip',
        'ctime',
        'mtime'
    ];

    protected $useSoftDeletes = true;
    protected $deletedField   = 'deleted';

    //protected $with = ['user_groups', 'user_permissions'];

    protected $auth_model;

    protected $errors;

    function __construct()
    {
        parent::__construct();

        $this->auth_model = new \App\Modules\Users\Models\AuthModel();
    }

    public function getAllByFilter($filter = null, $sort = null, $order = null)
    {
        $sort  = empty($sort) ? 'id' : $sort;
        $order = empty($order) ? 'DESC' : $order;

        if (!empty($filter["id"])) {
            $this->whereIn('id', (!is_array($filter["id"]) ? explode(',', $filter["id"]) : $filter["id"]));
        }

        if (!empty($filter["name"])) {
            $this->groupStart();
            $this->orLike('username', $filter["name"]);
            $this->orLike('first_name', $filter["name"]);
            $this->orLike('email', $filter["name"]);
            $this->orLike('phone', $filter["name"]);
            $this->groupEnd();
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
//            $return = $this->update(['is_deleted' => STATUS_ON], $id);
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
    public function login($username, $password, $remember = FALSE)
    {
        $this->errors = [];

        if (empty($username) || empty($password)) {
            $this->errors[] = lang('User.text_login_unsuccessful');
            return FALSE;
        }

        $user_info = $this->where(['username' => $username])->first();
        if (empty($user_info)) {
            $this->errors[] = lang('User.text_login_unsuccessful');

            return FALSE;
        }

        if (empty($user_info['active'])) {
            $this->errors[] = lang('User.text_login_unsuccessful_not_active');
            return FALSE;
        }

        if ($this->auth_model->checkPassword($password, $user_info['password']) === FALSE) {
            $this->errors[] = lang('User.text_login_unsuccessful');
            return FALSE;
        }

        $this->auth_model->setSession($user_info, true);

        $data_login = [];
        //check remember login
        if ($remember) {
            // Generate random tokens
            $token = $this->auth_model->generateSelectorValidatorCouple();
            if (!empty($token['validator_hashed'])) {
                $this->auth_model->setCookie($token, true);

                $user_token_model = new UserTokenModel();
                $user_token_model->addToken($user_info['id'], $token);
            }
        }

        //xoa forgotten pass neu login thanh cong
        $data_login['forgotten_password_selector'] = NULL;
        $data_login['forgotten_password_code']     = NULL;
        $data_login['forgotten_password_time']     = NULL;
        $data_login['last_login']                  = time(); // last login

        $this->update($user_info['id'], $data_login);

        return TRUE;
    }

    public function loginRememberedUser()
    {
        $this->errors = [];

        $user_token_model = new UserTokenModel();

        $remember_cookie = $this->auth_model->getCookie(true);
        $token           = $this->auth_model->retrieveSelectorValidatorCouple($remember_cookie);

        if ($token === FALSE) {
            $this->errors[] = lang('User.text_login_unsuccessful');
            return FALSE;
        }

        $user_token = $user_token_model->where(['remember_selector' => $token['selector']])->first();
        if (empty($user_token)) {
            $this->errors[] = lang('User.text_login_unsuccessful');
            return FALSE;
        }

        $user_info = $this->where(['id' => $user_token['user_id']])->first();
        if (empty($user_info)) {
            $this->errors[] = lang('User.text_login_unsuccessful');
            return FALSE;
        }

        if (empty($user_info['active'])) {
            $this->errors[] = lang('User.text_login_unsuccessful_not_active');
            return FALSE;
        }

        if ($this->auth_model->checkPassword($token['validator'], $user_token['remember_code']) === FALSE) {
            $this->errors[] = lang('User.text_login_unsuccessful');
            return FALSE;
        }

        $this->auth_model->setSession($user_info, true);

        //xoa forgotten pass neu login thanh cong
        $data_login = [
            'forgotten_password_selector' => NULL,
            'forgotten_password_code'     => NULL,
            'forgotten_password_time'     => NULL,
            'last_login'                  => time(), // last login
        ];
        $this->update($user_info['id'], $data_login);

        return TRUE;
    }

    public function logout()
    {
        $user_id = $this->auth_model->getUserIdAdmin();
        if (empty($user_id)) {
            return FALSE;
        }

        $remember_cookie = $this->auth_model->getCookie(true);
        $token           = $this->auth_model->retrieveSelectorValidatorCouple($remember_cookie);

        $user_token_model = new UserTokenModel();
        $user_token_model->deleteToken($token);

        $this->auth_model->clearSession(true);
        $this->auth_model->deleteCookie(true);

        // Clear all codes
        $data_logout = [
            'forgotten_password_selector' => NULL,
            'forgotten_password_code'     => NULL,
            'forgotten_password_time'     => NULL,
        ];

        $this->update($user_id, $data_logout);

        return TRUE;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function getUserInfo($user_id)
    {
        if (empty($user_id)) {
            return null;
        }

        return $this->find($user_id);
    }

    public function forgotPassword($email)
    {
        if (empty($email)) {
            return false;
        }

        $this->errors = [];

        $user_info = $this->where('email', $email)->orWhere('username', $email)->first();
        if (empty($user_info)) {
            $this->errors[] = lang('UserAdmin.text_email_not_found');
            return false;
        }

        if (empty($user_info['active'])) {
            $this->errors[] = lang('User.text_login_unsuccessful_not_active');
            return false;
        }

        // Generate random token: smaller size because it will be in the URL
        $token = $this->auth_model->generateSelectorValidatorCouple(20, 80);
        if (empty($token)) {
            $this->errors[] = lang('User.error_generate_code');
            return false;
        }

        $update = [
            'forgotten_password_selector' => $token['selector'],
            'forgotten_password_code'     => $token['validator_hashed'],
            'forgotten_password_time'     => time()
        ];
        $id = $this->update($user_info['id'], $update);
        if (empty($id)) {
            return false;
        }

        $user_info['user_code'] = $token['user_code'];

        return $user_info;
    }

    public function checkForgottenPassword($code)
    {
        $this->errors = [];

        if (empty($code)) {
            $this->errors[] = '[001] ' . lang('UserAdmin.error_password_change_unsuccessful');
            return false;
        }

        // Retrieve the token object from the code
        $token = $this->auth_model->retrieveSelectorValidatorCouple($code);
        if (empty($token)) {
            $this->errors[] = '[002] ' . lang('User.error_password_code');
            return false;
        }

        // Retrieve the user according to this selector
        $user = $this->where('forgotten_password_selector', $token['selector'])->first();
        if (empty($user)) {
            $this->errors[] = '[003] ' . lang('User.error_password_code');
            return FALSE;
        }

        // Check the hash against the validator
        if (!$this->auth_model->checkPassword($token['validator'], $user['forgotten_password_code'])) {
            $this->errors[] = '[004] ' . lang('UserAdmin.error_password_change_unsuccessful');
            return false;
        }

        if (config_item('forgotPasswordExpiration') > 0) {
            //Make sure it isn't expired
            $expiration = config_item('forgotPasswordExpiration');
            if (time() - $user['forgotten_password_time'] > $expiration) {
                //it has expired, clear_forgotten_password_code
                $this->clearForgottenPasswordCode($user['id']);
                $this->errors[] = '[005] ' . lang('error_password_code');
                return FALSE;
            }
        }

        return $user;
    }

    public function clearForgottenPasswordCode($user_id)
    {
        if (empty($user_id)) {
            return FALSE;
        }

        $data = [
            'forgotten_password_selector' => NULL,
            'forgotten_password_code' => NULL,
            'forgotten_password_time' => NULL
        ];

        $this->update($user_id, $data);

        return TRUE;
    }
}
