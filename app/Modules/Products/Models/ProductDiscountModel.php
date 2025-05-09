<?php

namespace App\Modules\Products\Models;

use App\Models\MyModel;

class ProductDiscountModel extends MyModel
{
    protected $table      = 'product_discount';
    protected $primaryKey = 'product_discount_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'product_discount_id',
        'product_id',
        'customer_group_id',
        'quantity',
        'priority',
        'price',
        'date_start',
        'date_end',
    ];

    public function __construct()
    {
        parent::__construct();
    }
}
