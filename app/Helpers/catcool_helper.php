<?php

if (!function_exists('get_config_lang'))
{
    function get_config_lang($is_admin = false)
    {
        if (!empty($is_admin)) {
            return config_item('default_locale_admin');
        }
        return config_item('default_locale');
    }
}

if (!function_exists('get_name_cookie_lang'))
{
    function get_name_cookie_lang($is_admin = false)
    {
        if (!empty($is_admin)) {
            return 'cc_lang_admin_web_value';
        }
        return 'cc_lang_web_value';
    }
}

if (!function_exists('get_name_session_lang'))
{
    function get_name_session_lang($is_admin = false)
    {
        if (!empty($is_admin)) {
            return 'site_admin_lang';
        }
        return 'site_lang';
    }
}

if (!function_exists('get_lang'))
{
    function get_lang($is_admin = false)
    {
        if (is_multi_lang() == false) {
            return get_config_lang($is_admin);
        }

        if (!empty(session(get_name_session_lang($is_admin)))) {
            return session(get_name_session_lang($is_admin));
        }

        $language_value = '';
        if (!empty(is_multi_lang()) && is_multi_lang() == true) {
            $name_cookie_lang = get_name_cookie_lang($is_admin);
            $language         = get_cookie($name_cookie_lang);
            if (!empty($language)) {
                $language_value = $language;
            }
        }

        if (empty($language_value)) {
            $language_value = get_config_lang($is_admin);
        }

        session()->set(get_name_session_lang($is_admin), $language_value);

        return $language_value;
    }
}

if (!function_exists('set_lang'))
{
    function set_lang($lang, $is_admin = false)
    {
        if (is_multi_lang() == false || empty($lang)) {
            return get_config_lang($is_admin);
        }

        $is_lang        = false;
        $multi_language = get_list_lang();
        foreach($multi_language as $value) {
            if ($value['code'] == $lang) {
                $is_lang = true;
            }
        }
        if (!$is_lang) {
            $lang = get_config_lang($is_admin);
        }

        $cookie_config = [
            'name' => get_name_cookie_lang($is_admin),
            'value' => $lang,
            'expire' => 86400 * 30,
            'domain' => '',
            'path' => '/',
            'prefix' => '',
            'secure' => FALSE
        ];

        $response = \Config\Services::response();
        $response->setCookie($cookie_config)->send();

        session()->set(get_name_session_lang($is_admin), $lang);

        return true;
    }
}

if (!function_exists('is_multi_lang'))
{
    function is_multi_lang()
    {

        $list_language = json_decode(config_item('list_language_cache'), 1);
        if (count($list_language) >= 2) {
            return true;
        }

        return false;
    }
}

if (!function_exists('is_show_select_language'))
{
    function is_show_select_language()
    {
        if (is_multi_lang() == false) {
            return false;
        }

        if (empty(config_item('is_show_select_language'))) {
            return false;
        }

        return true;
    }
}

if (!function_exists('get_list_lang'))
{
    /**
     * Get list language
     *
     * @return bool|mixed
     */
    function get_list_lang()
    {
        //list lang
        $list_language = json_decode(config_item('list_language_cache'), 1);
        if (empty($list_language)) {
            return false;
        }

        foreach ($list_language as $key => $value) {
            $list_language[$key]['active'] = false;
            if ($value['code'] == get_lang()) {
                $list_language[$key]['active'] = true;
            }
            if (empty($value['icon'])) {
                $list_language[$key]['icon'] = '<i class="flag-icon flag-icon-' . (($value['code'] == 'vi') ? 'vn' : $value['code']) . ' me-2"></i>';
            } else {
                $list_language[$key]['icon'] = '<i class="' . $value['icon'] . ' me-2"></i>';
            }
        }

        return $list_language;
    }
}

if (!function_exists('get_lang_id'))
{
    /**
     * @param bool $is_admin
     * @return int|mixed
     */
    function get_lang_id($is_admin = false)
    {
        $language_id = 1;
        //list lang
        $list_language = json_decode(config_item('list_language_cache'), 1);
        foreach ($list_language as $key => $value) {
            if ($value['code'] == get_lang($is_admin)) {
                $language_id = $value['id'];
                break;
            }
        }

        return $language_id;
    }
}

if (!function_exists('format_data_lang_id'))
{
    /**
     * @param $data
     * @param $key_sort
     * @return array
     */
    function format_data_lang_id($data, $key_sort)
    {
        if (empty($data[$key_sort])) {
            return $data;
        }
        $data[$key_sort] = array_column($data[$key_sort], null, 'language_id');

        return $data;
    }
}

if (!function_exists('format_lang_form'))
{
    /**
     * @param $data
     * @return array
     */
    function format_lang_form($data)
    {
        if (empty($data)) {
            return $data;
        }

        $input_list = [];
        foreach (get_list_lang() as $lang) {
            foreach ($data as $key => $value) {
                if (strrpos($key, $lang['id']) !== FALSE) {
                    $lang_tmp = explode('_', $key);
                    if (empty($lang_tmp) || count($lang_tmp) < 3) {
                        continue;
                    }
                    //lang_{$language.id}_description
                    $input_list[$lang_tmp[1]][$lang_tmp[2]] = $value;
                }
            }
        }

        return $input_list;
    }
}

if(!function_exists('http_get_query'))
{
    function http_get_query()
    {
        $query_string_sep = (strpos(base_url(), '?') === FALSE) ? '?' : '&amp;';
        if ( !empty(\Config\Services::request()->getGet())) {
            return $query_string_sep.http_build_query(\Config\Services::request()->getGet());
        }

        return false;
    }
}

