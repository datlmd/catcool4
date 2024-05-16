<?php

namespace App\Modules\Products\Models;

use App\Models\MyModel;

class ProductVariantModel extends MyModel
{
    protected $table = 'product_variant';
    protected $primaryKey = 'product_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'variant_id',
        'product_id',
        'sort_order',
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function getListVariantByProductId($product_id, $language_id)
    {
        if (empty($product_id)) {
            return [];
        }

        $result = $this->where(['product_id' => $product_id])->findAll();
        if (empty($result)) {
            return [];
        }

        $variant_sort = array_column($result, 'sort_order');
        array_multisort($variant_sort, SORT_DESC, $result);

        $variant_model = new \App\Modules\Variants\Models\VariantModel();
        $variant_value_model = new \App\Modules\Variants\Models\VariantValueModel();
        $product_variant_value_model = new ProductVariantValueModel();

        $variant_list = $variant_model->getVariants($language_id);
        $variant_value_list = $variant_value_model->getVariantValues($language_id);

        $product_variant_value_list = $product_variant_value_model->getListVariantValueByProductId($product_id);
        $product_variant_group_list = [];

        foreach ($product_variant_value_list as $product_variant_value_key => $product_variant_value) {
            if (empty($variant_value_list[$product_variant_value['variant_value_id']])) {
                continue;
            }
            $product_variant_group_list[$product_variant_value['variant_id']][] = array_merge($product_variant_value, $variant_value_list[$product_variant_value['variant_value_id']]);
        }

        $list = [];
        foreach ($result as $key => $value) {
            if (empty($variant_list[$value['variant_id']])) {
                //unset($result[$key]);
                continue;
            }

            $value['name'] = $variant_list[$value['variant_id']]['name'];
            $value['variant_row'] = format_product_variant_row($value['variant_id']);

            $variant_values = $product_variant_group_list[$value['variant_id']];
            $variant_value_sort = array_column($variant_values, 'sort_order');
            array_multisort($variant_value_sort, SORT_DESC, $variant_values);

            foreach ($variant_values as $variant_value) {
                $variant_value['variant_value_row'] = format_product_variant_row($variant_value['variant_value_id']);
                $value['value_list'][$variant_value['variant_value_id']] = $variant_value;
            }

            $list[$value['variant_id']] = $value;
        }

        return $list;
    }
}
