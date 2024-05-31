<?php

namespace App\Modules\Languages\Models;

use App\Models\MyModel;

class LanguageModel extends MyModel
{
    protected $table = 'language';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'id',
        'name',
        'code',
        'icon',
        'user_id',
        'published',
        'created_at',
        'updated_at',
    ];

    const LANGUAGE_CACHE_NAME = PREFIX_CACHE_NAME_MYSQL.'language_list';
    const LANGUAGE_CACHE_EXPIRE = YEAR;

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllByFilter($filter = null, $sort = null, $order = null)
    {
        $sort = in_array($sort, $this->allowedFields) ? $sort : 'id';
        $order = empty($order) ? 'DESC' : $order;

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
