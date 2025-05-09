<?php

namespace App\Modules\Products\Models;

use App\Models\MyModel;

class ProductCategoryModel extends MyModel
{
    protected $table      = 'product_categories';
    protected $primaryKey = 'product_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'product_id',
        'category_id',
    ];

    public function __construct()
    {
        parent::__construct();
    }
}
