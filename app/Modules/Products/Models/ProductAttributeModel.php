<?php namespace App\Modules\Products\Models;

use App\Models\MyModel;

class ProductAttributeModel extends MyModel
{
    protected $table      = 'product_attribute';
    protected $primaryKey = 'product_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'product_id',
        'language_id',
        'attribute_id',
        'text',
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

        $list = [];
        foreach ($result as $value) {
            $list[$value['attribute_id']]['product_id'] = $value['product_id'];
            $list[$value['attribute_id']]['attribute_id'] = $value['attribute_id'];
            $list[$value['attribute_id']]['lang'][$value['language_id']]['text'] = $value['text'];
        }

        return $list;
    }
}
