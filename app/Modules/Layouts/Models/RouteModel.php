<?php namespace App\Modules\Layouts\Models;

use App\Models\MyModel;

class RouteModel extends MyModel
{
    protected $table      = 'layout_route';
    protected $primaryKey = 'layout_route_id';

    protected $allowedFields = [
        'layout_id',
        'store_id',
        'route',
    ];

    const CACHE_NAME_LIST = PREFIX_CACHE_NAME_MYSQL.'layout_route_list';
    const CACHE_EXPIRE = YEAR;

    function __construct()
    {
        parent::__construct();
    }

    public function getRoutes($is_cache = true)
    {
        $result = $is_cache ? cache()->get(self::CACHE_NAME_LIST) : null;
        if (empty($result)) {
            $result = $this->findAll();
            if (empty($result)) {
                return [];
            }

            if ($is_cache) {
                cache()->save(self::CACHE_NAME_LIST, $result, self::CACHE_EXPIRE);
            }
        }

        return $result;
    }

    public function getRoutesByLayoutId($layout_id, $is_cache = true)
    {
        $list = $this->getRoutes($is_cache);
        if (empty($list)) {
            return [];
        }

        $layouts = [];
        foreach ($list as $value) {
            if ($value['layout_id'] != $layout_id) {
                continue;
            }
            $layouts[] = $value;
        }

        return $layouts;
    }

    public function deleteCache()
    {
        cache()->delete(self::CACHE_NAME_LIST);
        return true;
    }
}
