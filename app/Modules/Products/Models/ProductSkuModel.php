<?php namespace App\Modules\Products\Models;

use App\Models\MyModel;

class ProductSkuModel extends MyModel
{
    protected $table      = 'product_sku';
    protected $primaryKey = 'product_sku_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'product_sku_id',
        'product_id',
        'price',
        'quantity',
        'sku',
        'published',
    ];

    public function __construct()
    {
        parent::__construct();
    }
}
