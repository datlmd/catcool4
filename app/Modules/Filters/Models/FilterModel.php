<?php namespace App\Modules\Filters\Models;

use App\Models\MyModel;

class FilterModel extends MyModel
{
    protected $table      = 'filter';
    protected $primaryKey = 'filter_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'filter_id',
        'filter_group_id',
        'sort_order'
    ];

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    protected $table_lang = 'filter_lang';
    protected $with = ['filter_lang'];

    const FILTER_CACHE_NAME   = 'filter_list';
    const FILTER_CACHE_EXPIRE = YEAR;

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllByFilter($filter = null, $sort = null, $order = null)
    {
        $sort  = in_array($sort, $this->allowedFields) ? "$this->table.$sort" : (in_array($sort, ['name']) ? "$this->table_lang.$sort" : "");
        $sort  = !empty($sort) ? $sort : "$this->table.filter_id";
        $order = ($order == 'ASC') ? 'ASC' : 'DESC';

        $this->where("$this->table_lang.language_id", get_lang_id(true));
        if (!empty($filter["filter_id"])) {
            $this->whereIn("$this->table.filter_id", (!is_array($filter["filter_id"]) ? explode(',', $filter["filter_id"]) : $filter["filter_id"]));
        }

        if (!empty($filter["name"])) {
            $this->like("$this->table_lang.name", $filter["name"]);
        }

        $this->select("$this->table.*, $this->table_lang.*")
            ->with(false)
            ->join($this->table_lang, "$this->table_lang.filter_id = $this->table.filter_id")
            ->orderBy($sort, $order);

        return $this;
    }

    public function getListByFilterGroupId($filter_group_id)
    {
        $result = $this->orderBy('sort_order', 'DESC')->where('filter_group_id', $filter_group_id)->findAll();
        if (empty($result)) {
            return [];
        }

        $language_id = get_lang_id(IS_ADMIN);
        foreach ($result as $key => $value) {
            $result[$key] = format_data_lang_id($value, $this->table_lang, $language_id);
        }

        return $result;
    }

    public function getListAll($is_cache = true)
    {
        $result = $is_cache ? cache()->get(self::FILTER_CACHE_NAME) : null;
        if (empty($result)) {
            $result = $this->orderBy('sort_order', 'DESC')->findAll();
            if (empty($result)) {
                return [];
            }

            if ($is_cache) {
                // Save into the cache for $expire_time 1 month
                cache()->save(self::FILTER_CACHE_NAME, $result, self::FILTER_CACHE_EXPIRE);
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
        cache()->delete(self::FILTER_CACHE_NAME);
        return true;
    }
}
