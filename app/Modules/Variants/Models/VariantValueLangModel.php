<?php

namespace App\Modules\Variants\Models;

use App\Models\MyModel;

class VariantValueLangModel extends MyModel
{
    protected $table      = 'variant_value_lang';
    protected $primaryKey = 'variant_value_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'variant_value_id',
        'language_id',
        'variant_id',
        'name',
    ];

    public function __construct()
    {
        parent::__construct();
    }
}
