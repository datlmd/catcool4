<?php

namespace App\Modules\Locations\Models;

use App\Models\MyModel;

class LocationModel extends MyModel
{
    protected $table = 'location';
    protected $primaryKey = 'location_id';

    protected $allowedFields = [
        'location_id',
        'name',
        'address',
        'telephone',
        'geocode',
        'image',
        'open',
        'comment',
    ];

    const LOCATION_CACHE_NAME = 'location_list_all';
    const LOCATION_CACHE_EXPIRE = YEAR;

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllByFilter($filter = null, $sort = null, $order = null)
    {
        $sort = in_array($sort, $this->allowedFields) ? $sort : "$this->table.$this->primaryKey";
        $order = empty($order) ? 'DESC' : $order;

        if (!empty($filter["$this->primaryKey"])) {
            $this->whereIn("$this->table.$this->primaryKey", (is_array($filter["$this->primaryKey"])) ? $filter["$this->primaryKey"] : explode(',', $filter["$this->primaryKey"]));
        }

        if (!empty($filter['name'])) {
            if (!empty($filter['name'])) {
                $this->Like("$this->table.name", $filter['name']);
            }
        }

        return $this->orderBy($sort, $order);
    }

    public function getLocations($is_cache = true)
    {
        $result = $is_cache ? cache()->get(self::LOCATION_CACHE_NAME) : null;
        if (empty($result)) {
            $result = $this->orderBy('location_id', 'DESC')->findAll();
            if (empty($result)) {
                return [];
            }

            if ($is_cache) {
                // Save into the cache for $expire_time 1 month
                cache()->save(self::LOCATION_CACHE_NAME, $result, self::LOCATION_CACHE_EXPIRE);
            }
        }

        return $result;
    }

    public function deleteCache()
    {
        cache()->delete(self::LOCATION_CACHE_NAME);

        return true;
    }
}
