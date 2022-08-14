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
}
