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
        'option_id',
        'option_value_id',
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function getListByProductId($product_id)
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
