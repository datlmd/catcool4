<?php

namespace App\Modules\Customers\Models;

use App\Models\MyModel;
use CodeIgniter\Database\RawSql;

class CustomerModel extends MyModel
{
    protected $table = 'customer';
    protected $primaryKey = 'customer_id';
    protected $allowedFields = [
        'customer_id',
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
        'safe',
        'activation_selector',
        'activation_code',
        'forgotten_password_selector',
        'forgotten_password_code',
        'forgotten_password_time',
        'active',
        'language_id',
        'customer_group_id',
        'store_id',
        'ip',
        'last_login',
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    protected $useSoftDeletes = true;
    protected $deletedField = 'deleted_at';

    protected $auth_model;

    protected $errors;

    public $activation_code;

    public function __construct()
    {
        parent::__construct();

        $this->auth_model = new \App\Modules\Customers\Models\AuthModel();
    }

    public function getAllByFilter($filter = null, $sort = null, $order = null)
    {
        $sort = empty($sort) ? 'customer_id' : $sort;
        $order = empty($order) ? 'DESC' : $order;

        if (!empty($filter['id'])) {
            $this->whereIn('customer_id', (!is_array($filter['id']) ? explode(',', $filter['id']) : $filter['id']));
        }

        if (!empty($filter['name'])) {
            $this->groupStart();
            $this->orLike('username', $filter['name']);
            $this->orLike('first_name', $filter['name']);
            $this->orLike('email', $filter['name']);
            $this->orLike('phone', $filter['name']);
            $this->groupEnd();
        }

        if (!empty($where)) {
            $this->where($where);
        }

        $this->orderBy($sort, $order);

        return $this;
    }

    public function login($username, $password, $remember = false)
    {
        $attempt_model = new LoginAttemptModel();

        $this->errors = [];

        if (empty($username) || empty($password)) {
            $this->errors[] = lang('Customer.text_login_unsuccessful');

            return false;
        }

        $customer_info = $this->where('username', $username)
            ->orWhere('email', $username)
            ->orWhere('phone', $username)
            ->first();
        if (empty($customer_info)) {
            $this->errors[] = lang('Customer.error_login_account_not_exist');

            return false;
        }

        if ($attempt_model->isMaxLoginAttemptsExceeded($customer_info['customer_id'])) {
            $this->errors[] = lang('Customer.text_login_timeout');
            $this->errors[] = lang('Customer.error_attempts', [config_item('lockout_time') / 60]);

            return false;
        }

        if (empty($customer_info['active'])) {
            $this->errors[] = lang('Customer.text_login_unsuccessful_not_active');

            return false;
        }

        if (!$this->auth_model->checkPassword($password, $customer_info['password'])) {
            $attempt_model->increaseLoginAttempts($customer_info['customer_id']);

            $this->errors[] = lang('Customer.error_login_password_incorrect');

            $total_attempt = $attempt_model->getRemainingAttempts($customer_info['customer_id']);
            if ($total_attempt > 0 && $total_attempt < 3) {
                $this->errors[] = lang('Customer.error_attempt_time', [$total_attempt]);
            }

            return false;
        }

        $this->auth_model->setSession($customer_info);

        $data_login = [];
        //check remember login
        if ($remember) {
            // Generate random tokens
            $token = $this->auth_model->generateSelectorValidatorCouple();
            if (!empty($token['validator_hashed'])) {
                $this->auth_model->setCookie($token);

                $token_model = new TokenModel();
                $token_model->addToken($customer_info['customer_id'], $token);
            }
        }

        //xoa forgotten pass neu login thanh cong
        $data_login['forgotten_password_selector'] = null;
        $data_login['forgotten_password_code'] = null;
        $data_login['forgotten_password_time'] = null;
        $data_login['last_login'] = time(); // last login
        $data_login['ip'] = service('request')->getIPAddress();

        $this->update($customer_info['customer_id'], $data_login);

        //Clear attemt
        $attempt_model->clearLoginAttempts($customer_info['customer_id']);

        return true;
    }

    public function loginRememberedCustomer()
    {
        $this->errors = [];

        $token_model = new TokenModel();

        $remember_cookie = $this->auth_model->getCookie();
        $token = $this->auth_model->retrieveSelectorValidatorCouple($remember_cookie);

        if (!$token) {
            $this->errors[] = lang('Customer.text_login_unsuccessful');

            return false;
        }

        $customer_token = $token_model->where(['remember_selector' => $token['selector']])->first();
        if (empty($customer_token)) {
            $this->errors[] = lang('Customer.text_login_unsuccessful');

            return false;
        }

        $customer_info = $this->where(['customer_id' => $customer_token['customer_id']])->first();
        if (empty($customer_info)) {
            $this->errors[] = lang('Customer.text_login_unsuccessful');

            return false;
        }

        if (empty($customer_info['active'])) {
            $this->errors[] = lang('Customer.text_login_unsuccessful_not_active');

            return false;
        }

        if ($this->auth_model->checkPassword($token['validator'], $customer_token['remember_code']) === false) {
            $this->errors[] = lang('Customer.text_login_unsuccessful');

            return false;
        }

        $this->auth_model->setSession($customer_info);

        //xoa forgotten pass neu login thanh cong
        $data_login = [
            'forgotten_password_selector' => null,
            'forgotten_password_code' => null,
            'forgotten_password_time' => null,
            'last_login' => time(), // last login
            'ip' => service('request')->getIPAddress(),
        ];
        $this->update($customer_info['customer_id'], $data_login);

        return true;
    }

    public function loginSocial($social_type, $data)
    {
        if (empty($data) || empty($data['id'])) {
            return false;
        }

        $social_model = new LoginSocial();

        $this->errors = [];

        //check gender
        $gender = $data['gender'] ?? null;
        if ($gender == 'male') {
            $gender = GENDER_MALE;
        } elseif ($gender == 'female') {
            $gender = GENDER_FEMALE;
        } else {
            $gender = GENDER_OTHER;
        }
        $data['gender'] = $gender; //unisex

        $social_info = $social_model->where(['social_id' => $data['id'], 'type' => $social_type])->first();
        if (empty($social_info)) {
            $email = $data['email'] ?? null;

            $customer_info = [
                'email' => strtolower($email),
                'first_name' => $data['first_name'] ?? null,
                'last_name' => $data['last_name'] ?? null,
                'phone' => $data['last_name'] ?? null,
                'gender' => $data['gender'],
                'active' => STATUS_ON,
                'dob' => $data['dob'] ?? null,
                'ip' => service('request')->getIPAddress(),
            ];

            if (!empty($data['image'])) {
                //save image to local
                $customer_info['image'] = $data['image'];
            }

            $customer_id = $this->insert($customer_info);
            $customer_info['customer_id'] = $customer_id;

            $social_info = [
                'social_id' => $data['id'],
                'customer_id' => $customer_id,
                'type' => $social_type,
                'access_token' => $data['access_token'] ?? null,
            ];
            $social_model->insert($social_info);
        } else {
            //xoa forgotten pass neu login thanh cong
            $data_login = [
                'forgotten_password_selector' => null,
                'forgotten_password_code' => null,
                'forgotten_password_time' => null,
                'last_login' => time(), // last login
                'ip' => service('request')->getIPAddress(),
            ];
            $this->update($social_info['customer_id'], $data_login);

            $social_model->update($data['id'], ['access_token' => $data['access_token'] ?? null]);
        }

        if (empty($customer_info)) {
            $customer_info = $this->where('customer_id', $social_info['customer_id'])->first();
        }

        $customer_info['access_token'] = $data['access_token'];

        $this->auth_model->setSession($customer_info);

        return true;
    }

    public function logout()
    {
        $customer_id = $this->auth_model->getCustomerId();
        if (empty($customer_id)) {
            return false;
        }

        $remember_cookie = $this->auth_model->getCookie();
        $token = $this->auth_model->retrieveSelectorValidatorCouple($remember_cookie);

        $token_model = new TokenModel();
        $token_model->deleteToken($token);

        $this->auth_model->clearSession();
        $this->auth_model->deleteCookie();

        // Clear all codes
        $data_logout = [
            'forgotten_password_selector' => null,
            'forgotten_password_code' => null,
            'forgotten_password_time' => null,
        ];

        $this->update($customer_id, $data_logout);

        return true;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function getAvatar($avatar = '')
    {
        $avatar = empty($avatar) ? 'customers/' . session('customer.customer_id') . '.jpg' : $avatar;
        if (!is_file(get_upload_path($avatar))) {
            return (session('customer.gender') == GENDER_MALE) ? base_url('common/' . config_item('avatar_default_male')) : base_url('common/' . config_item('avatar_default_female'));
        }

        return $avatar;
    }

    public function getCustomerInfo($customer_id)
    {
        if (empty($customer_id)) {
            return null;
        }

        return $this->where(['customer_id' => $customer_id, 'active' => STATUS_ON])->first();
    }

    public function forgotPassword($email)
    {
        if (empty($email)) {
            return false;
        }

        $this->errors = [];

        $customer_info = $this->where('email', $email)->orWhere('username', $email)->first();
        if (empty($customer_info)) {
            $this->errors[] = lang('Customer.text_email_not_found');

            return false;
        }

        if (empty($customer_info['active'])) {
            $this->errors[] = lang('Customer.text_login_unsuccessful_not_active');

            return false;
        }

        // Generate random token: smaller size because it will be in the URL
        $token = $this->auth_model->generateSelectorValidatorCouple(20, 80);
        if (empty($token)) {
            $this->errors[] = lang('Customer.error_generate_code');

            return false;
        }

        $update = [
            'forgotten_password_selector' => $token['selector'],
            'forgotten_password_code' => $token['validator_hashed'],
            'forgotten_password_time' => time(),
        ];
        $id = $this->update($customer_info['customer_id'], $update);
        if (empty($id)) {
            return false;
        }

        $customer_info['user_code'] = $token['user_code'];

        //call event
        \CodeIgniter\Events\Events::trigger('post_account_forgotten_mail', $customer_info);

        return $customer_info;
    }

    public function checkForgottenPassword($code)
    {
        $this->errors = [];

        if (empty($code)) {
            $this->errors[] = '[001] ' . lang('Customer.error_password_change_unsuccessful');

            return false;
        }

        // Retrieve the token object from the code
        $token = $this->auth_model->retrieveSelectorValidatorCouple($code);
        if (empty($token)) {
            $this->errors[] = '[002] ' . lang('Customer.error_password_code');

            return false;
        }

        // Retrieve the user according to this selector
        $customer_info = $this->where('forgotten_password_selector', $token['selector'])->first();
        if (empty($customer_info)) {
            $this->errors[] = '[003] ' . lang('Customer.error_password_code');

            return false;
        }

        // Check the hash against the validator
        if (!$this->auth_model->checkPassword($token['validator'], $customer_info['forgotten_password_code'])) {
            $this->errors[] = '[004] ' . lang('Customer.error_password_change_unsuccessful');

            return false;
        }

        if (config_item('forgot_password_expiration') > 0) {
            //Make sure it isn't expired
            $expiration = config_item('forgot_password_expiration');
            if (time() - $customer_info['forgotten_password_time'] > $expiration) {
                //it has expired, clear_forgotten_password_code
                $this->clearForgottenPasswordCode($customer_info['customer_id']);
                $this->errors[] = '[005] ' . lang('error_password_code');

                return false;
            }
        }

        return $customer_info;
    }

    public function clearForgottenPasswordCode($customer_id)
    {
        if (empty($customer_id)) {
            return false;
        }

        $data = [
            'forgotten_password_selector' => null,
            'forgotten_password_code' => null,
            'forgotten_password_time' => null,
        ];

        $this->update($customer_id, $data);

        return true;
    }

    public function editPassword($customer_id, $password)
    {
        if (empty($customer_id) || empty($password)) {
            return false;
        }

        $data = [
            'password' => $this->auth_model->hashPassword($password),
            'forgotten_password_selector' => null,
            'forgotten_password_code' => null,
            'forgotten_password_time' => null,
        ];

        $this->update($customer_id, $data);

        return true;
    }

    public function addCustomer($data)
    {
        if (empty($data) || empty($data['password'])) {
            return false;
        }

        $this->errors = [];
        $email = $data['email'] ?? null;
        $phone = $data['phone'] ?? null;

        $sql = [];

        if (!empty($email)) {
            $sql[] = ' email=' . $this->db->escape($email) . ' ';
        }

        if (!empty($phone)) {
            $sql[] = " phone=$phone ";
        }

        $customer_info = $this->where(new RawSql(implode('OR', $sql)))->first();

        if (!empty($customer_info)) {
            if (!empty($customer_info['email'])) {
                $this->errors[] = lang('Customer.account_creation_duplicate_email');
            }

            if (!empty($customer_info['phone'])) {
                $this->errors[] = lang('Customer.account_creation_duplicate_phone');
            }

            return false;
        }

        $customer_group_model = new GroupModel();
        $customer_group_list = $customer_group_model->getCustomerGroups(language_id());

        if (empty($data['customer_group_id']) || empty(config_item('customer_group_display')) || empty($customer_group_list[$data['customer_group_id']])) {
            $data['customer_group_id'] = config_item('customer_group_id');
        }

        $customer_group_info = $customer_group_list[$data['customer_group_id']];

        $add_data = [
            'customer_group_id' => $data['customer_group_id'],
            'username' => $data['username'] ?? null,
            'email' => strtolower($email),
            'password' => $this->auth_model->hashPassword($data['password']),
            'first_name' => $data['first_name'] ?? null,
            'last_name' => $data['last_name'] ?? null,
            'phone' => $phone,
            'newsletter' => $data['newsletter'] ?? STATUS_OFF,
            'gender' => $data['gender'],
            'address_id' => $data['address_id'] ?? null,
            'ip' => $data['ip'] ?? null,
            'active' => (int) !$customer_group_info['approval'],
        ];

        if (!empty($data['dob'])) {
            $add_data['dob'] = standar_date($data['dob']);
        }

        $customer_id = $this->insert($add_data);
        if (empty($customer_id)) {
            return false;
        }

        if ($customer_group_info['approval']) {
            $customer_group_model = new CustomerApprovalModel();
            $customer_group_model->insert(['customer_id' => $customer_id, 'type' => 'customer']);
        }

        $add_data['customer_id'] = $customer_id;
        $add_data['approval'] = $customer_group_info['approval'];
        $add_data['customer_group'] = $customer_group_info['name'];

        //call event
        \CodeIgniter\Events\Events::trigger('post_account_register_mail', $add_data);
        \CodeIgniter\Events\Events::trigger('post_account_register_mail_alert', $add_data);

        return $add_data;
    }

    public function editCustomer($customer_id, $data)
    {
        if (empty($data)) {
            return false;
        }

        $edit_data = [
            'customer_group_id' => $data['customer_group_id'],
            //'username' => $data['username'] ?? null,
            'email' => strtolower($data['email']),
            'first_name' => $data['first_name'] ?? null,
            'last_name' => $data['last_name'] ?? null,
            'phone' => $data['phone'],
            'gender' => $data['gender'],
        ];

        if (!empty($data['dob'])) {
            $edit_data['dob'] = standar_date($data['dob']);
        }


        return $this->update($customer_id, $edit_data);
    }

    public function editNewsletter($customer_id, $newsletter = false)
    {
        if (empty($customer_id)) {
            return false;
        }

        return $this->update($customer_id, ['newsletter' => $newsletter]);
    }

    public function deactivate($customer_id)
    {
        if (empty($customer_id)) {
            return false;
        }

        $token = $this->auth_model->generateSelectorValidatorCouple(20, 40);
        if (empty($token)) {
            $this->errors[] = lang('Customer.error_generate_code');

            return false;
        }

        $this->activation_code = $token['user_code'];

        $update = [
            'activation_selector' => $token['selector'],
            'activation_code' => $token['validator_hashed'],
            'active' => STATUS_OFF,
        ];

        $this->update($customer_id, $update);

        return true;
    }

    public function activate($customer_id, $code)
    {
        if (empty($customer_id) || empty($code)) {
            return false;
        }

        $customer_info = $this->find($customer_id);
        if (!empty($customer_info) && !empty($customer_info['active'])) {
            $this->errors[] = lang('Customer.activate_successful');

            return false;
        }

        $token = $this->auth_model->retrieveSelectorValidatorCouple($code);
        if (empty($token)) {
            $this->errors[] = lang('Customer.error_password_code');

            return false;
        }

        $customer_info = $this->where('activation_selector', $token['selector'])->first();
        if (empty($customer_info) || $customer_info['customer_id'] != $customer_id) {
            $this->errors[] = lang('Customer.activate_unsuccessful');

            return false;
        }

        $update = [
            'activation_selector' => null,
            'activation_code' => null,
            'active' => STATUS_ON,
        ];

        $this->update($customer_id, $update);

        return true;
    }
}
