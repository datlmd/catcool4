<?php namespace App\Modules\Layouts\Models;

use App\Models\MyModel;

class ActionModel extends MyModel
{
    protected $table      = 'layout_action';
    protected $primaryKey = 'layout_action_id';

    protected $allowedFields = [
        'layout_action_id',
        'name',
        'controller',
        'action',
    ];

    const CACHE_NAME_LIST = 'layout_action_list';
    const CACHE_EXPIRE = YEAR;

    function __construct()
    {
        parent::__construct();
    }

    public function getAllByFilter($filter = null, $sort = null, $order = null)
    {
        $sort  = in_array($sort, $this->allowedFields) ? $sort : 'layout_action_id';
        $order = empty($order) ? 'DESC' : $order;

        if (!empty($filter["layout_action_id"])) {
            $this->whereIn('layout_action_id', (is_array($filter["layout_action_id"])) ? $filter["layout_action_id"] : explode(',', $filter["layout_action_id"]));
        }

        if (!empty($filter["name"])) {
            if (!empty($filter["name"])) {
                $this->Like('name', $filter["name"]);
            }
        }

        return $this->orderBy($sort, $order);
    }

    public function getActions($is_cache = true)
    {
        $result = $is_cache ? cache()->get(self::CACHE_NAME_LIST) : null;
        if (empty($result)) {
            $result = $this->findAll();
            if (empty($result)) {
                return [];
            }

            $list = [];
            foreach ($result as $value) {
                $list[$value['layout_action_id']] = $value;
            }

            $result = $list;
            if ($is_cache) {
                cache()->save(self::CACHE_NAME_LIST, $result, self::CACHE_EXPIRE);
            }
        }

        return $result;
    }

    public function deleteCache()
    {
        cache()->delete(self::CACHE_NAME_LIST);
        return true;
    }
}
