<?php

namespace App\Modules\GeoZones\Models;

use App\Models\MyModel;

class GeoZoneModel extends MyModel
{
    protected $table = 'geo_zone';
    protected $primaryKey = 'geo_zone_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'name',
        'description',
    ];

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;

    protected $table_lang = 'option_lang';

    public const OPTION_CACHE_NAME = PREFIX_CACHE_NAME_MYSQL.'option_list_all';
    public const OPTION_CACHE_EXPIRE = DAY;

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

    public function getOptionsByIds(array $option_ids, int $language_id): array
    {
        $result = $this->join($this->table_lang, "$this->table_lang.$this->primaryKey = $this->table.$this->primaryKey")
                ->where(["$this->table_lang.language_id" => $language_id])
                ->whereIn("$this->table.$this->primaryKey", $option_ids)
                ->findAll();

        return $result;
    }

    public function deleteCache()
    {
        cache()->delete(self::OPTION_CACHE_NAME);

        $option_value_model = new OptionValueModel();
        $option_value_model->deleteCache();

        return true;
    }

    public function getOptions($language_id, $is_cache = true)
    {
        $result = $is_cache ? cache()->get(self::OPTION_CACHE_NAME) : null;
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
                cache()->save(self::OPTION_CACHE_NAME, $result, self::OPTION_CACHE_EXPIRE);
            }
        }

        if (empty($result)) {
            return [];
        }

        $list = $this->formatDataLanguage($result, $language_id);

        //get list option value
        $option_value_model = new OptionValueModel();
        $option_value_list = $option_value_model->getOptionValues($language_id);
        if (!empty($option_value_list)) {
            foreach ($option_value_list as $value) {
                $list[$value['option_id']]['option_value_list'][$value['option_value_id']] = $value;
            }
        }

        return $list;
    }
}
