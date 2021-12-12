<?php namespace App\Modules\Products\Models;

use App\Models\MyModel;

class WeightClassLangModel extends MyModel
{
    protected $table      = 'weight_class_lang';
    protected $primaryKey = 'weight_class_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'weight_class_id',
        'language_id',
        'name',
        "unit",
    ];

    public function __construct()
    {
        parent::__construct();
    }
}
