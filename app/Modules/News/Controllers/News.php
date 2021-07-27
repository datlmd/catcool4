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


        $data = [
            'category_list'        => $this->model->getListHome(),
            'slide_list'           => $this->model->getSlideHome(3),
            'counter_list'         => $this->model->getListCounter(10),
            'hot_list'             => $this->model->getListHot(4),
            'new_list'             => $this->model->getListNew(5),
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
        //@$_SERVER['HTTP_X_FORWARDED_FOR']
        $user_client_info = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip=' . $this->request->getIPAddress()));

        //cc_debug($new_arr);
//        $province_model = new ProvinceModel();
//        $province_list = $province_model->getListPublished();
//
//        foreach ($province_list as $key => $value) {
//            if ($value['country_id'] != 237) {
//                unset($province_list[$key]);
//            }
//        }

        $data = [];

        if (!empty($user_client_info['geoplugin_latitude']) && !empty($user_client_info['geoplugin_longitude'])) {
            //https://home.openweathermap.org/api_keys
            //http://api.openweathermap.org/data/2.5/weather?q=" . $city_name . "&lang=vi&units=metric&APPID=" . $api_key; //or forecast
            $api_key = "e1bcab87ca5fada08e784d62483c578c";
            $city_name = "sa dec";
            $googleApiUrl = "http://api.openweathermap.org/data/2.5/weather?lat=" . $user_client_info['geoplugin_latitude'] . "&lon=" . $user_client_info['geoplugin_longitude'] . "&lang=vi&units=metric&APPID=" . $api_key;

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
        }

        return $data;
    }
}
