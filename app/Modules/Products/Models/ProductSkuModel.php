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

    public function getListSkuByProductId($product_id)
    {
        if (empty($product_id)) {
            return [];
        }

        $result = $this->where(['product_id' => $product_id])->findAll();
        if (empty($result)) {
            return [];
        }

        $list = [];

        $sku_value_model = new \App\Modules\Products\Models\ProductSkuValueModel();
        $sku_value_list = $sku_value_model->getListByProductId($product_id);

        foreach ($result as $value) {
            $variant_value_list = [];
            foreach($sku_value_list as $key_sku_value => $sku_value) {
                if ($value['product_sku_id'] != $sku_value['product_sku_id']) {
                    continue;
                }

                $variant_value_list[] = $sku_value['variant_value_id'];
            }

            $value['price'] = (float)$value['price'];

            $list[create_variant_key($product_id, $variant_value_list)] = $value;
        }

        return $list;
    }
}
