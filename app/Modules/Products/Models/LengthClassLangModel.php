<?php

namespace App\Modules\Products\Models;

use App\Models\MyModel;

class LengthClassLangModel extends MyModel
{
    protected $table      = 'length_class_lang';
    protected $primaryKey = 'length_class_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'length_class_id',
        'language_id',
        'name',
        "unit",
    ];

    public function __construct()
    {
        parent::__construct();
    }
}
