<?php namespace App\Modules\Customers\Models;

use App\Models\MyModel;

class CustomerGroupModel extends MyModel
{
    protected $table      = 'customer_group';
    protected $primaryKey = 'customer_group_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'customer_group_id',
        'approval',
        'sort_order',
    ];

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    protected $table_lang = 'customer_group_lang';
    protected $with = ['customer_group_lang'];

    const CUSTOMER_GROUP_CACHE_NAME = 'customer_group_list_all';
    const CUSTOMER_GROUP_CACHE_EXPIRE = YEAR;

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllByFilter($filter = null, $sort = null, $order = null)
    {
        $sort  = in_array($sort, $this->allowedFields) ? "$this->table.$sort" : (in_array($sort, ['name']) ? "$this->table_lang.$sort" : "");
        $sort  = !empty($sort) ? $sort : "$this->table.customer_group_id";
        $order = ($order == 'ASC') ? 'ASC' : 'DESC';

        $this->where("$this->table_lang.language_id", get_lang_id(true));
        if (!empty($filter["customer_group_id"])) {
            $this->whereIn("$this->table.customer_group_id", (!is_array($filter["customer_group_id"]) ? explode(',', $filter["customer_group_id"]) : $filter["customer_group_id"]));
        }

        if (!empty($filter["name"])) {
            $this->like("$this->table_lang.name", $filter["name"]);
        }

        $this->select("$this->table.*, $this->table_lang.*")
            ->with(false)
            ->join($this->table_lang, "$this->table_lang.customer_group_id = $this->table.customer_group_id")
            ->orderBy($sort, $order);

        return $this;
    }

    public function getListAll($is_cache = true)
    {
        $result = $is_cache ? cache()->get(self::CUSTOMER_GROUP_CACHE_NAME) : null;
        if (empty($result)) {
            $result = $this->orderBy('value', 'ASC')->findAll();
            if (empty($result)) {
                return [];
            }

            if ($is_cache) {
                // Save into the cache for $expire_time 1 month
                cache()->save(self::CUSTOMER_GROUP_CACHE_NAME, $result, self::CUSTOMER_GROUP_CACHE_EXPIRE);
            }
        }

        if (empty($result)) {
            return [];
        }

        $list = [];

        $language_id = get_lang_id(true);
        foreach ($result as $value) {
            $list[$value['customer_group_id']] = format_data_lang_id($value, $this->table_lang, $language_id);
        }

        return $list;
    }

    public function deleteCache()
    {
        cache()->delete(self::CUSTOMER_GROUP_CACHE_NAME);
        return true;
    }
}