if (!function_exists('format_tree'))
{
    function format_tree($list_data, $parent_id = 0)
    {
        if (empty($list_data)) {
            return false;
        }

        if (is_array($list_data) && empty($list_data['data'])) {
            return null;
        }

        if (is_array($list_data) && !empty($list_data['data']) && !empty($list_data['key_id'])) {
            $list_tree = $list_data['data'];
            $key_id    = $list_data['key_id'];
        } else {
            $list_tree = $list_data;
            $key_id    = 'id';
        }

        $tree_array = [];
        foreach ($list_tree as $element) {
            if ($element['parent_id'] == $parent_id) {
                $subs = format_tree($list_data, $element[$key_id]);
                if (!empty($subs)) {
                    $element['subs'] = $subs;
                }
                $tree_array[$element[$key_id]] = $element;
            }
        }

        return $tree_array;
    }
}

if (!function_exists('fetch_tree'))
{
    /**
     * get node parent
     *
     * @param $tree
     * @param $parent_id
     * @param bool $parentfound
     * @param array $list
     * @return array
     */
    function fetch_tree($tree, $parent_id, $parentfound = false, $list = array())
    {
        foreach ($tree as $k => $v) {
            if ($parentfound || $k == $parent_id) {
                $rowdata = [];
                foreach ($v as $field => $value) {
                    if ($field != 'subs') {
                        $rowdata[$field] = $value;
                    }
                }
                $list[] = $rowdata;
                if (!empty($v['subs'])) {
                    $list = array_merge($list, fetch_tree($v['subs'], $parent_id, true));
                }
            } elseif (!empty($v['subs'])) {
                $list = array_merge($list, fetch_tree($v['subs'], $parent_id));
            }
        }

        return $list;
    }
}

if(!function_exists('draw_tree_output'))
{
    /**
     * <select name="parent_id" id="parent_id" size="8" class="form-control">
     *  <option value="">{lang('select_dropdown_label')}</option>
     *  {$output_html = '<option ##SELECTED## value="##VALUE##">##INDENT_SYMBOL####NAME##</option>'}
     *  {$indent_symbol = '-&nbsp;-&nbsp;'}
     *  {draw_tree_output(['data' => $list_patent, 'key_id' => 'category_id', 'id_root' => $edit_data.category_id], $output_html, 0, $edit_data.parent_id, $indent_symbol)}
     * </select>
     *
     * @param $list_data
     * @param $input_html
     * @param int $level
     * @param array $selected_value
     * @param string $indent_symbol - $indent_symbol = '-&nbsp;-&nbsp;'
     * @param string $href_uri
     * @return null|string
     */
    function draw_tree_output($list_data, $input_html = null, $level = 0, $selected_value = [], $indent_symbol = '-&nbsp;', $href_uri = '')
    {
        if (empty($list_data)) {
            return null;
        }

        if (is_array($list_data) && empty($list_data['data'])) {
            return null;
        }

        if (is_array($list_data) && !empty($list_data['data']) && !empty($list_data['key_id'])) {
            $list_tree = $list_data['data'];
            $key_id    = $list_data['key_id'];
            $id_root   = !empty($list_data['id_root']) ? $list_data['id_root'] : null;
        } else {
            $list_tree = $list_data;
            $key_id    = 'id';
            $id_root   = null;
        }

        $input_html = !empty($input_html) ? $input_html : '<option ##SELECTED## value="##VALUE##">##INDENT_SYMBOL####NAME##</option>';

        $output = '';
        foreach($list_tree as $value)
        {
            // Init
            $each_category_html = $input_html;

            if (!empty($selected_value) && !is_array($selected_value)) {
                $selected_value = explode("," , $selected_value);
            }

            $selected = (!empty($selected_value) && in_array($value[$key_id], $selected_value)) ? 'selected' : '';

            if ($value[$key_id] == $id_root || $value['parent_id'] == $id_root) {
                $selected = 'disabled';
            }

            //check khi da ngon ngu
            if (!empty($value['detail'])) {
                $name = (isset($value['detail']['title'])) ? $value['detail']['title'] : (isset($value['detail']['name']) ? $value['detail']['name'] : '');
            } else {
                $name = (isset($value['title'])) ? $value['title'] : (isset($value['name']) ? $value['name'] : '');
            }

            $indent = '';
            for($i = 1; $i <= $level; $i++)
            {
                $indent .= $indent_symbol;
            }

            $find_replace = array(
                '##VALUE##'         => $value[$key_id],
                '##INDENT_SYMBOL##' => $indent,
                '##NAME##'          => $name,
                '##SELECTED##'      => $selected,
                '##HREF##'          => $href_uri
            );

            $output .= strtr($each_category_html, $find_replace);

            if(isset($value['subs']))
            {
                if ($value['parent_id'] == $id_root) {
                    $id_root = $value[$key_id];
                }
                $output .= draw_tree_output(['data' => $value['subs'], 'key_id' => $key_id, 'id_root' => $id_root], $input_html, $level + 1, $selected_value, $indent_symbol, $href_uri);
            }
        }

        return $output;
    }
}

