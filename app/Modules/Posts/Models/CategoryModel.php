<?php namespace App\Modules\Posts\Models;

use App\Models\MyModel;

class CategoryModel extends MyModel
{
    protected $table      = 'post_category';
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
        'ctime',
        'mtime',
    ];

    const CATEGORY_CACHE_NAME   = 'post_category_list';
    const CATEGORY_CACHE_EXPIRE = YEAR;

    function __construct()
    {
        parent::__construct();
    }

    public function getAllByFilter($filter = null, $sort = null, $order = null)
    {
        $sort  = in_array($sort, $this->allowedFields) ? $sort : "sort_order";
        $order = ($order == 'ASC') ? 'ASC' : 'DESC';


        if (!empty($filter["name"])) {
            $this->like("$this->table_lang.name", $filter["name"]);
        }

        $result = $this->orderBy($sort, $order)->findAll();
        if (empty($result)) {
            return null;
        }

        return $result;
    }

    public function getListPublished($is_cache = true)
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

        if (empty($result)) {
            return [];
        }

        $language_id = get_lang_id(true);
        foreach ($result as $key => $value) {
            $result[$key] = format_data_lang_id($value, $this->table_lang, $language_id);
        }

        return $result;
    }

    public function deleteCache()
    {
        cache()->delete(self::CATEGORY_CACHE_NAME);
        return true;
    }
}
