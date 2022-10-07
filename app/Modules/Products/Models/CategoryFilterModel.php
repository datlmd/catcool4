<?php namespace App\Modules\Products\Models;

use App\Models\MyModel;

class CategoryFilterModel extends MyModel
{
    protected $table      = 'product_category_filter';
    protected $primaryKey = 'category_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'category_id',
        'filter_id',
    ];

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function __construct()
    {
        parent::__construct();
    }
}
