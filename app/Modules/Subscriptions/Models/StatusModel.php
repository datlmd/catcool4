<?php namespace App\Modules\Subscriptions\Models;

use App\Models\MyModel;

class StatusModel extends MyModel
{
    protected $table      = 'subscription_status';
    protected $primaryKey = 'subscription_status_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'subscription_status_id',
        'published',
    ];

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    protected $table_lang = 'subscription_status_lang';
    protected $with = ['subscription_status_lang'];

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllByFilter($filter = null, $sort = null, $order = null)
    {
        $sort  = in_array($sort, $this->allowedFields) ? "$this->table.$sort" : (in_array($sort, ['name']) ? "$this->table_lang.$sort" : "");
        $sort  = !empty($sort) ? $sort : "$this->table.subscription_status_id";
        $order = ($order == 'ASC') ? 'ASC' : 'DESC';

        $this->where("$this->table_lang.language_id", get_lang_id(true));
        if (!empty($filter["subscription_status_id"])) {
            $this->whereIn("$this->table.subscription_status_id", (!is_array($filter["subscription_status_id"]) ? explode(',', $filter["subscription_status_id"]) : $filter["subscription_status_id"]));
        }

        if (!empty($filter["name"])) {
            $this->like("$this->table_lang.name", $filter["name"]);
        }

        $this->select("$this->table.*, $this->table_lang.*")
            ->with(false)
            ->join($this->table_lang, "$this->table_lang.subscription_status_id = $this->table.subscription_status_id")
            ->orderBy($sort, $order);

        return $this;
    }
}
