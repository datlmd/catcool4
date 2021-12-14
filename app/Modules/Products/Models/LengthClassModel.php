<?php namespace App\Modules\Products\Models;

use App\Models\MyModel;

class LengthClassModel extends MyModel
{
    protected $table      = 'length_class';
    protected $primaryKey = 'length_class_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'length_class_id',
        "value",
    ];

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    protected $table_lang = 'length_class_lang';
    protected $with = ['length_class_lang'];

    const LENGTH_CLASS_CACHE_NAME = 'length_class_list_all';
    const LENGTH_CLASS_CACHE_EXPIRE = YEAR;

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllByFilter($filter = null, $sort = null, $order = null)
    {
        $sort  = in_array($sort, $this->allowedFields) ? "$this->table.$sort" : (in_array($sort, ['name']) ? "$this->table_lang.$sort" : "");
        $sort  = !empty($sort) ? $sort : "$this->table.length_class_id";
        $order = ($order == 'ASC') ? 'ASC' : 'DESC';

        $this->where("$this->table_lang.language_id", get_lang_id(true));
        if (!empty($filter["length_class_id"])) {
            $this->whereIn("$this->table.length_class_id", (!is_array($filter["length_class_id"]) ? explode(',', $filter["length_class_id"]) : $filter["length_class_id"]));
        }

        if (!empty($filter["name"])) {
            $this->like("$this->table_lang.name", $filter["name"]);
        }

        $this->select("$this->table.*, $this->table_lang.*")
            ->with(false)
            ->join($this->table_lang, "$this->table_lang.length_class_id = $this->table.length_class_id")
            ->orderBy($sort, $order);

        return $this;
    }

    public function getListALL($is_cache = true)
    {
        $result = $is_cache ? cache()->get(self::LENGTH_CLASS_CACHE_NAME) : null;
        if (empty($result)) {
            $result = $this->orderBy('value', 'ASC')->findAll();
            if (empty($result)) {
                return false;
            }

            $language_id = get_lang_id(true);
            foreach ($result as $key => $value) {
                $result[$key] = format_data_lang_id($value, $this->table_lang, $language_id);
            }

            if ($is_cache) {
                // Save into the cache for $expire_time 1 month
                cache()->save(self::LENGTH_CLASS_CACHE_NAME, $result, self::LENGTH_CLASS_CACHE_EXPIRE);
            }
        }

        return $result;
    }

    public function deleteCache()
    {
        cache()->delete(self::LENGTH_CLASS_CACHE_NAME);
        return true;
    }
}