if(!function_exists('draw_tree_output_name'))
{
    /**
     * @param $list_data
     * @param $input_html
     * @param int $level
     * @param array $selected_value
     * @param string $href_uri
     * @return null|string
     */
    function draw_tree_output_name($list_data, $input_html = null, $level = 0, $selected_value = [], $indent_symbol = null, $href_uri = '')
    {
        if (empty($list_data)) {
            return null;
        }

        if (is_array($list_data) && !empty($list_data['data']) && !empty($list_data['key_id'])) {
            $list_tree = $list_data['data'];
            $key_id    = $list_data['key_id'];
            $id_root   = !empty($list_data['id_root']) ? $list_data['id_root'] : null;
        } else {
            $list_tree = $list_data;
            $key_id    = 'id';
            $id_root   = null;
        }

        $input_html = !empty($input_html) ? $input_html : '<option ##SELECTED## value="##VALUE##">##INDENT_SYMBOL####NAME##</option>';

        $output = '';
        foreach($list_tree as $value)
        {
            // Init
            $each_category_html = $input_html;

            if (!empty($selected_value) && !is_array($selected_value)) {
                $selected_value = explode("," , $selected_value);
            }

            $selected = (!empty($selected_value) && in_array($value[$key_id], $selected_value)) ? 'selected' : '';

            if ($value[$key_id] == $id_root || $value['parent_id'] == $id_root) {
                $selected = 'disabled';
            }

            //check khi da ngon ngu
            if (!empty($value['detail'])) {
                $name = (isset($value['detail']['title'])) ? $value['detail']['title'] : (isset($value['detail']['name']) ? $value['detail']['name'] : '');
            } else {
                $name = (isset($value['title'])) ? $value['title'] : (isset($value['name']) ? $value['name'] : '');
            }

            $indent = empty($indent_symbol) ? '' : $indent_symbol;

            $find_replace = array(
                '##VALUE##'         => $value[$key_id],
                '##INDENT_SYMBOL##' => $indent,
                '##NAME##'          => $name,
                '##SELECTED##'      => $selected,
                '##HREF##'          => $href_uri
            );

            $output .= strtr($each_category_html, $find_replace);

            if(isset($value['subs']))
            {
                $indent = $indent . $name . ' > ';
                if ($value['parent_id'] == $id_root) {
                    $id_root = $value[$key_id];
                }
                $output .= draw_tree_output_name(['data' => $value['subs'], 'key_id' => $key_id, 'id_root' => $id_root], $input_html, $level + 1, $selected_value, $indent, $href_uri);
            }
        }

        return $output;
    }
}

if (!function_exists('format_dropdown'))
{
    function format_dropdown($list_array, $key_id = 'id')
    {
        if (empty($list_array)) {
            return false;
        }

        $dropdown_list = [];
        foreach ($list_array as $value) {
            //check khi da ngon ngu
            if (!empty($value['detail'])) {
                $name = (isset($value['detail']['title'])) ? $value['detail']['title'] : (isset($value['detail']['name']) ? $value['detail']['name'] : '');
            } else {
                $name = (isset($value['title'])) ? $value['title'] : (isset($value['name']) ? $value['name'] : '');
            }

            $dropdown_list[$value[$key_id]] = $name;
        }

        return $dropdown_list;
    }
}

// Check if the function does not exists
if ( ! function_exists('slugify'))
{
    // Slugify a string
    function slugify($string)
    {
        helper('text');
        helper('url');

        // Replace unsupported characters (add your owns if necessary)
        $string = str_replace("'", '-', $string);
        $string = str_replace(".", '-', $string);
        $string = str_replace("?", '2', $string);

        // Slugify and return the string
        return url_title(convert_accented_characters($string), 'dash', true);
    }
}

if (!function_exists('get_list_limit'))
{
    function get_list_limit($limit_array = null)
    {
        if (!empty($limit_array) && is_array($limit_array)) {
            return $limit_array;
        }

        $limit_array = [
            get_pagination_limit(true) => get_pagination_limit(true),
            50  => 50,
            100 => 100,
            200 => 200,
            250 => 250,
            500 => 500,
        ];

        return $limit_array;
    }
}

if(!function_exists('image_domain'))
{
    function image_domain($path = null)
    {
        if (!empty(config_item('image_domain'))) {
            return config_item('image_domain') . $path;
        }

        return base_url($path);
    }
}

if(!function_exists('image_default_url'))
{
    function image_default_url() {
        $upload_path = get_upload_url();
        if (!empty(config_item('image_none')) && is_file( ROOTPATH . $upload_path . config_item('image_none'))) {
            return image_domain($upload_path . config_item('image_none'));
        }

        return base_url('common/'.UPLOAD_IMAGE_DEFAULT);
    }
}

if(!function_exists('get_image_resize_info'))
{
    function get_image_resize_info($width, $height)
    {
        if (empty($width) || empty($height)) {
            return [0,0];
        }
        $resize_width = !empty(config_item('image_thumbnail_large_width')) ? config_item('image_thumbnail_large_width') : RESIZE_IMAGE_DEFAULT_WIDTH;
        if ($width >= $resize_width) {
            $width = $resize_width;
        } else if ($width >= 1792 && $width < $resize_width) {
            $width = 1792; // 1792 ~ 2048
        } else if ($width >= 1536 && $width < 1792) {
            $width = 1536;
        } else if ($width >= 1280 && $width < 1536) {
            $width = 1280;
        } else if ($width >= 1024 && $width < 1280) {
            $width = 1024;
        } else if ($width >= 768 && $width < 1024) {
            $width = 768;
        }

        $resize_height = !empty(config_item('image_thumbnail_large_height')) ? config_item('image_thumbnail_large_height') : RESIZE_IMAGE_DEFAULT_HEIGHT;
        if ($height >= $resize_height) {
            $height = $resize_height;
        } else if ($height >= 1800 && $height < $resize_height) {
            $height = 1800; // 1800 ~ 2048
        } else if ($height >= 1600 && $height < 1800) {
            $height = 1600;
        } else if ($height >= 1440 && $height < 1600) {
            $height = 1440;
        } else if ($height >= 1152 && $height < 1440) {
            $height = 1152;
        } else if ($height >= 900 && $height < 1152) {
            $height = 900;
        }

        return [$width, $height];
    }
}

