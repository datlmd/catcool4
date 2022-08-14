<?php namespace App\Modules\Subscriptions\Models;

use App\Models\MyModel;

class PlanModel extends MyModel
{
    protected $table      = 'subscription_plan';
    protected $primaryKey = 'subscription_plan_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'subscription_plan_id',
        'trial_price',
        'trial_frequency',
        'trial_duration',
        'trial_cycle',
        'trial_published',
        'price',
        'frequency',
        'duration',
        'cycle',
        'published',
        'sort_order',
    ];

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    protected $table_lang = 'subscription_plan_lang';
    protected $with = ['subscription_plan_lang'];

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllByFilter($filter = null, $sort = null, $order = null)
    {
        $sort  = in_array($sort, $this->allowedFields) ? "$this->table.$sort" : (in_array($sort, ['name']) ? "$this->table_lang.$sort" : "");
        $sort  = !empty($sort) ? $sort : "$this->table.subscription_plan_id";
        $order = ($order == 'ASC') ? 'ASC' : 'DESC';

        $this->where("$this->table_lang.language_id", get_lang_id(true));
        if (!empty($filter["subscription_plan_id"])) {
            $this->whereIn("$this->table.subscription_plan_id", (!is_array($filter["subscription_plan_id"]) ? explode(',', $filter["subscription_plan_id"]) : $filter["subscription_plan_id"]));
        }

        if (!empty($filter["name"])) {
            $this->like("$this->table_lang.name", $filter["name"]);
        }

        $this->select("$this->table.*, $this->table_lang.*")
            ->with(false)
            ->join($this->table_lang, "$this->table_lang.subscription_plan_id = $this->table.subscription_plan_id")
            ->orderBy($sort, $order);

        return $this;
    }
}
