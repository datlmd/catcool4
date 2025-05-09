<?php

namespace App\Modules\Products\Models;

use App\Models\MyModel;

class ProductFilterModel extends MyModel
{
    protected $table      = 'product_filter';
    protected $primaryKey = 'product_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'product_id',
        'filter_id',
    ];

    public function __construct()
    {
        parent::__construct();
    }
}
