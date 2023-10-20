<?php namespace App\Modules\Products\Models;

use App\Models\MyModel;

class ProductVariantCombinationModel extends MyModel
{
    protected $table      = 'product_variant_combination';
    protected $primaryKey = 'product_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'product_id',
        'product_variant_id',
        'option_id',
        'option_value_id',
    ];

    public function __construct()
    {
        parent::__construct();
    }
}
