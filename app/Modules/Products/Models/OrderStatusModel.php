<?php

namespace App\Modules\Products\Models;

use App\Models\MyModel;

class OrderStatusModel extends MyModel
{
    protected $table = 'order_status';
    protected $primaryKey = 'order_status_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'order_status_id',
        'published',
    ];

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;

    protected $table_lang = 'order_status_lang';

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllByFilter($filter = null, $sort = null, $order = null)
    {
        $sort = in_array($sort, $this->allowedFields) ? "$this->table.$sort" : (in_array($sort, ['name']) ? "$this->table_lang.$sort" : '');
        $sort = !empty($sort) ? $sort : "$this->table.order_status_id";
        $order = ($order == 'ASC') ? 'ASC' : 'DESC';

        $this->where("$this->table_lang.language_id", language_id_admin());
        if (!empty($filter['order_status_id'])) {
            $this->whereIn("$this->table.order_status_id", (!is_array($filter['order_status_id']) ? explode(',', $filter['order_status_id']) : $filter['order_status_id']));
        }

        if (!empty($filter['name'])) {
            $this->like("$this->table_lang.name", $filter['name']);
        }

        $this->select("$this->table.*, $this->table_lang.*")
            ->join($this->table_lang, "$this->table_lang.order_status_id = $this->table.order_status_id")
            ->orderBy($sort, $order);

        return $this;
    }

    public function getOrderStatusesByIds(array $order_status_ids, int $language_id): array
    {
        $result = $this->join($this->table_lang, "$this->table_lang.$this->primaryKey = $this->table.$this->primaryKey")
                ->where(["$this->table_lang.language_id" => $language_id])
                ->whereIn("$this->table.$this->primaryKey", $order_status_ids)
                ->findAll();

        return $result;
    }
}
