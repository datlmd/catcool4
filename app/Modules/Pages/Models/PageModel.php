<?php

namespace App\Modules\Pages\Models;

use App\Models\MyModel;

class PageModel extends MyModel
{
    protected $table = 'page';
    protected $primaryKey = 'page_id';

    protected $table_lang = 'page_lang';
    protected $with = ['page_lang'];

    protected $allowedFields = [
        'page_id',
        'body_class',
        'layout',
        'sort_order',
        'published',
        'deleted',
        'created_at',
        'updated_at',
    ];

    protected $useSoftDeletes = true;
    protected $deletedField = 'deleted';

    const PAGE_CACHE_NAME = 'page_list';
    const PAGE_CACHE_EXPIRE = YEAR;

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllByFilter($filter = null, $sort = null, $order = null)
    {
        $sort = in_array($sort, $this->allowedFields) ? "$this->table.$sort" : (in_array($sort, ['name']) ? "$this->table_lang.$sort" : '');
        $sort = !empty($sort) ? $sort : "$this->table.page_id";
        $order = ($order == 'ASC') ? 'ASC' : 'DESC';

        $this->where("$this->table_lang.language_id", language_id_admin());

        if (!empty($filter['page_id'])) {
            $this->whereIn("$this->table.page_id", (!is_array($filter['page_id']) ? explode(',', $filter['page_id']) : $filter['page_id']));
        }

        if (!empty($filter['name'])) {
            $this->like("$this->table_lang.name", $filter['name']);
        }

        if (!empty($filter['published'])) {
            $this->where("$this->table.published", $filter['published']);
        }

        $result = $this->select("$this->table.*, $this->table_lang.*")
            ->with(false)
            ->join($this->table_lang, "$this->table_lang.page_id = $this->table.page_id")
            ->orderBy($sort, $order);

        return $result;
    }

    public function getPages($language_id, $is_cache = true)
    {
        $result = $is_cache ? cache()->get(self::PAGE_CACHE_NAME) : null;
        if (empty($result)) {
            $result = $this->orderBy('sort_order', 'DESC')->where(['published' => STATUS_ON])->findAll();

            if ($is_cache) {
                // Save into the cache for $expire_time 1 month
                cache()->save(self::PAGE_CACHE_NAME, $result, self::PAGE_CACHE_EXPIRE);
            }
        }

        if (empty($result)) {
            return [];
        }

        $page_list = [];
        foreach ($result as $key => $value) {
            $page_list[$value['page_id']] = format_data_lang_id($value, $this->table_lang, $language_id);
        }

        return $page_list;
    }

    public function getPageInfo($page_id, $language_id, $is_cache = true)
    {
        if (empty($page_id)) {
            return [];
        }

        $page_list = $this->getPages($language_id, $is_cache);
        if (empty($page_list[$page_id])) {
            return [];
        }

        return $page_list[$page_id];
    }

    public function deleteCache($id = null)
    {
        cache()->delete(self::PAGE_CACHE_NAME.$id);

        return true;
    }
}
