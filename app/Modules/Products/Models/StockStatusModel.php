<?php namespace App\Modules\Products\Models;

use App\Models\MyModel;

class StockStatusModel extends MyModel
{
    protected $table      = 'stock_status';
    protected $primaryKey = 'stock_status_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'stock_status_id',
        'published',
    ];

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    protected $table_lang = 'stock_status_lang';
    protected $with = ['stock_status_lang'];

    const STOCK_STATUS_CACHE_NAME   = 'stock_status_list';
    const STOCK_STATUS_CACHE_EXPIRE = YEAR;

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllByFilter($filter = null, $sort = null, $order = null)
    {
        $sort  = in_array($sort, $this->allowedFields) ? "$this->table.$sort" : (in_array($sort, ['name']) ? "$this->table_lang.$sort" : "");
        $sort  = !empty($sort) ? $sort : "$this->table.stock_status_id";
        $order = ($order == 'ASC') ? 'ASC' : 'DESC';

        $this->where("$this->table_lang.language_id", language_id_admin());
        if (!empty($filter["stock_status_id"])) {
            $this->whereIn("$this->table.stock_status_id", (!is_array($filter["stock_status_id"]) ? explode(',', $filter["stock_status_id"]) : $filter["stock_status_id"]));
        }

        if (!empty($filter["name"])) {
            $this->like("$this->table_lang.name", $filter["name"]);
        }

        $this->select("$this->table.*, $this->table_lang.*")
            ->with(false)
            ->join($this->table_lang, "$this->table_lang.stock_status_id = $this->table.stock_status_id")
            ->orderBy($sort, $order);

        return $this;
    }

    public function deleteCache()
    {
        cache()->delete(self::STOCK_STATUS_CACHE_NAME);
        return true;
    }

    /** ---------- Frontend ----------  **/

    public function getStockStatuses($language_id, $is_cache = true)
    {
        $result = $is_cache ? cache()->get(self::STOCK_STATUS_CACHE_NAME) : null;
        if (empty($result)) {
            $result = $this->orderBy('stock_status_id', 'DESC')->where(['published' => STATUS_ON])->findAll();
            if (empty($result)) {
                return [];
            }

            if ($is_cache) {
                // Save into the cache for $expire_time 1 month
                cache()->save(self::STOCK_STATUS_CACHE_NAME, $result, self::STOCK_STATUS_CACHE_EXPIRE);
            }
        }

        if (empty($result)) {
            return [];
        }

        foreach ($result as $key => $value) {
            $result[$key] = format_data_lang_id($value, $this->table_lang, $language_id);
        }

        return $result;
    }
}
