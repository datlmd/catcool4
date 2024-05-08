<?php namespace App\Modules\Customers\Models;

use App\Models\MyAuthModel;

class AuthModel extends MyAuthModel
{
    function __construct()
    {
        parent::__construct();

    }

    public function setSession($customer_info)
    {
        if (empty($customer_info)) {
            return false;
        }

        $session_data = [
            'username'       => $customer_info['username'] ?? null,
            'email'          => $customer_info['email'] ?? null,
            'customer_id'    => $customer_info['customer_id'],
            'gender'         => $customer_info['gender'] ?? null,
            'full_name'      => full_name($customer_info['first_name'], $customer_info['last_name']),
            'first_name'     => $customer_info['first_name'],
            'last_name'      => $customer_info['last_name'],
            'old_last_login' => $customer_info['last_login'] ?? null,
            'last_login'     => time(),
        ];

        session()->set([
            'customer' => $session_data,
            'customer_token' => $this->token()
        ]);

        return true;
    }

    public function getCustomerId()
    {
        return session('customer.customer_id');
    }

    public function clearSession()
    {
        session()->remove(['customer']);

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
        return config_item('remember_cookie_name');
    }
}
