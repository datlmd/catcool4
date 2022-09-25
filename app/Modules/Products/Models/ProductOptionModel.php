<?php namespace App\Modules\Products\Models;

use App\Models\MyModel;

class ProductOptionModel extends MyModel
{
    protected $table      = 'product_option';
    protected $primaryKey = 'product_option_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'product_option_id',
        'product_id',
        'option_id',
        'value',
        'required',
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
        $product_option_value_model = new ProductOptionValueModel();
        $option_model = new \App\Modules\Options\Models\OptionModel();

        $option_list = $option_model->getListAll();
        foreach ($result as $key => $value) {
            if (empty($option_list[$value['option_id']])) {
                unset($result[$key]);
                continue;
            }
            $option_info = $option_list[$value['option_id']];

            $result[$key]['name'] = $option_info['name'];
            $result[$key]['type'] = $option_info['type'];

            $product_option_value_list = $product_option_value_model->where(['product_option_id' => $value['product_option_id']])->orderBy('product_option_value_id', 'DESC')->findAll();
            if (!empty($product_option_value_list)) {
                foreach ($product_option_value_list as $product_option_value_key => $product_option_value) {
                    if (empty($option_info['option_value_list'][$product_option_value['option_value_id']])) {
                        unset($product_option_value_list[$product_option_value_key]);
                        continue;
                    }
                    $option_value_info = $option_info['option_value_list'][$product_option_value['option_value_id']];

                    $result[$key]['product_option_value_list'][] = [
                        'product_option_value_id' => $product_option_value['product_option_value_id'],
                        'option_value_id'         => $product_option_value['option_value_id'],
                        'name'                    => $option_value_info['name'],
                        'quantity'                => $product_option_value['quantity'],
                        'subtract'                => $product_option_value['subtract'],
                        'price'                   => round($product_option_value['price']),
                        'price_prefix'            => $product_option_value['price_prefix'],
                        'points'                  => round($product_option_value['points']),
                        'points_prefix'           => $product_option_value['points_prefix'],
                        'weight'                  => round($product_option_value['weight']),
                        'weight_prefix'           => $product_option_value['weight_prefix']
                    ];
                }
            }

            if ($option_info['type'] == 'select' || $option_info['type'] == 'radio' || $option_info['type'] == 'checkbox' || $option_info['type'] == 'image') {
                $result[$key]['option_value_list'] = $option_info['option_value_list'];
            }
        }

        return $result;
    }
}
