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
        'fax',
        'address_id',
        'dob',
        'gender',
        'image',
        'salt',
        'cart',
        'wishlist',
        'newsletter',
        'custom_field',
        'status',
        'safe',
        'activation_selector',
        'activation_code',
        'forgotten_password_selector',
        'forgotten_password_code',
        'forgotten_password_time',
        'last_login',
        'active',
        'deleted',
        'language_id',
        'group_id',
        'store_id',
        'ip',
        'ctime',
        'mtime'
    ];

    protected $useSoftDeletes = true;
    protected $deletedField   = 'deleted';

    protected $auth_model;

    protected $errors;

    public $activation_code;

    function __construct()
    {
        parent::__construct();

        $this->auth_model = new AuthModel();
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

    public function login($username, $password, $remember = FALSE)
    {
        $attempt_model = new UserLoginAttemptModel();

        $this->errors = [];

        if (empty($username) || empty($password)) {
            $this->errors[] = lang('User.text_login_unsuccessful');
            return FALSE;
        }

        $user_info = $this->where('username', $username)
            ->orWhere('email', $username)
            ->orWhere('phone', $username)
            ->first();
        if (empty($user_info)) {
            $this->errors[] = lang('User.error_login_account_not_exist');
            return FALSE;
        }

        if ($attempt_model->isMaxLoginAttemptsExceeded($user_info['id'])) {
            $this->errors[] = lang('User.text_login_timeout');

            return FALSE;
        }

        if (empty($user_info['active'])) {
            $this->errors[] = lang('User.text_login_unsuccessful_not_active');
            return FALSE;
        }

        if ($this->auth_model->checkPassword($password, $user_info['password']) === FALSE) {
            $attempt_model->increaseLoginAttempts($user_info['id']);

            $this->errors[] = lang('User.error_login_password_incorrect');
            return FALSE;
        }

        $this->auth_model->setSession($user_info);

        $data_login = [];
        //check remember login
        if ($remember) {
            // Generate random tokens
            $token = $this->auth_model->generateSelectorValidatorCouple();
            if (!empty($token['validator_hashed'])) {
                $this->auth_model->setCookie($token);

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

        //Clear attemt
        $attempt_model->clearLoginAttempts($user_info['id']);

        return TRUE;
    }

    public function loginRememberedUser()
    {
        $this->errors = [];

        $user_token_model = new UserTokenModel();

        $remember_cookie = $this->auth_model->getCookie();
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

        $this->auth_model->setSession($user_info);

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

    public function loginSocial($social_type, $data)
    {
        if (empty($data) || empty($data['id'])) {
            return false;
        }

        $social_model = new UserLoginSocial();

        $this->errors = [];

        $social_info = $social_model->where(['social_id' => $data['id'], 'type' => $social_type])->first();
        if (empty($social_info)) {
            $email = $data['email'] ?? null;

            $user_info = [
                'email'      => strtolower($email),
                'first_name' => $data['first_name'] ?? null,
                'last_name'  => $data['last_name'] ?? null,
                'phone'      => $data['last_name'] ?? null,
                'gender'     => $data['gender'] ?? null,
                'active'     => STATUS_ON,
                'dob'        => $data['dob'] ?? null,
                'ip'         => get_client_ip(),
            ];

            if (!empty($data['image'])) {
                //save image to local
                $user_info['image'] = $data['image'];
            }

            $user_id         = $this->insert($user_info);
            $user_info['id'] = $user_id;

            $social_info = [
                'social_id'    => $data['id'],
                'user_id'      => $user_id,
                'type'         => $social_type,
                'access_token' => $data['access_token'] ?? null,
            ];
            $social_model->insert($social_info);
        }


        if (empty($user_info)) {
            $user_info = $this->where('id', $social_info['user_id'])->first();
        }

        $this->auth_model->setSession($user_info);

        return true;
    }

    public function logout()
    {
        $user_id = $this->auth_model->getUserId();
        if (empty($user_id)) {
            return FALSE;
        }

        $remember_cookie = $this->auth_model->getCookie();
        $token           = $this->auth_model->retrieveSelectorValidatorCouple($remember_cookie);

        $user_token_model = new UserTokenModel();
        $user_token_model->deleteToken($token);

        $this->auth_model->clearSession();
        $this->auth_model->deleteCookie();

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

        if (config_item('forgot_password_expiration') > 0) {
            //Make sure it isn't expired
            $expiration = config_item('forgot_password_expiration');
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

    public function register($data)
    {
        if (empty($data) || empty($data['identity']) || empty($data['password'])) {
            return false;
        }

        $this->errors = [];
        $identity     = '';
        $email        = $data['email'] ?? null;
        $phone        = $data['phone'] ?? null;

        if (filter_var($data['identity'], FILTER_VALIDATE_EMAIL)) {
            $identity = 'email';
            $email    = $data['identity'];
        } elseif (filter_var($data['identity'], FILTER_SANITIZE_NUMBER_INT)) {
            $phone_to_check = str_replace("-", "", $data['identity']);

            if (strlen($phone_to_check) < 10 || strlen($phone_to_check) > 14) {

            }

            $identity = 'phone';
            $phone    = $data['identity'];
        }

        $user_info = $this->where($identity, $data['identity'])->first();
        if (!empty($user_info)) {
            $this->errors[] = lang("User.account_creation_duplicate_$identity");
            return false;
        }


        $add_data = [
            $identity    => $data['identity'],
            'username'   => $data['username'] ?? null,
            'email'      => strtolower($email),
            'password'   => $this->auth_model->hashPassword($data['password']),
            'first_name' => $data['first_name'] ?? null,
            'last_name'  => $data['last_name'] ?? null,
            'phone'      => $phone,
            'gender'     => $data['gender'],
            'address_id' => $data['address_id'] ?? null,
            'active'     => config_item('manual_activation'),
            'ip'         => $data['ip'] ?? null,
        ];

        if (!empty($data['dob'])) {
            $add_data['dob'] = standar_date($data['dob']);
        }

        $id = $this->insert($add_data);

        $add_data['id'] = $id;

        return (!empty($id)) ? $add_data : false;
    }

    public function deactivate($user_id)
    {
        if (empty($user_id)) {
            return FALSE;
        }

        $token = $this->auth_model->generateSelectorValidatorCouple(20, 40);
        if (empty($token)) {
            $this->errors[] = lang('User.error_generate_code');
            return false;
        }

        $this->activation_code = $token['user_code'];

        $update = [
            'activation_selector' => $token['selector'],
            'activation_code'     => $token['validator_hashed'],
            'active'              => STATUS_OFF
        ];

        $this->update($user_id, $update);

        return TRUE;
    }

    public function activate($user_id, $code)
    {
        if (empty($user_id) || empty($code)) {
            return false;
        }

        $user_info = $this->find($user_id);
        if (!empty($user_info) && !empty($user_info['active'])) {
            $this->errors[] = lang('User.activate_successful');
            return false;
        }

        $token = $this->auth_model->retrieveSelectorValidatorCouple($code);
        if (empty($token)) {
            $this->errors[] = lang('User.error_password_code');
            return false;
        }

        $user_info = $this->where('activation_selector', $token['selector'])->first();
        if (empty($user_info) || $user_info['id'] != $user_id) {
            $this->errors[] = lang('User.activate_unsuccessful');
            return false;
        }


        $update = [
            'activation_selector' => null,
            'activation_code'     => null,
            'active'              => STATUS_ON
        ];

        $this->update($user_id, $update);

        return true;
    }
}
