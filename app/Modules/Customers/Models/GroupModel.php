<?php

namespace App\Modules\Customers\Models;

use App\Models\MyModel;

class GroupModel extends MyModel
{
    protected $table = 'customer_group';
    protected $primaryKey = 'customer_group_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'customer_group_id',
        'approval',
        'sort_order',
    ];

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;

    protected $table_lang = 'customer_group_lang';

    public const CUSTOMER_GROUP_CACHE_NAME = PREFIX_CACHE_NAME_MYSQL.'customer_group_list_all';
    public const CUSTOMER_GROUP_CACHE_EXPIRE = YEAR;

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllByFilter($filter = null, $sort = null, $order = null)
    {
        $sort = in_array($sort, $this->allowedFields) ? "$this->table.$sort" : (in_array($sort, ['name']) ? "$this->table_lang.$sort" : '');
        $sort = !empty($sort) ? $sort : "$this->table.customer_group_id";
        $order = ($order == 'ASC') ? 'ASC' : 'DESC';

        $this->where("$this->table_lang.language_id", language_id_admin());
        if (!empty($filter['customer_group_id'])) {
            $this->whereIn("$this->table.customer_group_id", (!is_array($filter['customer_group_id']) ? explode(',', $filter['customer_group_id']) : $filter['customer_group_id']));
        }

        if (!empty($filter['name'])) {
            $this->like("$this->table_lang.name", $filter['name']);
        }

        $this->select("$this->table.*, $this->table_lang.*")
            ->join($this->table_lang, "$this->table_lang.customer_group_id = $this->table.customer_group_id")
            ->orderBy($sort, $order);

        return $this;
    }

    public function getCustomerGroupsByIds(array $customer_group_ids, int $language_id): array
    {
        $result = $this->join($this->table_lang, "$this->table_lang.$this->primaryKey = $this->table.$this->primaryKey")
                ->orderBy('sort_order', 'DESC')
                ->where(["$this->table_lang.language_id" => $language_id])
                ->whereIn("$this->table.$this->primaryKey", $customer_group_ids)
                ->findAll();

        return $result;
    }

    public function getCustomerGroups($language_id, $is_cache = true)
    {
        $result = $is_cache ? cache()->get(self::CUSTOMER_GROUP_CACHE_NAME) : null;
        if (empty($result)) {
            $result = $this->join($this->table_lang, "$this->table_lang.$this->primaryKey = $this->table.$this->primaryKey")
                ->orderBy('sort_order', 'DESC')
                ->findAll();
            if (empty($result)) {
                return [];
            }

            if ($is_cache) {
                // Save into the cache for $expire_time 1 month
                cache()->save(self::CUSTOMER_GROUP_CACHE_NAME, $result, self::CUSTOMER_GROUP_CACHE_EXPIRE);
            }
        }

        return $this->formatDataLanguage($result, $language_id);
    }

    public function deleteCache()
    {
        cache()->delete(self::CUSTOMER_GROUP_CACHE_NAME);

        return true;
    }
}
