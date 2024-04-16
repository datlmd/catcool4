<?php namespace App\Modules\Products\Models;

use App\Models\MyModel;

class ProductVariantModel extends MyModel
{
    protected $table      = 'product_variant';
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

    public function getListVariantByProductId($product_id)
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

        $variant_model       = new \App\Modules\Variants\Models\VariantModel();
        $variant_value_model = new \App\Modules\Variants\Models\VariantValueModel();

        $variant_list = $variant_model->getListAll();

        $list = [];
        foreach ($result as $key => $value) {
            if (empty($variant_list[$value['variant_id']])) {
                //unset($result[$key]);
                continue;
            }

            $value['name']        = $variant_list[$value['variant_id']]['name'];
            $value['variant_row'] = format_product_variant_row($value['variant_id']);
            $value['value_list']  = $variant_value_model->getListById($value['variant_id']);
            $list[$value['variant_id']] = $value;
        }

        return $list;
    }
}
