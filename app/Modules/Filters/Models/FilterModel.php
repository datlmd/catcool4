<?php

namespace App\Modules\Filters\Models;

use App\Models\MyModel;

class FilterModel extends MyModel
{
    protected $table = 'filter';
    protected $primaryKey = 'filter_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'filter_id',
        'filter_group_id',
        'sort_order',
    ];

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;

    protected $table_lang = 'filter_lang';

    public const FILTER_CACHE_NAME = PREFIX_CACHE_NAME_MYSQL.'filter_list';
    public const FILTER_CACHE_EXPIRE = YEAR;

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllByFilter($filter = null, $sort = null, $order = null)
    {
        $sort = in_array($sort, $this->allowedFields) ? "$this->table.$sort" : (in_array($sort, ['name']) ? "$this->table_lang.$sort" : '');
        $sort = !empty($sort) ? $sort : "$this->table.filter_id";
        $order = ($order == 'ASC') ? 'ASC' : 'DESC';

        $this->where("$this->table_lang.language_id", language_id_admin());
        if (!empty($filter['filter_id'])) {
            $this->whereIn("$this->table.filter_id", (!is_array($filter['filter_id']) ? explode(',', $filter['filter_id']) : $filter['filter_id']));
        }

        if (!empty($filter['name'])) {
            $this->like("$this->table_lang.name", $filter['name']);
        }

        $this->select("$this->table.*, $this->table_lang.*")
            ->join($this->table_lang, "$this->table_lang.filter_id = $this->table.filter_id")
            ->orderBy($sort, $order);

        return $this;
    }

    public function deleteCache()
    {
        cache()->delete(self::FILTER_CACHE_NAME);

        return true;
    }

    public function getFiltersByGroupId($filter_group_id, $language_id)
    {
        $result = $this->join($this->table_lang, "$this->table_lang.$this->primaryKey = $this->table.$this->primaryKey")
            ->orderBy('sort_order', 'DESC')
            ->where(["$this->table.filter_group_id" => $filter_group_id])
            ->findAll();

        if (empty($result)) {
            return [];
        }

        $filters = [];
        foreach ($result as $value) {
            if ($value['language_id'] == $language_id) {
                $filters[$value['filter_id']] = isset($filters[$value['filter_id']]) ? array_merge($filters[$value['filter_id']], $value) : $value;
            }
            $filters[$value['filter_id']]['lang'][$value['language_id']] = $value;
        }

        return $filters;
    }

    public function getFilters($language_id, $is_cache = true)
    {
        $result = $is_cache ? cache()->get(self::FILTER_CACHE_NAME) : null;
        if (empty($result)) {
            $result = $this->join($this->table_lang, "$this->table_lang.$this->primaryKey = $this->table.$this->primaryKey")
                ->orderBy('sort_order', 'DESC')
                ->findAll();
            if (empty($result)) {
                return [];
            }

            if ($is_cache) {
                // Save into the cache for $expire_time 1 month
                cache()->save(self::FILTER_CACHE_NAME, $result, self::FILTER_CACHE_EXPIRE);
            }
        }

        return $this->formatDataLanguage($result, $language_id);
    }
}
