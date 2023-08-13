<?php namespace App\Modules\Attributes\Models;

use App\Models\MyModel;

class AttributeModel extends MyModel
{
    protected $table      = 'attribute';
    protected $primaryKey = 'attribute_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        "attribute_id",
        "sort_order",
        "attribute_group_id",
    ];

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    protected $table_lang = 'attribute_lang';
    protected $with = ['attribute_lang'];

    const ATTRIBUTE_CACHE_NAME = 'attribute_list_all';
    const ATTRIBUTE_CACHE_EXPIRE = YEAR;

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllByFilter($filter = null, $sort = null, $order = null)
    {
        $sort  = in_array($sort, $this->allowedFields) ? "$this->table.$sort" : (in_array($sort, ['name']) ? "$this->table_lang.$sort" : "");
        $sort  = !empty($sort) ? $sort : "$this->table.attribute_id";
        $order = ($order == 'ASC') ? 'ASC' : 'DESC';

        $this->where("$this->table_lang.language_id", get_lang_id(true));
        if (!empty($filter["attribute_id"])) {
            $this->whereIn("$this->table.attribute_id", (!is_array($filter["attribute_id"]) ? explode(',', $filter["attribute_id"]) : $filter["attribute_id"]));
        }

        if (!empty($filter["name"])) {
            $this->like("$this->table_lang.name", $filter["name"]);
        }

        $this->select("$this->table.*, $this->table_lang.*")
            ->with(false)
            ->join($this->table_lang, "$this->table_lang.attribute_id = $this->table.attribute_id")
            ->orderBy($sort, $order);

        return $this;
    }

    public function getListAll($is_cache = true) : array
    {
        $result = $is_cache ? cache()->get(self::ATTRIBUTE_CACHE_NAME) : null;
        if (empty($result)) {
            $result = $this->orderBy('sort_order', 'DESC')->findAll();
            if (empty($result)) {
                return [];
            }

            if ($is_cache) {
                // Save into the cache for $expire_time 1 month
                cache()->save(self::ATTRIBUTE_CACHE_NAME, $result, self::ATTRIBUTE_CACHE_EXPIRE);
            }
        }

        if (empty($result)) {
            return [];
        }

        $list = [];

        $language_id = get_lang_id(true);
        foreach ($result as $value) {
            $list[$value['attribute_id']] = format_data_lang_id($value, $this->table_lang, $language_id);
        }

        return $list;
    }

    public function getListAttributeDefault() : array
    {
        $list = $this->getListAll();
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

    public function deleteCache()
    {
        cache()->delete(self::ATTRIBUTE_CACHE_NAME);
        return true;
    }
}
