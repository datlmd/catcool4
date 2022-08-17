<?php namespace App\Modules\Products\Models;

use App\Models\MyModel;

class ProductOptionValueModel extends MyModel
{
    protected $table      = 'product_option_value';
    protected $primaryKey = 'product_option_value_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'product_option_value_id',
        'product_option_id',
        'product_id',
        'option_id',
        'option_value_id',
        'quantity',
        'subtract',
        'price',
        'price_prefix',
        'points',
        'points_prefix',
        'weight',
        'weight_prefix',
    ];

    public function __construct()
    {
        parent::__construct();
    }
}
