<?php namespace App\Modules\Users\Models;

use App\Models\MyAuthModel;

class AuthModel extends MyAuthModel
{
    function __construct()
    {
        parent::__construct();
    }

    public function setSession($user_info)
    {
        if (empty($user_info)) {
            return false;
        }

        $session_data = [
            'username'       => $user_info['username'] ?? null,
            'user_email'     => $user_info['email'] ?? null,
            'user_id'        => $user_info['user_id'], //everyone likes to overwrite id so we'll use user_id
            'user_gender'    => $user_info['gender'] ?? null,
            'full_name'      => full_name($user_info['first_name'], $user_info['last_name']),
            'old_last_login' => $user_info['last_login'] ?? null,
            'super_admin'    => false,
            'last_login'     => time(),
            'is_admin'       => true,
            'super_admin'    => false,
        ];

        if (isset($user_info['super_admin']) && $user_info['super_admin'] == true) {
            $session_data['super_admin'] = TRUE;
        }

        session()->set(['user_info' => $session_data]);

        return true;
    }

    public function getUserId()
    {
        return session('user_info.user_id');
    }

    public function clearSession()
    {
        session()->remove([
            'user_info',
        ]);

        // Destroy the session
        //session()->destroy();
    }

    public function setCookie($token)
    {
        if (empty($token)) {
            return false;
        }

        $expire = empty(config_item('user_expire')) ? self::MAX_COOKIE_LIFETIME : config_item('user_expire');
        $cookie_config = [
            'name'   => $this->_getNameCookie(),
            'value'  => $token['user_code'],
            'expire' => $expire,
            'domain' => '',
            'path'   => '/',
            'prefix' => '',
            'secure' => (bool)config_item('force_global_secure_requests'),
            'samesite' => \CodeIgniter\Cookie\Cookie::SAMESITE_LAX,
        ];

        $response = \Config\Services::response();
        $response->setCookie($cookie_config)->send();
        //set_cookie(config_item('remember_cookie_name'), $token['user_code'], $expire, site_url(), '/');
    }

    public function getCookie()
    {
        return get_cookie($this->_getNameCookie());
    }

    public function deleteCookie()
    {
        // delete the remember me cookies if they exist
        $response = \Config\Services::response();
        $response->deleteCookie($this->_getNameCookie())->send();
        //delete_cookie(config_item('remember_cookie_name'));
    }

    private function _getNameCookie()
    {
        return config_item('remember_cookie_name') . '_admin';
    }
}
