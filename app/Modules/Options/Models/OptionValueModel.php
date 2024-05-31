<?php

namespace App\Modules\Options\Models;

use App\Models\MyModel;

class OptionValueModel extends MyModel
{
    protected $table = 'option_value';
    protected $primaryKey = 'option_value_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'option_value_id',
        'option_id',
        'image',
        'sort_order',
    ];

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;

    protected $table_lang = 'option_value_lang';

    const OPTION_VALUE_CACHE_NAME = PREFIX_CACHE_NAME_MYSQL.'option_value_list_all';
    const OPTION_VALUE_CACHE_EXPIRE = YEAR;

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllByFilter($filter = null, $sort = null, $order = null)
    {
        $sort = in_array($sort, $this->allowedFields) ? "$this->table.$sort" : (in_array($sort, ['name']) ? "$this->table_lang.$sort" : '');
        $sort = !empty($sort) ? $sort : "$this->table.option_value_id";
        $order = ($order == 'ASC') ? 'ASC' : 'DESC';

        $this->where("$this->table_lang.language_id", language_id_admin());
        if (!empty($filter['option_value_id'])) {
            $this->whereIn("$this->table.option_value_id", (!is_array($filter['option_value_id']) ? explode(',', $filter['option_value_id']) : $filter['option_value_id']));
        }

        if (!empty($filter['name'])) {
            $this->like("$this->table_lang.name", $filter['name']);
        }

        $this->select("$this->table.*, $this->table_lang.*")
            ->join($this->table_lang, "$this->table_lang.option_value_id = $this->table.option_value_id")
            ->orderBy($sort, $order);

        return $this;
    }

    public function getOptionValueByOptionId($option_id, $language_id)
    {
        $result = $this->join($this->table_lang, "$this->table_lang.$this->primaryKey = $this->table.$this->primaryKey")
            ->orderBy('sort_order', 'DESC')
            ->where("$this->table.option_id", $option_id)
            ->findAll();

        if (empty($result)) {
            return [];
        }

        return $this->formatDataLanguage($result, $language_id);
    }

    public function getOptionValues($language_id, $is_cache = true)
    {
        $result = $is_cache ? cache()->get(self::OPTION_VALUE_CACHE_NAME) : null;
        if (empty($result)) {
            $result = $this
                ->join($this->table_lang, "$this->table_lang.$this->primaryKey = $this->table.$this->primaryKey")
                ->orderBy('sort_order', 'ASC')
                ->findAll();
            if (empty($result)) {
                return [];
            }

            if ($is_cache) {
                // Save into the cache for $expire_time 1 year
                cache()->save(self::OPTION_VALUE_CACHE_NAME, $result, self::OPTION_VALUE_CACHE_EXPIRE);
            }
        }

        return $this->formatDataLanguage($result, $language_id);
    }

    public function deleteCache()
    {
        cache()->delete(self::OPTION_VALUE_CACHE_NAME);

        return true;
    }
}
