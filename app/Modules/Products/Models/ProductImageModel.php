<?php namespace App\Modules\Products\Models;

use App\Models\MyModel;

class ProductImageModel extends MyModel
{
    protected $table      = 'product_image';
    protected $primaryKey = 'product_image_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'product_image_id',
        'product_id',
        'image',
        'sort_order',
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function getImagesByProductId($product_id)
    {
        if (empty($product_id)) {
            return [];
        }

        return $this->orderBy('sort_order', 'DESC')
            ->where(['product_id' => $product_id])
            ->findAll();
    }
}
