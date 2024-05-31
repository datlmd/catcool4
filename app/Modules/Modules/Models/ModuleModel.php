<?php

namespace App\Modules\Modules\Models;

use App\Models\MyModel;

class ModuleModel extends MyModel
{
    protected $table = 'module';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'id',
        'module',
        'sub_module',
        'user_id',
        'published',
        'created_at',
        'updated_at',
    ];

    const MODULE_CACHE_NAME = PREFIX_CACHE_NAME_MYSQL.'module_list';
    const MODULE_CACHE_EXPIRE = 30 * MINUTE;

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllByFilter($filter = null, $sort = null, $order = null)
    {
        $sort = empty($sort) ? 'id' : $sort;
        $order = empty($order) ? 'DESC' : $order;
        $where = null;

        if (!empty($filter['module'])) {
            $this->like('module', $filter['module']);
        }

        if (!empty($filter['sub_module'])) {
            $this->like('sub_module', $filter['sub_module']);
        }

        if (!empty($where)) {
            $this->where($where);
        }

        $this->orderBy($sort, $order);

        return $this;
    }

    public function getListPublished($is_cache = false)
    {
        $result = $is_cache ? cache()->get(self::MODULE_CACHE_NAME) : null;
        if (empty($result)) {
            $result = $this->orderBy('module', 'ASC')->where(['published' => STATUS_ON])->findAll();
            if (empty($result)) {
                return null;
            }

            if ($is_cache) {
                // Save into the cache for $expire_time 1 year
                cache()->save(self::MODULE_CACHE_NAME, $result, self::MODULE_CACHE_EXPIRE);
            }
        }

        $list = [];
        foreach ($result as $value) {
            $list[$value['id']] = $value;
        }

        return $list;
    }

    public function deleteCache()
    {
        cache()->delete(self::MODULE_CACHE_NAME);

        return true;
    }
}
