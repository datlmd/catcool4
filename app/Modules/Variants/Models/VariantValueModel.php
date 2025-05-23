<?php

namespace App\Modules\Variants\Models;

use App\Models\MyModel;

class VariantValueModel extends MyModel
{
    protected $table = 'variant_value';
    protected $primaryKey = 'variant_value_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'variant_value_id',
        'variant_id',
        'image',
        'sort_order',
    ];

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;

    protected $table_lang = 'variant_value_lang';

    public const VALUE_CACHE_NAME = PREFIX_CACHE_NAME_MYSQL.'variant_value_list_all';
    public const VALUE_CACHE_EXPIRE = YEAR;

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllByFilter($filter = null, $sort = null, $order = null)
    {
        $sort = in_array($sort, $this->allowedFields) ? "$this->table.$sort" : (in_array($sort, ['name']) ? "$this->table_lang.$sort" : '');
        $sort = !empty($sort) ? $sort : "$this->table.$this->primaryKey";
        $order = ($order == 'ASC') ? 'ASC' : 'DESC';

        $this->where("$this->table_lang.language_id", language_id_admin());
        if (!empty($filter["$this->primaryKey"])) {
            $this->whereIn("$this->table.$this->primaryKey", (!is_array($filter["$this->primaryKey"]) ? explode(',', $filter["$this->primaryKey"]) : $filter["$this->primaryKey"]));
        }

        if (!empty($filter['name'])) {
            $this->like("$this->table_lang.name", $filter['name']);
        }

        $this->select("$this->table.*, $this->table_lang.*")
            ->join($this->table_lang, "$this->table_lang.$this->primaryKey = $this->table.$this->primaryKey")
            ->orderBy($sort, $order);

        return $this;
    }

    public function deleteCache()
    {
        cache()->delete(self::VALUE_CACHE_NAME);

        return true;
    }

    /** ----------- Frontend ----------- **/
    public function getVariantValues($language_id, $is_cache = true)
    {
        $result = $is_cache ? cache()->get(self::VALUE_CACHE_NAME) : null;
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
                cache()->save(self::VALUE_CACHE_NAME, $result, self::VALUE_CACHE_EXPIRE);
            }
        }

        return $this->formatDataLanguage($result, $language_id);
    }

    public function getVariantInfo($variant_id, $language_id)
    {
        $result = $this
            ->join($this->table_lang, "$this->table_lang.$this->primaryKey = $this->table.$this->primaryKey")
            ->orderBy('sort_order', 'DESC')
            ->where("$this->table.variant_id", $variant_id)
            ->findAll();
        if (empty($result)) {
            return [];
        }

        $result = $this->formatDataLanguage($result, $language_id);
        foreach ($result as $key => $value) {
            $result[$key]['variant_value_row'] = format_product_variant_row($value['variant_value_id']);
        }

        return $result;
    }
}
