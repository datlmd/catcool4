<?php

namespace App\Modules\Products\Models;

use App\Models\MyModel;

class ProductSpecialModel extends MyModel
{
    protected $table      = 'product_special';
    protected $primaryKey = 'product_special_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'product_reward_id',
        'product_id',
        'customer_group_id',
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
