<?php

namespace App\Modules\News\Models;

use App\Models\MyModel;

class CategoryModel extends MyModel
{
    protected $table = 'news_category';
    protected $primaryKey = 'category_id';

    protected $allowedFields = [
        'category_id',
        'name',
        'slug',
        'description',
        'image',
        'sort_order',
        'parent_id',
        'published',
        'meta_title',
        'meta_description',
        'meta_keyword',
        'language_id',
        'created_at',
        'updated_at',
    ];

    const CATEGORY_CACHE_NAME = PREFIX_CACHE_NAME_MYSQL.'news_category_list';
    const CATEGORY_CACHE_EXPIRE = YEAR;

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllByFilter($filter = null, $sort = null, $order = null)
    {
        $sort = in_array($sort, $this->allowedFields) ? $sort : 'sort_order';
        $order = ($order == 'ASC') ? 'ASC' : 'DESC';

        if (!empty($filter['name'])) {
            $this->like("$this->table_lang.name", $filter['name']);
        }

        $result = $this->orderBy($sort, $order)->findAll();
        if (empty($result)) {
            return null;
        }

        return $result;
    }

    public function deleteCache()
    {
        cache()->delete(self::CATEGORY_CACHE_NAME);

        return true;
    }

    public function getNewsCategories($language_id, $is_cache = true)
    {
        $result = $is_cache ? cache()->get(self::CATEGORY_CACHE_NAME) : null;
        if (empty($result)) {
            $result = $this->orderBy('sort_order', 'DESC')->where(['published' => STATUS_ON])->findAll();
            if (empty($result)) {
                return [];
            }

            if ($is_cache) {
                // Save into the cache for $expire_time 1 month
                cache()->save(self::CATEGORY_CACHE_NAME, $result, self::CATEGORY_CACHE_EXPIRE);
            }
        }

        return $result;
    }
}
