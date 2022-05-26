<?php namespace App\Modules\Attributes\Models;

use App\Models\MyModel;

class AttributeModel extends MyModel
{
    protected $table      = 'attribute';
    protected $primaryKey = 'attribute_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        "attribute_id",
        "sort_order",
        "attribute_group_id",
    ];

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    protected $table_lang = 'attribute_lang';
    protected $with = ['attribute_lang'];

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllByFilter($filter = null, $sort = null, $order = null)
    {
        $sort  = in_array($sort, $this->allowedFields) ? "$this->table.$sort" : (in_array($sort, ['name']) ? "$this->table_lang.$sort" : "");
        $sort  = !empty($sort) ? $sort : "$this->table.attribute_id";
        $order = ($order == 'ASC') ? 'ASC' : 'DESC';

        $this->where("$this->table_lang.language_id", get_lang_id(true));
        if (!empty($filter["attribute_id"])) {
            $this->whereIn("$this->table.attribute_id", (!is_array($filter["attribute_id"]) ? explode(',', $filter["attribute_id"]) : $filter["attribute_id"]));
        }

        if (!empty($filter["name"])) {
            $this->like("$this->table_lang.name", $filter["name"]);
        }

        $this->select("$this->table.*, $this->table_lang.*")
            ->with(false)
            ->join($this->table_lang, "$this->table_lang.attribute_id = $this->table.attribute_id")
            ->orderBy($sort, $order);

        return $this;
    }
}
