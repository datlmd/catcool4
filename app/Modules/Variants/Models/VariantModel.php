<?php namespace App\Modules\Variants\Models;

use App\Models\MyModel;

class VariantModel extends MyModel
{
    protected $table      = 'variant';
    protected $primaryKey = 'variant_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'variant_id',
        'type',
        'sort_order'
    ];

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    protected $table_lang = 'variant_lang';
    protected $with = ['variant_lang'];

    const CACHE_NAME = 'variant_list_all';
    const CACHE_EXPIRE = DAY;

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllByFilter($filter = null, $sort = null, $order = null)
    {
        $sort  = in_array($sort, $this->allowedFields) ? "$this->table.$sort" : (in_array($sort, ['name']) ? "$this->table_lang.$sort" : "");
        $sort  = !empty($sort) ? $sort : "$this->table.$this->primaryKey";
        $order = ($order == 'ASC') ? 'ASC' : 'DESC';

        $this->where("$this->table_lang.language_id", get_lang_id(true));
        if (!empty($filter["$this->primaryKey"])) {
            $this->whereIn("$this->table.$this->primaryKey", (!is_array($filter["$this->primaryKey"]) ? explode(',', $filter["$this->primaryKey"]) : $filter["$this->primaryKey"]));
        }

        if (!empty($filter["name"])) {
            $this->like("$this->table_lang.name", $filter["name"]);
        }

        $this->select("$this->table.*, $this->table_lang.*")
            ->with(false)
            ->join($this->table_lang, "$this->table_lang.$this->primaryKey = $this->table.$this->primaryKey")
            ->orderBy($sort, $order);

        return $this;
    }

    public function getListAll($is_cache = true)
    {
        $result = $is_cache ? cache()->get(self::CACHE_NAME) : null;
        if (empty($result)) {
            $result = $this->orderBy('sort_order', 'ASC')->findAll();
            if (empty($result)) {
                return [];
            }

            if ($is_cache) {
                // Save into the cache for $expire_time 1 year
                cache()->save(self::CACHE_NAME, $result, self::CACHE_EXPIRE);
            }
        }

        if (empty($result)) {
            return [];
        }

        $list = [];

        $language_id = get_lang_id(true);
        foreach ($result as $value) {
            $list[$value["$this->primaryKey"]] = format_data_lang_id($value, $this->table_lang, $language_id);
        }

        //get list value
        $value_model = new VariantValueModel();
        $value_list = $value_model->getListAll();
        if (!empty($value_list)) {
            foreach ($value_list as $value) {
                $list[$value["$this->primaryKey"]]['value_list'][$value['variant_value_id']] = $value;
            }
        }

        return $list;
    }

    public function deleteCache()
    {
        cache()->delete(self::CACHE_NAME);

        $value_model = new VariantValueModel();
        $value_model->deleteCache();

        return true;
    }
}
