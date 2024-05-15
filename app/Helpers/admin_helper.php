<?php

if (!function_exists('key_session_language_admin'))
{
    function key_session_language_admin()
    {
        return 'site_language_admin';
    }
}

if (!function_exists('get_language_admin'))
{
    function get_language_admin()
    {
        if (!is_multi_language()) {
            return config_item('default_locale_admin');
        }

        if (!empty(session(key_session_language_admin()))) {
            return session(key_session_language_admin());
        }

        $language_value = '';
        if (is_multi_language()) {
            $language = get_cookie('catcool_language_locale_admin');
            if (!empty($language)) {
                $language_value = $language;
            }
        }

        if (empty($language_value)) {
            $language_value = config_item('default_locale_admin');
        }

        session()->set(key_session_language_admin(), $language_value);

        return $language_value;
    }
}

if (!function_exists('set_language_admin'))
{
    function set_language_admin($language_code)
    {
        if (!is_multi_language() || empty($language_code)) {
            return config_item('default_locale_admin');
        }

        $language_codes = array_column(list_language(), 'code');
        if (!in_array($language_code, $language_codes)) {
            $language_code = config_item('default_locale_admin');
        }

        $cookie_config = [
            'name' => 'catcool_language_locale_admin',
            'value' => $language_code,
            'expire' => 86400 * 30,
            'domain' => '',
            'path' => '/',
            'prefix' => '',
            'secure' => (bool)config_item('force_global_secure_requests'),
            'samesite' => \CodeIgniter\Cookie\Cookie::SAMESITE_LAX,
        ];

        $response = \Config\Services::response();
        $response->setCookie($cookie_config)->send();

        session()->set(key_session_language_admin(), $language_code);

        return true;
    }
}

if (!function_exists('list_language_admin'))
{
    /**
     * Get list language admin
     *
     * @return array|bool
     */
    function list_language_admin()
    {
        //list lang
        $language_list = json_decode(config_item('list_language_cache'), 1);
        if (empty($language_list)) {
            return false;
        }

        $language_active = [];
        foreach ($language_list as $key => $value) {
            if (empty($value['icon'])) {
                $language_list[$key]['icon'] = '<i class="flag-icon flag-icon-' . (($value['code'] == 'vi') ? 'vn' : $value['code']) . '"></i>';
            } else {
                $language_list[$key]['icon'] = '<i class="' . $value['icon'] . '"></i>';
            }

            $language_list[$key]['active'] = false;
            if ($value['code'] == get_language_admin()) {
                $language_list[$key]['active'] = true;
                $language_active[] = $language_list[$key];
                unset($language_list[$key]);
            }

        }

        $language_list = array_merge($language_active, $language_list);

        $result = [];
        foreach ($language_list as $item) {
            $result[$item['id']] = $item;
        }

        return $result;
    }
}