<?php

namespace App\Modules\Posts\Controllers;

use App\Controllers\MyController;
use App\Modules\Posts\Models\PostModel;
use App\Modules\Posts\Models\CategoryModel;

class Posts extends MyController
{
    public function index()
    {
        $this->themes->setTheme(config_item('theme_frontend'));

        //$this->cachePage(180);

        $post_model = new PostModel();

        $list_latest = $post_model->getLatestPostsHome(5);


        $post_category_model = new CategoryModel();
        $post_category_list = $post_category_model->getPostCategories();
        $category_tree = format_tree([$post_category_list, 'category_id']);

        $post_group_category_list =  $post_model->getPostsGroupByCategory(5);

        $data = [
            'latest_post_list'         => $list_latest,
            'post_category_list'       => $post_category_list,
            'category_tree'            => $category_tree,
            'counter_list'             => $post_model->getListCounter(6),
            'post_group_category_list' => $post_group_category_list,
            'script_google_search'     => $this->_scriptGoogleSearch(),
            'weather'                  => $this->_getWeather(),
        ];

        add_meta(['title' => lang("Post.heading_title")], $this->themes);

        $params['params'] = [
            'breadcrumb' => $this->breadcrumb->render(),
            'breadcrumb_title' => lang("Post.heading_title"),
        ];

        if ($this->request->isAJAX()) {
            return $this->themes::view('list_latest', $data);
        }

        $this->themes->addPartial('header_top', $params)
            ->addPartial('header_bottom', $params)
            ->addPartial('content_top', $params)
            ->addPartial('content_left', $params)
            ->addPartial('content_right', $params)
            ->addPartial('content_bottom', $params)
            ->addPartial('footer_top', $params)
            ->addPartial('footer_bottom', $params);

        $tpl_name = 'index';
        if (!empty($this->is_mobile)) {
            $tpl_name = 'mobile/index';
        }

        theme_load($tpl_name, $data);
    }

    private function _scriptGoogleSearch()
    {
        $category_model = new CategoryModel();
        $category_list = $category_model->getPostCategories();

        //GOOGLE BREADCRUMB STRUCTURED DATA
        $script_breadcrumb  = [];
        if (!empty($category_list)) {
            foreach ($category_list as $category) {
                $script_breadcrumb[] = [
                    'name' => $category['name'],
                    'url'  => sprintf('%s/%s',  base_url(), $category['slug'])
                ];
            }
        }
        $script_detail = null;
        $script_google_search = script_google_search($script_detail, $script_breadcrumb);

        return $script_google_search;
    }

    private function _getWeather()
    {
        try {
            helper(['text']);

            $getloc = json_decode(file_get_contents("http://ipinfo.io/"));

            $city_list = [
                1580578 => "Hồ Chí Minh",
                1581129 => "Hà Nội",
                1559970 => "Ninh Bình",
                1559969 => "Nghệ An",
                1559971 => "Ninh Thuận",
                1559972 => "Sóc Trăng",
                1559975 => "Trà Vinh",
                1559976 => "Tuyên Quang",
                1559977 => "Vĩnh Long",
                1559978 => "Yên Bái",
                1562412 => "Lào Cai",
                1562414 => "Vũng Tàu",
                1562798 => "Vinh",
                1564676 => "Tiền Giang",
                1565088 => "Kon Tum",
                1565033 => "Thừa Thiên-Huế",
                1566165 => "Thanh Hoá",
                1905497 => "Thái Nguyên",
                1566338 => "Thái Bình",
                1566557 => "Tây Ninh",
                1567643 => "Sơn La",
                1568043 => "Sa Pa",
                1582562 => "Đồng Tháp",
                1568510 => "Rach Gia",
                1568574 => "Quy Nhơn",
                1568733 => "Quảng Trị",
                1568758 => "Quảng Ninh",
                1568769 => "Quảng Ngãi",
                1568839 => "Quảng Bình",
                1569684 => "Pleiku",
                1569805 => "Phú Yên",
                1571058 => "Phan Thiết",
                1572151 => "Nha Trang",
                1572594 => "Hòa Bình",
                1573517 => "Nam Định",
                1575788 => "Long An",
                1576303 => "Lao Cai",
                1576632 => "Tỉnh Lạng Sơn",
                1576633 => "Lạng Sơn",
                1577882 => "Tỉnh Lâm Ðồng",
                1579008 => "Kiên Giang",
                1579634 => "Khánh Hòa",
                1905699 => "Hưng Yên",
                1580410 => "Hạ Long",
                1580700 => "Hà Tĩnh",
                1580830 => "Hoa Binh",
                1581030 => "Hà Giang",
                1581088 => "Gia Lai",
                1581188 => "Cần Thơ",
                1581297 => "Hải Phòng",
                1905686 => "Hải Dương",
                1581882 => "Bình Thuận",
                1582720 => "Đồng Nai",
                1583477 => "Điện Biên",
                1584169 => "Ðắk Lắk",
                1586182 => "Cao Bằng",
                1905678 => "Cà Mau",
                1587871 => "Bình Định",
                1587974 => "Bến Tre",
                1905412 => "Bắc Ninh",
                1905419 => "Bắc Giang",
                1905669 => "Bắc Kạn",
                1594446 => "An Giang",
                1905468 => "Đà Nẵng",
                1905475 => "Bình Duơng",
                1905480 => "Bình Phuớc",
                1905516 => "Quảng Nam",
                1905577 => "Phú Thọ",
                1905626 => "Nam Ðịnh",
                1905637 => "Hà Nam",
                1905675 => "Bạc Liêu",
                1905856 => "Vĩnh Phúc",

            ];

            $id = 1580578;
            foreach ($city_list as $key => $val) {
                if (strpos(convert_accented_characters(strtolower($val)), convert_accented_characters(strtolower($getloc->region))) !== FALSE) {
                    $id = $key;
                    break;
                }
            }
            $data = [];

            //break;
            //https://home.openweathermap.org/api_keys
            //http://api.openweathermap.org/data/2.5/weather?q=" . $city_name . "&lang=vi&units=metric&APPID=" . $api_key; //or forecast
            //"http://api.openweathermap.org/data/2.5/weather?lat=" . $user_client_info['geoplugin_latitude'] . "&lon=" . $user_client_info['geoplugin_longitude'] . "&lang=vi&units=metric&APPID=" . $api_key;
            $api_key = "e1bcab87ca5fada08e784d62483c578c";

            $googleApiUrl = "http://api.openweathermap.org/data/2.5/weather?id=" . $id . "&lang=vi&units=metric&APPID=" . $api_key;

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, $googleApiUrl);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_VERBOSE, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($ch);

            curl_close($ch);

            $data = json_decode($response, true);
            $data['name'] = $city_list[$id];
            $data['getloc'] = $getloc->region;

            return $data;
        } catch (\Exception $ex) {
            log_message('error', $ex->getMessage());
            return null;
        }
    }
}
