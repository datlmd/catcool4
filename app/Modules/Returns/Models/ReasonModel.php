<?php namespace App\Modules\Returns\Models;

use App\Models\MyModel;

class ReasonModel extends MyModel
{
    protected $table      = 'return_reason';
    protected $primaryKey = 'return_reason_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'return_reason_id',
        'published',
    ];

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    protected $table_lang = 'return_reason_lang';
    protected $with = ['return_reason_lang'];

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllByFilter($filter = null, $sort = null, $order = null)
    {
        $sort  = in_array($sort, $this->allowedFields) ? "$this->table.$sort" : (in_array($sort, ['name']) ? "$this->table_lang.$sort" : "");
        $sort  = !empty($sort) ? $sort : "$this->table.return_reason_id";
        $order = ($order == 'ASC') ? 'ASC' : 'DESC';

        $this->where("$this->table_lang.language_id", language_id_admin());
        if (!empty($filter["return_reason_id"])) {
            $this->whereIn("$this->table.return_reason_id", (!is_array($filter["return_reason_id"]) ? explode(',', $filter["return_reason_id"]) : $filter["return_reason_id"]));
        }

        if (!empty($filter["name"])) {
            $this->like("$this->table_lang.name", $filter["name"]);
        }

        $this->select("$this->table.*, $this->table_lang.*")
            ->with(false)
            ->join($this->table_lang, "$this->table_lang.return_reason_id = $this->table.return_reason_id")
            ->orderBy($sort, $order);

        return $this;
    }
}
