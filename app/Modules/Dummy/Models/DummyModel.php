<?php

namespace App\Modules\Dummy\Models;

use App\Models\MyModel;

class DummyModel extends MyModel
{
    protected $table = 'dummy';
    protected $primaryKey = 'dummy_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'dummy_id',
        'sort_order',
        'published',
        'created_at',
        'updated_at',
        //FIELD_ROOT
    ];

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;

    protected $table_lang = 'dummy_lang';
    protected $with = ['dummy_lang'];

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllByFilter($filter = null, $sort = null, $order = null)
    {
        $sort = in_array($sort, $this->allowedFields) ? "$this->table.$sort" : (in_array($sort, ['name']) ? "$this->table_lang.$sort" : '');
        $sort = !empty($sort) ? $sort : "$this->table.dummy_id";
        $order = ($order == 'ASC') ? 'ASC' : 'DESC';

        $this->where("$this->table_lang.language_id", language_id_admin());
        if (!empty($filter['dummy_id'])) {
            $this->whereIn("$this->table.dummy_id", (!is_array($filter['dummy_id']) ? explode(',', $filter['dummy_id']) : $filter['dummy_id']));
        }

        if (!empty($filter['name'])) {
            $this->like("$this->table_lang.name", $filter['name']);
        }

        $this->select("$this->table.*, $this->table_lang.*")
            ->with(false)
            ->join($this->table_lang, "$this->table_lang.dummy_id = $this->table.dummy_id")
            ->orderBy($sort, $order);

        return $this;
    }
}
