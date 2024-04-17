<?php namespace App\Modules\Products\Models;

use App\Models\MyModel;

class ProductVariantValueModel extends MyModel
{
    protected $table      = 'product_variant_value';
    protected $primaryKey = 'product_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'variant_id',
        'variant_value_id',
        'product_id',
        'sort_order',
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function getListVariantValueByProductId($product_id)
    {
        if (empty($product_id)) {
            return [];
        }

        $result = $this->where(['product_id' => $product_id])->findAll();
        if (empty($result)) {
            return [];
        }

        return $result;
    }
}
