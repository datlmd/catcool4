<?php namespace App\Modules\Products\Models;

use App\Models\MyModel;

class WeightClassModel extends MyModel
{
    protected $table      = 'weight_class';
    protected $primaryKey = 'weight_class_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'weight_class_id',
        "value",
    ];

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    protected $table_lang = 'weight_class_lang';
    protected $with = ['weight_class_lang'];

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllByFilter($filter = null, $sort = null, $order = null)
    {
        $sort  = in_array($sort, $this->allowedFields) ? "$this->table.$sort" : (in_array($sort, ['name']) ? "$this->table_lang.$sort" : "");
        $sort  = !empty($sort) ? $sort : "$this->table.weight_class_id";
        $order = ($order == 'ASC') ? 'ASC' : 'DESC';

        $this->where("$this->table_lang.language_id", get_lang_id(true));
        if (!empty($filter["weight_class_id"])) {
            $this->whereIn("$this->table.weight_class_id", (!is_array($filter["weight_class_id"]) ? explode(',', $filter["weight_class_id"]) : $filter["weight_class_id"]));
        }

        if (!empty($filter["name"])) {
            $this->like("$this->table_lang.name", $filter["name"]);
        }

        $this->select("$this->table.*, $this->table_lang.*")
            ->with(false)
            ->join($this->table_lang, "$this->table_lang.weight_class_id = $this->table.weight_class_id")
            ->orderBy($sort, $order);

        return $this;
    }
}
