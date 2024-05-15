<?php namespace App\Modules\Filters\Models;

use App\Models\MyModel;

class FilterGroupModel extends MyModel
{
    protected $table      = 'filter_group';
    protected $primaryKey = 'filter_group_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'filter_group_id',
        'sort_order'
    ];

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    protected $table_lang = 'filter_group_lang';
    protected $with = ['filter_group_lang'];

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllByFilter($filter = null, $sort = null, $order = null)
    {
        $sort  = in_array($sort, $this->allowedFields) ? "$this->table.$sort" : (in_array($sort, ['name']) ? "$this->table_lang.$sort" : "");
        $sort  = !empty($sort) ? $sort : "$this->table.filter_group_id";
        $order = ($order == 'ASC') ? 'ASC' : 'DESC';

        $this->where("$this->table_lang.language_id", language_id_admin());
        if (!empty($filter["filter_group_id"])) {
            $this->whereIn("$this->table.filter_group_id", (!is_array($filter["filter_group_id"]) ? explode(',', $filter["filter_group_id"]) : $filter["filter_group_id"]));
        }

        if (!empty($filter["name"])) {
            $this->like("$this->table_lang.name", $filter["name"]);
        }

        $this->select("$this->table.*, $this->table_lang.*")
            ->with(false)
            ->join($this->table_lang, "$this->table_lang.filter_group_id = $this->table.filter_group_id")
            ->orderBy($sort, $order);

        return $this;
    }
}