if(!function_exists('image_url'))
{
    function image_url($image = null, $width = null, $height = null, $is_watermark = false)
    {
        if (stripos($image, "https://") !== false || stripos($image, "http://") !== false) {
            return $image;
        }


        if (!is_null($width) && is_numeric($width) && !is_null($height) && is_numeric($height)) {
            $image = sprintf('%dx%d/%s', $width, $height, $image);
        }
        $image = 'img/'.$image;

        if (!empty(session()->get('is_admin'))) {
            return image_domain($image) . '?' . time();
        }

        return image_domain( $image);
    }
}

if(!function_exists('image_thumb_url'))
{
    function image_thumb_url($image = null, $width = null, $height = null, $is_watermark = false)
    {
        $width = !empty($width) ? $width : (!empty(config_item('image_thumbnail_small_width')) ? config_item('image_thumbnail_small_width') : RESIZE_IMAGE_THUMB_WIDTH);
        $height = !empty($height) ? $height : (!empty(config_item('image_thumbnail_small_height')) ? config_item('image_thumbnail_small_height') : RESIZE_IMAGE_THUMB_HEIGHT);
        $upload_path = get_upload_url();
        if (! is_file( ROOTPATH . $upload_path . $image)) {
            return image_default_url();
        }

        $image_tool = new \App\Modules\Images\Models\Image_tool();

        $image_resize = $image_tool->resize($image, $width, $height);

        if (!empty($is_watermark)) {
            $image_resize = $image_tool->watermark($image_resize);
        }

        if (!empty(session()->get('is_admin'))) {
            return image_domain($upload_path) . $image_resize . '?' . time();
        }

        return image_domain($upload_path) . $image_resize;
    }
}

if ( ! function_exists('img_alt'))
{
    /**
     * Displays an alternative image using placehold.it website.
     *
     * @return  string
     */
    function img_alt($width, $height = null, $text = null, $background = null, $foreground = null)
    {
        $params = [];
        if (is_array($width))
        {
            $params = $width;
        }
        else
        {
            $params['width']        = $width;
            $params['height']       = $height;
            $params['text']         = $text;
            $params['background']   = $background;
            $params['foreground']   = $foreground;
        }
        $params['height']       = (empty($params['height'])) ? $params['width'] : $params['height'];
        $params['text']         = (empty($params['text'])) ? $params['width'].' x '. $params['height'] : $params['text'];
        $params['background']   = (empty($params['background'])) ? 'CCCCCC' : $params['background'];
        $params['foreground']   = (empty($params['foreground'])) ? '969696' : $params['foreground'];
        return '<img src="' . base_url("images/alt/"). $params['width'].'x'. $params['height'].'/'.$params['background'].'/'.$params['foreground'].'?text='. $params['text'].'" alt="CatCool CMS">';
    }
}

if ( ! function_exists('img_alt_url'))
{
    /**
     * Displays an alternative image using placehold.it website.
     *
     * @return  string
     */
    function img_alt_url($width, $height = null, $text = null, $background = null, $foreground = null)
    {
        $params = [];
        if (is_array($width))
        {
            $params = $width;
        }
        else
        {
            $params['width']        = $width;
            $params['height']       = $height;
            $params['text']         = $text;
            $params['background']   = $background;
            $params['foreground']   = $foreground;
        }
        $params['height']       = (empty($params['height'])) ? $params['width'] : $params['height'];
        $params['text']         = (empty($params['text'])) ? $params['width'].' x '. $params['height'] : $params['text'];
        $params['background']   = (empty($params['background'])) ? 'CCCCCC' : $params['background'];
        $params['foreground']   = (empty($params['foreground'])) ? '969696' : $params['foreground'];
        return  base_url("images/alt/") . $params['width'].'x'. $params['height'].'/'.$params['background'].'/'.$params['foreground'].'?text='. $params['text'];
    }
}

if ( ! function_exists('get_image_data_url'))
{
    function get_image_data_url($url)
    {
        if (empty($url)) {
            return false;
        }
        $urlParts = pathinfo($url);
        $extension = $urlParts['extension'];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        $base64 = 'data:image/' . $extension . ';base64,' . base64_encode($response);

        return $base64;
    }
}

if ( ! function_exists('save_image_from_url'))
{
    function save_image_from_url($url, $folder_name)
    {
        if (empty($url)) {
            return false;
        }
        $url_parts = pathinfo($url);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $response = curl_exec($ch);
        curl_close($ch);

        $folder_name = $folder_name . '/' . date('Y');
        $folder_path = get_upload_path($folder_name);

        // make dir
        if(!is_dir($folder_path)) {
            mkdir($folder_path, 0775, TRUE);
        }

        $file_new =  $url_parts['filename'] . '.' . $url_parts['extension'];

        file_put_contents($folder_path . '/' . $file_new, $response);

        return $folder_name . '/' . $file_new;
    }
}

