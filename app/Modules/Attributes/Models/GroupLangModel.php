<?php

namespace App\Modules\Attributes\Models;

use App\Models\MyModel;

class GroupLangModel extends MyModel
{
    protected $table      = 'attribute_group_lang';
    protected $primaryKey = 'attribute_group_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'attribute_group_id',
        'language_id',
        'name',
    ];

    public function __construct()
    {
        parent::__construct();
    }
}
