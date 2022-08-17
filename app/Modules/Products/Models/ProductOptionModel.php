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
}
