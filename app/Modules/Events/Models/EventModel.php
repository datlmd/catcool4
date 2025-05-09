<?php

namespace App\Modules\Events\Models;

use App\Models\MyModel;

class EventModel extends MyModel
{
    protected $table = 'event';
    protected $primaryKey = 'event_id';

    protected $allowedFields = [
        'event_id',
        'code',
        'action',
        'published',
        'priority',
    ];

    public const EVENTS_CACHE_NAME = PREFIX_CACHE_NAME_MYSQL.'events_list';
    public const EVENTS_CACHE_EXPIRE = YEAR;

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
                $this->like("$this->table.name", $filter['name']);
            }
        }

        return $this->orderBy($sort, $order);
    }

    public function getEvents($is_cache = true)
    {
        $result = $is_cache ? cache()->get(self::EVENTS_CACHE_NAME) : null;
        if (empty($result)) {
            $result = $this->where(['published' => STATUS_ON])->orderBy('event_id', 'DESC')->findAll();
            if (empty($result)) {
                return [];
            }

            if ($is_cache) {
                // Save into the cache for $expire_time 1 month
                cache()->save(self::EVENTS_CACHE_NAME, $result, self::EVENTS_CACHE_EXPIRE);
            }
        }

        return $result;
    }

    public function deleteCache()
    {
        cache()->delete(self::EVENTS_CACHE_NAME);

        return true;
    }
}
