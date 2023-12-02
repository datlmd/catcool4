<?php namespace App\Modules\Products\Models;

use App\Models\MyModel;

class ProductSkuValueModel extends MyModel
{
    protected $table      = 'product_sku';
    protected $primaryKey = 'product_sku_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'product_sku_id',
        'product_id',
        'option_id',
        'option_value_id',
    ];

    public function __construct()
    {
        parent::__construct();
    }
}
