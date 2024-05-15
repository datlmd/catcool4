<?php namespace App\Modules\Returns\Models;

use App\Models\MyModel;

class ActionModel extends MyModel
{
    protected $table      = 'return_action';
    protected $primaryKey = 'return_action_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'return_action_id',
        'published',
    ];

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    protected $table_lang = 'return_action_lang';
    protected $with = ['return_action_lang'];

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllByFilter($filter = null, $sort = null, $order = null)
    {
        $sort  = in_array($sort, $this->allowedFields) ? "$this->table.$sort" : (in_array($sort, ['name']) ? "$this->table_lang.$sort" : "");
        $sort  = !empty($sort) ? $sort : "$this->table.return_action_id";
        $order = ($order == 'ASC') ? 'ASC' : 'DESC';

        $this->where("$this->table_lang.language_id", language_id_admin());
        if (!empty($filter["return_action_id"])) {
            $this->whereIn("$this->table.return_action_id", (!is_array($filter["return_action_id"]) ? explode(',', $filter["return_action_id"]) : $filter["return_action_id"]));
        }

        if (!empty($filter["name"])) {
            $this->like("$this->table_lang.name", $filter["name"]);
        }

        $this->select("$this->table.*, $this->table_lang.*")
            ->with(false)
            ->join($this->table_lang, "$this->table_lang.return_action_id = $this->table.return_action_id")
            ->orderBy($sort, $order);

        return $this;
    }
}
