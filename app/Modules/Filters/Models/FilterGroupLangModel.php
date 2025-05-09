<?php

namespace App\Modules\Filters\Models;

use App\Models\MyModel;

class FilterGroupLangModel extends MyModel
{
    protected $table      = 'filter_group_lang';
    protected $primaryKey = 'filter_group_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'filter_group_id',
        'language_id',
        'name',
    ];

    public function __construct()
    {
        parent::__construct();
    }
}
