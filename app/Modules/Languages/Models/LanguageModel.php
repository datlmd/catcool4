<?php namespace App\Modules\Languages\Models;

use App\Models\MyModel;

class LanguageModel extends MyModel
{
    protected $table      = 'language';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'id',
        'name',
        'code',
        'icon',
        'user_id',
        'published',
        'ctime',
        'mtime',
    ];

    const LANGUAGE_CACHE_NAME   = 'language_list';
    const LANGUAGE_CACHE_EXPIRE = YEAR;

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

        return $this->orderBy($sort, $order)->findAll();
    }

    public function getListPublished($is_cache = false)
    {
        $result = $is_cache ? cache()->get(self::LANGUAGE_CACHE_NAME) : null;
        if (empty($result)) {
            $result = $this->where(['published' => STATUS_ON])->findAll();
            if (empty($result)) {
                return null;
            }

            if ($is_cache) {
                // Save into the cache for $expire_time 1 year
                cache()->save(self::LANGUAGE_CACHE_NAME, $result, self::LANGUAGE_CACHE_EXPIRE);
            }
        }

        return $result;
    }

    public function deleteCache()
    {
        cache()->delete(self::LANGUAGE_CACHE_NAME);
        return true;
    }
}
