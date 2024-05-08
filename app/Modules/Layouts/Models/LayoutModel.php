<?php namespace App\Modules\Layouts\Models;

use App\Models\MyModel;

class LayoutModel extends MyModel
{
    protected $table      = 'layout';
    protected $primaryKey = 'layout_id';

    protected $allowedFields = [
        'layout_id',
        'name',
    ];

    const CACHE_NAME_LIST = 'layout_list';
    const CACHE_EXPIRE = YEAR;

    function __construct()
    {
        parent::__construct();
    }

    public function getAllByFilter($filter = null, $sort = null, $order = null)
    {
        $sort  = in_array($sort, $this->allowedFields) ? $sort : "$this->table.layout_id";
        $order = empty($order) ? 'DESC' : $order;

        if (!empty($filter["layout_id"])) {
            $this->whereIn("$this->table.layout_id", (is_array($filter["layout_id"])) ? $filter["layout_id"] : explode(',', $filter["layout_id"]));
        }

        if (!empty($filter["name"])) {
            if (!empty($filter["name"])) {
                $this->Like("$this->table.name", $filter["name"]);
            }
        }

        return $this->orderBy($sort, $order);
    }

    public function getLayouts($is_cache = true)
    {
        $result = $is_cache ? cache()->get(self::CACHE_NAME_LIST) : null;
        if (empty($result)) {
            $result = $this->findAll();
            if (empty($result)) {
                return [];
            }

            $list = [];
            foreach ($result as $value) {
                $list[$value['layout_id']] = $value;
            }

            $result = $list;
            if ($is_cache) {
                cache()->save(self::CACHE_NAME_LIST, $result, self::CACHE_EXPIRE);
            }
        }

        return $result;
    }

    public function getLayout($id, $is_cache = true)
    {
        $list = $this->getLayouts($is_cache);
        if (empty($list[$id])) {
            return null;
        }

        $route_model = new RouteModel();
        $module_model = new ModuleModel();

        $info = $list[$id];
        $info['routes']  = $route_model->getRoutesByLayoutId($info['layout_id']);
        $info['modules'] = $module_model->getModulesByLayoutId($info['layout_id']);

        return $info;
    }

    public function deleteCache()
    {
        $route_model = new RouteModel();
        $module_model = new ModuleModel();

        $route_model->deleteCache();
        $module_model->deleteCache();

        cache()->delete(self::CACHE_NAME_LIST);
        return true;
    }

    public function getLayoutsByPostion($route, $position, $is_cache = true)
    {
        if (empty($route)) {
            return [];
        }

        $position_list = [
            'column_left',
            'content_top',
            'content_bottom',
            'column_right'
        ];

        if (!in_array($position, $position_list)) {
            return [];
        }

        $action_model = new ActionModel();
        $route_model = new RouteModel();
        $module_model = new ModuleModel();

        $layout_list = $this->getLayouts($is_cache);
        $route_list = $route_model->getRoutes($is_cache);
        $module_list = $module_model->getModules($is_cache);
        $action_list = $action_model->getActions($is_cache);

        $layout_id = 0;
        foreach ($route_list as $value) {
            if (strtolower($value['route']) == strtolower($route)) {
                $layout_id = $value['layout_id'];
                break;
            }
        }
        
        $list = [];
        foreach ($module_list as $value) {
            if ($value['layout_id'] != $layout_id || $value['position'] != $position) {
                continue;
            }

            $list[] = array_merge($value, $action_list[$value['layout_action_id']]);
        }

        $sort_list = array_column($list, 'sort_order');

        array_multisort($sort_list, SORT_DESC, $list);

        return $list;
    }
}
