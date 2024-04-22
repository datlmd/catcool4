<?php namespace App\Modules\Products\Models;

use App\Models\MyModel;

class ProductSkuValueModel extends MyModel
{
    protected $table      = 'product_sku_value';
    protected $primaryKey = 'product_sku_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'product_sku_id',
        'product_id',
        'variant_id',
        'variant_value_id',
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function getListByProductIds($product_ids)
    {
        if (empty($product_ids) || !is_array($product_ids)) {
            return [];
        }

        $result = $this->whereIn('product_id', $product_ids)->findAll();
        if (empty($result)) {
            return [];
        }

        return $result;
    }
}
