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
}
