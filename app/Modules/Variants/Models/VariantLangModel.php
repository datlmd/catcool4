<?php

namespace App\Modules\Variants\Models;

use App\Models\MyModel;

class VariantLangModel extends MyModel
{
    protected $table      = 'variant_lang';
    protected $primaryKey = 'variant_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'variant_id',
        'language_id',
        'name',
    ];

    public function __construct()
    {
        parent::__construct();
    }
}
