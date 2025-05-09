<?php

namespace App\Modules\Products\Models;

use App\Models\MyModel;

class WeightClassModel extends MyModel
{
    protected $table = 'weight_class';
    protected $primaryKey = 'weight_class_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'weight_class_id',
        'value',
    ];

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;

    protected $table_lang = 'weight_class_lang';

    public const WEIGHT_CLASS_CACHE_NAME = PREFIX_CACHE_NAME_MYSQL.'weight_class_list_all';
    public const WEIGHT_CLASS_CACHE_EXPIRE = YEAR;

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllByFilter($filter = null, $sort = null, $order = null)
    {
        $sort = in_array($sort, $this->allowedFields) ? "$this->table.$sort" : (in_array($sort, ['name']) ? "$this->table_lang.$sort" : '');
        $sort = !empty($sort) ? $sort : "$this->table.weight_class_id";
        $order = ($order == 'ASC') ? 'ASC' : 'DESC';

        $this->where("$this->table_lang.language_id", language_id_admin());
        if (!empty($filter['weight_class_id'])) {
            $this->whereIn("$this->table.weight_class_id", (!is_array($filter['weight_class_id']) ? explode(',', $filter['weight_class_id']) : $filter['weight_class_id']));
        }

        if (!empty($filter['name'])) {
            $this->like("$this->table_lang.name", $filter['name']);
        }

        $this->select("$this->table.*, $this->table_lang.*")
            ->join($this->table_lang, "$this->table_lang.weight_class_id = $this->table.weight_class_id")
            ->orderBy($sort, $order);

        return $this;
    }

    public function deleteCache()
    {
        cache()->delete(self::WEIGHT_CLASS_CACHE_NAME);

        return true;
    }

    public function getWeightClassesByIds(array $weight_class_ids, int $language_id): array
    {
        $result = $this->join($this->table_lang, "$this->table_lang.$this->primaryKey = $this->table.$this->primaryKey")
                ->where(["$this->table_lang.language_id" => $language_id])
                ->whereIn("$this->table.$this->primaryKey", $weight_class_ids)
                ->findAll();

        return $result;
    }

    /** ---------- Frontend ----------  **/
    public function getWeightClasses($language_id, $is_cache = true)
    {
        $result = $is_cache ? cache()->get(self::WEIGHT_CLASS_CACHE_NAME) : null;
        if (empty($result)) {
            $result = $this
                ->join($this->table_lang, "$this->table_lang.$this->primaryKey = $this->table.$this->primaryKey")
                ->orderBy('value', 'ASC')
                ->findAll();
            if (empty($result)) {
                return [];
            }

            if ($is_cache) {
                // Save into the cache for $expire_time 1 month
                cache()->save(self::WEIGHT_CLASS_CACHE_NAME, $result, self::WEIGHT_CLASS_CACHE_EXPIRE);
            }
        }

        return $this->formatDataLanguage($result, $language_id);
    }
}
