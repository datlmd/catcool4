<?php namespace App\Modules\News\Controllers;

use App\Controllers\BaseController;
use App\Modules\News\Models\NewsModel;

class Robot extends BaseController
{
    protected $model;

    public function __construct()
    {
        parent::__construct();

    }
        /**
     *
     * @param null $robot_type
     * @param int $robot_href_position - index array config
     */
    public function index($robot_type = null, $robot_href_position = null)
    {
        $model = new NewsModel();
        try {
            echo "Đang quét tin..." . PHP_EOL;

            $robot = Config('Robot');

            $list = [];

            switch ($robot_type) {
                case 'kenh14':
                    $kenh14 = $robot->pageKenh14;
                    if (!empty($robot_href_position)) {
                        $robot_href_position = is_array($robot_href_position) ? $robot_href_position : explode(',', $robot_href_position);

                        foreach ($kenh14['attribute_menu'] as $key => $value) {
                            if (!in_array($key, $robot_href_position)) {
                                unset($kenh14['attribute_menu'][$key]);
                            }
                        }
                    }
                    $list = $model->robotGetNews($kenh14);
                    break;
                default:
                    break;
            }

            $total = 0;
            foreach ($list as $value) {
                if (empty($value['list_news'])) {
                    continue;
                }
                $total += count($value['list_news']);
            }

            echo "Đã thêm được {$total} tin!" . PHP_EOL;
        } catch (\Exception $e)
        {
            echo $e->getMessage() . PHP_EOL;
        }
    }
}