if(!function_exists('move_file_tmp'))
{
    /**
     * copy file den thu muc moi va xoa file cu
     *
     * @param $field_name_tmp
     * @param null $name_file_new
     * @return bool|mixed
     */
    function move_file_tmp($field_name_tmp, $name_file_new = null)
    {
        if (empty($field_name_tmp)) {
            return FALSE;
        }

        helper('filesystem');

        $upload_path = get_upload_path();
        $file_info   = pathinfo($upload_path . $field_name_tmp);

        if (! is_file($upload_path . $field_name_tmp)) {
            return FALSE;
        }

        $file_new   = !empty($name_file_new) ? $name_file_new : str_replace('tmp/', '', $field_name_tmp);
        $folder_new = str_replace('tmp/', '', $file_info['dirname']);

        if (!is_dir($folder_new)) {
            mkdir($folder_new, 0777, true);
        }

        //create folder
        $path = '';
        $directories = explode('/', dirname($name_file_new));
        foreach ($directories as $directory) {
            $path = $path . '/' . $directory;

            if (!is_dir($upload_path . $path)) {
                mkdir($upload_path . $path, 0777);
            }
        }

        if (write_file($upload_path . $file_new, file_get_contents($upload_path . $field_name_tmp))) {
            delete_files(unlink($upload_path . $field_name_tmp));
            return $file_new;
        }

        return FALSE;
    }
}

if(!function_exists('delete_cache'))
{
    function delete_cache()
    {
        //delete file old
        helper('filesystem');

        //delete cache html
        delete_files(WRITEPATH . 'cache/html/');

        //delete cache smarty
        delete_files(WRITEPATH . 'cache/smarty/cache/');

        //clear file upload
        delete_files(get_upload_path('cache'), TRUE);

        return true;
    }
}


if(!function_exists('delete_file_upload_tmp'))
{
    function delete_file_upload_tmp($field_name_tmp = null, $expired_time = 7200)
    {
        //delete file old
        helper('filesystem');

        $upload_path = empty($field_name_tmp) ? get_upload_path('tmp') : $field_name_tmp;
        $list_file   = directory_map($upload_path);

        if (empty($list_file)) {
            return false;
        }

        foreach ($list_file as $folder => $filename) {
            if (is_array($filename)) {
                //folder
                delete_file_upload_tmp($upload_path . DIRECTORY_SEPARATOR . $folder);
            } else {
                $file_tmp = $upload_path . DIRECTORY_SEPARATOR . $filename;
                if (is_file($file_tmp)) {
                    $file_info_tmp = get_file_info($file_tmp);
                    if (time() > $file_info_tmp['date'] + $expired_time) {
                        unlink($file_tmp);
                    }
                }
            }
        }

        return true;
    }
}

if(!function_exists('delete_file_upload'))
{
    function delete_file_upload($file_name)
    {
        $upload_path = get_upload_path();

        if (! is_file($upload_path . $file_name)) {
            return FALSE;
        }

        return delete_files(unlink($upload_path . $file_name));
    }
}

/**
 * Get folder upload file
 *
 * @param string $folder_uri /images/avatar
 * @param string $sub_link_file return
 * @return array 'dir' full path, 'sub_dir' path yymmdd
 */
if(!function_exists('get_folder_upload'))
{
    function get_folder_upload($folder_uri, $is_make_ymd_folder = TRUE)
    {
        // get dir path
        $dir = get_upload_path() . $folder_uri;

        // get date
        $sub_folder = ($is_make_ymd_folder) ? date('Ym') : '';

        if(!is_dir($dir))
        {
            mkdir($dir, 0775, TRUE);
        }

        $dir_all = ($is_make_ymd_folder) ? $dir . '/' . $sub_folder : $dir;

        // get folder path
        $dir_all = str_replace('//', '/', $dir_all);

        // make dir
        if(!is_dir($dir_all))
        {
            mkdir($dir_all, 0775, TRUE);
        }

        $sub_dir = $folder_uri . '/' . $sub_folder;

        return [
            'dir'     => str_replace('//', '/', $dir_all),
            'sub_dir' => str_replace('//', '/', $sub_dir)
        ];

        return FALSE;
    }
}

if(!function_exists('get_upload_path'))
{
    function get_upload_path($upload_uri = NULL)
    {
        if (!empty($upload_uri)) {
            return ROOTPATH . UPLOAD_FILE_DIR . $upload_uri;
        }

        return ROOTPATH . UPLOAD_FILE_DIR;
    }
}

if(!function_exists('get_upload_url'))
{
    function get_upload_url($upload_uri = NULL)
    {
        $dir = !empty($upload_uri) ? UPLOAD_FILE_DIR . $upload_uri : UPLOAD_FILE_DIR;
        $dir = preg_replace('@/+$@', '', $dir) . '/';

        return $dir;
    }
}

//check field data is image or not
if(!function_exists('is_image_link'))
{
    function is_image_link($field, $extension = null)
    {
        if (!empty($extension)) {
            $extension = (is_array($extension)) ? $extension : explode('|', $extension);
        } else {
            $extension = ['png', 'PNG', 'jpg', 'JPG', 'jpeg', 'JPEG', 'gif', 'GIF', 'bmp', 'BMP'];
        }

        $info = pathinfo($field);
        if(in_array($info["extension"], $extension))
            return TRUE;

        return FALSE;
    }
}

/**
 * Debug by PG
 *
 * @param type $var
 */
