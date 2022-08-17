<?php namespace App\Modules\Products\Models;

use App\Models\MyModel;

class ProductLayoutModel extends MyModel
{
    protected $table      = 'product_layout';
    protected $primaryKey = 'product_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'product_id',
        'store_id',
        'layout_id',
    ];

    public function __construct()
    {
        parent::__construct();
    }
}
