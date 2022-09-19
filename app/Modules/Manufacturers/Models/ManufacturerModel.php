<?php namespace App\Modules\Manufacturers\Models;

use App\Models\MyModel;

class ManufacturerModel extends MyModel
{
    protected $table      = 'manufacturer';
    protected $primaryKey = 'manufacturer_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        "manufacturer_id",
        "sort_order",
        "published",
        "image",
    ];

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    protected $table_lang = 'manufacturer_lang';
    protected $with = ['manufacturer_lang'];

    const MANUFACTURER_CACHE_NAME   = 'manufacturer_list';
    const MANUFACTURER_CACHE_EXPIRE = YEAR;

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllByFilter($filter = null, $sort = null, $order = null)
    {
        $sort  = in_array($sort, $this->allowedFields) ? "$this->table.$sort" : (in_array($sort, ['name']) ? "$this->table_lang.$sort" : "");
        $sort  = !empty($sort) ? $sort : "$this->table.manufacturer_id";
        $order = ($order == 'ASC') ? 'ASC' : 'DESC';

        $this->where("$this->table_lang.language_id", get_lang_id(true));
        if (!empty($filter["manufacturer_id"])) {
            $this->whereIn("$this->table.manufacturer_id", (!is_array($filter["manufacturer_id"]) ? explode(',', $filter["manufacturer_id"]) : $filter["manufacturer_id"]));
        }

        if (!empty($filter["name"])) {
            $this->like("$this->table_lang.name", $filter["name"]);
        }

        $this->select("$this->table.*, $this->table_lang.*")
            ->with(false)
            ->join($this->table_lang, "$this->table_lang.manufacturer_id = $this->table.manufacturer_id")
            ->orderBy($sort, $order);

        return $this;
    }

    public function getListAll($is_cache = true)
    {
        $result = $is_cache ? cache()->get(self::MANUFACTURER_CACHE_NAME) : null;
        if (empty($result)) {
            $result = $this->orderBy('sort_order', 'DESC')->where(['published' => STATUS_ON])->findAll();
            if (empty($result)) {
                return [];
            }

            if ($is_cache) {
                // Save into the cache for $expire_time 1 month
                cache()->save(self::MANUFACTURER_CACHE_NAME, $result, self::MANUFACTURER_CACHE_EXPIRE);
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
        cache()->delete(self::MANUFACTURER_CACHE_NAME);
        return true;
    }
}
