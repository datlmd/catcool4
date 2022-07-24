<?php namespace App\Modules\Options\Models;

use App\Models\MyModel;

class OptionModel extends MyModel
{
    protected $table      = 'option';
    protected $primaryKey = 'option_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'option_id',
        'type',
        'sort_order'
    ];

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    protected $table_lang = 'option_lang';
    protected $with = ['option_lang'];

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllByFilter($filter = null, $sort = null, $order = null)
    {
        $sort  = in_array($sort, $this->allowedFields) ? "$this->table.$sort" : (in_array($sort, ['name']) ? "$this->table_lang.$sort" : "");
        $sort  = !empty($sort) ? $sort : "$this->table.option_id";
        $order = ($order == 'ASC') ? 'ASC' : 'DESC';

        $this->where("$this->table_lang.language_id", get_lang_id(true));
        if (!empty($filter["option_id"])) {
            $this->whereIn("$this->table.option_id", (!is_array($filter["option_id"]) ? explode(',', $filter["option_id"]) : $filter["option_id"]));
        }

        if (!empty($filter["name"])) {
            $this->like("$this->table_lang.name", $filter["name"]);
        }

        $this->select("$this->table.*, $this->table_lang.*")
            ->with(false)
            ->join($this->table_lang, "$this->table_lang.option_id = $this->table.option_id")
            ->orderBy($sort, $order);

        return $this;
    }
}