if(!function_exists('cc_debug'))
{
    function cc_debug($var, $is_die = TRUE)
    {
        echo '<pre>';
        print_r($var);
        echo '</pre>';
        if($is_die == TRUE)
        {
            exit();
        }
    }
}

if(!function_exists('standar_date'))
{
    function get_date($format = 'Y-m-d H:i:s')
    {
        return date($format, time());
    }
}

/**
 * Chuyển dạng date sang dạng chuẩn SQL
 *
 * @param string $char_standar Dấu phân cách dạng chuẩn
 * @param string $char Dấu phân cách dạng hiện tại
 * @return string yyyy-mm-dd
 */
if(!function_exists('standar_date'))
{
    function standar_date($date, $char_standar = '-', $char = '/', $show = FALSE)
    {
        // if show view
        if($show == TRUE)
        {
            // check char
            if(strpos($date, $char_standar) === FALSE)
            {
                return date('Y-m-d',  strtotime($date));
            }

            // convert date yy-mm-dd to array
            $date_array = explode($char_standar, $date);

            // return date dd/mm/yy
            $return_date = $date_array[2] . $char . $date_array[1] . $char . $date_array[0];

            if($return_date != $char . $char)
            {
                return $return_date;
            }
        }
        else // insert db
        {
            // check char
            if(strpos($date, $char) === FALSE)
            {
                return date('Y-m-d',  strtotime($date));
            }

            // convert date dd/mm/yyyy to array
            $date_array = explode($char, $date);

            // return date yyyy/mm/dd
            $return_date = $date_array[2] . $char_standar . $date_array[1] . $char_standar . $date_array[0];

            if($return_date != $char_standar . $char_standar)
            {
                return $return_date;
            }
        }

        return '';
    }
}

if(!function_exists('format_date'))
{
    function format_date($date, $format = FALSE, $style = FALSE)
    {
        $style = $style ? $style : 1;
        $format = $format ? $format : 'd/m/y, H:i';

        //format date to compare
        $date = date('Y-m-d H:i:s', strtotime($date));
        $today = date('Y-m-d 00:00:00');

        $formated_date = '';

        switch($style)
        {
            case 1:
                if($today < $date)
                    $format_date = 'Hôm nay ' . date('H:i', strtotime($date));
                else
                    $format_date = date($format, strtotime($date));

                break;
            case 2:
                break;
        }

        return $format_date;
    }
}
/**
 * Add/Subtract time
 * @param datetime $date
 * @param int $time time add
 * @param boolean $is_add
 */
if(!function_exists('add_time'))
{
    function add_time($date, $time, $is_add = TRUE)
    {
        $date_convert_time = strtotime($date);
        if($is_add)
        {
            $date_added = $date_convert_time + $time;
        }
        else
        {
            $date_added = $date_convert_time - $time;
        }
        return date('Y-m-d H:i:s', $date_added);
    }
}

