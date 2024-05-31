<?php

namespace App\Modules\Attributes\Models;

use App\Models\MyModel;

class AttributeModel extends MyModel
{
    protected $table = 'attribute';
    protected $primaryKey = 'attribute_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'attribute_id',
        'sort_order',
        'attribute_group_id',
    ];

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;

    protected $table_lang = 'attribute_lang';

    const ATTRIBUTE_CACHE_NAME = PREFIX_CACHE_NAME_MYSQL.'attribute_list_all';
    const ATTRIBUTE_CACHE_EXPIRE = YEAR;

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllByFilter($filter = null, $sort = null, $order = null)
    {
        $sort = in_array($sort, $this->allowedFields) ? "$this->table.$sort" : (in_array($sort, ['name']) ? "$this->table_lang.$sort" : '');
        $sort = !empty($sort) ? $sort : "$this->table.attribute_id";
        $order = ($order == 'ASC') ? 'ASC' : 'DESC';

        $this->where("$this->table_lang.language_id", language_id_admin());
        if (!empty($filter['attribute_id'])) {
            $this->whereIn("$this->table.attribute_id", (!is_array($filter['attribute_id']) ? explode(',', $filter['attribute_id']) : $filter['attribute_id']));
        }

        if (!empty($filter['name'])) {
            $this->like("$this->table_lang.name", $filter['name']);
        }

        $this->select("$this->table.*, $this->table_lang.*")
            ->join($this->table_lang, "$this->table_lang.attribute_id = $this->table.attribute_id")
            ->orderBy($sort, $order);

        return $this;
    }

    public function deleteCache()
    {
        cache()->delete(self::ATTRIBUTE_CACHE_NAME);

        return true;
    }

    public function getAttributeByIds(array $attribute_ids, int $language_id): array
    {
        $result = $this->join($this->table_lang, "$this->table_lang.$this->primaryKey = $this->table.$this->primaryKey")
                ->orderBy('sort_order', 'DESC')
                ->where(["$this->table_lang.language_id" => $language_id])
                ->whereIn("$this->table.$this->primaryKey", $attribute_ids)
                ->findAll();

        return $result;
    }

    /** ------- Frontend ------- */
    public function getAttributes($language_id, $is_cache = true): array
    {
        $result = $is_cache ? cache()->get(self::ATTRIBUTE_CACHE_NAME) : null;
        if (empty($result)) {
            $result = $this
                ->join($this->table_lang, "$this->table_lang.$this->primaryKey = $this->table.$this->primaryKey")
                ->orderBy('sort_order', 'DESC')
                ->findAll();
            if (empty($result)) {
                return [];
            }

            if ($is_cache) {
                // Save into the cache for $expire_time 1 month
                cache()->save(self::ATTRIBUTE_CACHE_NAME, $result, self::ATTRIBUTE_CACHE_EXPIRE);
            }
        }

        return $this->formatDataLanguage($result, $language_id);
    }

    public function getAttributesDefault($language_id): array
    {
        $list = $this->getAttributes($language_id);
        if (empty($list)) {
            return [];
        }

        foreach ($list as $key => $value) {
            if ($value['attribute_group_id'] != config_item('attribute_default')) {
                unset($list[$key]);
            }
        }

        return $list;
    }
}
