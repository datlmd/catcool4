<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Model
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

    public function generate_selector_validator_couple($selector_size = 40, $validator_size = 128)
    {
        // The selector is a simple token to retrieve the user
        $selector = $this->_random_token($selector_size);

        // The validator will strictly validate the user and should be more complex
        $validator = $this->_random_token($validator_size);

        // The validator is hashed for storing in DB (avoid session stealing in case of DB leaked)
        $validator_hashed = $this->hash_password($validator);

        // The code to be used user-side
        $user_code = "$selector.$validator";

        return [
            'selector' => $selector,
            'validator_hashed' => $validator_hashed,
            'user_code' => $user_code,
        ];
    }

    public function retrieve_selector_validator_couple($user_code)
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

    protected function _random_token($result_length = 32)
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

    public function hash_password($password)
    {
        return password_hash(md5($password) . md5(config_item('catcool_hash')), PASSWORD_DEFAULT, ['cost' => 12]);
    }

    public function check_password($password, $password_db)
    {
        if (empty($password) || empty($password_db) || strpos($password, "\0") !== FALSE
            || strlen($password) > self::MAX_PASSWORD_SIZE_BYTES)
        {
            return FALSE;
        }

        return password_verify(md5($password) . md5(config_item('catcool_hash')), $password_db);
    }

    public function set_session($user_info, $is_check_admin = false)
    {
        if (empty($user_info)) {
            return false;
        }

        $session_data = [
            'username'       => $user_info['username'],
            'user_email'     => $user_info['email'],
            'user_id'        => $user_info['id'], //everyone likes to overwrite id so we'll use user_id
            'user_gender'    => $user_info['gender'],
            'full_name'      => empty($user_info['last_name']) ? $user_info['first_name'] : $user_info['first_name'] . ' ' . $user_info['last_name'],
            'old_last_login' => $user_info['last_login'],
            'last_login'     => time(),
        ];
        if ($is_check_admin) {
            $session_data['is_admin'] = true;
            if (isset($user_info['super_admin']) && $user_info['super_admin'] == true) {
                $session_data['super_admin'] = TRUE;
            }
        }

        $this->session->set_userdata($session_data);
    }

    public function get_user_id()
    {
        return $this->session->userdata('user_id');
    }

    public function clear_session()
    {
        $this->session->unset_userdata(['username', 'user_id']);

        // Destroy the session
        $this->session->sess_destroy();
    }

    public function set_cookie($token)
    {
        if (empty($token)) {
            return false;
        }

        $cookie_config = array(
            'name' => config_item('remember_cookie_name'),
            'value' => $token['user_code'],
            'expire' => (config_item('user_expire') === 0) ? self::MAX_COOKIE_LIFETIME : config_item('user_expire'),
            'domain' => '',
            'path' => '/',
            'prefix' => '',
            'secure' => FALSE
        );

        set_cookie($cookie_config);
    }

    public function get_cookie()
    {
        return get_cookie(config_item('remember_cookie_name'));
    }

    public function delete_cookie()
    {
        // delete the remember me cookies if they exist
        delete_cookie(config_item('remember_cookie_name'));
    }
}
