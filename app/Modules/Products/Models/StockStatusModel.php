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

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllByFilter($filter = null, $sort = null, $order = null)
    {
        $sort  = in_array($sort, $this->allowedFields) ? "$this->table.$sort" : (in_array($sort, ['name']) ? "$this->table_lang.$sort" : "");
        $sort  = !empty($sort) ? $sort : "$this->table.stock_status_id";
        $order = ($order == 'ASC') ? 'ASC' : 'DESC';

        $this->where("$this->table_lang.language_id", get_lang_id(true));
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
}
