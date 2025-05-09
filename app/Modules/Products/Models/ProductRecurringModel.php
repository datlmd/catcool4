<?php

namespace App\Modules\Products\Models;

use App\Models\MyModel;

class ProductRecurringModel extends MyModel
{
    protected $table      = 'product_recurring';
    protected $primaryKey = 'product_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'product_id',
        'recurring_id',
        'customer_group_id',
    ];

    public function __construct()
    {
        parent::__construct();
    }
}
