<?php namespace App\Modules\News\Controllers;

use App\Controllers\BaseController;
use App\Modules\News\Models\NewsModel;
use App\Modules\News\Models\CategoryModel;
use App\Modules\Countries\Models\ProvinceModel;

class News extends BaseController
{
    protected $model;

    public function __construct()
    {
        parent::__construct();

        //set theme
        $this->themes->setTheme(config_item('theme_frontend'));

        $this->themes->addPartial('header_top')
            ->addPartial('header_bottom')
            ->addPartial('footer_top')
            ->addPartial('footer_bottom');

        $this->model = new NewsModel();
    }

    public function index()
    {
        $this->cachePage(180);

        $category_list = $this->model->getListHome(120);

        $new_list = [];
        if (!empty($category_list)) {
            foreach ($category_list as $cate) {
                if (count($new_list) >= 5) {
                    break;
                }

                if (empty($cate['list'])) {
                    continue;
                }

                foreach ($cate['list'] as $val) {
                    $new_list[] = $val;
                    break;
                }
            }
        }

        $data = [
            'category_list'        => $category_list,
            'slide_list'           => $this->model->getSlideHome(3),
            'counter_list'         => $this->model->getListCounter(10),
            'hot_list'             => $this->model->getListHot(4),
            'new_list'             => $new_list,
            'script_google_search' => $this->_scriptGoogleSearch(),
            'weather'              => $this->_getWeather(),
        ];

        add_meta(['title' => lang("News.heading_title")], $this->themes);

        theme_load('index', $data);
    }

    private function _scriptGoogleSearch()
    {
        $category_model = new CategoryModel();
        $category_list = $category_model->getListPublished();

        //GOOGLE BREADCRUMB STRUCTURED DATA
        $script_breadcrumb  = [];
        if (!empty($category_list)) {
            foreach ($category_list as $category) {
                $script_breadcrumb[] = [
                    'name' => $category['name'],
                    'url'  => sprintf('%s/%s.html',  base_url(), $category['slug'])
                ];
            }
        }
        $script_detail = null;
        $script_google_search = script_google_search($script_detail, $script_breadcrumb);

        return $script_google_search;
    }

    private function _getWeather()
    {
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
            1576303 =>"Lao Cai",
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
    }

    public function test($val = null)
    {
        $data = [
            'val' => !empty($val) ? $val : 0,
        ];

        add_meta(['title' => "Test"], $this->themes);

        theme_load('test', $data);
    }
}
