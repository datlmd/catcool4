<?php

namespace App\Modules\Products\Models;

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
        'sort_order',
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function getListSkuByProductIds($product_ids)
    {
        if (empty($product_ids) || !is_array($product_ids)) {
            return [];
        }

        $result = $this->whereIn('product_id', $product_ids)->findAll();
        if (empty($result)) {
            return [];
        }

        $sort_list = array_column($result, 'sort_order');
        array_multisort($sort_list, SORT_DESC, $result);

        $list = [];

        $sku_value_model = new \App\Modules\Products\Models\ProductSkuValueModel();
        $sku_value_list = $sku_value_model->getListByProductIds($product_ids);

        foreach ($result as $value) {
            $variant_value_list = [];
            $variant_value_row_list = [];

            foreach ($sku_value_list as $key_sku_value => $sku_value) {
                if ($value['product_sku_id'] != $sku_value['product_sku_id']) {
                    continue;
                }

                $variant_value_list[] = $sku_value['variant_value_id'];
                $variant_value_row_list[] = format_product_variant_row($sku_value['variant_value_id']);
                $value['sku_value_list'][] = $sku_value;
            }

            $value['price'] = (float)$value['price'];

            $value['variant_combination_sku_name'] = PRODUCT_VARIANT_COMBINATION_SKU_NAME . implode("_", $variant_value_row_list);

            $list[create_variant_key($value['product_id'], $variant_value_list)] = $value;
        }

        return $list;
    }
}
