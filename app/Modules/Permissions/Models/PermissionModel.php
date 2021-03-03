<?php namespace App\Modules\Permissions\Models;

use App\Models\MyModel;

class PermissionModel extends MyModel
{
    protected $table      = 'permission';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'id',
        'name',
        'description',
        'published',
    ];

    const PERMISSION_CACHE_NAME   = 'permission_list';
    const PERMISSION_CACHE_EXPIRE = YEAR;

    function __construct()
    {
        parent::__construct();
    }

    public function getAllByFilter($filter = null, $sort = null, $order = null)
    {
        $sort  = empty($sort) ? 'id' : $sort;
        $order = empty($order) ? 'DESC' : $order;
        $where = null;

        if (!empty($filter["id"])) {
            $where .= "id IN(" . (is_array($filter["id"]) ? implode(',', $filter["id"]) : $filter["id"]) . ")";
        }

        if (!empty($filter["name"])) {
            $where .= empty($where) ? "" : " AND ";
            $where .= "(name LIKE '%" . $filter["name"] . "%' OR description LIKE '%" . $filter["name"] . "%')";
        }

        if (!empty($where)) {
            $this->where($where);
        }

        $this->orderBy($sort, $order);

        return $this;
    }

    public function getListPublished($is_cache = true)
    {
        $result = $is_cache ? cache()->get(self::PERMISSION_CACHE_NAME) : null;
        if (empty($result)) {
            $result = $this->where(['published' => STATUS_ON])->findAll();
            if (empty($result)) {
                return null;
            }
            // Save into the cache for $expire_time 1 year
            cache()->save(self::PERMISSION_CACHE_NAME, $result, self::PERMISSION_CACHE_EXPIRE);
        }

        return $result;
    }

    public function deleteCache()
    {
        cache()->delete(self::PERMISSION_CACHE_NAME);
        return true;
    }
}
