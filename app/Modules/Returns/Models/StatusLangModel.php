<?php

namespace App\Modules\Returns\Models;

use App\Models\MyModel;

class StatusLangModel extends MyModel
{
    protected $table      = 'return_status_lang';
    protected $primaryKey = 'return_status_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'return_status_id',
        'language_id',
        'name',
    ];

    public function __construct()
    {
        parent::__construct();
    }
}
