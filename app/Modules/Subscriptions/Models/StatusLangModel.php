<?php

namespace App\Modules\Subscriptions\Models;

use App\Models\MyModel;

class StatusLangModel extends MyModel
{
    protected $table      = 'subscription_status_lang';
    protected $primaryKey = 'subscription_status_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'subscription_status_id',
        'language_id',
        'name',
    ];

    public function __construct()
    {
        parent::__construct();
    }
}