if(!function_exists('get_client_ip'))
{
    function get_client_ip()
    {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        } else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else if (isset($_SERVER['HTTP_X_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        } else if (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        } else if (isset($_SERVER['HTTP_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        } else if (isset($_SERVER['REMOTE_ADDR'])) {
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        } else {
            $ipaddress = 'UNKNOWN';
        }

        return $ipaddress;
    }
}

if(!function_exists('filter_bad_word_comment_content'))
{
    function filter_bad_word_comment_content($content)
    {
        static $filter;

        if (!$filter) {
            $filter = file_get_contents(APPPATH . 'Modules/Comments/Config/Filter_comment.txt');

            $filter = explode(';', $filter);

            if ($filter) {
                foreach ($filter as $key => $value) {
                    $filter[$key] = trim($value);
                }
            }
        }

        $content = str_replace($filter, '***', $content);

        return $content;
    }
}

/**
 * get javascript global
 *
 * @return string js global
 */
if(!function_exists('script_global'))
{
    function script_global()
    {
        return '
            var base_url = "' . base_url() . '";
            var current_url = "' . current_url() . '";
            var image_url = "' . base_url('img') . '";
            var image_root_url = "' . get_upload_url() . '";
            var username = "' . session('username') . '";
            var csrf_token = "' . csrf_token() . '";
        ';
    }
}

if (!function_exists('json_output'))
{
    function json_output($data)
    {
        if (empty($data)) {
            return false;
        }

        header('content-type: application/json; charset=utf8');
        echo json_encode($data);
        exit();
    }
}

if(!function_exists('send_email'))
{
    function send_email($email_to, $email_from, $subject_title = null, $subject, $content, $reply_to = null, $bcc = null, $config = null)
    {
        //Gửi mail
        try
        {
            $email = \Config\Services::email();

            if (empty($config))
            {
                //$config = config('Email');
                $config['protocol'] = config_item('email_engine');//'smtp';
                $config['SMTPTimeout'] = config_item('email_smtp_timeout');
                $config['mailType'] = 'html';
                //$config['charset'] = 'utf-8';
                $config['newline'] = "\r\n";
                $config['validate'] = TRUE;
                $config['SMTPHost'] = config_item('email_host'); //'10.30.46.99
                $config['SMTPPort'] = config_item('email_port'); //25

                if (!empty(config_item('email_smtp_user'))) {
                    $config['SMTPUser'] = config_item('email_smtp_user');
                }
                if (!empty(config_item('email_smtp_pass'))) {
                    $config['SMTPPass'] = config_item('email_smtp_pass');
                }
            }

            $email->initialize($config);

            $email->setFrom($email_from, $subject_title);
            $email->setTo($email_to);
            $email->setSubject($subject);
            $email->setMessage($content);

            if (!empty($bcc)) {
                $email->setBCC($bcc);
            }
            if (!empty($reply_to)) {
                $email->setReplyTo($reply_to);
            }

            if($email->send()) {
                return true;
            } else {
                die($email->printDebugger());
            }
        } catch (\Exception $e) {
            return false;
        }
    }
}

if(!function_exists('get_avatar'))
{
    function get_avatar($avatar = null)
    {
        $image_ext = '.jpg';
        if (session('is_admin')) {
            $image_ext = '_ad.jpg';
        }

        $upload_path = get_upload_url();
        $avatar      = empty($avatar) ? 'users/' . session('username') . $image_ext : $avatar;
        if (!is_file( WRITEPATH . $upload_path . $avatar)) {
            return (session('user_gender') == GENDER_MALE) ? base_url('common/'.config_item('avatar_default_male')) : base_url('common/'.config_item('avatar_default_female'));
        }

        return image_url($avatar);
    }
}

if(!function_exists('filter_sort_array'))
{
    function filter_sort_array($list, $parent_id = 0, $key_name = "id")
    {
        if (empty($list)) {
            return false;
        }

        $data = [];
        $sort_count = count($list);

        foreach($list as $value) {
            $key = "id_" . $value["id"];
            $data[$key][$key_name] = $value["id"];
            $data[$key]["parent_id"] = $parent_id;
            $data[$key]["sort_order"] = $sort_count;

            if (!empty($value["children"])) {
                $data_children = filter_sort_array($value["children"], $value["id"], $key_name);

                $data = array_merge($data, $data_children);
            }
            $sort_count--;
        }

        return $data;
    }
}

if(!function_exists('get_menu_by_position'))
{
    function get_menu_by_position($position = MENU_POSITION_MAIN)
    {
        $CI = & get_instance();
        $CI->load->model("menus/Menu", 'Menu');

        $menu = $CI->Menu->get_menu_active(['context' => $position], 3600*30*12);
        $menu = format_tree(['data' => $menu, 'key_id' => 'menu_id']);

        if (empty($menu)) {
            return false;
        }
        return $menu;
//        sort($menu);
//        if (empty($menu[0]['subs'])) {
//            return false;
//        }
//
//        return $menu[0]['subs'];
    }
}

if(!function_exists('file_get_contents_ssl'))
{
    function file_get_contents_ssl($url)
    {
        $arr_context_options = [
            "ssl" => [
                "verify_peer"      =>false,
                "verify_peer_name" =>false,
            ],
        ];

        if (empty(config_item('force_global_secure_requests'))) {
            return file_get_contents($url);
        }

        return file_get_contents($url, false, stream_context_create($arr_context_options));
    }
}

if(!function_exists('get_pagination_limit'))
{
    function get_pagination_limit($is_admin = false)
    {
        if (empty($is_admin)) {

            if (!empty(config_item('pagination_limit')) && config_item('pagination_limit') > 0) {
                return config_item('pagination_limit');
            }

            return PAGINATION_DEFAULF_LIMIT;
        }

        if (!empty(config_item('pagination_limit_admin')) && config_item('pagination_limit_admin') > 0) {
            return config_item('pagination_limit_admin');
        }

        return PAGINATION_MANAGE_DEFAULF_LIMIT;
    }
}

if(!function_exists('get_fonts'))
{
    function get_fonts()
    {
        $list = [
            'Texb' => './system/fonts/texb.ttf',
            'TAHOMA' => './system/fonts/TAHOMA.TTF',
            'Oswald' => './system/fonts/Oswald.ttf',
            'Orbitron' => './system/fonts/Orbitron.ttf',
            'Bitter' => './system/fonts/Bitter.ttf',
            'Caveat' => './system/fonts/Caveat.ttf',
            'Dancing Script' => './system/fonts/DancingScript.ttf',
            'Gloria Hallelujah' => './system/fonts/GloriaHallelujah.ttf',
            'Lemonada' => './system/fonts/Lemonada.ttf',
            'Modak' => './system/fonts/Modak.ttf',
            'Sacramento' => './system/fonts/Sacramento.ttf',
            'Sansita Swashed' => './system/fonts/SansitaSwashed.ttf',
            'Stalinist One' => './system/fonts/StalinistOne.ttf',
        ];

        return $list;
    }
}

if(!function_exists('add_meta'))
{
    function add_meta($data = null, $theme, $is_admin = false)
    {
        try
        {
            $title = !empty($data['title']) ? $data['title'] : config_item('site_name');
            $description = !empty($data['description']) ? $data['description'] : config_item('site_description');
            $keywords = !empty($data['keywords']) ? $data['keywords'] : config_item('site_keywords');
            $url = !empty($data['url']) ? $data['url'] : base_url();
            $image = !empty($data['image']) ? $data['image'] : config_item('site_image');

            //$theme = \App\Libraries\Themes::init();


            $theme->setPageTitle($title);

            $theme->addMeta('robots', 'index,follow');
            $theme->addMeta('revisit-after', '1 days');

            $theme->addMeta('generator', 'Cat Cool CMS');
            $theme->addMeta('copyright', 'Cat Cool CMS');
            $theme->addMeta('author', 'Dat Le');
            $theme->addMeta('author', 'https://kenhtraitim.com', 'rel');

            $theme->addMeta('description', $description, 'meta', ['id' => 'meta_description']);
            $theme->addMeta('keywords', $keywords, 'meta', ['id' => 'meta_keywords']);
            $theme->addMeta('news_keywords', $keywords, 'meta', ['id' => 'meta_news_keywords']);
            $theme->addMeta('canonical', $url, 'ref');
            $theme->addMeta('alternate', $url, 'ref');

            // Let's add some extra tags.

            if (!empty(config_item('fb_app_id'))) {
                $theme->addMeta('og:fb:app_id', config_item('fb_app_id'), 'meta', ['property' => 'fb:app_id']);
            }
            if (!empty(config_item('fb_pages'))) {
                $theme->addMeta('og:fb:pages', config_item('fb_pages'), 'meta', ['property' => 'fb:pages']);
            }
            $theme->addMeta('og:type', 'article');
            $theme->addMeta('og:url', $url);
            $theme->addMeta('og:title', $title);
            $theme->addMeta('og:description', $description);
            $theme->addMeta('og:image', $image);
            if (!empty($image)) {
                $image = WRITEPATH . str_ireplace([base_url(), site_url()], ['', ''], $image);
                if (is_file($image)) {
                    $image_data = getimagesize($image);
                    if (!empty($image_data['mime']) && !empty($image_data[0]) && !empty($image_data[1])) {
                        $theme->addMeta('og:image:type', $image_data['mime']);
                        $theme->addMeta('og:image:width', $image_data[0]);
                        $theme->addMeta('og:image:height', $image_data[1]);
                    }
                }
            }

            $theme->addMeta('og:twitter:image', 'summary', 'meta', ['property' => 'twitter:image']);
            $theme->addMeta('og:twitter:card', 'summary_large_image', 'meta', ['property' => 'twitter:card']);
            $theme->addMeta('og:twitter:url', $url, 'meta', ['property' => 'twitter:url']);
            $theme->addMeta('og:twitter:title', $title, 'meta', ['property' => 'twitter:title']);
            $theme->addMeta('og:twitter:description', $description, 'meta', ['property' => 'twitter:description']);

            $theme->addMeta('resource-type', 'Document');
            $theme->addMeta('distribution', 'Global');

            if (!empty(config_item('google_site_verification'))) {
                $theme->addMeta('google-site-verification', config_item('google_site_verification'));
            }

            if (!empty(config_item('alexa_verify_id'))) {
                $theme->addMeta('alexaVerifyID', config_item('alexa_verify_id'));
            }
        }
        catch (\Exception $e)
        {
            die($e->getMessage());
        }

        return $theme;
    }
}

if(!function_exists('script_google_search'))
{
    function script_google_search()
    {
        $CI = & get_instance();

        return '
            <!-- GOOGLE SEARCH STRUCTURED DATA FOR ARTICLE -->
            <script type="application/ld+json">
            {
                "@context": "http://schema.org",
                "@type": "NewsArticle",
                "mainEntityOfPage":{
                "@type":"WebPage",
                    "@id":"https://kenh14.vn/meo-doc-tin-nhan-messenger-nhung-khong-bi-lo-da-xem-20210110231839102.chn"
                },
                "headline": "Mẹo đọc tin nhắn Messenger nhưng kh&amp;#244;ng bị lộ... &amp;quot;đ&amp;#227; xem&amp;quot;",
                "description": "Messenger l&#224; ứng dụng nhắn tin phổ biến được d&#249;ng để tr&#242; chuyện tại Việt Nam. Tuy nhi&#234;n, c&#243; nhiều l&#250;c ch&#250;ng ta kh&#244;ng muốn để người kia biết được m&#236;nh đ&#227; đọc tin nhắn.",
                "image": {
                "@type": "ImageObject",
                    "url": "https://kenh14cdn.com/zoom/700_438/203336854389633024/2021/1/10/photo1610295289747-16102952902141492839161.jpg",
                    "width" : 700,
                    "height" : 438
                },
                "datePublished": "2021-01-11T00:20:00+07:00",
                "dateModified": "2021-01-11T00:20:00+07:00",
                "author": {
                "@type": "Person",
                    "name": "Hạnh Koy"
                },
                "publisher": {
                "@type": "Organization",
                    "name": "kenh14.vn",
                    "logo": {
                    "@type": "ImageObject",
                        "url": "https://kenh14cdn.com/zoom/60_60/k14-logo.png",
                        "width": 60,
                        "height": 60
                    }
                }
            }
            </script><!-- GOOGLE BREADCRUMB STRUCTURED DATA -->
            <script type="application/ld+json">
            {
                "@context": "http://schema.org",
                "@type": "BreadcrumbList",
                "itemListElement": [
                {
                    "@type": "ListItem",
                    "position": 1,
                    "item": {
                    "@id": "https://kenh14.vn",
                        "name": "Trang chủ"
                    }
                },{
                "@type": "ListItem",
                                    "position": 2,
                                    "item": {
                    "@id": "https://kenh14.vn/2-tek.chn",
                                        "name": "2-Tek"
                                    }
                                },{
                "@type": "ListItem",
                                    "position": 3,
                                    "item": {
                    "@id": "https://kenh14.vn/2-tek/ung-dung-thu-thuat.chn",
                                        "name": "Ứng dụng/Thủ thuật"
                                    }
                                }
                ]
            }
            </script>';

    }
}

if(!function_exists('config_item'))
{
    function config_item($key)
    {
        $key = camelize($key);
        if (empty($key) || empty(config('Config')->$key)) {
            return null;
        }

        return config('Config')->$key;
    }
}
