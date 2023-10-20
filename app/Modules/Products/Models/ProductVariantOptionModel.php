<?php namespace App\Modules\Products\Models;

use App\Models\MyModel;

class ProductVariantOptionModel extends MyModel
{
    protected $table      = 'product_variant_option';
    protected $primaryKey = 'product_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'option_id',
        'product_id',
        'sort_order',
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function getListVariantOptionByProductId($product_id)
    {
        if (empty($product_id)) {
            return [];
        }

        $result = $this->where(['product_id' => $product_id])->findAll();
        if (empty($result)) {
            return [];
        }

        $option_model       = new \App\Modules\Options\Models\OptionModel();
        $option_value_model = new \App\Modules\Options\Models\OptionValueModel();

        $option_list = $option_model->getListAll();
        foreach ($result as $key => $value) {
            if (empty($option_list[$value['option_id']])) {
                unset($result[$key]);
                continue;
            }
            $option_info = $option_list[$value['option_id']];

            $result[$key]['name']              = $option_info['name'];
            $result[$key]['type']              = $option_info['type'];
            $result[$key]['option_value_list'] = $option_value_model->getListByOptionId($value['option_id']);
        }

        return $result;
    }
}
