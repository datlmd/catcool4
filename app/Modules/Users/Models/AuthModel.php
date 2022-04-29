<?php namespace App\Modules\Users\Models;

use App\Models\MyModel;

class AuthModel extends MyModel
{
    /**
     * Max cookie lifetime constant
     */
    const MAX_COOKIE_LIFETIME = 63072000; // 2 years = 60*60*24*365*2 = 63072000 seconds;

    /**
     * Max password size constant
     */
    const MAX_PASSWORD_SIZE_BYTES = 4096;

    function __construct()
    {
        parent::__construct();

    }

    public function generateSelectorValidatorCouple($selector_size = 40, $validator_size = 128)
    {
        // The selector is a simple token to retrieve the user
        $selector = $this->_randomToken($selector_size);

        // The validator will strictly validate the user and should be more complex
        $validator = $this->_randomToken($validator_size);

        // The validator is hashed for storing in DB (avoid session stealing in case of DB leaked)
        $validator_hashed = $this->hashPassword($validator);

        // The code to be used user-side
        $user_code = "$selector.$validator";

        return [
            'selector' => $selector,
            'validator_hashed' => $validator_hashed,
            'user_code' => $user_code,
        ];
    }

    public function retrieveSelectorValidatorCouple($user_code)
    {
        // Check code
        if ($user_code)
        {
            $tokens = explode('.', $user_code);

            // Check tokens
            if (count($tokens) === 2) {
                return [
                    'selector' => $tokens[0],
                    'validator' => $tokens[1]
                ];
            }
        }

        return FALSE;
    }

    protected function _randomToken($result_length = 32)
    {
        if(!isset($result_length) || intval($result_length) <= 8 ){
            $result_length = 32;
        }

        // Try random_bytes: PHP 7
        if (function_exists('random_bytes')) {
            return bin2hex(random_bytes($result_length / 2));
        }

        // Try mcrypt
        if (function_exists('mcrypt_create_iv')) {
            return bin2hex(mcrypt_create_iv($result_length / 2, MCRYPT_DEV_URANDOM));
        }

        // Try openssl
        if (function_exists('openssl_random_pseudo_bytes')) {
            return bin2hex(openssl_random_pseudo_bytes($result_length / 2));
        }

        // No luck!
        return FALSE;
    }

    public function hashPassword($password)
    {
        return password_hash(md5($password) . md5(config_item('catcool_hash')), PASSWORD_DEFAULT, ['cost' => 12]);
    }

    public function checkPassword($password, $password_db)
    {
        if (empty($password) || empty($password_db) || strpos($password, "\0") !== FALSE
            || strlen($password) > self::MAX_PASSWORD_SIZE_BYTES)
        {
            return FALSE;
        }

        return password_verify(md5($password) . md5(config_item('catcool_hash')), $password_db);
    }

    public function setSession($user_info, $is_check_admin = false)
    {
        if (empty($user_info)) {
            return false;
        }

        $session_data = [
            'username'       => $user_info['username'] ?? null,
            'user_email'     => $user_info['email'] ?? null,
            'user_id'        => $user_info['id'], //everyone likes to overwrite id so we'll use user_id
            'user_gender'    => $user_info['gender'] ?? null,
            'full_name'      => full_name($user_info['first_name'], $user_info['last_name']),
            'old_last_login' => $user_info['last_login'] ?? null,
            'super_admin'    => false,
            'last_login'     => time(),
            'is_admin'       => false,
            'super_admin'    => false,
        ];
        if ($is_check_admin) {
            $session_data['is_admin'] = true;
            if (isset($user_info['super_admin']) && $user_info['super_admin'] == true) {
                $session_data['super_admin'] = TRUE;
            }

            session()->set(['admin' => $session_data]);
            return true;
        }

        session()->set(['user' => $session_data]);
        return true;
    }

    public function getUserId()
    {
        return session('user.user_id');
    }

    public function getUserIdAdmin()
    {
        return session('admin.user_id');
    }

    public function clearSession($is_admin = false)
    {
        if ($is_admin) {
            session()->remove(['admin']);
        } else {
            session()->remove(['user']);
        }

        // Destroy the session
        //session()->destroy();
    }

    public function setCookie($token, $is_admin = false)
    {
        if (empty($token)) {
            return false;
        }

        $expire = empty(config_item('user_expire')) ? self::MAX_COOKIE_LIFETIME : config_item('user_expire');
        $cookie_config = [
            'name'   => $this->_getNameCookie($is_admin),
            'value'  => $token['user_code'],
            'expire' => $expire,
            'domain' => '',
            'path'   => '/',
            'prefix' => '',
            'secure' => false
        ];

        $response = \Config\Services::response();
        $response->setCookie($cookie_config)->send();
        //set_cookie(config_item('remember_cookie_name'), $token['user_code'], $expire, site_url(), '/');
    }

    public function getCookie($is_admin = false)
    {
        return get_cookie($this->_getNameCookie($is_admin));
    }

    public function deleteCookie($is_admin = false)
    {
        // delete the remember me cookies if they exist
        $response = \Config\Services::response();
        $response->deleteCookie($this->_getNameCookie($is_admin))->send();
        //delete_cookie(config_item('remember_cookie_name'));
    }

    private function _getNameCookie($is_admin = false)
    {
        if ($is_admin) {
            return config_item('remember_cookie_name') . '_admin';
        }

        return config_item('remember_cookie_name');
    }
}
