<?php

namespace App\Modules\Subscriptions\Models;

use App\Models\MyModel;

class PlanLangModel extends MyModel
{
    protected $table      = 'subscription_plan_lang';
    protected $primaryKey = 'subscription_plan_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'subscription_plan_id',
        'language_id',
        'name',
        'description',
    ];

    public function __construct()
    {
        parent::__construct();
    }
}
